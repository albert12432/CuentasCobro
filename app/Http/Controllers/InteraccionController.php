<?php

namespace App\Http\Controllers;

use App\Models\CuentaCobro;
use App\Models\Interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteraccionController extends Controller
{
    /**
     * Agregar una interacción manual (nota)
     */
    public function store(Request $request, $cuentaId)
    {
        $cuenta = CuentaCobro::findOrFail($cuentaId);
        
        // Validar permiso: solo ciertos roles pueden agregar notas
        $userRole = Auth::user()?->role?->name;
        
        $request->validate([
            'asunto' => 'required|string|max:200',
            'detalle' => 'required|string|max:1000',
            'tipo' => 'required|in:nota_manual,llamada',
        ]);

        Interaccion::registrar(
            $cuenta->id,
            $request->tipo,
            $request->asunto,
            $request->detalle
        );

        return back()->with('success', 'Interacción registrada exitosamente.');
    }

    /**
     * Eliminar una interacción (solo el que la creó o super_admin)
     */
    public function destroy($cuentaId, $interaccionId)
    {
        $interaccion = Interaccion::findOrFail($interaccionId);
        $userRole = Auth::user()?->role?->name;
        
        if (Auth::id() !== $interaccion->user_id && $userRole !== 'super_admin') {
            return back()->with('error', 'No puedes eliminar esta interacción.');
        }

        $interaccion->delete();
        return back()->with('success', 'Interacción eliminada.');
    }
}
