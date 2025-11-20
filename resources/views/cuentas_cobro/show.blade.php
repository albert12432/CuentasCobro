@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/components/badges.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/timeline.css') }}">
    <link rel="stylesheet" href="{{ asset('css/views/cuentas-cobro.css') }}">
@endpush

@section('content')

<div class="detail-container">
    {{-- Header --}}
    <div class="detail-header">
        <h1 class="detail-title">
            <span class="material-symbols-rounded">receipt_long</span>
            Detalle de Cuenta de Cobro
        </h1>
        <a href="{{ route('cuentas_cobro.index') }}" class="btn-action btn-back">
            <span class="material-symbols-rounded">arrow_back</span>
            Volver al listado
        </a>
    </div>

    {{-- Card principal --}}
    <div class="detail-card">
        {{-- Banner superior --}}
        <div class="detail-banner">
            <div class="banner-info">
                <h2>{{ $cuenta->numero }}</h2>
                <p>Emitida el {{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</p>
            </div>
            <div class="banner-amount">
                <div class="banner-amount-label">Valor Total</div>
                <div class="banner-amount-value">${{ number_format($cuenta->valor_total, 2, ',', '.') }}</div>
            </div>
        </div>

        {{-- Cuerpo del detalle --}}
        <div class="detail-body">
            {{-- Estado y Etapa de Aprobación --}}
            <div class="detail-section">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <span class="material-symbols-rounded" style="color: {{ $cuenta->getEstadoColor() }}; font-size: 28px;">
                        {{ $cuenta->getEstadoIcono() }}
                    </span>
                    <div>
                        <div style="font-size: 14px; color: #86868b; font-weight: 500;">Estado Actual</div>
                        <div style="font-size: 20px; font-weight: 700; color: {{ $cuenta->getEstadoColor() }};">
                            {{ $cuenta->getEstadoTexto() }}
                        </div>
                    </div>
                </div>
                <div style="color:#6b7280; font-size: 14px; margin-bottom: 8px;">
                    Etapa: <strong>{{ $cuenta->getEtapaTexto() }}</strong>
                </div>
                @if($cuenta->motivo_rechazo)
                    <div style="background: #FFF3F3; border-left: 4px solid #FF3B30; padding: 12px; border-radius: 12px; margin-top: 8px;">
                        <strong>Motivo de rechazo:</strong> {{ $cuenta->motivo_rechazo }}
                    </div>
                @endif
                @if($cuenta->motivo_devolucion)
                    <div style="background: #FFF8E1; border-left: 4px solid #FF9500; padding: 12px; border-radius: 12px; margin-top: 8px;">
                        <strong>Motivo de devolución:</strong> {{ $cuenta->motivo_devolucion }}
                    </div>
                @endif
            </div>

            {{-- Sección: Información del Beneficiario --}}
            <div class="detail-section">
                <h3 class="section-title">
                    <span class="material-symbols-rounded">person</span>
                    Información del Beneficiario
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <span class="material-symbols-rounded">badge</span>
                            Tipo de Identificación
                        </div>
                        <div class="info-value">{{ $cuenta->tipo_identificacion ?? 'No especificado' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <span class="material-symbols-rounded">fingerprint</span>
                            Número de Identificación
                        </div>
                        <div class="info-value">{{ $cuenta->identificacion ?? 'No especificado' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <span class="material-symbols-rounded">account_circle</span>
                            Nombre del Beneficiario
                        </div>
                        <div class="info-value">{{ $cuenta->nombre_beneficiario ?? 'No especificado' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <span class="material-symbols-rounded">groups</span>
                            Tipo de Cliente
                        </div>
                        <div class="info-value">
                            {{ $cuenta->tipo_cliente === 'natural' ? 'Persona Natural' : 'Persona Jurídica' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección: Datos de la Cuenta --}}
            <div class="detail-section">
                <h3 class="section-title">
                    <span class="material-symbols-rounded">description</span>
                    Datos de la Cuenta
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <span class="material-symbols-rounded">schedule</span>
                            Plazo de Pago
                        </div>
                        <div class="info-value">{{ $cuenta->plazo_pago ?? 30 }} días</div>
                    </div>
                    @if($cuenta->contrato)
                    <div class="info-item">
                        <div class="info-label">
                            <span class="material-symbols-rounded">handshake</span>
                            Contrato Asociado
                        </div>
                        <div class="info-value">
                            {{ $cuenta->contrato->numero ?? 'Contrato #'.$cuenta->contrato->id }}
                            @if($cuenta->contrato->tipo_contrato)
                                <br><span style="font-size: 0.9rem; color: var(--apple-gray);">{{ $cuenta->contrato->tipo_contrato }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="info-item">
                        <div class="info-label">
                            <span class="material-symbols-rounded">flag</span>
                            Estado
                        </div>
                        <div class="info-value">
                            <span class="status-badge" style="background: {{ $cuenta->getEstadoColor() }}22; color: {{ $cuenta->getEstadoColor() }};">
                                <span class="material-symbols-rounded" style="font-size: 1rem; color: {{ $cuenta->getEstadoColor() }};">{{ $cuenta->getEstadoIcono() }}</span>
                                {{ $cuenta->getEstadoTexto() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección: Ubicación --}}
            <div class="detail-section">
                <h3 class="section-title">
                    <span class="material-symbols-rounded">location_on</span>
                    Ubicación
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <span class="material-symbols-rounded">map</span>
                            Departamento
                        </div>
                        <div class="info-value">{{ $cuenta->departamento }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <span class="material-symbols-rounded">location_city</span>
                            Municipio
                        </div>
                        <div class="info-value">{{ $cuenta->municipio }}</div>
                    </div>
                    @if($cuenta->descripcion)
                    <div class="info-item full-width">
                        <div class="info-label">
                            <span class="material-symbols-rounded">notes</span>
                            Descripción
                        </div>
                        <div class="info-value">{{ $cuenta->descripcion }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sección: Ítems --}}
            @if($cuenta->items && $cuenta->items->count() > 0)
            <div class="detail-section">
                <h3 class="section-title">
                    <span class="material-symbols-rounded">inventory_2</span>
                    Ítems de la Cuenta
                </h3>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Ítem</th>
                            <th>Detalle</th>
                            <th class="text-right">Cantidad</th>
                            <th class="text-right">Precio Unitario</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuenta->items as $item)
                        <tr>
                            <td>{{ $item->item }}</td>
                            <td>{{ $item->detalle ?? '—' }}</td>
                            <td class="text-right">{{ $item->cantidad }}</td>
                            <td class="text-right">${{ number_format($item->precio_unitario, 2, ',', '.') }}</td>
                            <td class="text-right">${{ number_format($item->cantidad * $item->precio_unitario, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Timeline e Interacciones de Aprobación --}}
            <div class="detail-section">
                <h3 class="section-title">
                    <span class="material-symbols-rounded">history</span>
                    Historial de Cambios
                </h3>
                @php $hist = $cuenta->historial ?? collect(); @endphp
                @if($hist->count() === 0)
                <div style="background:#f9fafb;border:1px dashed #d1d5db;padding:16px;border-radius:12px;color:#6b7280;">Sin registros aún.</div>
                @else
                    <div class="timeline">
                        @foreach($hist as $registro)
                            <div class="timeline-item">
                                <div class="timeline-marker" style="background: {{ $registro->getColor() }};">
                                    <span class="material-symbols-rounded">{{ $registro->getIcono() }}</span>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <span class="timeline-action" style="color: {{ $registro->getColor() }};">{{ ucfirst($registro->accion) }}</span>
                                        <span class="timeline-date">{{ $registro->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if($registro->estado_anterior || $registro->estado_nuevo)
                                    <div class="timeline-states">
                                        @if($registro->estado_anterior)
                                            <span class="state-badge">{{ $registro->estado_anterior }}</span>
                                            <span class="material-symbols-rounded" style="font-size:16px;color:#86868b;">arrow_forward</span>
                                        @endif
                                        @if($registro->estado_nuevo)
                                            <span class="state-badge state-new">{{ $registro->estado_nuevo }}</span>
                                        @endif
                                    </div>
                                    @endif
                                    @if($registro->comentario)
                                        <div class="timeline-comment">{{ $registro->comentario }}</div>
                                    @endif
                                    @if($registro->user)
                                        <div class="timeline-user"><span class="material-symbols-rounded">person</span> {{ $registro->user->name }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @include('cuentas_cobro.partials.interacciones')

            @php
                $userRole = auth()->user()->role->name ?? '';
                $isContratistaOwner = $cuenta->isOwner(auth()->user());
                $canApprove = $cuenta->canUserApprove(auth()->user());
                $canSendClient = $cuenta->canSendToClient(auth()->user());
            @endphp

            @if($canApprove)
            <div class="detail-section" style="background:#F5F5F7;padding:16px;border-radius:16px;">
                <h3 class="section-title" style="margin-bottom: 12px;">
                    <span class="material-symbols-rounded">verified</span>
                    Acciones de Aprobación
                </h3>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <form action="{{ route('cuentas_cobro.aprobar', $cuenta->id) }}" method="POST" id="approveForm">
                        @csrf
                        <input type="hidden" name="comentario" value="" />
                        <button type="submit" class="btn-action btn-approve" style="background:#34C759;color:white;border:none;" id="approveBtn">
                            <span class="material-symbols-rounded">send</span>
                            Enviar al siguiente nivel
                        </button>
                    </form>
                    <button type="button" class="btn-action" onclick="openRejectModal()" style="background:#FF3B30;color:white;border:none;">
                        <span class="material-symbols-rounded">cancel</span>
                        Rechazar
                    </button>
                    @if($userRole === 'contratacion' && $cuenta->etapa_aprobacion === 'contratacion')
                    <button type="button" class="btn-action" onclick="openDevolverModal()" style="background:#FF9500;color:white;border:none;">
                        <span class="material-symbols-rounded">undo</span>
                        Devolver para corrección
                    </button>
                    @endif
                </div>
            </div>
            @endif

            @if($canSendClient)
            <div class="detail-section" style="background:#F5F5F7;padding:16px;border-radius:16px;">
                <h3 class="section-title" style="margin-bottom: 12px;">
                    <span class="material-symbols-rounded">send</span>
                    Envío al Cliente
                </h3>
                <form action="{{ route('cuentas_cobro.enviar_cliente', $cuenta->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-action" style="background:#5856D6;color:white;border:none;">
                        <span class="material-symbols-rounded">send</span>
                        Enviar al cliente
                    </button>
                </form>
            </div>
            @endif

            {{-- Soportes --}}
            <div class="detail-section">
                <h3 class="section-title">
                    <span class="material-symbols-rounded">attach_file</span>
                    Soportes adjuntos
                </h3>
                @php $soportes = $cuenta->soportes ?? collect(); @endphp
                @if($soportes->count() === 0)
                    <div style="background:#f9fafb;border:1px dashed #d1d5db;padding:16px;border-radius:12px;color:#6b7280;">No hay soportes adjuntos.</div>
                @else
                    <ul style="list-style:none;padding:0;margin:0;display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:10px;">
                        @foreach($soportes as $s)
                        <li style="background:white;border:1px solid #E5E5EA;border-radius:12px;padding:12px;display:flex;align-items:center;justify-content:space-between;gap:10px;">
                            <div style="display:flex;align-items:center;gap:8px;min-width:0;">
                                <span class="material-symbols-rounded">description</span>
                                <a href="{{ Storage::url($s->path) }}" target="_blank" style="font-weight:600;color:#007AFF;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $s->nombre }}</a>
                            </div>
                            @if($isContratistaOwner && in_array($cuenta->estado_aprobacion, ['en_correccion','en_revision']))
                            <form action="{{ route('cuentas_cobro.soportes.destroy', [$cuenta->id, $s->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar soporte?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action" style="background:#FF3B30;color:white;border:none;padding:8px 12px;">
                                    <span class="material-symbols-rounded">delete</span>
                                    Eliminar
                                </button>
                            </form>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                @endif

                @if($isContratistaOwner && in_array($cuenta->estado_aprobacion, ['en_correccion','en_revision']))
                <form action="{{ route('cuentas_cobro.soportes.store', $cuenta->id) }}" method="POST" enctype="multipart/form-data" style="margin-top:12px;background:#F5F5F7;padding:16px;border-radius:12px;">
                    @csrf
                    <label style="display:block;font-weight:600;margin-bottom:6px;">Subir nuevos soportes</label>
                    <input type="file" name="soportes[]" multiple required />
                    <div style="margin-top:8px;">
                        <button type="submit" class="btn-action" style="background:#007AFF;color:white;border:none;">
                            <span class="material-symbols-rounded">upload</span>
                            Subir archivos
                        </button>
                    </div>
                </form>
                @endif
            </div>

            {{-- Acciones --}}
            <div class="detail-actions">
                <a href="{{ route('cuentas_cobro.index') }}" class="btn-action btn-back">
                    <span class="material-symbols-rounded">arrow_back</span>
                    Volver
                </a>
                @if($isContratistaOwner && $cuenta->estado_aprobacion === 'en_correccion')
                <a href="{{ route('cuentas_cobro.edit', $cuenta) }}" class="btn-action btn-edit">
                    <span class="material-symbols-rounded">edit</span>
                    Editar
                </a>
                <form action="{{ route('cuentas_cobro.reenviar', $cuenta->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-action" style="background:#0A84FF;color:white;border:none;">
                        <span class="material-symbols-rounded">redo</span>
                        Reenviar a revisión
                    </button>
                </form>
                @endif
                <a href="{{ route('cuentas_cobro.pdf', $cuenta->id) }}" target="_blank" class="btn-action btn-pdf">
                    <span class="material-symbols-rounded">picture_as_pdf</span>
                    Descargar PDF
                </a>
                @if($isContratistaOwner && !$cuenta->archived_at)
                <form action="{{ route('cuentas_cobro.archivar', $cuenta->id) }}" method="POST" onsubmit="return confirm('¿Archivar esta cuenta?');">
                    @csrf
                    <button type="submit" class="btn-action" style="background:#6b7280;color:white;border:none;">
                        <span class="material-symbols-rounded">inventory_2</span>
                        Archivar
                    </button>
                </form>
                @elseif($isContratistaOwner && $cuenta->archived_at)
                <form action="{{ route('cuentas_cobro.desarchivar', $cuenta->id) }}" method="POST" onsubmit="return confirm('¿Desarchivar esta cuenta?');">
                    @csrf
                    <button type="submit" class="btn-action" style="background:#10b981;color:white;border:none;">
                        <span class="material-symbols-rounded">unarchive</span>
                        Desarchivar
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Rechazo --}}
<div id="rejectModal" style="display:none; position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:20px;padding:24px;max-width:500px;width:92%;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h2 style="margin-top:0;display:flex;align-items:center;gap:8px;"><span class="material-symbols-rounded">cancel</span> Rechazar Cuenta</h2>
        <form action="{{ route('cuentas_cobro.rechazar', $cuenta->id) }}" method="POST">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:600;margin-bottom:6px;">Motivo de rechazo</label>
                <textarea name="motivo_rechazo" rows="4" required style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px;"></textarea>
            </div>
            <div style="display:flex;gap:8px;justify-content:flex-end;">
                <button type="button" onclick="closeRejectModal()" class="btn-action btn-back">Cancelar</button>
                <button type="submit" class="btn-action" style="background:#FF3B30;color:white;border:none;">Rechazar</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Devolver --}}
<div id="devolverModal" style="display:none; position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:20px;padding:24px;max-width:500px;width:92%;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h2 style="margin-top:0;display:flex;align-items:center;gap:8px;"><span class="material-symbols-rounded">undo</span> Devolver para corrección</h2>
        <form action="{{ route('cuentas_cobro.devolver', $cuenta->id) }}" method="POST">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block;font-weight:600;margin-bottom:6px;">Motivo</label>
                <textarea name="motivo" rows="4" required style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px;"></textarea>
            </div>
            <div style="display:flex;gap:8px;justify-content:flex-end;">
                <button type="button" onclick="closeDevolverModal()" class="btn-action btn-back">Cancelar</button>
                <button type="submit" class="btn-action" style="background:#FF9500;color:white;border:none;">Devolver</button>
            </div>
        </form>
    </div>
</div>

<style>
.timeline {position: relative; padding-left: 50px;}
.timeline::before {content:'';position:absolute;left:20px;top:0;bottom:0;width:2px;background:linear-gradient(to bottom, #007AFF, #34C759);}
.timeline-item {position:relative;margin-bottom:20px;}
.timeline-marker {position:absolute;left:-30px;top:0;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,0.15);border:3px solid white;}
.timeline-marker .material-symbols-rounded {color:white;font-size:18px;}
.timeline-content {background:white;padding:16px;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.08);border:1px solid #E5E5EA;}
.timeline-header {display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;}
.timeline-action {font-weight:700;font-size:16px;}
.timeline-date {font-size:12px;color:#86868b;}
.timeline-states {display:flex;align-items:center;gap:8px;margin-bottom:8px;}
.state-badge {display:inline-block;padding:4px 10px;background:#F5F5F7;color:#86868b;border-radius:8px;font-size:12px;font-weight:600;text-transform:capitalize;}
.state-badge.state-new {background:#E3F2FD;color:#007AFF;}
.timeline-comment {background:#F5F5F7;padding:10px 14px;border-radius:10px;font-size:14px;color:#1d1d1f;margin-bottom:8px;}
.timeline-user {display:flex;align-items:center;gap:6px;font-size:13px;color:#86868b;font-weight:500;}
.timeline-user .material-symbols-rounded {font-size:16px;}
</style>

<script>
function openRejectModal(){ document.getElementById('rejectModal').style.display='flex'; }
function closeRejectModal(){ document.getElementById('rejectModal').style.display='none'; }
document.getElementById('rejectModal')?.addEventListener('click', function(e){ if(e.target === this) closeRejectModal(); });
function openDevolverModal(){ document.getElementById('devolverModal').style.display='flex'; }
function closeDevolverModal(){ document.getElementById('devolverModal').style.display='none'; }
document.getElementById('devolverModal')?.addEventListener('click', function(e){ if(e.target === this) closeDevolverModal(); });

// Deshabilitar botón de aprobación mientras se procesa
document.getElementById('approveForm')?.addEventListener('submit', function(e) {
    const btn = document.getElementById('approveBtn');
    if (btn) {
        btn.disabled = true;
        btn.style.opacity = '0.6';
        btn.style.cursor = 'not-allowed';
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="material-symbols-rounded" style="animation: spin 1s linear infinite;">autorenew</span> Procesando...';
    }
});
</script>
@endsection
