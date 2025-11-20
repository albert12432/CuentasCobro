<?php

namespace App\Http\Controllers;

use App\Models\CuentaCobro;
use App\Models\ItemCuentaCobro;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Contrato;
use App\Models\Notificacion;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CuentaCobroController extends Controller
{
    /**
     * Mostrar todas las cuentas de cobro.
     */
    public function index()
    {
        $cuentas = CuentaCobro::with('items', 'contrato')
            ->whereNull('archived_at')
            ->latest()
            ->paginate(10);
        return view('cuentas_cobro.index', compact('cuentas'));
    }

    /**
     * Mostrar formulario de creación.
     */
   public function create()
{
    // Solo contratista puede crear
    if ((Auth::user()?->role?->name) !== 'contratista') {
        return redirect()->route('cuentas_cobro.index')->with('error', 'Solo el contratista puede crear cuentas de cobro.');
    }
    $contratos = Contrato::all();

    $departamentos = \App\Models\Departamento::with('municipios')->get();

    // Formatear datos para el formulario
    $departamentosFormateados = [];
    foreach ($departamentos as $dep) {
        $departamentosFormateados[$dep->nombre] = $dep->municipios->pluck('nombre')->toArray();
    }

    return view('cuentas_cobro.create', [
        'contratos' => $contratos,
        'departamentos' => $departamentosFormateados
    ]);
}


    /**
     * Guardar una nueva cuenta de cobro.
     */
 public function store(Request $request)
{
    $request->validate([
        'numero' => 'required|unique:cuentas_cobro',
        'fecha_emision' => 'required|date',
        'departamento' => 'required',
        'municipio' => 'required',
        'tipo_identificacion' => 'required',
        'tipo_cliente' => 'required',
        'nombre_beneficiario' => 'required',
        'items.*.item' => 'required|string',
        'items.*.cantidad' => 'required|integer|min:1',
        'items.*.precio_unitario' => 'required|numeric|min:0',
    ]);

    // Calcular subtotal de los ítems (servidor)
    $subtotal = collect($request->items)->sum(function($item) {
        return $item['cantidad'] * $item['precio_unitario'];
    });

    // Tomar impuestos/retenciones enviados (si existen)
    $iva = (float) $request->input('iva_valor', 0);
    $retFuente = (float) $request->input('retencion_fuente', 0);
    $retIca = (float) $request->input('retencion_ica', 0);
    $retIva = (float) $request->input('retencion_iva', 0);

    // Calcular total neto
    $valorTotal = round($subtotal + $iva - $retFuente - $retIca - $retIva, 2);

    // Preparar contrato_id: solo si es numérico y existe, sino null
    $contratoId = null;
    if ($request->filled('contrato_id') && is_numeric($request->contrato_id)) {
        $contratoId = (int) $request->contrato_id;
    }

    // Crear la cuenta de cobro
    $cuenta = CuentaCobro::create([
        'numero' => $request->numero,
        'fecha_emision' => $request->fecha_emision,
        'valor_total' => $valorTotal,
        'departamento' => $request->departamento,
        'municipio' => $request->municipio,
        'descripcion' => $request->descripcion,
        'tipo_identificacion' => $request->tipo_identificacion,
        'identificacion' => $request->identificacion,
        'tipo_cliente' => $request->tipo_cliente,
        'nombre_beneficiario' => $request->nombre_beneficiario,
        'plazo_pago' => $request->plazo_pago,
        'contrato_id' => $contratoId,
    'estado_aprobacion' => 'en_revision',
    // Flujo OBLIGATORIO: Supervisor → Ordenador → Contratación → Alcalde → Tesorería
    'etapa_aprobacion' => ($startStage = 'supervisor'),
        'user_id' => Auth::id(),
    ]);
    // Asegurar estado de pago por defecto
    $cuenta->estado_pago = 'pending';
    $cuenta->save();

    // Guardar ítems
    foreach ($request->items as $item) {
        ItemCuentaCobro::create([
            'cuenta_cobro_id' => $cuenta->id,
            'item' => $item['item'],
            'detalle' => $item['detalle'] ?? null,
            'cantidad' => $item['cantidad'],
            'precio_unitario' => $item['precio_unitario'],
        ]);
    }

    // Generar PDF automáticamente al crear la cuenta de cobro
    try {
        $data = [
            'cuenta' => $cuenta->load('items', 'contrato'),
            'subtotal' => $subtotal,
            'iva' => $iva,
            'retFuente' => $retFuente,
            'retIca' => $retIca,
            'retIva' => $retIva,
            'total' => $valorTotal,
            'appName' => config('app.name'),
        ];

        $pdf = Pdf::loadView('cuentas_cobro.pdf', $data)->setPaper('letter');
        $fileName = 'CuentaCobro_' . ($cuenta->numero ?? $cuenta->id) . '.pdf';
        // Asegurar carpeta
        Storage::makeDirectory('public/cuentas_cobro');
        Storage::put('public/cuentas_cobro/' . $fileName, $pdf->output());

        $pdfUrl = Storage::url('public/cuentas_cobro/' . $fileName);
    } catch (\Exception $e) {
        // Registrar error y continuar; no bloquear la creación por fallos en PDF
        \Log::error('Error generando PDF de cuenta de cobro: ' . $e->getMessage());
        $pdfUrl = null;
    }

    // Registrar historial: creado y enviado a revisión (etapa inicial)
    try {
        $cuenta->registrarHistorial(Auth::id(), 'creado', null, 'en_revision', 'Cuenta de cobro creada');
        $etiquetaInicial = $startStage === 'ordenador_gasto' ? 'Ordenador del Gasto' : ucfirst(str_replace('_',' ', $startStage));
        $cuenta->registrarHistorial(Auth::id(), 'revisado', 'pendiente', 'en_revision', 'Enviada a revisión (' . $etiquetaInicial . ')');
    } catch (\Exception $e) {
        \Log::warning('No se pudo registrar historial al crear la cuenta: '.$e->getMessage());
    }

    $msg = 'Cuenta de cobro creada y enviada a revisión.';
    if ($pdfUrl) {
        $msg .= ' <span style="display:inline-flex;align-items:center;gap:6px;margin-left:8px;"><a href="' . $pdfUrl . '" target="_blank" style="display:inline-flex;align-items:center;gap:6px;background:#007AFF;color:white;padding:8px 16px;border-radius:8px;text-decoration:none;font-weight:600;transition:all 0.2s;box-shadow:0 2px 8px rgba(0,122,255,0.3);" onmouseover="this.style.background=\'#0051D5\';this.style.transform=\'translateY(-2px)\';this.style.boxShadow=\'0 4px 12px rgba(0,122,255,0.4)\';" onmouseout="this.style.background=\'#007AFF\';this.style.transform=\'translateY(0)\';this.style.boxShadow=\'0 2px 8px rgba(0,122,255,0.3)\';"><span class="material-symbols-rounded" style="font-size:18px;">picture_as_pdf</span>Ver PDF</a></span>';
    }

    // Notificar SOLO al rol responsable de la etapa actual
    try {
        $rolesNotificar = [$startStage];
        $usuariosNotificar = User::whereHas('role', function($q) use ($rolesNotificar) {
            $q->whereIn('name', $rolesNotificar);
        })->get();

        foreach ($usuariosNotificar as $usuario) {
            Notificacion::create([
                'user_id' => $usuario->id,
                'tipo' => 'cuenta_cobro',
                'titulo' => 'Nueva cuenta para revisión (' . ($startStage === 'ordenador_gasto' ? 'Ordenador del Gasto' : ucfirst(str_replace('_',' ', $startStage))) . ')',
                'mensaje' => 'Cuenta #' . $cuenta->numero . ' por $' . number_format($cuenta->valor_total, 2, ',', '.') . ' - Beneficiario: ' . $cuenta->nombre_beneficiario,
                'cuenta_cobro_id' => $cuenta->id,
            ]);
        }
    } catch (\Exception $e) {
        \Log::error('Error creando notificaciones de cuenta de cobro: ' . $e->getMessage());
    }

    return redirect()->route('cuentas_cobro.index')->with('success', $msg);
    }


    /**
     * Mostrar una cuenta de cobro específica.
     */
    public function show($id)
    {
        $cuenta = CuentaCobro::with(['items', 'contrato', 'historial.user', 'aprobadoPor'])->findOrFail($id);
        return view('cuentas_cobro.show', compact('cuenta'));
    }

    /**
     * Listado de aprobaciones asignadas a mi rol y pendientes.
     */
    public function misAprobaciones()
    {
        $role = Auth::user()?->role?->name;
        $roleToEtapa = [
            'ordenador_gasto' => 'ordenador_gasto',
            'contratacion' => 'contratacion',
            'tesoreria' => 'tesoreria',
            'supervisor' => 'supervisor',
            'alcalde' => 'alcalde',
        ];

        $etapa = $roleToEtapa[$role] ?? null;
        
        // Super Admin ve todas las cuentas en revisión
        if ($role === 'super_admin') {
            $cuentas = CuentaCobro::where('estado_aprobacion', 'en_revision')
                ->whereNull('archived_at')
                ->orderByDesc('created_at')
                ->paginate(15);
        } else {
            // Otros roles solo ven cuentas en su etapa
            $cuentas = CuentaCobro::when($etapa, function ($q) use ($etapa) {
                    $q->where('estado_aprobacion', 'en_revision')
                      ->where('etapa_aprobacion', $etapa);
                })
                ->whereNull('archived_at')
                ->orderByDesc('created_at')
                ->paginate(15);
        }

        return view('cuentas_cobro.aprobaciones', compact('cuentas', 'etapa', 'role'));
    }

    /**
     * Aprobar una cuenta en la etapa actual o avanzar etapa.
     */
    public function aprobar(Request $request, $id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $role = Auth::user()?->role?->name;

        if ($cuenta->estado_aprobacion !== 'en_revision') {
            return back()->with('error', 'La cuenta no está en revisión.');
        }

        $comentario = $request->input('comentario');
        $estadoAnterior = $cuenta->estado_aprobacion;

        // 0) Supervisor -> Ordenador del Gasto (si la etapa es supervisor)
        if ($cuenta->etapa_aprobacion === 'supervisor' && in_array($role, ['supervisor', 'super_admin'])) {
            $cuenta->etapa_aprobacion = 'ordenador_gasto';
            $cuenta->save();
            $cuenta->registrarHistorial(Auth::id(), 'revisado', $estadoAnterior, 'en_revision', $comentario ?: 'Supervisor aprobó y envió a Ordenador del Gasto.');
            $this->notificarRoles(['ordenador_gasto'], 'Cuenta para revisión (Ordenador del Gasto)', $cuenta);
            return back()->with('success', 'Cuenta enviada a Ordenador del Gasto.');
        }

        // Avance por etapas (nuevo flujo)
        // 1) Ordenador del gasto -> Contratación
        if ($cuenta->etapa_aprobacion === 'ordenador_gasto' && in_array($role, ['ordenador_gasto', 'super_admin'])) {
            $cuenta->etapa_aprobacion = 'contratacion';
            $cuenta->save();
            $cuenta->registrarHistorial(Auth::id(), 'revisado', $estadoAnterior, 'en_revision', $comentario ?: 'Ordenador del Gasto aprobó y envió a Contratación.');
            $this->notificarRoles(['contratacion'], 'Cuenta para revisión (Contratación)', $cuenta);
            return back()->with('success', 'Cuenta enviada a Contratación.');
        }

        // 2) Contratación -> Alcalde (OBLIGATORIO, sin chequeo dinámico)
        if ($cuenta->etapa_aprobacion === 'contratacion' && in_array($role, ['contratacion', 'super_admin'])) {
            $cuenta->etapa_aprobacion = 'alcalde';
            $cuenta->save();
            $cuenta->registrarHistorial(Auth::id(), 'revisado', $estadoAnterior, 'en_revision', $comentario ?: 'Contratación aprobó y envió a Alcalde.');
            $this->notificarRoles(['alcalde'], 'Cuenta para revisión (Alcalde)', $cuenta);
            return back()->with('success', 'Cuenta enviada a Alcalde.');
        }

        // 3) Alcalde -> Tesorería (aquí consideramos la cuenta como aprobada)
        if ($cuenta->etapa_aprobacion === 'alcalde' && in_array($role, ['alcalde', 'super_admin'])) {
            $cuenta->estado_aprobacion = 'aprobado';
            $cuenta->etapa_aprobacion = 'tesoreria';
            $cuenta->aprobado_por_id = Auth::id();
            $cuenta->fecha_aprobacion = now();
            $cuenta->save();
            $cuenta->registrarHistorial(Auth::id(), 'aprobado', $estadoAnterior, 'aprobado', $comentario ?: 'Alcalde aprobó y envió a Tesorería para pago.');
            $this->notificarRoles(['tesoreria'], 'Cuenta aprobada. Pendiente de pago (Tesorería)', $cuenta);
            if ($cuenta->user_id) {
                Notificacion::create([
                    'user_id' => $cuenta->user_id,
                    'tipo' => 'cuenta_cobro',
                    'titulo' => 'Tu cuenta fue aprobada',
                    'mensaje' => 'La cuenta #' . $cuenta->numero . ' fue aprobada. Enviada a Tesorería para pago.',
                    'cuenta_cobro_id' => $cuenta->id,
                ]);
            }
            return back()->with('success', 'Cuenta enviada a Tesorería para registro de pago.');
        }

        // Tesorería no aprueba aquí: registra pago en otra acción
        return back()->with('error', 'No tienes permisos para aprobar esta etapa o la etapa requiere registrar pago.');
    }

    /**
     * Rechazar la cuenta en cualquier etapa.
     */
    public function rechazar(Request $request, $id)
    {
        $request->validate(['motivo_rechazo' => 'required|string|min:5']);
        $cuenta = CuentaCobro::findOrFail($id);
        if (!in_array($cuenta->estado_aprobacion, ['en_revision'])) {
            return back()->with('error', 'La cuenta no está en estado válido para rechazo.');
        }
        $estadoAnterior = $cuenta->estado_aprobacion;
        $cuenta->update([
            'estado_aprobacion' => 'rechazado',
            'motivo_rechazo' => $request->motivo_rechazo,
            'fecha_rechazo' => now(),
            'etapa_aprobacion' => null,
        ]);

        $cuenta->registrarHistorial(Auth::id(), 'rechazado', $estadoAnterior, 'rechazado', $request->motivo_rechazo);

        // Notificar al creador
        if ($cuenta->user_id) {
            Notificacion::create([
                'user_id' => $cuenta->user_id,
                'tipo' => 'cuenta_cobro',
                'titulo' => 'Tu cuenta fue rechazada',
                'mensaje' => 'Cuenta #'.$cuenta->numero.' fue rechazada. Motivo: '.$request->motivo_rechazo,
                'cuenta_cobro_id' => $cuenta->id,
            ]);
        }
        return back()->with('success', 'Cuenta rechazada.');
    }

    /** Enviar al cliente (tras aprobado) */
    public function enviarCliente($id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $role = Auth::user()?->role?->name;
        if ($cuenta->estado_aprobacion !== 'aprobado') {
            return back()->with('error', 'La cuenta debe estar aprobada para enviarse al cliente.');
        }
        if (!in_array($role, ['ordenador_gasto', 'alcalde', 'super_admin', 'tesoreria'])) {
            return back()->with('error', 'No tienes permisos para enviar al cliente.');
        }
        $cuenta->update([
            'estado_aprobacion' => 'enviado_cliente',
            'fecha_envio_cliente' => now(),
        ]);
        $cuenta->registrarHistorial(Auth::id(), 'enviado_cliente', 'aprobado', 'enviado_cliente', 'Enviado al cliente');
        return back()->with('success', 'Cuenta enviada al cliente.');
    }

    /**
     * Registrar pago (Tesorería)
     */
    public function registrarPago(Request $request, $id)
    {
        $request->validate([
            'valor_pagado' => 'required|numeric|min:0',
            'medio_pago' => 'required|string',
            'referencia_pago' => 'nullable|string|max:255',
            'observacion_pago' => 'nullable|string',
        ]);

        $cuenta = CuentaCobro::findOrFail($id);
        $role = Auth::user()?->role?->name;
        if (!in_array($role, ['tesoreria', 'super_admin'])) {
            return back()->with('error', 'No tienes permisos para registrar pagos.');
        }
        if ($cuenta->etapa_aprobacion !== 'tesoreria' || $cuenta->estado_aprobacion !== 'aprobado') {
            return back()->with('error', 'La cuenta no está lista para pago.');
        }

        // Actualizar campos de pago (usar columnas existentes)
        $cuenta->estado_pago = 'approved';
        $cuenta->fecha_pago = now();
        $cuenta->pagado_por = Auth::id();
        // Registrar detalle en observaciones
        $detallePago = "Pago: $" . number_format((float)$request->input('valor_pagado'), 2, ',', '.') .
            " | Medio: " . $request->input('medio_pago') .
            ( $request->filled('referencia_pago') ? (" | Ref: " . $request->input('referencia_pago')) : '' ) .
            ( $request->filled('observacion_pago') ? (" | Obs: " . $request->input('observacion_pago')) : '' );
        $cuenta->observaciones = trim(($cuenta->observaciones ? ($cuenta->observaciones . "\n") : '') . $detallePago);
        // Al notificar pago, devolver la cuenta al contratista (para su control/seguimiento)
        $cuenta->etapa_aprobacion = 'contratista';
        $cuenta->save();

        // Historial y notificación
        $cuenta->registrarHistorial(Auth::id(), 'pagado', 'aprobado', 'pagado', 'Pago registrado por Tesorería.');
        if ($cuenta->user_id) {
            Notificacion::create([
                'user_id' => $cuenta->user_id,
                'tipo' => 'cuenta_cobro',
                'titulo' => 'Pago realizado',
                'mensaje' => 'Tu cuenta #' . $cuenta->numero . ' fue pagada.',
                'cuenta_cobro_id' => $cuenta->id,
            ]);
        }

        return back()->with('success', 'Pago registrado correctamente.');
    }

    /**
     * Rechazar pago (Tesorería)
     */
    public function rechazarPago(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|min:5',
        ]);
        $cuenta = CuentaCobro::findOrFail($id);
        $role = Auth::user()?->role?->name;
        if (!in_array($role, ['tesoreria', 'super_admin'])) {
            return back()->with('error', 'No tienes permisos para rechazar pagos.');
        }
        if ($cuenta->etapa_aprobacion !== 'tesoreria' || $cuenta->estado_aprobacion !== 'aprobado') {
            return back()->with('error', 'La cuenta no está lista para pago.');
        }

    $cuenta->estado_pago = 'rejected';
    $cuenta->observaciones = trim(($cuenta->observaciones ? ($cuenta->observaciones . "\n") : '') . 'Pago rechazado: ' . $request->input('motivo'));
    $cuenta->save();

        $cuenta->registrarHistorial(Auth::id(), 'pago_rechazado', 'aprobado', 'aprobado', 'Pago rechazado por Tesorería: '.$request->input('motivo'));
        if ($cuenta->user_id) {
            Notificacion::create([
                'user_id' => $cuenta->user_id,
                'tipo' => 'cuenta_cobro',
                'titulo' => 'Pago rechazado',
                'mensaje' => 'El pago de tu cuenta #'.$cuenta->numero.' fue rechazado: '.$request->input('motivo'),
                'cuenta_cobro_id' => $cuenta->id,
            ]);
        }

        return back()->with('success', 'Pago marcado como rechazado.');
    }

    private function notificarRoles(array $roles, string $titulo, CuentaCobro $cuenta): void
    {
        $usuarios = User::whereHas('role', fn($q) => $q->whereIn('name', $roles))->get();
        foreach ($usuarios as $usuario) {
            Notificacion::create([
                'user_id' => $usuario->id,
                'tipo' => 'cuenta_cobro',
                'titulo' => $titulo,
                'mensaje' => 'Cuenta #'.$cuenta->numero.' por $'.number_format($cuenta->valor_total, 2, ',', '.').' para revisión.',
                'cuenta_cobro_id' => $cuenta->id,
            ]);
        }
    }

    /**
     * Mostrar formulario de edición.
     */
   public function edit($id)
{
    $cuenta = CuentaCobro::with('items')->findOrFail($id);
    $contratos = Contrato::all();

    $departamentos = \App\Models\Departamento::with('municipios')->get();
    $departamentosFormateados = [];
    foreach ($departamentos as $dep) {
        $departamentosFormateados[$dep->nombre] = $dep->municipios->pluck('nombre')->toArray();
    }

    // Restricciones de edición
    $role = Auth::user()?->role?->name;
    $readonly = false;
    if ($role === 'contratista') {
        if ($cuenta->user_id !== Auth::id() || $cuenta->estado_aprobacion !== 'en_correccion') {
            return redirect()->route('cuentas_cobro.show', $cuenta->id)->with('error', 'Solo puedes editar cuentas devueltas para corrección.');
        }
    } elseif ($role === 'tesoreria') {
        // Tesorería: acceso de solo lectura al formulario
        $readonly = true;
    } else {
        // Otros roles: no editar
        return redirect()->route('cuentas_cobro.show', $cuenta->id)->with('error', 'No tienes permisos para editar esta cuenta.');
    }

    return view('cuentas_cobro.edit', [
        'cuenta' => $cuenta,
        'contratos' => $contratos,
        'departamentos' => $departamentosFormateados,
        'readonly' => $readonly,
    ]);
}


    /**
     * Actualizar una cuenta de cobro existente.
     */
 public function update(Request $request, $id)
{
    $cuenta = CuentaCobro::findOrFail($id);
    $role = Auth::user()?->role?->name;
    if ($role === 'contratista') {
        if ($cuenta->user_id !== Auth::id() || $cuenta->estado_aprobacion !== 'en_correccion') {
            return redirect()->route('cuentas_cobro.show', $cuenta->id)->with('error', 'Solo puedes actualizar cuentas devueltas para corrección.');
        }
    }

    $request->validate([
        'fecha_emision' => 'required|date',
        'departamento' => 'required',
        'municipio' => 'required',
        'tipo_identificacion' => 'required',
        'tipo_cliente' => 'required',
        'nombre_beneficiario' => 'required',
        'items.*.item' => 'required|string',
        'items.*.cantidad' => 'required|integer|min:1',
        'items.*.precio_unitario' => 'required|numeric|min:0',
    ]);

    $subtotal = collect($request->items)->sum(function($item) {
        return $item['cantidad'] * $item['precio_unitario'];
    });
    $iva = (float) $request->input('iva_valor', 0);
    $retFuente = (float) $request->input('retencion_fuente', 0);
    $retIca = (float) $request->input('retencion_ica', 0);
    $retIva = (float) $request->input('retencion_iva', 0);
    $valorTotal = round($subtotal + $iva - $retFuente - $retIca - $retIva, 2);

    $cuenta->update([
        'fecha_emision' => $request->fecha_emision,
        'valor_total' => $valorTotal,
        'departamento' => $request->departamento,
        'municipio' => $request->municipio,
        'descripcion' => $request->descripcion,
        'tipo_identificacion' => $request->tipo_identificacion,
        'identificacion' => $request->identificacion,
        'tipo_cliente' => $request->tipo_cliente,
        'nombre_beneficiario' => $request->nombre_beneficiario,
        'plazo_pago' => $request->plazo_pago,
        'contrato_id' => $request->contrato_id ?? null,
    ]);

    // Eliminar ítems anteriores y guardar los nuevos
    $cuenta->items()->delete();
    foreach ($request->items as $item) {
        ItemCuentaCobro::create([
            'cuenta_cobro_id' => $cuenta->id,
            'item' => $item['item'],
            'detalle' => $item['detalle'] ?? null,
            'cantidad' => $item['cantidad'],
            'precio_unitario' => $item['precio_unitario'],
        ]);
    }

    // Regenerar PDF (si aplica) después de la actualización
    try {
        $data = [
            'cuenta' => $cuenta->load('items', 'contrato'),
            'subtotal' => $subtotal,
            'iva' => $iva,
            'retFuente' => $retFuente,
            'retIca' => $retIca,
            'retIva' => $retIva,
            'total' => $valorTotal,
            'appName' => config('app.name'),
        ];

        $pdf = Pdf::loadView('cuentas_cobro.pdf', $data)->setPaper('letter');
        $fileName = 'CuentaCobro_' . ($cuenta->numero ?? $cuenta->id) . '.pdf';
        Storage::makeDirectory('public/cuentas_cobro');
        Storage::put('public/cuentas_cobro/' . $fileName, $pdf->output());
    } catch (\Exception $e) {
        \Log::error('Error regenerando PDF de cuenta de cobro: ' . $e->getMessage());
    }

    return redirect()->route('cuentas_cobro.index')->with('success', 'Cuenta de cobro actualizada correctamente.');
}

    /**
     * Devolver para corrección (Contratación)
     */
    public function devolver(Request $request, $id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $role = Auth::user()?->role?->name;
        $request->validate(['motivo' => 'required|string|min:5']);
        if ($cuenta->estado_aprobacion !== 'en_revision' || $cuenta->etapa_aprobacion !== 'contratacion') {
            return back()->with('error', 'La cuenta no está en etapa de Contratación.');
        }
        if (!in_array($role, ['contratacion', 'super_admin'])) {
            return back()->with('error', 'No tienes permisos para devolver esta cuenta.');
        }
        $estadoAnterior = $cuenta->estado_aprobacion;
        $cuenta->estado_aprobacion = 'en_correccion';
        $cuenta->etapa_aprobacion = 'contratista';
        // Guardar motivo de devolución específico
        $cuenta->motivo_devolucion = $request->input('motivo');
        $cuenta->save();
        $cuenta->registrarHistorial(Auth::id(), 'devuelto', $estadoAnterior, 'en_correccion', 'Contratación devolvió: '.$request->input('motivo'));
        // Notificar al creador
        if ($cuenta->user_id) {
            Notificacion::create([
                'user_id' => $cuenta->user_id,
                'tipo' => 'cuenta_cobro',
                'titulo' => 'Cuenta devuelta para corrección',
                'mensaje' => 'La cuenta #'.$cuenta->numero.' fue devuelta por Contratación: '.$request->input('motivo'),
                'cuenta_cobro_id' => $cuenta->id,
            ]);
        }
        return back()->with('success', 'Cuenta devuelta al contratista para corrección.');
    }

    /**
     * Reenviar a revisión (Contratista)
     */
    public function reenviar($id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        if (Auth::user()?->role?->name !== 'contratista' || $cuenta->user_id !== Auth::id()) {
            return back()->with('error', 'No puedes reenviar esta cuenta.');
        }
        if ($cuenta->estado_aprobacion !== 'en_correccion') {
            return back()->with('error', 'La cuenta no está en corrección.');
        }
        $estadoAnterior = $cuenta->estado_aprobacion;
        $cuenta->estado_aprobacion = 'en_revision';
        $cuenta->etapa_aprobacion = 'ordenador_gasto';
        $cuenta->motivo_devolucion = null; // limpiar motivo de devolución al reenviar
        $cuenta->save();
        $cuenta->registrarHistorial(Auth::id(), 'reenviado', $estadoAnterior, 'en_revision', 'Contratista realizó correcciones y reenvió.');
        $this->notificarRoles(['ordenador_gasto'], 'Cuenta reenviada para revisión (Ordenador del Gasto)', $cuenta);
        return back()->with('success', 'Cuenta reenviada a revisión.');
    }
    /**
     * Eliminar una cuenta de cobro.
     */
    public function destroy($id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $cuenta->delete();

        return redirect()->route('cuentas_cobro.index')->with('success', 'Cuenta de cobro eliminada correctamente.');
    }

    /**
     * Mostrar vista de pagos (tesorería)
     */
    public function pagos()
    {
        // Obtener todas las cuentas con información relevante
        $cuentas = CuentaCobro::with(['user', 'items', 'contrato'])
            ->whereNull('archived_at')
            ->latest()
            ->get();

        // Calcular estadísticas
        $totalPagos = $cuentas->sum('valor_total');
        $pagosPendientes = $cuentas->where('estado_pago', 'pending')->count();
        $pagosAprobados = $cuentas->where('estado_pago', 'approved')->count();
        $pagosRechazados = $cuentas->where('estado_pago', 'rejected')->count();

        return view('cuentas_cobro.pagos', compact(
            'cuentas',
            'totalPagos',
            'pagosPendientes',
            'pagosAprobados',
            'pagosRechazados'
        ));
    }

    /**
     * Generar y visualizar el PDF de una cuenta de cobro.
     */
    public function pdf($id)
    {
        $cuenta = CuentaCobro::with(['items', 'contrato'])->findOrFail($id);

        // Asegurar cálculos en servidor
        $subtotal = $cuenta->items->sum(function ($it) {
            return ($it->cantidad ?? 0) * ($it->precio_unitario ?? 0);
        });
        // En este proyecto, valor_total ya es el neto; si no existe, usamos subtotal
        $total = $cuenta->valor_total ?? $subtotal;

        $data = [
            'cuenta' => $cuenta,
            'subtotal' => $subtotal,
            'total' => $total,
            'appName' => config('app.name'),
        ];

        $pdf = Pdf::loadView('cuentas_cobro.pdf', $data)->setPaper('letter');
        $fileName = 'CuentaCobro_' . ($cuenta->numero ?? $cuenta->id) . '.pdf';
        return $pdf->stream($fileName);
    }

    /**
     * Archivar una cuenta (solo contratista dueño)
     */
    public function archivar($id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $role = Auth::user()?->role?->name;
        if ($role !== 'contratista' || $cuenta->user_id !== Auth::id()) {
            return back()->with('error', 'No puedes archivar esta cuenta.');
        }
        if ($cuenta->archived_at) {
            return back()->with('info', 'La cuenta ya está archivada.');
        }
        $cuenta->archived_at = now();
        $cuenta->save();
        $cuenta->registrarHistorial(Auth::id(), 'archivado', $cuenta->estado_aprobacion, $cuenta->estado_aprobacion, 'Cuenta archivada por el contratista.');
        return redirect()->route('cuentas_cobro.index')->with('success', 'Cuenta archivada.');
    }

    /**
     * Desarchivar una cuenta (solo contratista dueño)
     */
    public function desarchivar($id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $role = Auth::user()?->role?->name;
        if ($role !== 'contratista' || $cuenta->user_id !== Auth::id()) {
            return back()->with('error', 'No puedes desarchivar esta cuenta.');
        }
        if (!$cuenta->archived_at) {
            return back()->with('info', 'La cuenta no está archivada.');
        }
        $cuenta->archived_at = null;
        $cuenta->save();
        $cuenta->registrarHistorial(Auth::id(), 'desarchivado', $cuenta->estado_aprobacion, $cuenta->estado_aprobacion, 'Cuenta desarchivada por el contratista.');
        return redirect()->route('cuentas_cobro.show', $cuenta->id)->with('success', 'Cuenta desarchivada.');
    }
}
