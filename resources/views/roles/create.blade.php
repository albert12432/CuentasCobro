@extends('layouts.app')

@section('title', 'Crear Nuevo Rol')

@section('content')
<style>
    .form-header {
        background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
        border-radius: 24px;
        padding: 40px 32px;
        color: white;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 10px 40px rgba(124, 58, 237, 0.15);
    }

    .form-header .material-symbols-rounded {
        font-size: 40px;
    }

    .form-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--apple-blue);
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 24px;
        transition: all 0.2s;
    }

    .back-link:hover {
        gap: 12px;
    }

    .form-container {
        background: white;
        border-radius: 18px;
        padding: 32px;
        box-shadow: var(--shadow-sm);
        max-width: 700px;
    }

    .form-section {
        margin-bottom: 32px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--apple-dark);
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title .material-symbols-rounded {
        color: var(--apple-blue);
        font-size: 22px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--apple-dark);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label .required {
        color: var(--apple-red);
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid rgba(0, 0, 0, 0.15);
        border-radius: 12px;
        font-size: 15px;
        font-family: inherit;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--apple-blue);
        box-shadow: 0 0 0 4px var(--apple-blue-light);
        background: #f9f9ff;
    }

    .form-input.error {
        border-color: var(--apple-red);
        background: rgba(255, 59, 48, 0.05);
    }

    .form-input.error:focus {
        box-shadow: 0 0 0 4px rgba(255, 59, 48, 0.1);
    }

    .error-message {
        color: var(--apple-red);
        font-size: 13px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
        margin-top: 12px;
    }

    .permission-chip {
        padding: 12px 16px;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 13px;
        font-weight: 500;
        text-align: center;
        color: var(--apple-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .permission-chip:hover {
        border-color: var(--apple-blue);
        color: var(--apple-blue);
    }

    .permission-chip.active {
        background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
    }

    .permissions-info {
        font-size: 13px;
        color: var(--apple-gray);
        margin-top: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .permissions-info .material-symbols-rounded {
        font-size: 18px;
        color: var(--apple-blue);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 2px solid rgba(0, 0, 0, 0.05);
    }

    .btn-submit {
        padding: 12px 28px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary-submit {
        background: linear-gradient(135deg, #0071e3 0%, #0056b3 100%);
        color: white;
    }

    .btn-primary-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 113, 227, 0.3);
    }

    .btn-cancel {
        background: rgba(0, 0, 0, 0.05);
        color: var(--apple-dark);
        flex: 1;
        justify-content: center;
    }

    .btn-cancel:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    .info-box {
        background: linear-gradient(135deg, rgba(0, 113, 227, 0.05), rgba(0, 198, 255, 0.05));
        border-left: 4px solid var(--apple-blue);
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 13px;
        color: var(--apple-blue);
        margin-top: 12px;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .info-box .material-symbols-rounded {
        font-size: 20px;
        flex-shrink: 0;
        margin-top: -2px;
    }

    @media (max-width: 768px) {
        .form-header {
            flex-direction: column;
            text-align: center;
            padding: 32px 24px;
        }

        .form-container {
            padding: 24px;
        }

        .permissions-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-cancel {
            order: 2;
        }

        .btn-primary-submit {
            order: 1;
        }
    }
</style>

<a href="{{ route('admin.roles.index') }}" class="back-link">
    <span class="material-symbols-rounded" style="font-size: 20px;">arrow_back</span>
    Volver a roles
</a>

<!-- Form Header -->
<div class="form-header">
    <span class="material-symbols-rounded">add_circle</span>
    <h1>Crear Nuevo Rol</h1>
</div>

<!-- Form Container -->
<div class="form-container">
    <form action="{{ route('admin.roles.store') }}" method="POST" id="roleForm">
        @csrf

        <!-- Role Information Section -->
        <div class="form-section">
            <div class="section-title">
                <span class="material-symbols-rounded">info</span>
                Información del Rol
            </div>

            <div class="form-group">
                <label class="form-label" for="name">
                    Nombre del Rol
                    <span class="required">*</span>
                </label>
                <input type="text" id="name" name="name" class="form-input @error('name') error @enderror"
                       value="{{ old('name') }}" placeholder="Ej: Supervisor, Contratista" required>
                @error('name')
                    <div class="error-message">
                        <span class="material-symbols-rounded" style="font-size: 16px;">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="info-box">
                <span class="material-symbols-rounded">info</span>
                <span>El nombre del rol debe ser único y descriptivo</span>
            </div>
        </div>

        <!-- Permissions Section -->
        <div class="form-section">
            <div class="section-title">
                <span class="material-symbols-rounded">security</span>
                Asignar Permisos
            </div>

            @if($availablePermissions && count($availablePermissions) > 0)
                <div class="permissions-grid">
                    @foreach($availablePermissions as $permission)
                        <button type="button" 
                                class="permission-chip @if(collect(old('permissions'))->contains($permission)) active @endif"
                                data-value="{{ $permission }}"
                                onclick="togglePermission(this)">
                            <span class="material-symbols-rounded" style="font-size: 18px;">check_circle</span>
                            {{ ucfirst(str_replace('_', ' ', $permission)) }}
                        </button>
                    @endforeach
                </div>
                <input type="hidden" name="permissions" id="permissionsInput" value="{{ old('permissions') ? implode(',', old('permissions')) : '' }}">
                
                <div class="permissions-info">
                    <span class="material-symbols-rounded">touch_app</span>
                    <span>Haz clic en los permisos para seleccionarlos o deseleccionarlos</span>
                </div>
            @else
                <div class="info-box">
                    <span class="material-symbols-rounded">warning</span>
                    <span>No hay permisos disponibles. Por favor, crea algunos permisos primero.</span>
                </div>
            @endif
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('admin.roles.index') }}" class="btn-submit btn-cancel">
                <span class="material-symbols-rounded" style="font-size: 20px;">close</span>
                Cancelar
            </a>
            <button type="submit" class="btn-submit btn-primary-submit">
                <span class="material-symbols-rounded" style="font-size: 20px;">save</span>
                Crear Rol
            </button>
        </div>
    </form>
</div>

<script>
function togglePermission(chip) {
    chip.classList.toggle('active');
    updatePermissionsInput();
}

function updatePermissionsInput() {
    const chips = document.querySelectorAll('.permission-chip.active');
    const permissions = Array.from(chips).map(chip => chip.getAttribute('data-value'));
    document.getElementById('permissionsInput').value = permissions.join(',');
}

// Validación del formulario
document.getElementById('roleForm').addEventListener('submit', function(e) {
    const nameInput = document.getElementById('name');
    
    if (!nameInput.value.trim()) {
        e.preventDefault();
        nameInput.classList.add('error');
        nameInput.focus();
    }
});

// Remover error cuando el usuario escriba
document.getElementById('name').addEventListener('input', function() {
    this.classList.remove('error');
});
</script>

@endsection