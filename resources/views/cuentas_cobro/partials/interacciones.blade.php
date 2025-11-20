<!-- Sección: Interacciones/Historial de Comunicaciones -->
<div class="detail-section">
    <h3 class="section-title">
        <span class="material-symbols-rounded">chat</span>
        Historial de Interacciones
    </h3>

    @php $interacciones = $cuenta->interacciones ?? collect(); @endphp
    @if($interacciones->count() === 0)
        <div style="background:#f9fafb;border:1px dashed #d1d5db;padding:16px;border-radius:12px;color:#6b7280;">
            No hay interacciones registradas aún.
        </div>
    @else
        <div class="timeline">
            @foreach($interacciones as $inter)
                <div class="timeline-item">
                    <div class="timeline-marker" style="background: {{ $inter->getColor() }};">
                        <span class="material-symbols-rounded">{{ $inter->getIcono() }}</span>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="timeline-action" style="color: {{ $inter->getColor() }};">{{ $inter->getEtiqueta() }}</span>
                            <span class="timeline-date">{{ $inter->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="timeline-subject" style="font-weight: 600; color: var(--apple-dark); margin-bottom: 6px;">
                            {{ $inter->asunto }}
                        </div>
                        @if($inter->detalle)
                            <div class="timeline-comment">{{ $inter->detalle }}</div>
                        @endif
                        @if($inter->usuario)
                            <div class="timeline-user">
                                <span class="material-symbols-rounded">person</span>
                                {{ $inter->usuario->name }}
                            </div>
                        @endif
                    </div>

                    @if(Auth::id() === $inter->user_id || Auth::user()?->role?->name === 'super_admin')
                    <form action="{{ route('cuentas_cobro.interacciones.destroy', [$cuenta->id, $inter->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar interacción?')" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action" style="background:#FF3B30;color:white;border:none;padding:8px 12px;font-size:12px;">
                            <span class="material-symbols-rounded">delete</span>
                        </button>
                    </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <!-- Agregar nueva interacción -->
    @php 
        $canAddInteraccion = in_array(Auth::user()?->role?->name, ['contratista', 'ordenador_gasto', 'supervisor', 'tesoreria', 'contratacion', 'alcalde', 'super_admin']);
    @endphp

    @if($canAddInteraccion)
    <div style="margin-top: 20px; background: #F5F5F7; padding: 16px; border-radius: 12px;">
        <h4 style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600;">Agregar Interacción</h4>
        <form action="{{ route('cuentas_cobro.interacciones.store', $cuenta->id) }}" method="POST">
            @csrf
            <div style="display: grid; gap: 12px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 4px; font-size: 13px;">Tipo</label>
                    <select name="tipo" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="nota_manual">📝 Nota Manual</option>
                        <option value="llamada">☎️ Llamada</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 4px; font-size: 13px;">Asunto</label>
                    <input type="text" name="asunto" required maxlength="200" placeholder="Ej: Solicitud de información" style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 4px; font-size: 13px;">Detalle</label>
                    <textarea name="detalle" required maxlength="1000" rows="3" placeholder="Describa la interacción..." style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: inherit;"></textarea>
                </div>
                <button type="submit" class="btn-action" style="background: #007AFF; color: white; border: none; align-self: flex-start;">
                    <span class="material-symbols-rounded">add</span>
                    Registrar Interacción
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
