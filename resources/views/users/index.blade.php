@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--apple-dark);
        letter-spacing: -0.5px;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-mini-card {
        background: white;
        padding: 20px 24px;
        border-radius: 14px;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s;
    }

    .stat-mini-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-mini-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gradient-blue { background: linear-gradient(135deg, #0071e3, #00c6ff); }
    .gradient-green { background: linear-gradient(135deg, #11998e, #38ef7d); }
    .gradient-orange { background: linear-gradient(135deg, #f093fb, #f5576c); }

    .stat-mini-icon .material-symbols-rounded {
        font-size: 24px;
        color: white;
    }

    .stat-mini-content h4 {
        font-size: 24px;
        font-weight: 700;
        color: var(--apple-dark);
        margin: 0;
    }

    .stat-mini-content p {
        font-size: 13px;
        color: var(--apple-gray);
        margin: 0;
    }

    .table-container {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .table-header-section {
        padding: 24px 32px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .table-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--apple-dark);
        margin: 0;
    }

    .search-box {
        position: relative;
        width: 300px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 42px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 100px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--apple-blue);
        box-shadow: 0 0 0 4px var(--apple-blue-light);
    }

    .search-box .material-symbols-rounded {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--apple-gray);
        font-size: 20px;
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

    .user-avatar-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar-small {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--apple-blue), #00c6ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
    }

    .badge-role {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-admin { background: #e3f2fd; color: #1976d2; }
    .badge-supervisor { background: #f3e5f5; color: #7b1fa2; }
    .badge-contratista { background: #e8f5e9; color: #388e3c; }
    .badge-ordenador_gasto { background: #fff3e0; color: #f57c00; }
    .badge-tesoreria { background: #fce4ec; color: #c2185b; }
    .badge-alcalde { background: #e0f2f1; color: #00796b; }
    .badge-super_admin { background: #fff3e0; color: #e65100; }
    .badge-none { background: #fafafa; color: #9e9e9e; }

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

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn-apple {
            flex: 1;
            justify-content: center;
        }

        .search-box {
            width: 100%;
        }

        .table-header-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Gestión de Usuarios</h1>
    <div class="header-actions">
        <a href="{{ route('admin.users.create') }}" class="btn-apple">
            <span class="material-symbols-rounded" style="font-size: 20px;">person_add</span>
            Nuevo Usuario
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-row">
    <div class="stat-mini-card">
        <div class="stat-mini-icon gradient-blue">
            <span class="material-symbols-rounded">group</span>
        </div>
        <div class="stat-mini-content">
            <h4>{{ $users->count() }}</h4>
            <p>Total Usuarios</p>
        </div>
    </div>
    <div class="stat-mini-card">
        <div class="stat-mini-icon gradient-green">
            <span class="material-symbols-rounded">verified_user</span>
        </div>
        <div class="stat-mini-content">
            <h4>{{ $users->whereNotNull('role_id')->count() }}</h4>
            <p>Con Rol Asignado</p>
        </div>
    </div>
    <div class="stat-mini-card">
        <div class="stat-mini-icon gradient-orange">
            <span class="material-symbols-rounded">person_off</span>
        </div>
        <div class="stat-mini-content">
            <h4>{{ $users->whereNull('role_id')->count() }}</h4>
            <p>Sin Rol</p>
        </div>
    </div>
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

<div class="table-container">
    <div class="table-header-section">
        <h3 class="table-title">Lista de Usuarios</h3>
        <div class="search-box">
            <span class="material-symbols-rounded">search</span>
            <input type="text" id="searchInput" placeholder="Buscar usuarios..." onkeyup="searchTable()">
        </div>
    </div>

    @if($users->count() > 0)
        <table class="apple-table" id="usersTable">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha Registro</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="user-avatar-cell">
                                <div class="user-avatar-small">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td style="color: var(--apple-gray);">{{ $user->email }}</td>
                        <td>
                            @if($user->role)
                                <span class="badge-role badge-{{ strtolower(str_replace(' ', '_', $user->role->name)) }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->role->name)) }}
                                </span>
                            @else
                                <span class="badge-role badge-none">Sin rol</span>
                            @endif
                        </td>
                        <td style="color: var(--apple-gray);">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn-icon btn-icon-view" title="Ver detalles">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">visibility</span>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon btn-icon-edit" title="Editar usuario">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" class="btn-icon btn-icon-delete" title="Eliminar usuario">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-illustration">
            <span class="material-symbols-rounded">group_off</span>
            <h2 class="empty-title">No hay usuarios registrados</h2>
            <p class="empty-text">Comienza agregando tu primer usuario al sistema</p>
            <a href="{{ route('admin.users.create') }}" class="btn-apple">
                <span class="material-symbols-rounded" style="font-size: 20px;">person_add</span>
                Crear Primer Usuario
            </a>
        </div>
    @endif
</div>

<!-- Floating Action Button for Mobile -->
<a href="{{ route('admin.users.create') }}" class="fab-create" title="Nuevo usuario" style="display: none;">
    <span class="material-symbols-rounded">add</span>
</a>

<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('usersTable');
    if (!table) return;
    
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                const txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        tr[i].style.display = found ? '' : 'none';
    }
}
</script>

@endsection
