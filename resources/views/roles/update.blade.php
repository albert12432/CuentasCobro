@extends('layouts.app')

@section('title', 'Editar Rol - CuentasCobro')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <!-- Sidebar opcional -->
        </div>
        
        <div class="col-md-10">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.roles.index') }}" class="text-decoration-none">
                                    <i class="fas fa-users-cog me-1"></i>Roles
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Editar Rol</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold text-dark mb-0">
                        <i class="fas fa-edit text-primary me-2"></i>
                        Editar Rol
                    </h2>
                </div>

                <div class="btn-group" role="group">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver
                    </a>
                </div>
            </div>

            <!-- Mensajes de error -->
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>¡Error!</strong> Corrige los siguientes campos:
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Formulario -->
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" id="updateRoleForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Información básica -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Información Básica
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-tag me-1"></i>Nombre del Rol
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name"
                                           value="{{ old('name', $role->name) }}"
                                           required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Use solo letras minúsculas y guiones bajos.
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Descripción -->
                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">
                                        <i class="fas fa-align-left me-1"></i>Descripción
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description"
                                              rows="4"
                                              required>{{ old('description', $role->description) }}</textarea>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>Máximo 500 caracteres.
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Resumen -->
                                <div class="mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body py-2">
                                            <h6 class="mb-1">
                                                <i class="fas fa-chart-pie me-1"></i>Resumen de Permisos
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">Permisos seleccionados:</small>
                                                <span class="badge bg-info" id="selectedCount">0</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">Total disponibles:</small>
                                                <span class="badge bg-secondary">{{ count($availablePermissions) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permisos -->
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-key me-2"></i>Actualizar Permisos
                                </h5>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-light btn-sm" onclick="selectAllPermissions()">
                                        <i class="fas fa-check-square me-1"></i>Seleccionar Todo
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm" onclick="clearAllPermissions()">
                                        <i class="fas fa-square me-1"></i>Limpiar Todo
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                @php
                                    $assignedPermissions = $role->permissions->pluck('name')->toArray();
                                @endphp
                                <div class="row">
                                    @foreach($permissionCategories as $category => $categoryPermissions)
                                    <div class="col-md-6 mb-4">
                                        <div class="border rounded p-3 h-100">
                                            <h6 class="fw-bold text-primary mb-2">
                                                {{ $category }}
                                            </h6>
                                            @foreach($categoryPermissions as $permission => $description)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input permission-checkbox"
                                                       type="checkbox"
                                                       id="permission_{{ $permission }}"
                                                       name="permissions[]"
                                                       value="{{ $permission }}"
                                                       {{ in_array($permission, old('permissions', $assignedPermissions)) ? 'checked' : '' }}
                                                       onchange="updatePermissionCount()">
                                                <label class="form-check-label" for="permission_{{ $permission }}">
                                                    <small>{{ $description }}</small>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Campos marcados con <span class="text-danger">*</span> son obligatorios.
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Actualizar Rol
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updatePermissionCount() {
        const checked = document.querySelectorAll('input[name="permissions[]"]:checked');
        document.getElementById('selectedCount').textContent = checked.length;
    }

    function selectAllPermissions() {
        document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = true);
        updatePermissionCount();
    }

    function clearAllPermissions() {
        document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = false);
        updatePermissionCount();
    }

    document.addEventListener('DOMContentLoaded', updatePermissionCount);

    document.getElementById('name').addEventListener('input', function(e) {
        let value = e.target.value;
        value = value.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z_]/g, '');
        e.target.value = value;
    });
    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role_id' => 'required|exists:roles,id',
    ]);

    $data = $request->only(['name', 'email', 'role_id']);
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('users.index')->with('success', 'Usuario actualizado');
}

</script>
@endpush
@endsection
