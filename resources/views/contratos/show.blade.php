@extends('layouts.app')

@section('title', 'Contrato ' . $contrato->numero)

@section('content')
<div class="container mt-4">
    <h1>Contrato {{ $contrato->numero }}</h1>

    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Objeto:</strong> {{ $contrato->objeto }}</li>
        <li class="list-group-item"><strong>Valor:</strong> ${{ number_format($contrato->valor,2) }}</li>
        <li class="list-group-item"><strong>Contratista:</strong> {{ $contrato->user->name ?? 'Sin asignar' }}</li>
        <li class="list-group-item"><strong>Estado:</strong> {{ ucfirst($contrato->estado) }}</li>
        <li class="list-group-item"><strong>Fecha Inicio:</strong> {{ $contrato->fecha_inicio }}</li>
        <li class="list-group-item"><strong>Fecha Fin:</strong> {{ $contrato->fecha_fin ?? 'N/A' }}</li>
    </ul>

    <a href="{{ route('contratacion.contratos.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
