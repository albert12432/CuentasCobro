{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dewey Accounts')</title>
    
    <!-- Fonts - SF Pro Display (Apple) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols (Google Icons) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
        <!-- Centralized CSS -->
        <link rel="stylesheet" href="{{ asset('css/layouts/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layouts/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layouts/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/buttons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/cards.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/tables.css') }}">
    
        @stack('styles')
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ url('/dashboard') }}" class="nav-logo">
                <span class="material-symbols-rounded">receipt_long</span>
                Dewey Accounts
            </a>
            
            <ul class="nav-menu">
                <li><a href="{{ route('dashboard') }}" class="nav-link">
                    <span class="material-symbols-rounded">dashboard</span>
                    Dashboard
                </a></li>
                <li><a href="{{ route('cuentas_cobro.index') }}" class="nav-link">
                    <span class="material-symbols-rounded">description</span>
                    Cuentas
                </a></li>
                <li><a href="{{ route('admin.users.index') }}" class="nav-link">
                    <span class="material-symbols-rounded">group</span>
                    Usuarios
                </a></li>
                <li><a href="{{ route('notificaciones.index') }}" class="nav-link" style="position: relative; display: flex; align-items: center; gap: 6px;">
                    <span class="material-symbols-rounded" style="font-size: 24px; position: relative;">
                        notifications_active
                        @if(isset($notificacionesNoLeidas) && $notificacionesNoLeidas > 0)
                            <span style="position: absolute; top: -4px; right: -8px; background: #ff3b30; color: white; font-size: 10px; font-weight: 700; padding: 2px 5px; border-radius: 999px; min-width: 18px; text-align: center; border: 2px solid white;">
                                {{ $notificacionesNoLeidas > 99 ? '99+' : $notificacionesNoLeidas }}
                            </span>
                        @endif
                    </span>
                    <span style="display: none;">Notificaciones</span>
                </a></li>
            </ul>

            <div class="nav-actions">
                @auth
                    <div class="user-info">
                        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-apple btn-apple-secondary">
                            <span class="material-symbols-rounded" style="font-size: 18px;">logout</span>
                            Salir
                        </button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn-apple">Iniciar sesión</a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Layout -->
    <div class="app-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Principal</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="material-symbols-rounded">dashboard</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('cuentas_cobro.index') }}" class="sidebar-link {{ request()->routeIs('cuentas_cobro.*') ? 'active' : '' }}">
                            <span class="material-symbols-rounded">receipt_long</span>
                            Cuentas de Cobro
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('cuentas_cobro.pagos') }}" class="sidebar-link">
                            <span class="material-symbols-rounded">payments</span>
                            Pagos
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Administración</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <span class="material-symbols-rounded">group</span>
                            Usuarios
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('admin.roles.index') }}" class="sidebar-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <span class="material-symbols-rounded">admin_panel_settings</span>
                            Roles
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-section">
                <h3 class="sidebar-title">Análisis</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="{{ route('reportes.index') }}" class="sidebar-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                            <span class="material-symbols-rounded">pie_chart</span>
                            Reportes
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
