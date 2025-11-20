<?php

namespace App\Http\Controllers;

use App\Models\CuentaCobro;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportesController extends Controller
{
    /**
     * Dashboard principal de reportes
     */
    public function index()
    {
        $ahora = now();
        
        // === TOTALES GENERALES ===
        $totalCuentas = CuentaCobro::notArchived()->count();
        $totalValor = CuentaCobro::notArchived()->sum('valor_total');
        $totalPagado = CuentaCobro::where('estado_aprobacion', 'pagado')
            ->notArchived()
            ->sum('valor_total');
        $totalPendiente = $totalValor - $totalPagado;

        // === DISTRIBUCIÓN POR ESTADO ===
        $porEstado = CuentaCobro::notArchived()
            ->select('estado_aprobacion', DB::raw('count(*) as total'), DB::raw('sum(valor_total) as valor'))
            ->groupBy('estado_aprobacion')
            ->get();

        // === POR DEPARTAMENTO ===
        $porDepartamento = CuentaCobro::notArchived()
            ->select('departamento', DB::raw('count(*) as total'), DB::raw('sum(valor_total) as valor'))
            ->groupBy('departamento')
            ->orderByDesc('valor')
            ->get();

        // === AGING (Antigüedad de cuentas) ===
        $aging = $this->calcularAging();

        // === CUENTAS MÁS RECIENTES ===
        $recentesCreadas = CuentaCobro::notArchived()
            ->latest('fecha_emision')
            ->limit(10)
            ->get();

        // === CUENTAS PAGADAS ESTE MES ===
        $mesActual = $ahora->month;
        $anoActual = $ahora->year;
        $pagadasEsteMes = CuentaCobro::where('estado_aprobacion', 'pagado')
            ->whereMonth('fecha_pago', $mesActual)
            ->whereYear('fecha_pago', $anoActual)
            ->notArchived()
            ->sum('valor_total');

        return view('reportes.index', compact(
            'totalCuentas',
            'totalValor',
            'totalPagado',
            'totalPendiente',
            'porEstado',
            'porDepartamento',
            'aging',
            'recentesCreadas',
            'pagadasEsteMes'
        ));
    }

    /**
     * Detalle de un departamento
     */
    public function departamento($nombre)
    {
        $departamento = $nombre;
        
        $cuentas = CuentaCobro::where('departamento', $departamento)
            ->notArchived()
            ->with(['user', 'items'])
            ->orderByDesc('created_at')
            ->paginate(20);

        $totalValor = CuentaCobro::where('departamento', $departamento)
            ->notArchived()
            ->sum('valor_total');

        $distribucion = CuentaCobro::where('departamento', $departamento)
            ->notArchived()
            ->select('estado_aprobacion', DB::raw('count(*) as total'), DB::raw('sum(valor_total) as valor'))
            ->groupBy('estado_aprobacion')
            ->get();

        return view('reportes.departamento', compact('departamento', 'cuentas', 'totalValor', 'distribucion'));
    }

    /**
     * Detalle de un cliente/contratista
     */
    public function cliente($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        
        $cuentas = CuentaCobro::where('user_id', $userId)
            ->notArchived()
            ->with(['items', 'historial'])
            ->orderByDesc('created_at')
            ->paginate(20);

        $totalValor = CuentaCobro::where('user_id', $userId)
            ->notArchived()
            ->sum('valor_total');

        $totalPagado = CuentaCobro::where('user_id', $userId)
            ->where('estado_aprobacion', 'pagado')
            ->notArchived()
            ->sum('valor_total');

        $distribucion = CuentaCobro::where('user_id', $userId)
            ->notArchived()
            ->select('estado_aprobacion', DB::raw('count(*) as total'), DB::raw('sum(valor_total) as valor'))
            ->groupBy('estado_aprobacion')
            ->get();

        return view('reportes.cliente', compact('user', 'cuentas', 'totalValor', 'totalPagado', 'distribucion'));
    }

    /**
     * Reporte de aging (antigüedad de cuentas)
     */
    public function aging()
    {
        $ahora = now();
        $aging = $this->calcularAging();

        // Detalles de cada bucket
        $buckets = [
            ['rango' => '0-30 días', 'dias_min' => 0, 'dias_max' => 30],
            ['rango' => '31-60 días', 'dias_min' => 31, 'dias_max' => 60],
            ['rango' => '61-90 días', 'dias_min' => 61, 'dias_max' => 90],
            ['rango' => '90+ días', 'dias_min' => 91, 'dias_max' => 999],
        ];

        foreach ($buckets as &$bucket) {
            $bucket['cuentas'] = CuentaCobro::where('estado_aprobacion', 'enviado_cliente')
                ->notArchived()
                ->select('*', DB::raw("DATEDIFF(NOW(), fecha_envio_cliente) as dias_antiguedad"))
                ->havingRaw('dias_antiguedad BETWEEN ? AND ?', [$bucket['dias_min'], $bucket['dias_max']])
                ->with(['user'])
                ->get();
            
            $bucket['total'] = $bucket['cuentas']->count();
            $bucket['valor'] = $bucket['cuentas']->sum('valor_total');
        }

        return view('reportes.aging', compact('buckets'));
    }

    /**
     * Exportar reportes a CSV
     */
    public function exportar($tipo = 'general')
    {
        $filename = 'reporte_' . $tipo . '_' . now()->format('Y-m-d-H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($tipo) {
            $file = fopen('php://output', 'w');
            
            if ($tipo === 'general') {
                fputcsv($file, ['ID', 'Número', 'Fecha', 'Beneficiario', 'Valor Total', 'Estado', 'Departamento', 'Municipio']);
                CuentaCobro::notArchived()->with(['user'])->chunk(100, function($cuentas) use ($file) {
                    foreach ($cuentas as $c) {
                        fputcsv($file, [
                            $c->id,
                            $c->numero,
                            $c->fecha_emision,
                            $c->nombre_beneficiario,
                            $c->valor_total,
                            $c->estado_aprobacion,
                            $c->departamento,
                            $c->municipio,
                        ]);
                    }
                });
            } elseif ($tipo === 'pagos') {
                fputcsv($file, ['ID', 'Número', 'Beneficiario', 'Valor', 'Fecha Pago', 'Pagado Por']);
                CuentaCobro::where('estado_aprobacion', 'pagado')
                    ->notArchived()
                    ->chunk(100, function($cuentas) use ($file) {
                    foreach ($cuentas as $c) {
                        fputcsv($file, [
                            $c->id,
                            $c->numero,
                            $c->nombre_beneficiario,
                            $c->valor_total,
                            $c->fecha_pago,
                            $c->pagado_por,
                        ]);
                    }
                });
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calcular antigüedad por buckets
     */
    private function calcularAging()
    {
        $ahora = now();
        
        return [
            '0_30' => CuentaCobro::where('estado_aprobacion', 'enviado_cliente')
                ->notArchived()
                ->whereBetween('fecha_envio_cliente', [
                    $ahora->copy()->subDays(30),
                    $ahora
                ])
                ->count(),
            '31_60' => CuentaCobro::where('estado_aprobacion', 'enviado_cliente')
                ->notArchived()
                ->whereBetween('fecha_envio_cliente', [
                    $ahora->copy()->subDays(60),
                    $ahora->copy()->subDays(31)
                ])
                ->count(),
            '61_90' => CuentaCobro::where('estado_aprobacion', 'enviado_cliente')
                ->notArchived()
                ->whereBetween('fecha_envio_cliente', [
                    $ahora->copy()->subDays(90),
                    $ahora->copy()->subDays(61)
                ])
                ->count(),
            '90_plus' => CuentaCobro::where('estado_aprobacion', 'enviado_cliente')
                ->notArchived()
                ->where('fecha_envio_cliente', '<', $ahora->copy()->subDays(90))
                ->count(),
        ];
    }
}
