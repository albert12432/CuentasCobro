@extends('layouts.app')

@section('title', 'Cuentas de Cobro')

@section('content')
@include('components.modals')

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

    .page-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .search-box {
        position: relative;
        width: 280px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 44px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.2s;
        background: white;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--apple-blue);
        box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
    }

    .search-box .material-symbols-rounded {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 20px;
    }

    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid #e5e7eb;
        background: white;
        color: #6b7280;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .filter-tab:hover {
        background: #f3f4f6;
    }

    .filter-tab.active {
        background: var(--apple-blue);
        color: white;
        border-color: var(--apple-blue);
    }

    .filter-tab .count {
        background: rgba(0, 0, 0, 0.1);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
    }

    .filter-tab.active .count {
        background: rgba(255, 255, 255, 0.2);
    }

    .table-container {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
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

    .btn-icon-pdf {
        background: rgba(52, 199, 89, 0.15);
        color: #34C759;
    }

    .btn-icon-pdf:hover {
        background: #34C759;
        color: white;
        transform: translateY(-2px);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge .material-symbols-rounded {
        font-size: 14px;
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

    .alert-custom.error {
        border-left-color: var(--apple-red);
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

    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        padding: 16px 20px;
        border-radius: 14px;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon .material-symbols-rounded {
        font-size: 22px;
        color: white;
    }

    .stat-info h4 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: var(--apple-dark);
    }

    .stat-info p {
        margin: 2px 0 0;
        font-size: 12px;
        color: var(--apple-gray);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Cuentas de Cobro</h1>
    <div class="page-actions">
        <div class="search-box">
            <span class="material-symbols-rounded">search</span>
            <input type="text" id="searchInput" placeholder="Buscar por número, beneficiario..." onkeyup="filterTable()">
        </div>
        @if(auth()->user()->role->name === 'contratista')
        <a href="{{ route('cuentas_cobro.create') }}" class="btn-apple" onclick="event.preventDefault(); openModal('confirmCreateModal');">
            <span class="material-symbols-rounded" style="font-size: 20px;">add_circle</span>
            Nueva Cuenta
        </a>
        @else
        <button class="btn-apple" style="opacity: 0.6; cursor: not-allowed;" onclick="openModal('permissionCreateModal')">
            <span class="material-symbols-rounded" style="font-size: 20px;">add_circle</span>
            Nueva Cuenta
        </button>
        @endif
    </div>
</div>

{{-- Stats Bar --}}
@php
    // Optimized: single query with aggregation
    $stats = App\Models\CuentaCobro::whereNull('archived_at')
        ->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN estado_aprobacion = 'en_revision' THEN 1 ELSE 0 END) as en_revision,
            SUM(CASE WHEN estado_aprobacion = 'aprobado' THEN 1 ELSE 0 END) as aprobadas,
            SUM(CASE WHEN estado_pago = 'approved' THEN 1 ELSE 0 END) as pagadas
        ")
        ->first();
    
    $totalCuentas = $cuentas->total();
    $enRevision = $stats->en_revision ?? 0;
    $aprobadas = $stats->aprobadas ?? 0;
    $pagadas = $stats->pagadas ?? 0;
@endphp
<div class="stats-bar">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #007AFF, #0051D5);">
            <span class="material-symbols-rounded">receipt_long</span>
        </div>
        <div class="stat-info">
            <h4>{{ $totalCuentas }}</h4>
            <p>Total Cuentas</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #FF9500, #F59E0B);">
            <span class="material-symbols-rounded">pending</span>
        </div>
        <div class="stat-info">
            <h4>{{ $enRevision }}</h4>
            <p>En Revisión</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #34C759, #22C55E);">
            <span class="material-symbols-rounded">check_circle</span>
        </div>
        <div class="stat-info">
            <h4>{{ $aprobadas }}</h4>
            <p>Aprobadas</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #5856D6, #7C3AED);">
            <span class="material-symbols-rounded">payments</span>
        </div>
        <div class="stat-info">
            <h4>{{ $pagadas }}</h4>
            <p>Pagadas</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert-custom">
        <span class="material-symbols-rounded" style="color: var(--apple-green); font-size: 24px;">check_circle</span>
        <span style="flex: 1;">{!! session('success') !!}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; opacity: 0.5;">
            <span class="material-symbols-rounded">close</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert-custom error">
        <span class="material-symbols-rounded" style="color: var(--apple-red); font-size: 24px;">error</span>
        <span style="flex: 1;">{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; opacity: 0.5;">
            <span class="material-symbols-rounded">close</span>
        </button>
    </div>
@endif

<div class="table-container">
    @if($cuentas->count() > 0)
        <table class="apple-table" id="cuentasTable">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Fecha Emisión</th>
                    <th>Beneficiario</th>
                    <th>Valor Total</th>
                    <th>Estado</th>
                    <th>Etapa</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuentas as $cuenta)
                    <tr>
                        <td><strong>{{ $cuenta->numero }}</strong></td>
                        <td style="color: var(--apple-gray);">{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($cuenta->nombre_beneficiario ?? 'N/A', 25) }}</td>
                        <td><strong style="color: var(--apple-blue);">${{ number_format($cuenta->valor_total, 0, ',', '.') }}</strong></td>
                        <td>
                            <span class="status-badge" style="background: {{ $cuenta->getEstadoColor() }}22; color: {{ $cuenta->getEstadoColor() }};">
                                <span class="material-symbols-rounded">{{ $cuenta->getEstadoIcono() }}</span>
                                {{ $cuenta->getEstadoTexto() }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 12px; color: #6b7280;">{{ $cuenta->getEtapaTexto() }}</span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('cuentas_cobro.show', $cuenta) }}" class="btn-icon btn-icon-view" title="Ver detalles">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">visibility</span>
                                </a>
                                <a href="{{ route('cuentas_cobro.pdf', $cuenta->id) }}" target="_blank" class="btn-icon btn-icon-pdf" title="Ver PDF">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">picture_as_pdf</span>
                                </a>
                                @if(auth()->user()->role->name === 'contratista' && $cuenta->user_id === auth()->id() && $cuenta->estado_aprobacion === 'en_correccion')
                                <a href="{{ route('cuentas_cobro.edit', $cuenta) }}" class="btn-icon btn-icon-edit" title="Editar">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
                                </a>
                                @endif
                                @if(auth()->user()->role->name === 'super_admin')
                                <form action="{{ route('cuentas_cobro.destroy', $cuenta) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta cuenta de cobro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-icon-delete" title="Eliminar">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb;">
            {{ $cuentas->links() }}
        </div>
    @else
        <div class="empty-illustration">
            <span class="material-symbols-rounded">receipt_long</span>
            <h2 class="empty-title">No hay cuentas de cobro</h2>
            <p class="empty-text">Comienza creando tu primera cuenta de cobro</p>
            @if(auth()->user()->role->name === 'contratista')
            <a href="{{ route('cuentas_cobro.create') }}" class="btn-apple">
                <span class="material-symbols-rounded" style="font-size: 20px;">add_circle</span>
                Crear Primera Cuenta
            </a>
            @endif
        </div>
    @endif
</div>

{{-- Modal Confirmar Creación --}}
<div id="confirmCreateModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header info">
            <span class="material-symbols-rounded">add_circle</span>
            <h2>Crear Nueva Cuenta de Cobro</h2>
            <button class="close-btn" onclick="closeModal('confirmCreateModal')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-alert info">
                <span class="material-symbols-rounded">info</span>
                <div>
                    <strong>Flujo de Aprobación</strong><br>
                    <span style="font-size: 13px;">Al crear una cuenta de cobro, esta será enviada automáticamente al flujo de aprobación.</span>
                </div>
            </div>
            <div style="background: #f9fafb; padding: 16px; border-radius: 12px;">
                <div style="font-weight: 600; margin-bottom: 12px;">Etapas del flujo:</div>
                <ol style="margin: 0; padding-left: 20px; color: #4b5563; font-size: 14px;">
                    <li style="margin-bottom: 6px;">Supervisor</li>
                    <li style="margin-bottom: 6px;">Ordenador del Gasto</li>
                    <li style="margin-bottom: 6px;">Contratación</li>
                    <li style="margin-bottom: 6px;">Alcalde</li>
                    <li>Tesorería (Pago)</li>
                </ol>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('confirmCreateModal')">
                <span class="material-symbols-rounded">close</span>
                Cancelar
            </button>
            <a href="{{ route('cuentas_cobro.create') }}" class="modal-btn modal-btn-primary" style="text-decoration: none;">
                <span class="material-symbols-rounded">add_circle</span>
                Continuar
            </a>
        </div>
    </div>
</div>

{{-- Modal Permisos para Crear --}}
<div id="permissionCreateModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header warning">
            <span class="material-symbols-rounded">lock</span>
            <h2>Permiso Requerido</h2>
            <button class="close-btn" onclick="closeModal('permissionCreateModal')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-alert warning">
                <span class="material-symbols-rounded">info</span>
                <div>
                    <strong>Solo Contratistas</strong><br>
                    <span style="font-size: 13px;">La creación de cuentas de cobro está reservada para usuarios con rol de Contratista.</span>
                </div>
            </div>
            <div style="background: #f9fafb; padding: 16px; border-radius: 12px;">
                <div style="font-weight: 600; margin-bottom: 8px;">Tu rol actual:</div>
                <span class="role-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px;">
                    {{ ucfirst(str_replace('_', ' ', auth()->user()->role->name ?? 'Sin rol')) }}
                </span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-btn modal-btn-primary" onclick="closeModal('permissionCreateModal')">
                <span class="material-symbols-rounded">check</span>
                Entendido
            </button>
        </div>
    </div>
</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('cuentasTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let match = false;
        for (let j = 0; j < cells.length - 1; j++) {
            if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                match = true;
                break;
            }
        }
        rows[i].style.display = match ? '' : 'none';
    }
}
</script>

<style>
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
</style>
@endsection
