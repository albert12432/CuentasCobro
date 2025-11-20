@extends('layouts.app')

@section('title', 'Dashboard - Dewey Accounts')

@section('content')
<style>
    /* Gradientes mejorados estilo Apple */
    .gradient-purple { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .gradient-blue { background: linear-gradient(135deg, #0071e3 0%, #00aaff 100%); }
    .gradient-green { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .gradient-orange { background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); }
    .gradient-pink { background: linear-gradient(135deg, #ee9ca7 0%, #ffdde1 100%); }
    .gradient-teal { background: linear-gradient(135deg, #13547a 0%, #80d0c7 100%); }
    .gradient-indigo { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); }
    .gradient-red { background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); }
    .gradient-gold { background: linear-gradient(135deg, #f2994a 0%, #f2c94c 100%); }
    .gradient-mint { background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%); }
    
    /* Animaciones suaves */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    
    /* Hero Section mejorado */
    .hero-section {
        position: relative;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 80px 60px;
        margin-bottom: 48px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
        animation: fadeInUp 0.8s ease;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>');
        background-size: 100px 100px;
        opacity: 0.5;
        animation: shimmer 20s linear infinite;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .hero-title {
        font-size: 56px;
        font-weight: 800;
        color: white;
        margin: 0 0 16px 0;
        letter-spacing: -1.5px;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .hero-subtitle {
        font-size: 22px;
        color: rgba(255, 255, 255, 0.9);
        margin: 0 0 32px 0;
        font-weight: 400;
        line-height: 1.5;
    }
    
    .hero-stats {
        display: flex;
        gap: 48px;
        margin-top: 40px;
    }
    
    .hero-stat {
        flex: 1;
    }
    
    .hero-stat-value {
        font-size: 48px;
        font-weight: 700;
        color: white;
        line-height: 1;
        margin-bottom: 8px;
    }
    
    .hero-stat-label {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        padding: 0 4px;
        animation: fadeInUp 0.8s ease;
    }

    .section-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--apple-dark);
        letter-spacing: -0.8px;
        margin: 0;
    }
    
    .section-subtitle {
        font-size: 16px;
        color: var(--apple-gray);
        margin-top: 4px;
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 48px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.04);
        cursor: pointer;
        text-decoration: none;
        display: block;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.8s ease;
        animation-fill-mode: both;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(0, 113, 227, 0.03) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        transition: transform 0.4s ease;
    }
    
    .stat-card:hover .stat-card-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-card-icon .material-symbols-rounded {
        font-size: 32px;
        color: white;
        font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48;
    }

    .stat-card-value {
        font-size: 44px;
        font-weight: 800;
        color: var(--apple-dark);
        margin-bottom: 8px;
        line-height: 1;
        letter-spacing: -1px;
    }

    .stat-card-label {
        font-size: 15px;
        color: var(--apple-gray);
        font-weight: 500;
        line-height: 1.4;
    }
    
    .stat-card-trend {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 12px;
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .stat-card-trend.positive {
        background: #d4edda;
        color: #155724;
    }
    
    .stat-card-trend.negative {
        background: #f8d7da;
        color: #721c24;
    }

    .quick-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        margin-top: 32px;
        justify-content: center;
    }

    .action-btn {
        padding: 16px 32px;
        border-radius: 100px;
        font-size: 17px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }
    
    .action-btn .material-symbols-rounded {
        font-size: 22px;
        font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;
    }

    .action-btn-primary {
        background: white;
        color: var(--apple-blue);
    }

    .action-btn-primary:hover {
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 12px 32px rgba(255, 255, 255, 0.3);
    }

    .action-btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .action-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: white;
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 12px 32px rgba(255, 255, 255, 0.2);
    }


    .users-table-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        animation: fadeInUp 0.8s ease;
        animation-delay: 0.5s;
        animation-fill-mode: both;
    }

    .table-header {
        padding: 32px 36px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        background: linear-gradient(135deg, #f5f5f7 0%, #ffffff 100%);
    }

    .table-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--apple-dark);
        margin: 0;
        letter-spacing: -0.5px;
    }

    .badge-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
    }
    
    .badge-role:hover {
        transform: scale(1.05);
    }

    .badge-admin { 
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); 
        color: #1565c0;
        box-shadow: 0 2px 8px rgba(21, 101, 192, 0.2);
    }
    
    .badge-supervisor { 
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); 
        color: #6a1b9a;
        box-shadow: 0 2px 8px rgba(106, 27, 154, 0.2);
    }
    
    .badge-contratista { 
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); 
        color: #2e7d32;
        box-shadow: 0 2px 8px rgba(46, 125, 50, 0.2);
    }
    
    .badge-user { 
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); 
        color: #e65100;
        box-shadow: 0 2px 8px rgba(230, 81, 0, 0.2);
    }
    
    .badge-none { 
        background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%); 
        color: #c2185b;
        box-shadow: 0 2px 8px rgba(194, 24, 91, 0.2);
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        color: var(--apple-gray);
    }

    .empty-state .material-symbols-rounded {
        font-size: 96px;
        opacity: 0.2;
        margin-bottom: 20px;
        color: var(--apple-gray);
    }
    
    .empty-state-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--apple-dark);
        margin-bottom: 8px;
    }
    
    .empty-state-text {
        font-size: 16px;
        color: var(--apple-gray);
    }
    
    /* Tabla mejorada */
    .apple-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .apple-table thead tr {
        background: linear-gradient(135deg, #fafafa 0%, #f5f5f7 100%);
    }
    
    .apple-table th {
        padding: 18px 24px;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        color: var(--apple-gray);
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.06);
    }
    
    .apple-table td {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        font-size: 15px;
        color: var(--apple-dark);
    }
    
    .apple-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .apple-table tbody tr:hover {
        background: rgba(0, 113, 227, 0.02);
        transform: scale(1.01);
    }
    
    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        letter-spacing: 0;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        flex-shrink: 0;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .hero-title {
            font-size: 44px;
        }
        
        .hero-subtitle {
            font-size: 18px;
        }
        
        .card-grid {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 48px 32px;
        }
        
        .hero-title {
            font-size: 36px;
        }
        
        .hero-subtitle {
            font-size: 16px;
        }
        
        .hero-stats {
            flex-direction: column;
            gap: 24px;
        }
        
        .section-title {
            font-size: 24px;
        }
        
        .card-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-card-value {
            font-size: 36px;
        }
        
        .apple-table {
            font-size: 14px;
        }
        
        .apple-table th,
        .apple-table td {
            padding: 14px 16px;
        }
    }
</style>


<!-- Hero Section mejorado -->
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">¡Hola, {{ Auth::user()->name }}! 👋</h1>
        <p class="hero-subtitle">Gestiona tus cuentas de cobro de manera eficiente y profesional</p>
        
        <div class="quick-actions">
            <a href="{{ route('cuentas_cobro.create') }}" class="action-btn action-btn-primary">
                <span class="material-symbols-rounded">add_circle</span>
                Nueva Cuenta de Cobro
            </a>
            <a href="{{ route('cuentas_cobro.index') }}" class="action-btn action-btn-secondary">
                <span class="material-symbols-rounded">receipt_long</span>
                Ver Todas las Cuentas
            </a>
            <a href="{{ route('cuentas_cobro.pagos') }}" class="action-btn action-btn-secondary">
                <span class="material-symbols-rounded">payments</span>
                Gestionar Pagos
            </a>
        </div>
        
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $totalUsers ?? 0 }}</div>
                <div class="hero-stat-label">Usuarios Activos</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $totalCuentas ?? 0 }}</div>
                <div class="hero-stat-label">Cuentas de Cobro</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $totalPagos ?? 0 }}</div>
                <div class="hero-stat-label">Pagos Procesados</div>
            </div>
        </div>
    </div>
</div>


<!-- Statistics Section - Gestión de Usuarios -->
<div class="section-header">
    <div>
        <h2 class="section-title">Gestión de Usuarios</h2>
        <p class="section-subtitle">Administra y supervisa los usuarios del sistema</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="action-btn action-btn-secondary" style="background: white; color: var(--apple-blue); border: 1px solid rgba(0,113,227,0.2); box-shadow: none;">
        <span class="material-symbols-rounded">arrow_forward</span>
        Ver Todos
    </a>
</div>

<div class="card-grid">
    <a href="{{ route('admin.users.index') }}" class="stat-card">
        <div class="stat-card-icon gradient-blue">
            <span class="material-symbols-rounded">group</span>
        </div>
        <div class="stat-card-value">{{ $totalUsers ?? 0 }}</div>
        <div class="stat-card-label">Usuarios Totales</div>
        <div class="stat-card-trend positive">
            <span class="material-symbols-rounded" style="font-size: 16px;">trending_up</span>
            Activos
        </div>
    </a>

    <a href="{{ route('admin.roles.index') }}" class="stat-card">
        <div class="stat-card-icon gradient-green">
            <span class="material-symbols-rounded">verified_user</span>
        </div>
        <div class="stat-card-value">{{ $usersWithRoles ?? 0 }}</div>
        <div class="stat-card-label">Con Rol Asignado</div>
        <div class="stat-card-trend positive">
            <span class="material-symbols-rounded" style="font-size: 16px;">check_circle</span>
            Verificados
        </div>
    </a>

    <div class="stat-card">
        <div class="stat-card-icon gradient-purple">
            <span class="material-symbols-rounded">admin_panel_settings</span>
        </div>
        <div class="stat-card-value">{{ $totalRoles ?? 0 }}</div>
        <div class="stat-card-label">Roles Disponibles</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon gradient-orange">
            <span class="material-symbols-rounded">person_off</span>
        </div>
        <div class="stat-card-value">{{ $usersWithoutRoles ?? 0 }}</div>
        <div class="stat-card-label">Sin Rol Asignado</div>
        @if(($usersWithoutRoles ?? 0) > 0)
        <div class="stat-card-trend negative">
            <span class="material-symbols-rounded" style="font-size: 16px;">warning</span>
            Pendiente
        </div>
        @endif
    </div>
</div>


<!-- Cuentas de Cobro Section -->
<div class="section-header">
    <div>
        <h2 class="section-title">Finanzas y Pagos</h2>
        <p class="section-subtitle">Monitorea las cuentas de cobro y movimientos financieros</p>
    </div>
    <a href="{{ route('cuentas_cobro.pagos') }}" class="action-btn action-btn-secondary" style="background: white; color: var(--apple-blue); border: 1px solid rgba(0,113,227,0.2); box-shadow: none;">
        <span class="material-symbols-rounded">payments</span>
        Ir a Pagos
    </a>
</div>

<div class="card-grid">
    <a href="{{ route('cuentas_cobro.index') }}" class="stat-card">
        <div class="stat-card-icon gradient-teal">
            <span class="material-symbols-rounded">receipt_long</span>
        </div>
        <div class="stat-card-value">{{ $totalCuentas ?? 0 }}</div>
        <div class="stat-card-label">Cuentas de Cobro</div>
        <div class="stat-card-trend positive">
            <span class="material-symbols-rounded" style="font-size: 16px;">description</span>
            Registradas
        </div>
    </a>

    <a href="{{ route('cuentas_cobro.pagos') }}" class="stat-card">
        <div class="stat-card-icon gradient-indigo">
            <span class="material-symbols-rounded">payments</span>
        </div>
        <div class="stat-card-value">{{ $totalPagos ?? 0 }}</div>
        <div class="stat-card-label">Pagos Procesados</div>
        <div class="stat-card-trend positive">
            <span class="material-symbols-rounded" style="font-size: 16px;">attach_money</span>
            Completados
        </div>
    </a>

    <div class="stat-card">
        <div class="stat-card-icon gradient-pink">
            <span class="material-symbols-rounded">account_balance</span>
        </div>
        <div class="stat-card-value">{{ $totalTesoreria ?? 0 }}</div>
        <div class="stat-card-label">En Tesorería</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon gradient-gold">
            <span class="material-symbols-rounded">description</span>
        </div>
        <div class="stat-card-value">{{ $totalContratacion ?? 0 }}</div>
        <div class="stat-card-label">Contratación</div>
    </div>
</div>


<!-- Recent Users Section -->
<div class="section-header">
    <div>
        <h2 class="section-title">Actividad Reciente</h2>
        <p class="section-subtitle">Últimos usuarios registrados en el sistema</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="action-btn action-btn-secondary" style="background: white; color: var(--apple-blue); border: 1px solid rgba(0,113,227,0.2); box-shadow: none;">
        <span class="material-symbols-rounded">group</span>
        Ver Todos los Usuarios
    </a>
</div>

<div class="users-table-container">
    <div class="table-header">
        <h3 class="table-title">
            <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px; font-size: 28px;">history</span>
            Últimos Registros
        </h3>
    </div>
    @if(isset($recentUsers) && $recentUsers->count() > 0)
        <table class="apple-table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol Asignado</th>
                    <th>Fecha de Registro</th>
                    <th style="text-align: center;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentUsers as $recentUser)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div class="user-avatar">{{ strtoupper(substr($recentUser->name, 0, 1)) }}</div>
                            <div>
                                <strong style="font-size: 15px; color: var(--apple-dark);">{{ $recentUser->name }}</strong>
                                <div style="font-size: 13px; color: var(--apple-gray); margin-top: 2px;">
                                    ID: #{{ $recentUser->id }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="material-symbols-rounded" style="font-size: 18px; color: var(--apple-gray);">mail</span>
                            <span style="color: var(--apple-gray);">{{ $recentUser->email }}</span>
                        </div>
                    </td>
                    <td>
                        @if($recentUser->role)
                            <span class="badge-role badge-{{ strtolower($recentUser->role->name) }}">
                                <span class="material-symbols-rounded" style="font-size: 16px;">verified</span>
                                {{ ucfirst($recentUser->role->name) }}
                            </span>
                        @else
                            <span class="badge-role badge-none">
                                <span class="material-symbols-rounded" style="font-size: 16px;">error</span>
                                Sin rol
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="material-symbols-rounded" style="font-size: 18px; color: var(--apple-gray);">schedule</span>
                            <span style="color: var(--apple-gray);">{{ $recentUser->created_at->diffForHumans() }}</span>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: #d4edda; color: #155724; border-radius: 100px; font-size: 13px; font-weight: 600;">
                            <span class="material-symbols-rounded" style="font-size: 16px;">check_circle</span>
                            Activo
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <span class="material-symbols-rounded">group_off</span>
            <div class="empty-state-title">No hay usuarios recientes</div>
            <p class="empty-state-text">Los nuevos usuarios registrados aparecerán aquí</p>
            <a href="{{ route('admin.users.create') }}" class="action-btn action-btn-primary" style="margin-top: 24px; display: inline-flex;">
                <span class="material-symbols-rounded">person_add</span>
                Agregar Primer Usuario
            </a>
        </div>
    @endif
</div>
@endsection
