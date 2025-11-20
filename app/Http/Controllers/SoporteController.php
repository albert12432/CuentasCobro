<?php

namespace App\Http\Controllers;

use App\Models\CuentaCobro;
use App\Models\Soporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SoporteController extends Controller
{
    public function store(Request $request, $cuentaId)
    {
        $cuenta = CuentaCobro::findOrFail($cuentaId);
        $user = Auth::user();

        // Permitir solo al contratista dueño cuando está en corrección o en revisión inicial
        if ($user->role?->name !== 'contratista' || $cuenta->user_id !== $user->id) {
            return back()->with('error', 'No tienes permisos para adjuntar soportes.');
        }
        if (!in_array($cuenta->estado_aprobacion, ['en_correccion', 'en_revision'])) {
            return back()->with('error', 'La cuenta no está en estado válido para adjuntar soportes.');
        }

        $request->validate([
            'soportes.*' => 'required|file|max:10240', // 10MB por archivo
        ]);

        foreach ((array) $request->file('soportes', []) as $file) {
            $dir = 'public/soportes/'.$cuenta->id;
            Storage::makeDirectory($dir);
            $path = $file->store($dir);

            Soporte::create([
                'cuenta_cobro_id' => $cuenta->id,
                'user_id' => $user->id,
                'nombre' => $file->getClientOriginalName(),
                'path' => $path,
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }

        return back()->with('success', 'Soportes cargados correctamente.');
    }

    public function destroy($cuentaId, $soporteId)
    {
        $cuenta = CuentaCobro::findOrFail($cuentaId);
        $soporte = Soporte::where('cuenta_cobro_id', $cuenta->id)->findOrFail($soporteId);
        $user = Auth::user();

        if ($user->role?->name !== 'contratista' || $cuenta->user_id !== $user->id) {
            return back()->with('error', 'No tienes permisos para eliminar el soporte.');
        }
        if (!in_array($cuenta->estado_aprobacion, ['en_correccion', 'en_revision'])) {
            return back()->with('error', 'La cuenta no está en estado válido para eliminar soportes.');
        }

        // Eliminar archivo físico
        if ($soporte->path) {
            Storage::delete($soporte->path);
        }
        $soporte->delete();

        return back()->with('success', 'Soporte eliminado.');
    }
}
