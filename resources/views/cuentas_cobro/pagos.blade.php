@extends('layouts.app')

@section('title', 'Gestión de Pagos')

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
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card-payment {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s;
        border-left: 4px solid;
    }

    .stat-card-payment.total {
        border-left-color: #0071e3;
    }

    .stat-card-payment.pending {
        border-left-color: #ff9500;
    }

    .stat-card-payment.approved {
        border-left-color: #30d158;
    }

    .stat-card-payment.rejected {
        border-left-color: #ff3b30;
    }

    .stat-card-payment:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stat-card-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }

    .stat-card-icon.total { background: linear-gradient(135deg, #0071e3, #00c6ff); }
    .stat-card-icon.pending { background: linear-gradient(135deg, #ff9500, #ffb84d); }
    .stat-card-icon.approved { background: linear-gradient(135deg, #30d158, #5de88a); }
    .stat-card-icon.rejected { background: linear-gradient(135deg, #ff3b30, #ff6b5e); }

    .stat-card-icon .material-symbols-rounded {
        font-size: 28px;
        color: white;
    }

    .stat-card-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--apple-dark);
        margin-bottom: 8px;
    }

    .stat-card-label {
        font-size: 14px;
        color: var(--apple-gray);
        font-weight: 500;
    }

    .filters-bar {
        background: white;
        padding: 20px 24px;
        border-radius: 14px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        font-size: 13px;
        font-weight: 600;
        color: var(--apple-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .filter-group select,
    .filter-group input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: var(--apple-blue);
        box-shadow: 0 0 0 3px var(--apple-blue-light);
    }

    .table-container {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.pending {
        background: rgba(255, 149, 0, 0.15);
        color: #ff9500;
    }

    .status-badge.approved {
        background: rgba(48, 209, 88, 0.15);
        color: #30d158;
    }

    .status-badge.rejected {
        background: rgba(255, 59, 48, 0.15);
        color: #ff3b30;
    }

    .status-badge.processing {
        background: rgba(0, 113, 227, 0.15);
        color: #0071e3;
    }

    .status-badge .material-symbols-rounded {
        font-size: 16px;
    }

    .payment-amount {
        font-size: 16px;
        font-weight: 700;
        color: var(--apple-blue);
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

    .btn-icon-approve {
        background: rgba(48, 209, 88, 0.15);
        color: #30d158;
    }

    .btn-icon-approve:hover {
        background: #30d158;
        color: white;
        transform: translateY(-2px);
    }

    .btn-icon-reject {
        background: rgba(255, 59, 48, 0.15);
        color: var(--apple-red);
    }

    .btn-icon-reject:hover {
        background: var(--apple-red);
        color: white;
        transform: translateY(-2px);
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
    <h1 class="page-title">Gestión de Pagos</h1>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('cuentas_cobro.index') }}" class="btn-apple btn-apple-secondary">
            <span class="material-symbols-rounded" style="font-size: 20px;">receipt_long</span>
            Ver Cuentas
        </a>
        <button onclick="exportPayments()" class="btn-apple">
            <span class="material-symbols-rounded" style="font-size: 20px;">download</span>
            Exportar
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-row">
    <div class="stat-card-payment total">
        <div class="stat-card-icon total">
            <span class="material-symbols-rounded">payments</span>
        </div>
        <div class="stat-card-value">${{ number_format($totalPagos ?? 0, 0, ',', '.') }}</div>
        <div class="stat-card-label">Total en Pagos</div>
    </div>

    <div class="stat-card-payment pending">
        <div class="stat-card-icon pending">
            <span class="material-symbols-rounded">schedule</span>
        </div>
        <div class="stat-card-value">{{ $pagosPendientes ?? 0 }}</div>
        <div class="stat-card-label">Pagos Pendientes</div>
    </div>

    <div class="stat-card-payment approved">
        <div class="stat-card-icon approved">
            <span class="material-symbols-rounded">check_circle</span>
        </div>
        <div class="stat-card-value">{{ $pagosAprobados ?? 0 }}</div>
        <div class="stat-card-label">Pagos Aprobados</div>
    </div>

    <div class="stat-card-payment rejected">
        <div class="stat-card-icon rejected">
            <span class="material-symbols-rounded">cancel</span>
        </div>
        <div class="stat-card-value">{{ $pagosRechazados ?? 0 }}</div>
        <div class="stat-card-label">Pagos Rechazados</div>
    </div>
</div>

<!-- Filters Bar -->
<div class="filters-bar">
    <div class="filter-group">
        <label>Estado</label>
        <select id="statusFilter" onchange="filterTable()">
            <option value="">Todos los estados</option>
            <option value="pending">Pendiente</option>
            <option value="approved">Aprobado</option>
            <option value="rejected">Rechazado</option>
            <option value="processing">En Proceso</option>
        </select>
    </div>

    <div class="filter-group">
        <label>Fecha Desde</label>
        <input type="date" id="dateFrom" onchange="filterTable()">
    </div>

    <div class="filter-group">
        <label>Fecha Hasta</label>
        <input type="date" id="dateTo" onchange="filterTable()">
    </div>

    <div class="filter-group">
        <label>Buscar</label>
        <input type="text" id="searchInput" placeholder="Número de cuenta..." onkeyup="filterTable()">
    </div>
</div>

<!-- Payments Table -->
<div class="table-container">
    @if(isset($cuentas) && $cuentas->count() > 0)
        <table class="apple-table" id="paymentsTable">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Contratista</th>
                    <th>Fecha Emisión</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Fecha Pago</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuentas as $cuenta)
                    <tr data-status="{{ $cuenta->estado_pago ?? 'pending' }}">
                        <td><strong>{{ $cuenta->numero }}</strong></td>
                        <td style="color: var(--apple-gray);">{{ $cuenta->user->name ?? 'N/A' }}</td>
                        <td style="color: var(--apple-gray);">{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</td>
                        <td>
                            <span class="payment-amount">${{ number_format($cuenta->valor_total, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            @php
                                $estado = $cuenta->estado_pago ?? 'pending';
                                $iconos = [
                                    'pending' => 'schedule',
                                    'approved' => 'check_circle',
                                    'rejected' => 'cancel',
                                    'processing' => 'sync'
                                ];
                                $textos = [
                                    'pending' => 'Pendiente',
                                    'approved' => 'Aprobado',
                                    'rejected' => 'Rechazado',
                                    'processing' => 'En Proceso'
                                ];
                            @endphp
                            <span class="status-badge {{ $estado }}">
                                <span class="material-symbols-rounded">{{ $iconos[$estado] ?? 'help' }}</span>
                                {{ $textos[$estado] ?? 'Desconocido' }}
                            </span>
                        </td>
                        <td style="color: var(--apple-gray);">
                            {{ $cuenta->fecha_pago ? \Carbon\Carbon::parse($cuenta->fecha_pago)->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('cuentas_cobro.show', $cuenta) }}" class="btn-icon btn-icon-view" title="Ver detalles">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">visibility</span>
                                </a>
                                @if(($cuenta->estado_pago ?? 'pending') === 'pending' && ($cuenta->estado_aprobacion === 'aprobado') && ($cuenta->etapa_aprobacion === 'tesoreria'))
                                    <button onclick="openPagoModal({{ $cuenta->id }}, {{ (float)($cuenta->valor_total ?? 0) }})" class="btn-icon btn-icon-approve" title="Registrar pago">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">paid</span>
                                    </button>
                                    <button onclick="openRejectPago({{ $cuenta->id }})" class="btn-icon btn-icon-reject" title="Rechazar pago">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">close</span>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-illustration">
            <span class="material-symbols-rounded">payments</span>
            <h2 class="empty-title">No hay pagos registrados</h2>
            <p class="empty-text">Las cuentas de cobro aparecerán aquí cuando sean creadas</p>
            <a href="{{ route('cuentas_cobro.index') }}" class="btn-apple">
                <span class="material-symbols-rounded" style="font-size: 20px;">receipt_long</span>
                Ver Cuentas de Cobro
            </a>
        </div>
    @endif
</div>

<script>
function filterTable() {
    const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    const searchInput = document.getElementById('searchInput').value.toUpperCase();
    const table = document.getElementById('paymentsTable');
    
    if (!table) return;
    
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const status = row.getAttribute('data-status');
        const cells = row.getElementsByTagName('td');
        let showRow = true;

        // Filter by status
        if (statusFilter && status !== statusFilter) {
            showRow = false;
        }

        // Filter by search
        if (searchInput && showRow) {
            let found = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toUpperCase().indexOf(searchInput) > -1) {
                    found = true;
                    break;
                }
            }
            if (!found) showRow = false;
        }

        row.style.display = showRow ? '' : 'none';
    }
}

function openPagoModal(id, valor){
  const form = document.getElementById('pagoForm');
  form.action = `{{ url('/cuentas_cobro') }}/${id}/pagar`;
  document.getElementById('valor_pagado').value = valor.toFixed(2);
  document.getElementById('pagoModal').style.display = 'flex';
}
function closePagoModal(){
  document.getElementById('pagoModal').style.display = 'none';
}

function exportPayments() {
    alert('Exportando pagos a Excel...');
    // Aquí iría la lógica de exportación
}
</script>

<style>
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        
        .page-header > div {
            width: 100%;
            flex-direction: column;
        }

        .page-header .btn-apple {
            width: 100%;
            justify-content: center;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }

        .filters-bar {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }
    }
</style>
<!-- Modal Registrar Pago -->
<div id="pagoModal" style="display:none; position: fixed; inset:0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; padding: 24px; max-width: 560px; width: 92%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <h2 style="margin-top:0;">Registrar pago</h2>
        <form id="pagoForm" method="POST">
            @csrf
            <div class="filters-bar" style="box-shadow:none; padding:0; gap:12px;">
                <div class="filter-group">
                    <label>Valor pagado</label>
                    <input type="number" name="valor_pagado" id="valor_pagado" step="0.01" required />
                </div>
                <div class="filter-group">
                    <label>Medio de pago</label>
                    <select name="medio_pago" required>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Consignación">Consignación</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Referencia</label>
                    <input type="text" name="referencia_pago" placeholder="# de transacción" />
                </div>
                <div class="filter-group" style="grid-column:1/-1;">
                    <label>Observaciones</label>
                    <textarea name="observacion_pago" rows="3" placeholder="Comentario opcional"></textarea>
                </div>
            </div>
            <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:12px;">
                <button type="button" class="btn-action btn-back" onclick="closePagoModal()">Cancelar</button>
                <button type="submit" class="btn-action" style="background:#34C759;color:white;border:none;">Confirmar pago</button>
            </div>
        </form>
    </div>
  
</div>
<!-- Modal Rechazar Pago -->
<div id="rejectPagoModal" style="display:none; position: fixed; inset:0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; padding: 24px; max-width: 520px; width: 92%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <h2 style="margin-top:0;">Rechazar pago</h2>
        <form id="rejectPagoForm" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label>Motivo</label>
                <textarea name="motivo" rows="3" required class="form-control"></textarea>
            </div>
            <div style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" class="btn-action btn-back" onclick="closeRejectPago()">Cancelar</button>
                <button type="submit" class="btn-action" style="background:#FF3B30;color:white;border:none;">Rechazar pago</button>
            </div>
        </form>
    </div>
</div>
<script>
function openRejectPago(id){
    const form = document.getElementById('rejectPagoForm');
    form.action = `{{ url('/cuentas_cobro') }}/${id}/rechazar-pago`;
    document.getElementById('rejectPagoModal').style.display = 'flex';
}
function closeRejectPago(){
    document.getElementById('rejectPagoModal').style.display = 'none';
}
</script>
@endsection
