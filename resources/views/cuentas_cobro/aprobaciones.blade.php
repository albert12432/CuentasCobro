@extends('layouts.app')

@section('content')
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
        <div class="detail-section" style="margin-bottom: 16px;">
            <div style="background:#F5F5F7;border-left:4px solid #007AFF;padding:12px 16px;border-radius:12px;">
                <strong>Etapa actual asignada:</strong> {{ ucfirst(str_replace('_',' ', $etapa)) }}
            </div>
        </div>
    @else
        <div class="detail-section" style="margin-bottom: 16px;">
            <div style="background:#FFF4E5;border-left:4px solid #FF9500;padding:12px 16px;border-radius:12px;">
                <strong>Tu rol ({{ $role }}) no tiene etapa asignada para aprobación.</strong>
            </div>
        </div>
    @endif

    @php $userRole = auth()->user()->role->name ?? ''; @endphp
    @forelse($cuentas as $cuenta)
        <div class="detail-card" style="margin-bottom: 16px;">
            <div class="detail-banner">
                <div class="banner-info">
                    <h2>#{{ $cuenta->numero }}</h2>
                    <p>Emitida el {{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }} • Beneficiario: {{ $cuenta->nombre_beneficiario }}</p>
                </div>
                <div class="banner-amount">
                    <div class="banner-amount-label">Valor Total</div>
                    <div class="banner-amount-value">${{ number_format($cuenta->valor_total, 2, ',', '.') }}</div>
                </div>
            </div>
            <div class="detail-body">
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" class="btn-action btn-edit">
                        <span class="material-symbols-rounded">visibility</span>
                        Ver detalle
                    </a>
                    @if($cuenta->canUserApprove(auth()->user()))
                        <form action="{{ route('cuentas_cobro.aprobar', $cuenta->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-action" style="background:#34C759;color:white;border:none;">
                                <span class="material-symbols-rounded">send</span>
                                Enviar al siguiente nivel
                            </button>
                        </form>
                        <button type="button" class="btn-action" onclick="openRejectModal({{ $cuenta->id }})" style="background:#FF3B30;color:white;border:none;">
                            <span class="material-symbols-rounded">cancel</span>
                            Rechazar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="detail-card">
            <div class="detail-body" style="text-align:center;color:#86868b;">
                <span class="material-symbols-rounded" style="font-size:48px;">inbox</span>
                <div>No tienes cuentas pendientes por aprobar en esta etapa.</div>
            </div>
        </div>
    @endforelse

    <div style="margin-top: 16px;">
        {{ $cuentas->links() }}
    </div>
</div>

<!-- Modal Rechazo reutilizable -->
<div id="rejectModal" style="display:none; position: fixed; inset:0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; padding: 24px; max-width: 520px; width: 92%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <h2 style="margin-top:0;">Rechazar Cuenta</h2>
        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label>Motivo de rechazo</label>
                <textarea name="motivo_rechazo" rows="4" required style="width:100%;border:1px solid #e5e7eb;border-radius:10px;padding:8px;"></textarea>
            </div>
            <div style="display:flex;gap:8px;justify-content:flex-end;">
                <button type="button" onclick="closeRejectModal()" class="btn-action btn-back">Cancelar</button>
                <button type="submit" class="btn-action" style="background:#FF3B30;color:white;border:none;">Rechazar</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(id){
    const form = document.getElementById('rejectForm');
    form.action = `{{ url('/cuentas_cobro') }}/${id}/rechazar`;
    document.getElementById('rejectModal').style.display = 'flex';
}
function closeRejectModal(){
    document.getElementById('rejectModal').style.display = 'none';
}
</script>
@endsection
