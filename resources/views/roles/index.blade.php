@extends('layouts.app')

@section('title', 'Gestión de Roles')

@section('content')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--apple-dark);
        letter-spacing: -0.5px;
        margin: 0;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .role-card {
        background: white;
        padding: 24px;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .role-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }

    .role-card.alcalde::before { background: linear-gradient(135deg, #0071e3, #00c6ff); }
    .role-card.supervisor::before { background: linear-gradient(135deg, #667eea, #764ba2); }
    .role-card.contratista::before { background: linear-gradient(135deg, #11998e, #38ef7d); }
    .role-card.ordenador_gasto::before { background: linear-gradient(135deg, #f093fb, #f5576c); }
    .role-card.tesoreria::before { background: linear-gradient(135deg, #fa709a, #fee140); }

    .role-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .role-card-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }

    .role-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .role-icon.alcalde { background: linear-gradient(135deg, #0071e3, #00c6ff); }
    .role-icon.supervisor { background: linear-gradient(135deg, #667eea, #764ba2); }
    .role-icon.contratista { background: linear-gradient(135deg, #11998e, #38ef7d); }
    .role-icon.ordenador_gasto { background: linear-gradient(135deg, #f093fb, #f5576c); }
    .role-icon.tesoreria { background: linear-gradient(135deg, #fa709a, #fee140); }

    .role-icon .material-symbols-rounded {
        font-size: 28px;
        color: white;
    }

    .role-card-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--apple-dark);
        margin: 0;
    }

    .role-card-users {
        font-size: 14px;
        color: var(--apple-gray);
    }

    .role-card-description {
        font-size: 14px;
        color: var(--apple-gray);
        margin-bottom: 16px;
        line-height: 1.5;
    }

    .role-card-actions {
        display: flex;
        gap: 8px;
    }

    .table-container {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .section-header-alt {
        padding: 24px 32px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-title-alt {
        font-size: 20px;
        font-weight: 600;
        color: var(--apple-dark);
        margin: 0 0 8px 0;
    }

    .section-subtitle {
        font-size: 14px;
        color: var(--apple-gray);
        margin: 0;
    }

    .table-actions {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-icon-view {
        background: var(--apple-blue-light);
        color: var(--apple-blue);
    }

    .btn-icon-view:hover {
        background: var(--apple-blue);
        color: white;
        transform: translateY(-2px);
    }

    .btn-icon-edit {
        background: rgba(255, 149, 0, 0.15);
        color: var(--apple-orange);
    }

    .btn-icon-edit:hover {
        background: var(--apple-orange);
        color: white;
        transform: translateY(-2px);
    }

    .btn-icon-delete {
        background: rgba(255, 59, 48, 0.15);
        color: var(--apple-red);
    }

    .btn-icon-delete:hover {
        background: var(--apple-red);
        color: white;
        transform: translateY(-2px);
    }

    .badge-count {
        background: var(--apple-blue-light);
        color: var(--apple-blue);
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
    }

    .alert-custom {
        background: white;
        border-radius: 12px;
        padding: 16px 24px;
        margin-bottom: 24px;
        border-left: 4px solid var(--apple-green);
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideInUp 0.4s ease-out;
    }

    .empty-illustration {
        text-align: center;
        padding: 80px 32px;
    }

    .empty-illustration .material-symbols-rounded {
        font-size: 120px;
        color: var(--apple-blue);
        opacity: 0.2;
        margin-bottom: 24px;
    }

    .empty-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--apple-dark);
        margin-bottom: 12px;
    }

    .empty-text {
        font-size: 16px;
        color: var(--apple-gray);
        margin-bottom: 32px;
    }
</style>

<div class="page-header">
    <h1 class="page-title">Gestión de Roles</h1>
    <a href="{{ route('admin.roles.create') }}" class="btn-apple">
        <span class="material-symbols-rounded" style="font-size: 20px;">add_circle</span>
        Nuevo Rol
    </a>
</div>

@if(session('success'))
    <div class="alert-custom">
        <span class="material-symbols-rounded" style="color: var(--apple-green); font-size: 24px;">check_circle</span>
        <span style="flex: 1;">{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; opacity: 0.5;">
            <span class="material-symbols-rounded">close</span>
        </button>
    </div>
@endif

<!-- Roles Cards Grid -->
@if($roles->count() > 0)
    <div class="stats-row">
        @foreach($roles as $role)
            <div class="role-card {{ strtolower($role->name) }}">
                <div class="role-card-header">
                    <div class="role-icon {{ strtolower($role->name) }}">
                        <span class="material-symbols-rounded">
                            @switch($role->name)
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
                        <h3 class="role-card-title">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</h3>
                        <p class="role-card-users">{{ $role->users->count() }} usuario(s)</p>
                    </div>
                </div>
                <p class="role-card-description">
                    {{ $role->description ?? 'Rol del sistema para gestión de permisos y accesos' }}
                </p>
                <div class="role-card-actions">
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn-icon btn-icon-edit" title="Editar rol">
                        <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
                    </a>
                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este rol?')" class="btn-icon btn-icon-delete" title="Eliminar rol">
                            <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Detailed Table -->
    <div class="table-container">
        <div class="section-header-alt">
            <h3 class="section-title-alt">Detalle de Roles</h3>
            <p class="section-subtitle">Información completa de todos los roles del sistema</p>
        </div>

        <table class="apple-table">
            <thead>
                <tr>
                    <th>Rol</th>
                    <th>Descripción</th>
                    <th>Usuarios Asignados</th>
                    <th>Fecha Creación</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="role-icon {{ strtolower($role->name) }}" style="width: 40px; height: 40px;">
                                    <span class="material-symbols-rounded" style="font-size: 20px;">
                                        @switch($role->name)
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
                                <strong>{{ ucfirst(str_replace('_', ' ', $role->name)) }}</strong>
                            </div>
                        </td>
                        <td style="color: var(--apple-gray);">
                            {{ $role->description ?? 'Sin descripción' }}
                        </td>
                        <td>
                            <span class="badge-count">{{ $role->users->count() }}</span>
                        </td>
                        <td style="color: var(--apple-gray);">
                            {{ $role->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.roles.show', $role) }}" class="btn-icon btn-icon-view" title="Ver detalles">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">visibility</span>
                                </a>
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn-icon btn-icon-edit" title="Editar rol">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
                                </a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este rol?')" class="btn-icon btn-icon-delete" title="Eliminar rol">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="table-container">
        <div class="empty-illustration">
            <span class="material-symbols-rounded">admin_panel_settings</span>
            <h2 class="empty-title">No hay roles registrados</h2>
            <p class="empty-text">Comienza creando los roles del sistema</p>
            <a href="{{ route('admin.roles.create') }}" class="btn-apple">
                <span class="material-symbols-rounded" style="font-size: 20px;">add_circle</span>
                Crear Primer Rol
            </a>
        </div>
    </div>
@endif

<!-- Floating Action Button for Mobile -->
<a href="{{ route('admin.roles.create') }}" class="fab-create" title="Nuevo rol" style="display: none;">
    <span class="material-symbols-rounded">add</span>
</a>

<style>
    @media (max-width: 768px) {
        .fab-create {
            display: flex !important;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        
        .page-header .btn-apple {
            width: 100%;
            justify-content: center;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
