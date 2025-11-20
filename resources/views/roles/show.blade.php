@extends('layouts.app')

@section('title', 'Detalles del Rol - ' . ucfirst(str_replace('_', ' ', $role->name)))

@section('content')
<style>
    .role-header {
        background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
        border-radius: 24px;
        padding: 40px 32px;
        color: white;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 32px;
        box-shadow: 0 10px 40px rgba(124, 58, 237, 0.15);
    }

    .role-icon-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        flex-shrink: 0;
    }

    .role-header-content h1 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .role-header-content p {
        font-size: 16px;
        opacity: 0.95;
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
        font-size: 20px;
        font-weight: 600;
        color: var(--apple-dark);
        margin: 0;
    }

    .info-group {
        margin-bottom: 20px;
    }

    .info-group:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-size: 12px;
        color: var(--apple-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .info-value {
        font-size: 16px;
        color: var(--apple-dark);
        font-weight: 500;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-item {
        text-align: center;
        background: rgba(0, 113, 227, 0.05);
        padding: 12px;
        border-radius: 10px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: var(--apple-blue);
        display: block;
    }

    .stat-label {
        font-size: 12px;
        color: var(--apple-gray);
        margin-top: 4px;
    }

    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }

    .permission-badge {
        background: linear-gradient(135deg, #e0e7ff 0%, #e9d5ff 100%);
        border: 1px solid rgba(124, 58, 237, 0.2);
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 13px;
        color: #7c3aed;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        text-align: center;
    }

    .permission-badge .material-symbols-rounded {
        font-size: 18px;
    }

    .permissions-category {
        background: rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
    }

    .category-title {
        font-weight: 600;
        color: var(--apple-dark);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .category-title .material-symbols-rounded {
        color: var(--apple-blue);
        font-size: 20px;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table thead {
        border-bottom: 2px solid rgba(0, 0, 0, 0.08);
    }

    .users-table th {
        font-size: 12px;
        font-weight: 600;
        color: var(--apple-gray);
        text-align: left;
        padding: 12px 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .users-table td {
        padding: 16px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        color: var(--apple-dark);
    }

    .users-table tbody tr:hover {
        background: rgba(0, 0, 0, 0.02);
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--apple-blue), #00c6ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
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

    .btn-primary {
        background: linear-gradient(135deg, #0071e3 0%, #0056b3 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 113, 227, 0.3);
    }

    .btn-secondary {
        background: rgba(0, 0, 0, 0.05);
        color: var(--apple-dark);
    }

    .btn-secondary:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--apple-gray);
    }

    .empty-state .material-symbols-rounded {
        font-size: 48px;
        opacity: 0.2;
        display: block;
        margin-bottom: 12px;
    }

    .empty-state p {
        margin: 0;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .role-header {
            flex-direction: column;
            text-align: center;
            padding: 32px 24px;
        }

        .role-icon-large {
            display: none;
        }

        .stat-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-submit {
            width: 100%;
            justify-content: center;
        }

        .users-table {
            font-size: 12px;
        }

        .users-table th,
        .users-table td {
            padding: 8px 12px;
        }
    }
</style>

<a href="{{ route('admin.roles.index') }}" class="back-link">
    <span class="material-symbols-rounded" style="font-size: 20px;">arrow_back</span>
    Volver a roles
</a>

<!-- Role Header -->
<div class="role-header">
    <div class="role-icon-large">
        <span class="material-symbols-rounded">
            @switch($role->name)
                @case('super_admin')
                    admin_panel_settings
                    @break
                @case('alcalde')
                    account_balance
                    @break
                @case('supervisor')
                    supervisor_account
                    @break
                @case('contratista')
                    engineering
                    @break
                @case('ordenador_gasto')
                    payments
                    @break
                @case('tesoreria')
                    account_balance_wallet
                    @break
                @default
                    admin_panel_settings
            @endswitch
        </span>
    </div>
    <div>
        <h1>{{ ucfirst(str_replace('_', ' ', $role->name)) }}</h1>
        <p>Gestión de permisos y usuarios del sistema</p>
    </div>
</div>

<div class="content-grid">
    <!-- Sidebar Information -->
    <div>
        <div class="card">
            <div class="card-header">
                <span class="material-symbols-rounded">info</span>
                <h2>Información del Rol</h2>
            </div>

            <div class="info-group">
                <label class="info-label">Nombre del Rol</label>
                <div class="info-value">{{ $role->name }}</div>
            </div>

            <div class="stat-grid">
                <div class="stat-item">
                    <span class="stat-value">{{ $users->total() ?? 0 }}</span>
                    <span class="stat-label">Usuarios</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $role->permissions?->count() ?? 0 }}</span>
                    <span class="stat-label">Permisos</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $role->created_at->format('y') }}</span>
                    <span class="stat-label">Año</span>
                </div>
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.05);">
                <div class="info-group">
                    <label class="info-label">Creado</label>
                    <div class="info-value" style="font-size: 14px;">{{ $role->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="info-group">
                    <label class="info-label">Actualizado</label>
                    <div class="info-value" style="font-size: 14px;">{{ $role->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.roles.edit', $role) }}" class="btn-submit btn-primary" style="flex: 1; justify-content: center;">
                    <span class="material-symbols-rounded" style="font-size: 20px;">edit</span>
                    Editar
                </a>
                <a href="{{ route('admin.roles.index') }}" class="btn-submit btn-secondary" style="flex: 1; justify-content: center;">
                    <span class="material-symbols-rounded" style="font-size: 20px;">close</span>
                    Cerrar
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div>
        <!-- Permissions Section -->
        <div class="card">
            <div class="card-header">
                <span class="material-symbols-rounded">security</span>
                <h2>Permisos Asignados</h2>
            </div>

            @if($role->permissions && $role->permissions->count() > 0)
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
                    @php
                        $categoryPermissions = array_intersect($role->permissions->pluck('name')->toArray(), $categoryPerms);
                    @endphp
                    @if(count($categoryPermissions) > 0)
                        <div class="permissions-category">
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
                            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                @foreach($categoryPermissions as $permission)
                                    <div class="permission-badge">
                                        <span class="material-symbols-rounded">check_circle</span>
                                        {{ ucfirst(str_replace('_', ' ', $permission)) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="empty-state">
                    <span class="material-symbols-rounded">lock_open</span>
                    <p>Este rol no tiene permisos asignados</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Users Section -->
<div class="card">
    <div class="card-header">
        <span class="material-symbols-rounded">group</span>
        <h2>Usuarios con este Rol</h2>
    </div>

    @if($users && $users->count() > 0)
        <table class="users-table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Fecha Registro</th>
                    <th style="text-align: center;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td style="color: var(--apple-gray);">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td style="text-align: center;">
                            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #22c55e;"></span>
                            <span style="font-size: 12px; color: var(--apple-gray);">Activo</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state" style="padding: 60px 20px;">
            <span class="material-symbols-rounded" style="font-size: 64px;">group_off</span>
            <p style="font-size: 16px; margin-top: 16px;">No hay usuarios asignados a este rol</p>
        </div>
    @endif
</div>

@endsection
    <div class="row">
        <!-- Sidebar (opcional) -->
        <div class="col-md-2">
            <!-- Sidebar content -->
        </div>
        
        <!-- Main content -->
        <div class="col-md-10">
            <!-- Header con navegación -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.roles.index') }}" class="text-decoration-none">
                                    <i class="fas fa-users-cog me-1"></i>Roles
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold text-dark mb-0">
                        @switch($role->name)
                            @case('contratista')
                                <i class="fas fa-user-tie text-primary me-2"></i>
                                @break
                            @case('supervisor')
                                <i class="fas fa-user-check text-success me-2"></i>
                                @break
                            @case('alcalde')
                                <i class="fas fa-crown text-warning me-2"></i>
                                @break
                            @case('ordenador_gasto')
                                <i class="fas fa-money-check-alt text-info me-2"></i>
                                @break
                            @case('tesoreria')
                                <i class="fas fa-coins text-success me-2"></i>
                                @break
                            @case('contratacion')
                                <i class="fas fa-handshake text-primary me-2"></i>
                                @break
                            @default
                                <i class="fas fa-user me-2"></i>
                        @endswitch
                        Detalles del Rol: {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                    </h2>
                </div>
                
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver
                    </a>
                    @if(Auth::user()->hasRole('alcalde'))
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>
                        Editar Rol
                    </a>
                    @endif
                </div>
            </div>

            <!-- Mensajes de éxito/error -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row">
                <!-- Información del Rol -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Información del Rol
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">ID del Rol:</label>
                                <div>
                                    <span class="badge bg-secondary fs-6">{{ $role->id }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Nombre:</label>
                                <div class="fs-5 fw-bold text-capitalize">
                                    {{ str_replace('_', ' ', $role->name) }}
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Descripción:</label>
                                <div class="text-muted">
                                    {{ $role->description ?? 'Sin descripción' }}
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Usuarios Asignados:</label>
                                <div>
                                    @if($users->total() > 0)
                                        <span class="badge bg-success fs-6">{{ $users->total() }} usuarios</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">Sin usuarios</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Permisos:</label>
                                <div>
                                    @if($role->permissions && count($role->permissions) > 0)
                                        <span class="badge bg-info fs-6">{{ count($role->permissions) }} permisos</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">Sin permisos</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Fecha de Creación:</label>
                                <div class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $role->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            
                            <div class="mb-0">
                                <label class="form-label fw-bold text-muted">Última Actualización:</label>
                                <div class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $role->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permisos del Rol -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-key me-2"></i>
                                Permisos Asignados
                                @if($role->permissions && count($role->permissions) > 0)
                                <span class="badge bg-light text-dark ms-2">{{ count($role->permissions) }}</span>
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($role->permissions && count($role->permissions) > 0)
                            <div class="row">
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
                                
                                @foreach($permissionCategories as $category => $categoryPermissions)
                                    @php
                                    $roleHasPermissionsInCategory = array_intersect($role->permissions, $categoryPermissions);
                                    @endphp
                                    
                                    @if(count($roleHasPermissionsInCategory) > 0)
                                    <div class="col-md-6 mb-3">
                                        <div class="border rounded p-3 h-100">
                                            <h6 class="fw-bold text-primary mb-2">
                                                @switch($category)
                                                    @case('Cuentas de Cobro')
                                                        <i class="fas fa-file-invoice me-1"></i>
                                                        @break
                                                    @case('Documentos')
                                                        <i class="fas fa-file-alt me-1"></i>
                                                        @break
                                                    @case('Contratos')
                                                        <i class="fas fa-handshake me-1"></i>
                                                        @break
                                                    @case('Pagos')
                                                        <i class="fas fa-money-bill me-1"></i>
                                                        @break
                                                    @case('Presupuesto')
                                                        <i class="fas fa-chart-line me-1"></i>
                                                        @break
                                                    @case('Reportes')
                                                        <i class="fas fa-chart-bar me-1"></i>
                                                        @break
                                                    @case('Administración')
                                                        <i class="fas fa-cogs me-1"></i>
                                                        @break
                                                    @default
                                                        <i class="fas fa-ellipsis-h me-1"></i>
                                                @endswitch
                                                {{ $category }}
                                            </h6>
                                            @foreach($roleHasPermissionsInCategory as $permission)
                                            <span class="badge bg-light text-dark border me-1 mb-1">
                                                <i class="fas fa-check text-success me-1"></i>
                                                {{ ucfirst(str_replace('_', ' ', $permission)) }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-key fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Sin permisos asignados</h5>
                                <p class="text-muted">Este rol no tiene permisos específicos configurados.</p>
                                @if(Auth::user()->hasRole('alcalde'))
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-1"></i>
                                    Asignar Permisos
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuarios con este rol -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-users me-2"></i>
                                Usuarios con este Rol
                                @if($users->total() > 0)
                                <span class="badge bg-light text-dark ms-2">{{ $users->total() }}</span>
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                            <th><i class="fas fa-user me-1"></i>Nombre</th>
                                            <th><i class="fas fa-envelope me-1"></i>Email</th>
                                            <th><i class="fas fa-calendar me-1"></i>Fecha Registro</th>
                                            @if(Auth::user()->hasAnyRole(['alcalde', 'contratacion']))
                                            <th class="text-center"><i class="fas fa-cogs me-1"></i>Acciones</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">{{ $user->id }}</span>
                                            </td>
                                            <td>
                                                <i class="fas fa-user text-primary me-2"></i>
                                                <strong>{{ $user->name }}</strong>
                                            </td>
                                            <td>
                                                <i class="fas fa-envelope text-muted me-2"></i>
                                                {{ $user->email }}
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $user->created_at->format('d/m/Y') }}
                                                </small>
                                            </td>
                                            @if(Auth::user()->hasAnyRole(['alcalde', 'contratacion']))
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        onclick="removeRole({{ $user->id }}, '{{ $user->name }}')"
                                                        title="Remover rol">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Paginación -->
                            @if($users->hasPages())
                            <div class="d-flex justify-content-center">
                                {{ $users->links() }}
                            </div>
                            @endif
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Sin usuarios asignados</h5>
                                <p class="text-muted">No hay usuarios con este rol actualmente.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-ocultar alertas después de 5 segundos
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Función para remover rol de usuario
    function removeRole(userId, userName) {
        if (confirm(`¿Estás seguro de remover el rol de ${userName}?`)) {
            // Aquí puedes implementar la llamada AJAX
            fetch("{{ route('admin.roles.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    user_id: userId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al remover el rol');
            });
        }
    }
</script>
@endpush
@endsection