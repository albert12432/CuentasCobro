@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/components/badges.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/timeline.css') }}">
    <link rel="stylesheet" href="{{ asset('css/views/cuentas-cobro.css') }}">
@endpush

@section('content')
@include('components.modals')

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

            {{-- Flujo de Documento - Acciones según Rol --}}
            <div class="detail-section workflow-section" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 20px; border-radius: 16px; border: 1px solid #e2e8f0;">
                <h3 class="section-title" style="margin-bottom: 16px;">
                    <span class="material-symbols-rounded">account_tree</span>
                    Flujo de Documento
                </h3>
                
                {{-- Indicador de Etapa Actual --}}
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 12px; background: white; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $cuenta->getEstadoColor() }}; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-rounded" style="color: white;">{{ $cuenta->getEstadoIcono() }}</span>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #6b7280; font-weight: 500;">Etapa Actual</div>
                        <div style="font-size: 16px; font-weight: 700; color: #1f2937;">{{ $cuenta->getEtapaTexto() }}</div>
                    </div>
                    <div style="margin-left: auto;">
                        <span class="role-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px;">
                            Tu rol: {{ ucfirst(str_replace('_', ' ', $userRole)) }}
                        </span>
                    </div>
                </div>

                @if($canApprove)
                {{-- Acciones de Aprobación --}}
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="button" class="btn-action" onclick="openModal('approveModal')" style="background: linear-gradient(135deg, #34C759 0%, #22C55E 100%); color: white; border: none; padding: 12px 20px;">
                        <span class="material-symbols-rounded">send</span>
                        Aprobar y Enviar
                    </button>
                    <button type="button" class="btn-action" onclick="openModal('rejectModal')" style="background: linear-gradient(135deg, #FF3B30 0%, #DC2626 100%); color: white; border: none; padding: 12px 20px;">
                        <span class="material-symbols-rounded">cancel</span>
                        Rechazar
                    </button>
                    @if(in_array($userRole, ['contratacion', 'super_admin']) && $cuenta->etapa_aprobacion === 'contratacion')
                    <button type="button" class="btn-action" onclick="openModal('devolverModal')" style="background: linear-gradient(135deg, #FF9500 0%, #F59E0B 100%); color: white; border: none; padding: 12px 20px;">
                        <span class="material-symbols-rounded">undo</span>
                        Devolver para Corrección
                    </button>
                    @endif
                    <button type="button" class="btn-action" onclick="openModal('comentarioModal')" style="background: linear-gradient(135deg, #007AFF 0%, #0051D5 100%); color: white; border: none; padding: 12px 20px;">
                        <span class="material-symbols-rounded">comment</span>
                        Agregar Comentario
                    </button>
                </div>
                @elseif(!$canApprove && $cuenta->estado_aprobacion === 'en_revision')
                {{-- Advertencia de permisos --}}
                <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: #FEF3C7; border: 1px solid #F59E0B; border-radius: 12px;">
                    <span class="material-symbols-rounded" style="color: #92400E; font-size: 24px;">info</span>
                    <div>
                        <div style="font-weight: 600; color: #92400E;">Esta cuenta está pendiente de aprobación</div>
                        <div style="font-size: 13px; color: #A16207;">Requiere aprobación del rol: <strong>{{ $cuenta->getEtapaTexto() }}</strong></div>
                    </div>
                </div>
                @endif

                {{-- Registro de Pago para Tesorería --}}
                @if($cuenta->canRegisterPayment(auth()->user()))
                <div style="margin-top: 16px; padding: 16px; background: white; border-radius: 12px; border: 2px solid #34C759;">
                    <h4 style="margin: 0 0 12px 0; display: flex; align-items: center; gap: 8px;">
                        <span class="material-symbols-rounded" style="color: #34C759;">payments</span>
                        Registro de Pago (Tesorería)
                    </h4>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button type="button" class="btn-action" onclick="openModal('pagoModal')" style="background: linear-gradient(135deg, #34C759 0%, #22C55E 100%); color: white; border: none; padding: 12px 20px;">
                            <span class="material-symbols-rounded">check_circle</span>
                            Registrar Pago
                        </button>
                        <button type="button" class="btn-action" onclick="openModal('rechazarPagoModal')" style="background: linear-gradient(135deg, #FF3B30 0%, #DC2626 100%); color: white; border: none; padding: 12px 20px;">
                            <span class="material-symbols-rounded">block</span>
                            Rechazar Pago
                        </button>
                    </div>
                </div>
                @endif
            </div>

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

{{-- Modal Aprobar --}}
<div id="approveModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header success">
            <span class="material-symbols-rounded">verified</span>
            <h2>Aprobar y Enviar al Siguiente Nivel</h2>
            <button class="close-btn" onclick="closeModal('approveModal')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form action="{{ route('cuentas_cobro.aprobar', $cuenta->id) }}" method="POST" id="approveForm">
            @csrf
            <div class="modal-body">
                <div class="modal-alert info">
                    <span class="material-symbols-rounded">info</span>
                    <div>
                        <strong>Cuenta #{{ $cuenta->numero }}</strong><br>
                        <span style="font-size: 13px;">Esta cuenta será enviada a la siguiente etapa del flujo de aprobación.</span>
                    </div>
                </div>
                <div class="modal-form-group">
                    <label>Comentario (opcional)</label>
                    <textarea name="comentario" rows="3" placeholder="Agregue un comentario sobre esta aprobación..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('approveModal')">
                    <span class="material-symbols-rounded">close</span>
                    Cancelar
                </button>
                <button type="submit" class="modal-btn modal-btn-success" id="approveBtn">
                    <span class="material-symbols-rounded">send</span>
                    Aprobar y Enviar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Rechazo --}}
<div id="rejectModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header danger">
            <span class="material-symbols-rounded">cancel</span>
            <h2>Rechazar Cuenta de Cobro</h2>
            <button class="close-btn" onclick="closeModal('rejectModal')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form action="{{ route('cuentas_cobro.rechazar', $cuenta->id) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-alert danger">
                    <span class="material-symbols-rounded">warning</span>
                    <div>
                        <strong>¡Atención!</strong><br>
                        <span style="font-size: 13px;">Esta acción rechazará definitivamente la cuenta. El contratista será notificado.</span>
                    </div>
                </div>
                <div class="modal-form-group">
                    <label>Motivo del rechazo *</label>
                    <textarea name="motivo_rechazo" rows="4" required minlength="5" placeholder="Explique el motivo del rechazo..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('rejectModal')">
                    <span class="material-symbols-rounded">close</span>
                    Cancelar
                </button>
                <button type="submit" class="modal-btn modal-btn-danger">
                    <span class="material-symbols-rounded">cancel</span>
                    Confirmar Rechazo
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Devolver para Corrección --}}
<div id="devolverModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header warning">
            <span class="material-symbols-rounded">undo</span>
            <h2>Devolver para Corrección</h2>
            <button class="close-btn" onclick="closeModal('devolverModal')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form action="{{ route('cuentas_cobro.devolver', $cuenta->id) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-alert warning">
                    <span class="material-symbols-rounded">edit</span>
                    <div>
                        <strong>Devolución al Contratista</strong><br>
                        <span style="font-size: 13px;">La cuenta será devuelta al contratista para que realice las correcciones necesarias.</span>
                    </div>
                </div>
                <div class="modal-form-group">
                    <label>Motivo de la devolución *</label>
                    <textarea name="motivo" rows="4" required minlength="5" placeholder="Indique qué correcciones debe realizar el contratista..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('devolverModal')">
                    <span class="material-symbols-rounded">close</span>
                    Cancelar
                </button>
                <button type="submit" class="modal-btn modal-btn-warning">
                    <span class="material-symbols-rounded">undo</span>
                    Devolver
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Comentario --}}
<div id="comentarioModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header info">
            <span class="material-symbols-rounded">comment</span>
            <h2>Agregar Comentario</h2>
            <button class="close-btn" onclick="closeModal('comentarioModal')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form action="{{ route('cuentas_cobro.interacciones.store', $cuenta->id) }}" method="POST">
            @csrf
            <input type="hidden" name="tipo" value="nota_manual">
            <div class="modal-body">
                <div class="modal-form-group">
                    <label>Asunto *</label>
                    <input type="text" name="asunto" required maxlength="200" placeholder="Asunto del comentario...">
                </div>
                <div class="modal-form-group">
                    <label>Comentario *</label>
                    <textarea name="detalle" rows="4" required maxlength="1000" placeholder="Escriba su comentario aquí..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('comentarioModal')">
                    <span class="material-symbols-rounded">close</span>
                    Cancelar
                </button>
                <button type="submit" class="modal-btn modal-btn-primary">
                    <span class="material-symbols-rounded">send</span>
                    Enviar Comentario
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Registro de Pago --}}
<div id="pagoModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header success">
            <span class="material-symbols-rounded">payments</span>
            <h2>Registrar Pago</h2>
            <button class="close-btn" onclick="closeModal('pagoModal')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form action="{{ route('cuentas_cobro.pagar', $cuenta->id) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-alert info">
                    <span class="material-symbols-rounded">account_balance</span>
                    <div>
                        <strong>Valor Total: ${{ number_format($cuenta->valor_total, 2, ',', '.') }}</strong><br>
                        <span style="font-size: 13px;">Beneficiario: {{ $cuenta->nombre_beneficiario }}</span>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="modal-form-group">
                        <label>Valor Pagado *</label>
                        <input type="number" name="valor_pagado" step="0.01" min="0" required value="{{ $cuenta->valor_total }}" placeholder="0.00">
                    </div>
                    <div class="modal-form-group">
                        <label>Medio de Pago *</label>
                        <select name="medio_pago" required>
                            <option value="">Seleccione...</option>
                            <option value="transferencia">Transferencia Bancaria</option>
                            <option value="cheque">Cheque</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="consignacion">Consignación</option>
                        </select>
                    </div>
                </div>
                <div class="modal-form-group">
                    <label>Referencia de Pago</label>
                    <input type="text" name="referencia_pago" maxlength="255" placeholder="Número de transacción o referencia...">
                </div>
                <div class="modal-form-group">
                    <label>Observaciones</label>
                    <textarea name="observacion_pago" rows="3" placeholder="Observaciones adicionales..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('pagoModal')">
                    <span class="material-symbols-rounded">close</span>
                    Cancelar
                </button>
                <button type="submit" class="modal-btn modal-btn-success">
                    <span class="material-symbols-rounded">check_circle</span>
                    Confirmar Pago
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Rechazar Pago --}}
<div id="rechazarPagoModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header danger">
            <span class="material-symbols-rounded">block</span>
            <h2>Rechazar Pago</h2>
            <button class="close-btn" onclick="closeModal('rechazarPagoModal')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form action="{{ route('cuentas_cobro.rechazar_pago', $cuenta->id) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-alert danger">
                    <span class="material-symbols-rounded">warning</span>
                    <div>
                        <strong>¡Atención!</strong><br>
                        <span style="font-size: 13px;">Esta acción marcará el pago como rechazado. El contratista será notificado.</span>
                    </div>
                </div>
                <div class="modal-form-group">
                    <label>Motivo del rechazo de pago *</label>
                    <textarea name="motivo" rows="4" required minlength="5" placeholder="Explique el motivo del rechazo del pago..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal('rechazarPagoModal')">
                    <span class="material-symbols-rounded">close</span>
                    Cancelar
                </button>
                <button type="submit" class="modal-btn modal-btn-danger">
                    <span class="material-symbols-rounded">block</span>
                    Rechazar Pago
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Advertencia de Permisos --}}
<div id="permissionModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header permission">
            <span class="material-symbols-rounded">admin_panel_settings</span>
            <h2>Permisos Requeridos</h2>
            <button class="close-btn" onclick="closeModal('permissionModal')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-alert warning">
                <span class="material-symbols-rounded">lock</span>
                <div>
                    <strong>Acceso Restringido</strong><br>
                    <span style="font-size: 13px;">No tienes los permisos necesarios para realizar esta acción.</span>
                </div>
            </div>
            <div style="background: #f9fafb; padding: 16px; border-radius: 12px; margin-top: 16px;">
                <div style="font-weight: 600; margin-bottom: 12px;">Tu rol actual:</div>
                <span class="role-badge">{{ ucfirst(str_replace('_', ' ', $userRole)) }}</span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-btn modal-btn-primary" onclick="closeModal('permissionModal')">
                <span class="material-symbols-rounded">check</span>
                Entendido
            </button>
        </div>
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

.workflow-section { margin-top: 16px; }
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}
</style>

<style>
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<script>
// Deshabilitar botón de aprobación mientras se procesa
document.getElementById('approveForm')?.addEventListener('submit', function(e) {
    const btn = document.getElementById('approveBtn');
    if (btn) {
        btn.disabled = true;
        btn.style.opacity = '0.6';
        btn.style.cursor = 'not-allowed';
        btn.innerHTML = '<span class="material-symbols-rounded" style="animation: spin 1s linear infinite;">autorenew</span> Procesando...';
    }
});
</script>
@endsection
