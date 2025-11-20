@extends('layouts.app')

@section('title', 'Eliminar Rol - CuentasCobro')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-danger">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminación</h4>
        </div>
        <div class="card-body">
            <p class="fs-5">¿Estás seguro de que deseas eliminar el siguiente rol?</p>

            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Nombre:</strong> {{ $role->name }}</li>
                <li class="list-group-item"><strong>Descripción:</strong> {{ $role->description }}</li>
                <li class="list-group-item"><strong>Permisos asignados:</strong>
                    <ul>
                        @foreach ($role->permissions as $permiso)
                            <li>{{ $permiso->description ?? $permiso->name }}</li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <div class="alert alert-warning">
                <i class="fas fa-info-circle me-2"></i>
                Esta acción no se puede deshacer.
            </div>

            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Eliminar definitivamente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
