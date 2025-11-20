<?php

namespace App\Http\Controllers;

use App\Models\ItemCuentaCobro;
use App\Models\CuentaCobro;
use Illuminate\Http\Request;

class ItemCuentaCobroController extends Controller
{
    /**
     * Guarda un nuevo ítem asociado a una cuenta de cobro.
     */
    public function store(Request $request, $cuenta_cobro_id)
    {
        $request->validate([
            'item' => 'required|string|max:255',
            'detalle' => 'nullable|string',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        $cuentaCobro = CuentaCobro::findOrFail($cuenta_cobro_id);

        $item = new ItemCuentaCobro($request->all());
        $item->cuenta_cobro_id = $cuentaCobro->id;
        $item->save();

        // Actualiza el total de la cuenta
        $cuentaCobro->actualizarValorTotal();

        return redirect()
            ->back()
            ->with('success', 'Ítem agregado correctamente.');
    }

    /**
     * Actualiza un ítem existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'item' => 'required|string|max:255',
            'detalle' => 'nullable|string',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        $item = ItemCuentaCobro::findOrFail($id);
        $item->update($request->all());

        // Recalcular total
        $item->cuentaCobro->actualizarValorTotal();

        return redirect()
            ->back()
            ->with('success', 'Ítem actualizado correctamente.');
    }

    /**
     * Elimina un ítem de la cuenta.
     */
    public function destroy($id)
    {
        $item = ItemCuentaCobro::findOrFail($id);
        $cuentaCobro = $item->cuentaCobro;

        $item->delete();

        // Actualiza el total después de borrar
        $cuentaCobro->actualizarValorTotal();

        return redirect()
            ->back()
            ->with('success', 'Ítem eliminado correctamente.');
    }
}
