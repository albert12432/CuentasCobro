@extends('layouts.app')

@section('title', 'Crear Contrato')

@section('content')
<div class="container mt-4">
    <h1>Nuevo Contrato</h1>

    <form action="{{ route('contratacion.contratos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="numero" class="form-label">Número</label>
            <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero') }}">
        </div>

        <div class="mb-3">
            <label for="objeto" class="form-label">Objeto</label>
            <input type="text" class="form-control" id="objeto" name="objeto" value="{{ old('objeto') }}">
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="{{ old('valor') }}">
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Contratista</label>
            <select name="user_id" id="user_id" class="form-select">
                @foreach($contratistas as $contratista)
                    <option value="{{ $contratista->id }}" {{ old('user_id') == $contratista->id ? 'selected' : '' }}>
                        {{ $contratista->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}">
        </div>

        <div class="mb-3">
            <label for="fecha_fin" class="form-label">Fecha Fin</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}">
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select">
                <option value="vigente" {{ old('estado') == 'vigente' ? 'selected' : '' }}>Vigente</option>
                <option value="finalizado" {{ old('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                <option value="suspendido" {{ old('estado') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Contrato</button>
        <a href="{{ route('contratacion.contratos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
