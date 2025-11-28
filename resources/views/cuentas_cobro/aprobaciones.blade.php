@extends('layouts.app')

@section('content')
@include('components.modals')

<style>
    .approval-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }

    .approval-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }

    .approval-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .approval-header .cuenta-info h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .approval-header .cuenta-info p {
        margin: 4px 0 0;
        opacity: 0.9;
        font-size: 13px;
    }

    .approval-amount {
        text-align: right;
    }

    .approval-amount .label {
        font-size: 11px;
        opacity: 0.8;
        text-transform: uppercase;
    }

    .approval-amount .value {
        font-size: 24px;
        font-weight: 700;
    }

    .approval-body {
        padding: 20px 24px;
    }

    .approval-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .stage-info {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #F3F4F6;
        border-radius: 8px;
        font-size: 13px;
        color: #4B5563;
        margin-bottom: 16px;
    }

    .stage-info .material-symbols-rounded {
        font-size: 18px;
        color: #007AFF;
    }

    .empty-state {
        text-align: center;
        padding: 60px 32px;
    }

    .empty-state .material-symbols-rounded {
        font-size: 80px;
        color: #D1D5DB;
    }

    .empty-state h3 {
        margin: 16px 0 8px;
        font-size: 18px;
        color: #4B5563;
    }

    .empty-state p {
        color: #9CA3AF;
        margin: 0;
    }
</style>

<div class="detail-container">
    <div class="detail-header">
        <h1 class="detail-title">
            <span class="material-symbols-rounded">task_alt</span>
            Mis Aprobaciones
        </h1>
        <a href="{{ route('dashboard') }}" class="btn-action btn-back">
            <span class="material-symbols-rounded">arrow_back</span>
            Volver
        </a>
    </div>

    @if($etapa)
        <div class="stage-info">
            <span class="material-symbols-rounded">account_tree</span>
            <strong>Etapa actual asignada:</strong> {{ ucfirst(str_replace('_',' ', $etapa)) }}
        </div>
    @elseif($role === 'super_admin')
        <div class="stage-info" style="background: #DBEAFE; color: #1E40AF;">
            <span class="material-symbols-rounded">admin_panel_settings</span>
            <strong>Super Admin:</strong> Puedes gestionar todas las cuentas en revisión
        </div>
    @else
        <div class="stage-info" style="background: #FEF3C7; color: #92400E;">
            <span class="material-symbols-rounded">info</span>
            <strong>Tu rol ({{ $role }}) no tiene etapa asignada para aprobación.</strong>
        </div>
    @endif

    @php $userRole = auth()->user()->role->name ?? ''; @endphp
    @forelse($cuentas as $cuenta)
        <div class="approval-card">
            <div class="approval-header">
                <div class="cuenta-info">
                    <h3>#{{ $cuenta->numero }}</h3>
                    <p>Emitida el {{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }} • Beneficiario: {{ $cuenta->nombre_beneficiario }}</p>
                </div>
                <div class="approval-amount">
                    <div class="label">Valor Total</div>
                    <div class="value">${{ number_format($cuenta->valor_total, 2, ',', '.') }}</div>
                </div>
            </div>
            <div class="approval-body">
                <div class="stage-info" style="margin-bottom: 16px;">
                    <span class="material-symbols-rounded">flag</span>
                    Etapa actual: <strong>{{ $cuenta->getEtapaTexto() }}</strong>
                </div>
                <div class="approval-actions">
                    <a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" class="btn-action" style="background: #007AFF; color: white; border: none;">
                        <span class="material-symbols-rounded">visibility</span>
                        Ver Detalle
                    </a>
                    @if($cuenta->canUserApprove(auth()->user()))
                        <button type="button" class="btn-action" onclick="openApproveModal({{ $cuenta->id }})" style="background: linear-gradient(135deg, #34C759 0%, #22C55E 100%); color: white; border: none;">
                            <span class="material-symbols-rounded">check_circle</span>
                            Aprobar
                        </button>
                        <button type="button" class="btn-action" onclick="openRejectModal({{ $cuenta->id }})" style="background: linear-gradient(135deg, #FF3B30 0%, #DC2626 100%); color: white; border: none;">
                            <span class="material-symbols-rounded">cancel</span>
                            Rechazar
                        </button>
                        @if(in_array($userRole, ['contratacion', 'super_admin']) && $cuenta->etapa_aprobacion === 'contratacion')
                        <button type="button" class="btn-action" onclick="openDevolverModal({{ $cuenta->id }})" style="background: linear-gradient(135deg, #FF9500 0%, #F59E0B 100%); color: white; border: none;">
                            <span class="material-symbols-rounded">undo</span>
                            Devolver
                        </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="approval-card">
            <div class="empty-state">
                <span class="material-symbols-rounded">inbox</span>
                <h3>No hay cuentas pendientes</h3>
                <p>No tienes cuentas pendientes por aprobar en esta etapa.</p>
            </div>
        </div>
    @endforelse

    <div style="margin-top: 16px;">
        {{ $cuentas->links() }}
    </div>
</div>

<!-- Modal Aprobar -->
<div id="approveModalList" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header success">
            <span class="material-symbols-rounded">verified</span>
            <h2>Aprobar Cuenta</h2>
            <button class="close-btn" onclick="closeModal('approveModalList')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form id="approveFormList" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-alert info">
                    <span class="material-symbols-rounded">info</span>
                    <div>
                        <strong>Confirmación</strong><br>
                        <span style="font-size: 13px;">La cuenta será enviada a la siguiente etapa del flujo de aprobación.</span>
                    </div>
                </div>
                <div class="modal-form-group">
                    <label>Comentario (opcional)</label>
                    <textarea name="comentario" rows="3" placeholder="Agregue un comentario sobre esta aprobación..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('approveModalList')">
                    <span class="material-symbols-rounded">close</span>
                    Cancelar
                </button>
                <button type="submit" class="modal-btn modal-btn-success">
                    <span class="material-symbols-rounded">check_circle</span>
                    Aprobar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Rechazo -->
<div id="rejectModalList" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header danger">
            <span class="material-symbols-rounded">cancel</span>
            <h2>Rechazar Cuenta</h2>
            <button class="close-btn" onclick="closeModal('rejectModalList')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form id="rejectFormList" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-alert danger">
                    <span class="material-symbols-rounded">warning</span>
                    <div>
                        <strong>¡Atención!</strong><br>
                        <span style="font-size: 13px;">Esta acción rechazará definitivamente la cuenta.</span>
                    </div>
                </div>
                <div class="modal-form-group">
                    <label>Motivo del rechazo *</label>
                    <textarea name="motivo_rechazo" rows="4" required minlength="5" placeholder="Explique el motivo del rechazo..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('rejectModalList')">Cancelar</button>
                <button type="submit" class="modal-btn modal-btn-danger">Rechazar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Devolver -->
<div id="devolverModalList" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header warning">
            <span class="material-symbols-rounded">undo</span>
            <h2>Devolver para Corrección</h2>
            <button class="close-btn" onclick="closeModal('devolverModalList')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form id="devolverFormList" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-form-group">
                    <label>Motivo de la devolución *</label>
                    <textarea name="motivo" rows="4" required minlength="5" placeholder="Indique qué correcciones debe realizar el contratista..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('devolverModalList')">Cancelar</button>
                <button type="submit" class="modal-btn modal-btn-warning">Devolver</button>
            </div>
        </form>
    </div>
</div>

<script>
function openApproveModal(id) {
    const form = document.getElementById('approveFormList');
    form.action = `{{ url('/cuentas_cobro') }}/${id}/aprobar`;
    openModal('approveModalList');
}

function openRejectModal(id) {
    const form = document.getElementById('rejectFormList');
    form.action = `{{ url('/cuentas_cobro') }}/${id}/rechazar`;
    openModal('rejectModalList');
}

function openDevolverModal(id) {
    const form = document.getElementById('devolverFormList');
    form.action = `{{ url('/cuentas_cobro') }}/${id}/devolver`;
    openModal('devolverModalList');
}
</script>
@endsection
