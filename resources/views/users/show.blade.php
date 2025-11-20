@extends('layouts.app')

@section('title', 'Detalle de Usuario - ' . $user->name)

@section('content')
<style>
    .user-header {
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

    .user-avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 700;
        border: 4px solid rgba(255, 255, 255, 0.3);
        flex-shrink: 0;
    }

    .user-header-content h1 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .user-header-content p {
        font-size: 16px;
        opacity: 0.95;
        margin: 8px 0;
    }

    .user-header-meta {
        display: flex;
        gap: 24px;
        margin-top: 12px;
        flex-wrap: wrap;
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
        grid-template-columns: 2fr 1fr;
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
        margin-bottom: 24px;
    }

    .info-group:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-size: 13px;
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

    .info-value.secondary {
        color: var(--apple-gray);
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

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: rgba(34, 197, 94, 0.15);
        color: #22c55e;
    }

    .status-inactive {
        background: rgba(107, 114, 128, 0.15);
        color: #6b7280;
    }

    .role-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
        color: white;
        margin-bottom: 12px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .btn-small {
        padding: 10px 20px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary-small {
        background: var(--apple-blue);
        color: white;
    }

    .btn-primary-small:hover {
        background: #0056b3;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 113, 227, 0.2);
    }

    .btn-secondary-small {
        background: rgba(0, 113, 227, 0.1);
        color: var(--apple-blue);
    }

    .btn-secondary-small:hover {
        background: rgba(0, 113, 227, 0.2);
        transform: translateY(-1px);
    }

    .btn-danger-small {
        background: rgba(239, 68, 68, 0.15);
        color: var(--apple-red);
    }

    .btn-danger-small:hover {
        background: var(--apple-red);
        color: white;
        transform: translateY(-1px);
    }

    .sidebar-card {
        background: white;
        border-radius: 18px;
        padding: 24px 28px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .sidebar-card h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--apple-dark);
        margin: 0 0 16px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.05);
    }

    .activity-item {
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 13px;
        color: var(--apple-gray);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-time {
        font-weight: 600;
        color: var(--apple-dark);
        display: block;
        margin-bottom: 4px;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .user-header {
            flex-direction: column;
            text-align: center;
            padding: 32px 24px;
        }

        .user-header-meta {
            justify-content: center;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-small {
            justify-content: center;
        }

        .permissions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<a href="{{ route('admin.users.index') }}" class="back-link">
    <span class="material-symbols-rounded" style="font-size: 20px;">arrow_back</span>
    Volver a usuarios
</a>

<!-- User Header -->
<div class="user-header">
    <div class="user-avatar-large">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>
    <div class="user-header-content">
        <h1>{{ $user->name }}</h1>
        <p>{{ $user->email }}</p>
        <div class="user-header-meta">
            @if($user->role)
                <span class="role-badge">{{ ucfirst(str_replace('_', ' ', $user->role->name)) }}</span>
            @else
                <span class="status-badge status-inactive">Sin Rol Asignado</span>
            @endif
            <span class="status-badge status-active">Activo</span>
        </div>
    </div>
</div>

<div class="content-grid">
    <!-- Main Content -->
    <div>
        <!-- Personal Information -->
        <div class="card">
            <div class="card-header">
                <span class="material-symbols-rounded">person_check</span>
                <h2>Información Personal</h2>
            </div>

            <div class="info-group">
                <label class="info-label">Nombre Completo</label>
                <div class="info-value">{{ $user->name }}</div>
            </div>

            <div class="info-group">
                <label class="info-label">Email</label>
                <div class="info-value">{{ $user->email }}</div>
            </div>

            <div class="info-group">
                <label class="info-label">Fecha de Registro</label>
                <div class="info-value">{{ $user->created_at->format('d/m/Y \a \l\a\s H:i') }}</div>
            </div>

            <div class="info-group">
                <label class="info-label">Última Actualización</label>
                <div class="info-value secondary">{{ $user->updated_at->format('d/m/Y \a \l\a\s H:i') }}</div>
            </div>
        </div>

        <!-- Role & Permissions -->
        @if($user->role)
            <div class="card">
                <div class="card-header">
                    <span class="material-symbols-rounded">verified_user</span>
                    <h2>Rol y Permisos</h2>
                </div>

                <div class="info-group">
                    <label class="info-label">Rol Asignado</label>
                    <div class="role-badge" style="display: block; width: fit-content;">
                        {{ ucfirst(str_replace('_', ' ', $user->role->name)) }}
                    </div>
                </div>

                @if($user->role->permissions && $user->role->permissions->count() > 0)
                    <div class="info-group">
                        <label class="info-label">Permisos del Rol</label>
                        <div class="permissions-grid">
                            @foreach($user->role->permissions as $permission)
                                <div class="permission-badge">
                                    <span class="material-symbols-rounded">check_circle</span>
                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="info-group">
                        <label class="info-label">Permisos</label>
                        <p style="color: var(--apple-gray); font-style: italic;">Este rol no tiene permisos asignados</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Account Activity -->
        <div class="card">
            <div class="card-header">
                <span class="material-symbols-rounded">history</span>
                <h2>Información de Cuenta</h2>
            </div>

            <div class="info-group">
                <label class="info-label">Estado</label>
                <span class="status-badge status-active">Activo</span>
            </div>

            <div class="info-group">
                <label class="info-label">Tipo de Usuario</label>
                <div class="info-value">
                    @if($user->role && strtolower($user->role->name) === 'super_admin')
                        Administrador
                    @else
                        Usuario Regular
                    @endif
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn-small btn-primary-small">
                    <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
                    Editar Usuario
                </a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')" class="btn-small btn-danger-small">
                        <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Quick Stats -->
        <div class="sidebar-card">
            <h3>Estadísticas Rápidas</h3>
            <div class="info-group">
                <label class="info-label">ID de Usuario</label>
                <div class="info-value" style="font-family: monospace;">{{ $user->id }}</div>
            </div>
            <div class="info-group">
                <label class="info-label">Estado</label>
                <span class="status-badge status-active">Activo</span>
            </div>
            @if($user->role)
                <div class="info-group">
                    <label class="info-label">Permisos</label>
                    <div class="info-value">{{ $user->role->permissions?->count() ?? 0 }} permisos</div>
                </div>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="sidebar-card">
            <h3>Actividad Reciente</h3>
            <div class="activity-item">
                <span class="activity-time">Creado</span>
                {{ $user->created_at->format('d M Y, H:i') }}
            </div>
            <div class="activity-item">
                <span class="activity-time">Actualizado</span>
                {{ $user->updated_at->format('d M Y, H:i') }}
            </div>
        </div>

        <!-- Security Info -->
        <div class="sidebar-card">
            <h3>Seguridad</h3>
            <div class="info-group">
                <label class="info-label">Contraseña</label>
                <div class="info-value secondary">Configurada</div>
            </div>
            <div class="info-group">
                <label class="info-label">Verificación</label>
                <span class="status-badge status-active">Verificado</span>
            </div>
        </div>
    </div>
</div>

@endsection
