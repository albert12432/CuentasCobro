@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">✏️ Editar Usuario</h4>
        </div>

        <div class="card-body">
            {{-- Mensajes de error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops!</strong> Corrige los siguientes errores:<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario --}}
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">Nombre completo</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-bold">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-bold">Contraseña (dejar en blanco si no quieres cambiar)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="role_id" class="form-label fw-bold">Rol</label>
                        <select name="role_id" id="role_id" class="form-select" required>
                            <option value="">-- Selecciona un rol --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">
                        ← Volver
                    </a>
                    <button type="submit" class="btn btn-success">
                        💾 Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
