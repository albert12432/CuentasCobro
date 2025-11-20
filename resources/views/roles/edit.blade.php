@extends('layouts.app')

@section('title', 'Editar Rol - ' . ucfirst(str_replace('_', ' ', $role->name)))

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
        border-radius: 24px;
        padding: 40px 32px;
        color: white;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        box-shadow: 0 10px 40px rgba(124, 58, 237, 0.15);
        flex-wrap: wrap;
    }

    .page-header-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-header-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }

    .page-header p {
        font-size: 14px;
        opacity: 0.9;
        margin: 4px 0 0 0;
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

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 24px;
        margin-bottom: 32px;
    }

    .card {
        background: white;
        border-radius: 18px;
        padding: 28px 32px;
        box-shadow: var(--shadow-sm);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.05);
    }

    .card-header .material-symbols-rounded {
        color: var(--apple-blue);
        font-size: 28px;
    }

    .card-header h2 {
        font-size: 18px;
        font-weight: 600;
        color: var(--apple-dark);
        margin: 0;
    }

    .info-box {
        background: linear-gradient(135deg, rgba(0, 113, 227, 0.05), rgba(0, 198, 255, 0.05));
        border-left: 4px solid var(--apple-blue);
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 14px;
        color: var(--apple-blue);
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-box .material-symbols-rounded {
        font-size: 20px;
        flex-shrink: 0;
        margin-top: -2px;
    }

    .alert-warning-custom {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.05), rgba(255, 152, 0, 0.05));
        border-left: 4px solid #ffc107;
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 14px;
        color: #ff9800;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
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

    .form-input:disabled {
        background: #f5f5f5;
        color: var(--apple-gray);
        cursor: not-allowed;
    }

    .stat-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 16px;
    }

    .stat-item {
        background: rgba(0, 113, 227, 0.05);
        border-radius: 12px;
        padding: 12px;
        text-align: center;
    }

    .stat-item .stat-value {
        font-size: 20px;
        font-weight: 700;
        color: var(--apple-blue);
        display: block;
    }

    .stat-item .stat-label {
        font-size: 12px;
        color: var(--apple-gray);
        margin-top: 4px;
    }

    .permissions-section {
        margin-top: 24px;
    }

    .permissions-toolbar {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .btn-small {
        padding: 8px 16px;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        background: white;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-small:hover {
        background: rgba(0, 113, 227, 0.1);
        color: var(--apple-blue);
        border-color: var(--apple-blue);
    }

    .permission-category {
        background: rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
    }

    .category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .category-title {
        font-weight: 600;
        color: var(--apple-dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .category-title .material-symbols-rounded {
        font-size: 20px;
        color: var(--apple-blue);
    }

    .permission-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 0;
    }

    .permission-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--apple-blue);
    }

    .permission-label {
        font-size: 14px;
        color: var(--apple-dark);
        cursor: pointer;
        flex: 1;
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
        flex: 1;
        justify-content: center;
    }

    .btn-primary-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 113, 227, 0.3);
    }

    .btn-cancel {
        background: rgba(0, 0, 0, 0.05);
        color: var(--apple-dark);
    }

    .btn-cancel:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            text-align: center;
            align-items: flex-start;
            padding: 32px 24px;
        }

        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-header-icon {
            display: none;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-primary-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }

        .stat-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<a href="{{ route('admin.roles.index') }}" class="back-link">
    <span class="material-symbols-rounded" style="font-size: 20px;">arrow_back</span>
    Volver a roles
</a>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-icon">
            <span class="material-symbols-rounded">group_add</span>
        </div>
        <div>
            <h1>Editar Rol</h1>
            <p>{{ ucfirst(str_replace('_', ' ', $role->name)) }}</p>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
    <!-- Left Sidebar -->
    <div>
        <!-- Role Information Card -->
        <div class="card">
            <div class="card-header">
                <span class="material-symbols-rounded">info</span>
                <h2>Información del Rol</h2>
            </div>

            @php
                $isSystemRole = in_array($role->name, ['contratista', 'supervisor', 'alcalde', 'ordenador_gasto', 'tesoreria', 'contratacion', 'super_admin']);
            @endphp

            @if($isSystemRole)
                <div class="alert-warning-custom">
                    <span class="material-symbols-rounded">lock</span>
                    <span>Este es un rol del sistema. Solo pueden editarse los permisos.</span>
                </div>
            @endif

            <div class="form-group">
                <label class="form-label">Nombre del Rol</label>
                <input type="text" class="form-input" value="{{ $role->name }}" disabled>
            </div>

            <div class="stat-row">
                <div class="stat-item">
                    <span class="stat-value">{{ $role->users()->count() }}</span>
                    <span class="stat-label">Usuarios</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $role->permissions?->count() ?? 0 }}</span>
                    <span class="stat-label">Permisos</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ count($availablePermissions ?? []) }}</span>
                    <span class="stat-label">Total</span>
                </div>
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.05);">
                <div style="margin-bottom: 12px;">
                    <label class="form-label" style="margin-bottom: 4px;">Creado:</label>
                    <div style="font-size: 14px; color: var(--apple-gray);">{{ $role->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div>
                    <label class="form-label" style="margin-bottom: 4px;">Actualizado:</label>
                    <div style="font-size: 14px; color: var(--apple-gray);">{{ $role->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Content -->
    <div>
        <!-- Permissions Card -->
        <div class="card">
            <div class="card-header">
                <span class="material-symbols-rounded">security</span>
                <h2>Gestionar Permisos</h2>
            </div>

            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" id="editRoleForm">
                @csrf
                @method('PUT')

                @if($role->users()->count() > 0)
                    <div class="info-box">
                        <span class="material-symbols-rounded">info</span>
                        <span>Este rol tiene {{ $role->users()->count() }} usuario(s). Los cambios se aplicarán inmediatamente.</span>
                    </div>
                @endif

                <div class="permissions-toolbar">
                    <button type="button" class="btn-small" onclick="selectAllPermissions()">
                        <span class="material-symbols-rounded" style="font-size: 18px;">check_circle</span>
                        Seleccionar Todo
                    </button>
                    <button type="button" class="btn-small" onclick="clearAllPermissions()">
                        <span class="material-symbols-rounded" style="font-size: 18px;">radio_button_unchecked</span>
                        Limpiar Todo
                    </button>
                </div>

                <div class="permissions-section">
                    @php
                        $permissionCategories = [
                            'Cuentas de Cobro' => ['create_cuenta_cobro', 'view_cuenta_cobro', 'view_own_cuenta_cobro', 'view_all_cuenta_cobro', 'edit_own_cuenta_cobro', 'review_cuenta_cobro', 'approve_cuenta_cobro', 'reject_cuenta_cobro', 'final_approval'],
                            'Documentos' => ['upload_documents', 'view_documents'],
                            'Contratos' => ['view_contract_info', 'manage_contracts', 'contract_validation'],
                            'Pagos' => ['authorize_payment', 'process_payment', 'generate_checks', 'bank_transfers', 'payment_confirmation', 'generate_payment_orders'],
                            'Presupuesto' => ['view_budget', 'manage_budget'],
                            'Reportes' => ['view_reports', 'financial_reports', 'view_financial_reports', 'contract_reports'],
                            'Administración' => ['manage_users', 'manage_contractors', 'contractor_registration', 'system_admin'],
                            'Otros' => ['add_comments', 'request_corrections', 'override_decisions']
                        ];
                    @endphp

                    @foreach($permissionCategories as $category => $categoryPerms)
                        <div class="permission-category">
                            <div class="category-header">
                                <div class="category-title">
                                    @switch($category)
                                        @case('Cuentas de Cobro')
                                            <span class="material-symbols-rounded">receipt_long</span>
                                            @break
                                        @case('Documentos')
                                            <span class="material-symbols-rounded">description</span>
                                            @break
                                        @case('Contratos')
                                            <span class="material-symbols-rounded">handshake</span>
                                            @break
                                        @case('Pagos')
                                            <span class="material-symbols-rounded">payment</span>
                                            @break
                                        @case('Presupuesto')
                                            <span class="material-symbols-rounded">trending_up</span>
                                            @break
                                        @case('Reportes')
                                            <span class="material-symbols-rounded">bar_chart</span>
                                            @break
                                        @case('Administración')
                                            <span class="material-symbols-rounded">admin_panel_settings</span>
                                            @break
                                        @default
                                            <span class="material-symbols-rounded">more_horiz</span>
                                    @endswitch
                                    {{ $category }}
                                </div>
                            </div>

                            @foreach($categoryPerms as $permission)
                                @if(in_array($permission, $availablePermissions ?? []))
                                    <div class="permission-item">
                                        <input type="checkbox" class="permission-checkbox category-{{ strtolower(str_replace(' ', '_', $category)) }}" 
                                               name="permissions[]" value="{{ $permission }}"
                                               {{ in_array($permission, $role->permissions->pluck('name')->toArray() ?? []) ? 'checked' : '' }}
                                               id="perm_{{ $permission }}">
                                        <label class="permission-label" for="perm_{{ $permission }}">
                                            {{ ucfirst(str_replace('_', ' ', $permission)) }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.roles.index') }}" class="btn-submit btn-cancel">
                        <span class="material-symbols-rounded" style="font-size: 20px;">close</span>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-submit btn-primary-submit">
                        <span class="material-symbols-rounded" style="font-size: 20px;">save</span>
                        Actualizar Rol
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function selectAllPermissions() {
    document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
}

function clearAllPermissions() {
    document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
}

document.getElementById('editRoleForm').addEventListener('submit', function(e) {
    if (document.querySelectorAll('.permission-checkbox:checked').length === 0) {
        if (!confirm('¿Estás seguro de quitar todos los permisos? Esto puede afectar a los usuarios con este rol.')) {
            e.preventDefault();
        }
    }
});
</script>

@endsection