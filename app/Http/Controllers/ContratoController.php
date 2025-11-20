<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\User;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    // Mostrar listado de contratos
    public function index()
    {
        // Cargar contratos con información del contratista
        $contratos = Contrato::with('user')->latest()->get();
        return view('contratos.index', compact('contratos'));
    }

    // Mostrar formulario para crear un nuevo contrato
    public function create()
    {
        // Solo se listan usuarios que son contratistas
        $contratistas = User::whereHas('role', fn($q) => $q->where('name', 'contratista'))->get();
        return view('contratos.create', compact('contratistas'));
    }

    // Guardar contrato en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|unique:contratos,numero',
            'objeto' => 'required|string',
            'valor' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'user_id' => 'required|exists:users,id',
            'estado' => 'required|in:vigente,finalizado,suspendido',
        ]);

        Contrato::create($request->all());

        return redirect()->route('contratos.index')->with('success', 'Contrato creado correctamente.');
    }

    // Mostrar un contrato específico
    public function show(Contrato $contrato)
    {
        $contrato->load('user', 'cuentasCobro');
        return view('contratos.show', compact('contrato'));
    }

    // Mostrar formulario para editar un contrato
    public function edit(Contrato $contrato)
    {
        $contratistas = User::whereHas('role', fn($q) => $q->where('name', 'contratista'))->get();
        return view('contratos.edit', compact('contrato', 'contratistas'));
    }

    // Actualizar contrato en la base de datos
    public function update(Request $request, Contrato $contrato)
    {
        $request->validate([
            'numero' => "required|string|unique:contratos,numero,{$contrato->id}",
            'objeto' => 'required|string',
            'valor' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'user_id' => 'required|exists:users,id',
            'estado' => 'required|in:vigente,finalizado,suspendido',
        ]);

        $contrato->update($request->all());

        return redirect()->route('contratos.index')->with('success', 'Contrato actualizado correctamente.');
    }

    // Eliminar contrato
    public function destroy(Contrato $contrato)
    {
        $contrato->delete();
        return redirect()->route('contratos.index')->with('success', 'Contrato eliminado correctamente.');
    }
}
