<style>
    .form-body {
        padding: 3rem 2.5rem;
    }

    .form-section {
        margin-bottom: 3rem;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--apple-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e5e7;
    }

    .section-title .material-symbols-rounded {
        color: var(--apple-blue);
        font-size: 1.8rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--apple-dark);
        margin-bottom: 0.75rem;
    }

    .form-label .material-symbols-rounded {
        font-size: 1.2rem;
        color: var(--apple-blue);
    }

    .form-label .optional-tag {
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--apple-gray);
        margin-left: 0.25rem;
    }

    .form-input-wrapper {
        position: relative;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        font-size: 1rem;
        border: 2px solid #e5e5e7;
        border-radius: 12px;
        outline: none;
        transition: all 0.3s ease;
        background: var(--apple-light-gray);
        color: var(--apple-dark);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: var(--apple-blue);
        background: white;
        box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
    }

    .form-input.is-invalid,
    .form-select.is-invalid,
    .form-textarea.is-invalid {
        border-color: #ff3b30;
        background: #fff5f5;
    }

    .form-input[readonly] {
        background: #e9ecef;
        cursor: not-allowed;
        font-weight: 600;
        color: var(--apple-blue);
    }

    .form-icon {
        position: absolute;
        left: 1rem;
        top: 1rem;
        color: var(--apple-gray);
        font-size: 1.3rem;
        pointer-events: none;
        transition: color 0.3s ease;
    }

    .form-input:focus ~ .form-icon,
    .form-select:focus ~ .form-icon,
    .form-textarea:focus ~ .form-icon {
        color: var(--apple-blue);
    }

    .form-error {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        color: #ff3b30;
        font-size: 0.85rem;
    }

    .form-error .material-symbols-rounded {
        font-size: 1rem;
    }

    /* Items Section */
    .items-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .items-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .item-row {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
        border: 2px solid #e5e5e7;
        border-radius: 16px;
        padding: 1.5rem;
        display: grid;
        grid-template-columns: 2fr 2fr 1fr 1.5fr auto;
        gap: 1rem;
        align-items: start;
        transition: all 0.3s ease;
        animation: slideInRight 0.4s ease;
    }

    .item-row:hover {
        border-color: var(--apple-blue);
        box-shadow: 0 4px 12px rgba(0, 113, 227, 0.1);
    }

    .item-row .form-input {
        padding: 0.875rem 0.875rem 0.875rem 2.5rem;
        font-size: 0.95rem;
    }

    .item-row .form-icon {
        left: 0.75rem;
        top: 0.875rem;
        font-size: 1.1rem;
    }

    .item-row .form-label {
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        color: var(--apple-gray);
    }

    .btn-remove-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #ff3b30 0%, #ff6b6b 100%);
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.75rem;
    }

    .btn-remove-item:hover {
        transform: scale(1.1) rotate(90deg);
        box-shadow: 0 4px 12px rgba(255, 59, 48, 0.4);
    }

    .btn-remove-item .material-symbols-rounded {
        font-size: 1.5rem;
    }

    .btn-add-item {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px dashed var(--apple-blue);
        background: rgba(0, 113, 227, 0.05);
        color: var(--apple-blue);
        margin-top: 1rem;
    }

    .btn-add-item:hover {
        background: rgba(0, 113, 227, 0.1);
        border-style: solid;
        transform: translateY(-2px);
    }

    .total-display {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 2rem;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }

    .total-display-label {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .total-display-value {
        font-size: 2.5rem;
        font-weight: 700;
        letter-spacing: -1px;
    }

    .totals-breakdown {
        width: 100%;
        margin-top: 1rem;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem 1.5rem;
        color: rgba(255,255,255,0.95);
        font-size: 0.95rem;
    }

    .totals-breakdown .row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        opacity: 0.95;
    }

    .badge-mini {
        font-size: 0.75rem;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        background: rgba(255,255,255,0.15);
        margin-left: 0.35rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e5e7;
    }

    .btn-cancel,
    .btn-submit {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
    }

    .btn-cancel {
        background: var(--apple-light-gray);
        color: var(--apple-dark);
    }

    .btn-cancel:hover {
        background: #e0e0e2;
        transform: translateY(-2px);
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-submit:hover {
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        transform: translateY(-2px);
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @media (max-width: 1024px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .item-row {
            grid-template-columns: 1fr;
        }

        .btn-remove-item {
            margin-top: 0;
        }
    }

    @media (max-width: 768px) {
        .form-body {
            padding: 2rem 1.5rem;
        }

        .form-grid-3 {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-submit {
            width: 100%;
            justify-content: center;
        }

        .total-display-value {
            font-size: 2rem;
        }
    }
</style>

<div class="form-body">
    {{-- Sección: Información del Beneficiario --}}
    <div class="form-section">
        <h2 class="section-title">
            <span class="material-symbols-rounded">person</span>
            Información del Beneficiario
        </h2>

        <div class="form-grid">
            <div class="form-group">
                <label for="tipo_identificacion" class="form-label">
                    <span class="material-symbols-rounded">badge</span>
                    Tipo de Identificación
                </label>
                <div class="form-input-wrapper">
                    <select name="tipo_identificacion" id="tipo_identificacion" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <option value="CC" {{ old('tipo_identificacion', $cuenta->tipo_identificacion ?? '') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                        <option value="NIT" {{ old('tipo_identificacion', $cuenta->tipo_identificacion ?? '') == 'NIT' ? 'selected' : '' }}>NIT</option>
                    </select>
                    <span class="material-symbols-rounded form-icon">credit_card</span>
                </div>
            </div>

            <div class="form-group">
                <label for="identificacion" class="form-label">
                    <span class="material-symbols-rounded">fingerprint</span>
                    Número de Identificación
                </label>
                <div class="form-input-wrapper">
                    <input 
                        type="text" 
                        name="identificacion" 
                        id="identificacion"
                        value="{{ old('identificacion', $cuenta->identificacion ?? '') }}" 
                        class="form-input" 
                        placeholder="1234567890"
                        required
                    >
                    <span class="material-symbols-rounded form-icon">tag</span>
                </div>
            </div>

            <div class="form-group full-width">
                <label for="nombre_beneficiario" class="form-label">
                    <span class="material-symbols-rounded">account_circle</span>
                    Nombre del Beneficiario
                </label>
                <div class="form-input-wrapper">
                    <input 
                        type="text" 
                        name="nombre_beneficiario" 
                        id="nombre_beneficiario"
                        value="{{ old('nombre_beneficiario', $cuenta->nombre_beneficiario ?? '') }}" 
                        class="form-input" 
                        placeholder="Juan Pérez García o Empresa S.A.S."
                        required
                    >
                    <span class="material-symbols-rounded form-icon">person</span>
                </div>
            </div>

            <div class="form-group">
                <label for="tipo_cliente" class="form-label">
                    <span class="material-symbols-rounded">groups</span>
                    Tipo de Cliente
                </label>
                <div class="form-input-wrapper">
                    <select name="tipo_cliente" id="tipo_cliente" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <option value="natural" {{ old('tipo_cliente', $cuenta->tipo_cliente ?? '') == 'natural' ? 'selected' : '' }}>Persona Natural</option>
                        <option value="juridico" {{ old('tipo_cliente', $cuenta->tipo_cliente ?? '') == 'juridico' ? 'selected' : '' }}>Persona Jurídica</option>
                    </select>
                    <span class="material-symbols-rounded form-icon">business</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección: Datos de la Cuenta --}}
    <div class="form-section">
        <h2 class="section-title">
            <span class="material-symbols-rounded">description</span>
            Datos de la Cuenta de Cobro
        </h2>

        <div class="form-grid">
            <div class="form-group">
                <label for="numero" class="form-label">
                    <span class="material-symbols-rounded">numbers</span>
                    Número de Cuenta
                </label>
                <div class="form-input-wrapper">
                    <input 
                        type="text" 
                        id="numero" 
                        name="numero" 
                        value="{{ old('numero', $cuenta->numero ?? '') }}" 
                        class="form-input @error('numero') is-invalid @enderror" 
                        placeholder="CC-2024-001"
                        required
                    >
                    <span class="material-symbols-rounded form-icon">confirmation_number</span>
                </div>
                @error('numero')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_emision" class="form-label">
                    <span class="material-symbols-rounded">event</span>
                    Fecha de Emisión
                </label>
                <div class="form-input-wrapper">
                    <input 
                        type="date" 
                        id="fecha_emision" 
                        name="fecha_emision" 
                        value="{{ old('fecha_emision', $cuenta->fecha_emision ?? '') }}" 
                        class="form-input @error('fecha_emision') is-invalid @enderror" 
                        required
                    >
                    <span class="material-symbols-rounded form-icon">calendar_today</span>
                </div>
                @error('fecha_emision')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="plazo_pago" class="form-label">
                    <span class="material-symbols-rounded">schedule</span>
                    Plazo de Pago (días)
                </label>
                <div class="form-input-wrapper">
                    <input 
                        type="number" 
                        id="plazo_pago" 
                        name="plazo_pago" 
                        value="{{ old('plazo_pago', $cuenta->plazo_pago ?? 30) }}" 
                        class="form-input" 
                        min="0"
                        placeholder="30"
                    >
                    <span class="material-symbols-rounded form-icon">timer</span>
                </div>
            </div>

            <div class="form-group">
                <label for="contrato_id" class="form-label">
                    <span class="material-symbols-rounded">handshake</span>
                    Contrato <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <!-- Cambiado a input para permitir escritura libre. Se mantiene el name/id para compatibilidad con backend. -->
                    <input
                        type="text"
                        id="contrato_id"
                        name="contrato_id"
                        class="form-input @error('contrato_id') is-invalid @enderror"
                        placeholder="Escriba el número o id del contrato (opcional)"
                        value="{{ old('contrato_id', $cuenta->contrato_id ?? '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">handshake</span>
                </div>
                @error('contrato_id')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    {{-- Sección: Ubicación --}}
    <div class="form-section">
        <h2 class="section-title">
            <span class="material-symbols-rounded">location_on</span>
            Ubicación
        </h2>

        <div class="form-grid">
            <div class="form-group">
                <label for="departamento" class="form-label">
                    <span class="material-symbols-rounded">map</span>
                    Departamento
                </label>
                <div class="form-input-wrapper">
                    <select id="departamento" name="departamento" class="form-select @error('departamento') is-invalid @enderror" required>
                        <option value="">Seleccione un departamento</option>
                        @foreach($departamentos as $dep => $muns)
                            <option value="{{ $dep }}" {{ old('departamento', $cuenta->departamento ?? '') == $dep ? 'selected' : '' }}>{{ $dep }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-rounded form-icon">public</span>
                </div>
                @error('departamento')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="municipio" class="form-label">
                    <span class="material-symbols-rounded">location_city</span>
                    Municipio
                </label>
                <div class="form-input-wrapper">
                    <!-- Cambiado a input para permitir escritura libre del municipio. -->
                    <input
                        type="text"
                        id="municipio"
                        name="municipio"
                        class="form-input @error('municipio') is-invalid @enderror"
                        placeholder="Escriba el municipio"
                        value="{{ old('municipio', $cuenta->municipio ?? '') }}"
                        required
                    >
                    <span class="material-symbols-rounded form-icon">apartment</span>
                </div>
                @error('municipio')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="descripcion" class="form-label">
                    <span class="material-symbols-rounded">notes</span>
                    Descripción <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        class="form-textarea @error('descripcion') is-invalid @enderror"
                        placeholder="Descripción detallada de la cuenta de cobro..."
                    >{{ old('descripcion', $cuenta->descripcion ?? '') }}</textarea>
                    <span class="material-symbols-rounded form-icon">edit_note</span>
                </div>
                @error('descripcion')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    {{-- Sección: Ítems --}}
    <div class="form-section">
        <div class="items-header">
            <h2 class="section-title" style="margin-bottom: 0; border-bottom: none;">
                <span class="material-symbols-rounded">inventory_2</span>
                Ítems de la Cuenta de Cobro
            </h2>
        </div>

        <div id="items-container" class="items-container">
            @php
                $itemsOld = old('items', $cuenta->items ?? []);
                $itemsOld = is_array($itemsOld) ? $itemsOld : $itemsOld->toArray();
            @endphp
            @forelse($itemsOld as $i => $item)
                <div class="item-row">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">label</span>
                            Nombre del Ítem
                        </label>
                        <div class="form-input-wrapper">
                            <input type="text" name="items[{{ $i }}][item]" value="{{ $item['item'] ?? '' }}" placeholder="Ej: Desarrollo de software" class="form-input" required>
                            <span class="material-symbols-rounded form-icon">shopping_cart</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">info</span>
                            Detalle
                        </label>
                        <div class="form-input-wrapper">
                            <input type="text" name="items[{{ $i }}][detalle]" value="{{ $item['detalle'] ?? '' }}" placeholder="Detalle adicional" class="form-input">
                            <span class="material-symbols-rounded form-icon">description</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">production_quantity_limits</span>
                            Cantidad
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[{{ $i }}][cantidad]" value="{{ $item['cantidad'] ?? 1 }}" placeholder="1" class="form-input" min="1" required>
                            <span class="material-symbols-rounded form-icon">add_circle</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">payments</span>
                            Precio Unitario
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[{{ $i }}][precio_unitario]" value="{{ $item['precio_unitario'] ?? 0 }}" placeholder="0.00" class="form-input" step="0.01" required>
                            <span class="material-symbols-rounded form-icon">attach_money</span>
                        </div>
                    </div>

                    <button type="button" class="btn-remove-item">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
            @empty
                <div class="item-row">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">label</span>
                            Nombre del Ítem
                        </label>
                        <div class="form-input-wrapper">
                            <input type="text" name="items[0][item]" placeholder="Ej: Desarrollo de software" class="form-input" required>
                            <span class="material-symbols-rounded form-icon">shopping_cart</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">info</span>
                            Detalle
                        </label>
                        <div class="form-input-wrapper">
                            <input type="text" name="items[0][detalle]" placeholder="Detalle adicional" class="form-input">
                            <span class="material-symbols-rounded form-icon">description</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">production_quantity_limits</span>
                            Cantidad
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[0][cantidad]" placeholder="1" class="form-input" min="1" value="1" required>
                            <span class="material-symbols-rounded form-icon">add_circle</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">payments</span>
                            Precio Unitario
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[0][precio_unitario]" placeholder="0.00" class="form-input" step="0.01" required>
                            <span class="material-symbols-rounded form-icon">attach_money</span>
                        </div>
                    </div>

                    <button type="button" class="btn-remove-item">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
            @endforelse
        </div>

        <button type="button" class="btn-add-item" id="add-item">
            <span class="material-symbols-rounded">add</span>
            Agregar Ítem
        </button>
    </div>

    {{-- Sección: Impuestos y Retenciones --}}
    <div class="form-section">
        <h2 class="section-title">
            <span class="material-symbols-rounded">balance</span>
            Impuestos y Retenciones
        </h2>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">
                    <span class="material-symbols-rounded">percent</span>
                    IVA (%) <span class="optional-tag">Si aplica</span>
                </label>
                <div class="form-input-wrapper">
                    <input type="number" step="0.01" min="0" max="100" id="iva_porcentaje" class="form-input" placeholder="Ej: 19" value="{{ old('iva_porcentaje', 0) }}">
                    <span class="material-symbols-rounded form-icon">percent</span>
                </div>
                <div class="form-hint" style="color:#86868b; font-size:0.85rem; margin-top:.4rem;">
                    Si eres no responsable de IVA, déjalo en 0.
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="material-symbols-rounded">percent</span>
                    ReteFuente (%)
                </label>
                <div class="form-input-wrapper">
                    <input type="number" step="0.01" min="0" max="100" id="retefuente_porcentaje" class="form-input" placeholder="Ej: 2.5" value="{{ old('retefuente_porcentaje', 0) }}">
                    <span class="material-symbols-rounded form-icon">percent</span>
                </div>
                <div class="form-hint" style="color:#86868b; font-size:0.85rem; margin-top:.4rem;">
                    Servicios profesionales suele ser 10% o 11% con tope; otros 2.5% o 4%. Ver política.
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="material-symbols-rounded">percent</span>
                    ReteICA (%)
                </label>
                <div class="form-input-wrapper">
                    <input type="number" step="0.001" min="0" max="100" id="reteica_porcentaje" class="form-input" placeholder="Ej: 0.966 (9.66 por mil)" value="{{ old('reteica_porcentaje', 0) }}">
                    <span class="material-symbols-rounded form-icon">percent</span>
                </div>
                <div class="form-hint" style="color:#86868b; font-size:0.85rem; margin-top:.4rem;">
                    En Bogotá 9.66‰ ≈ 0.966% (varía por actividad/ciudad).
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="material-symbols-rounded">percent</span>
                    ReteIVA (%)
                </label>
                <div class="form-input-wrapper">
                    <input type="number" step="0.01" min="0" max="100" id="reteiva_porcentaje" class="form-input" placeholder="Ej: 15" value="{{ old('reteiva_porcentaje', 0) }}">
                    <span class="material-symbols-rounded form-icon">percent</span>
                </div>
                <div class="form-hint" style="color:#86868b; font-size:0.85rem; margin-top:.4rem;">
                    Aplica sólo si hay IVA y el cliente es agente de retención de IVA.
                </div>
            </div>
        </div>
    </div>

    {{-- Total --}}
    <div class="form-section">
        <div class="form-grid">
            <div class="form-group full-width">
                <div class="total-display">
                    <span class="total-display-label">Valor Total</span>
                    <span class="total-display-value">$<span id="total-formatted">0</span></span>
                    <div class="totals-breakdown">
                        <div class="row"><span>Subtotal</span><strong>$ <span id="subtotal-formatted">0</span></strong></div>
                        <div class="row"><span>IVA <span class="badge-mini" id="iva-badge">0%</span></span><strong>+$ <span id="iva-formatted">0</span></strong></div>
                        <div class="row"><span>ReteFuente <span class="badge-mini" id="retefuente-badge">0%</span></span><strong>- $ <span id="retefuente-formatted">0</span></strong></div>
                        <div class="row"><span>ReteICA <span class="badge-mini" id="reteica-badge">0%</span></span><strong>- $ <span id="reteica-formatted">0</span></strong></div>
                        <div class="row"><span>ReteIVA <span class="badge-mini" id="reteiva-badge">0%</span></span><strong>- $ <span id="reteiva-formatted">0</span></strong></div>
                    </div>
                    <input type="hidden" id="valor_total" name="valor_total" value="{{ old('valor_total', $cuenta->valor_total ?? 0) }}">
                    <input type="hidden" id="subtotal" name="subtotal" value="{{ old('subtotal', 0) }}">
                    <input type="hidden" id="iva_valor" name="iva_valor" value="{{ old('iva_valor', 0) }}">
                    <input type="hidden" id="retencion_fuente" name="retencion_fuente" value="{{ old('retencion_fuente', 0) }}">
                    <input type="hidden" id="retencion_ica" name="retencion_ica" value="{{ old('retencion_ica', 0) }}">
                    <input type="hidden" id="retencion_iva" name="retencion_iva" value="{{ old('retencion_iva', 0) }}">
                </div>
            </div>
        </div>
    </div>

    {{-- Botones de Acción --}}
    <div class="form-actions">
        <a href="{{ route('cuentas_cobro.index') }}" class="btn-cancel">
            <span class="material-symbols-rounded">close</span>
            Cancelar
        </a>
        @if(empty($hideSubmit) || !$hideSubmit)
            <button type="submit" class="btn-submit">
                <span class="material-symbols-rounded">save</span>
                {{ $btnText ?? 'Guardar' }}
            </button>
        @endif
    </div>
</div>

@push('scripts')
<script>
    (function(){
        const deps = @json($departamentos ?? []);
        const depSelect = document.getElementById('departamento');
        const munSelect = document.getElementById('municipio');

        function fillMunicipios(dep){
            const list = deps[dep] || [];
            if (!munSelect) return;

            // Si el elemento es un SELECT, rellenamos las opciones como antes.
            if (munSelect.tagName === 'SELECT') {
                munSelect.innerHTML = '<option value="">Seleccione un municipio</option>';
                list.forEach(m => {
                    const opt = document.createElement('option');
                    opt.value = m; opt.textContent = m;
                    if ('{{ old('municipio', $cuenta->municipio ?? '') }}' === m) opt.selected = true;
                    munSelect.appendChild(opt);
                });
            } else {
                // Si es un INPUT (campo editable), usamos la primera entrada como sugerencia (placeholder)
                munSelect.placeholder = list[0] || 'Escriba el municipio';
                // Mantener valor previo si existe, sino dejar vacío
                if (!munSelect.value) {
                    munSelect.value = '{{ old('municipio', $cuenta->municipio ?? '') }}' || '';
                }
            }
        }

        if (depSelect) {
            depSelect.addEventListener('change', (e)=> fillMunicipios(e.target.value));
            if (depSelect.value) fillMunicipios(depSelect.value);
        }

        // Items dinámicos + total
        const container = document.getElementById('items-container');
        const addBtn = document.getElementById('add-item');
    const totalInput = document.getElementById('valor_total');
    const totalFormatted = document.getElementById('total-formatted');
    const subtotalHidden = document.getElementById('subtotal');
    const ivaHidden = document.getElementById('iva_valor');
    const retefuenteHidden = document.getElementById('retencion_fuente');
    const reteicaHidden = document.getElementById('retencion_ica');
    const reteivaHidden = document.getElementById('retencion_iva');

    // Porcentajes
    const ivaPct = document.getElementById('iva_porcentaje');
    const retefuentePct = document.getElementById('retefuente_porcentaje');
    const reteicaPct = document.getElementById('reteica_porcentaje');
    const reteivaPct = document.getElementById('reteiva_porcentaje');

    // Labels breakdown
    const subtotalFormatted = document.getElementById('subtotal-formatted');
    const ivaFormatted = document.getElementById('iva-formatted');
    const retefuenteFormatted = document.getElementById('retefuente-formatted');
    const reteicaFormatted = document.getElementById('reteica-formatted');
    const reteivaFormatted = document.getElementById('reteiva-formatted');
    const ivaBadge = document.getElementById('iva-badge');
    const retefuenteBadge = document.getElementById('retefuente-badge');
    const reteicaBadge = document.getElementById('reteica-badge');
    const reteivaBadge = document.getElementById('reteiva-badge');

        function fmt(n){
            return n.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function recalcTotal(){
            let subtotal = 0;
            container.querySelectorAll('.item-row').forEach(row => {
                const cant = parseFloat(row.querySelector('[name$="[cantidad]"]').value) || 0;
                const precio = parseFloat(row.querySelector('[name$="[precio_unitario]"]').value) || 0;
                subtotal += cant * precio;
            });

            const ivaPor = parseFloat(ivaPct?.value || 0) / 100;
            const rfPor = parseFloat(retefuentePct?.value || 0) / 100;
            const icaPor = parseFloat(reteicaPct?.value || 0) / 100;
            const rivaPor = parseFloat(reteivaPct?.value || 0) / 100;

            const iva = subtotal * ivaPor;
            const retefuente = subtotal * rfPor;
            const reteica = subtotal * icaPor;
            const reteiva = iva * rivaPor; // sobre IVA

            let total = subtotal + iva - retefuente - reteica - reteiva;

            // Hidden values
            subtotalHidden.value = subtotal.toFixed(2);
            ivaHidden.value = iva.toFixed(2);
            retefuenteHidden.value = retefuente.toFixed(2);
            reteicaHidden.value = reteica.toFixed(2);
            reteivaHidden.value = reteiva.toFixed(2);
            totalInput.value = total.toFixed(2);

            // UI
            subtotalFormatted.textContent = fmt(subtotal);
            ivaFormatted.textContent = fmt(iva);
            retefuenteFormatted.textContent = fmt(retefuente);
            reteicaFormatted.textContent = fmt(reteica);
            reteivaFormatted.textContent = fmt(reteiva);
            totalFormatted.textContent = fmt(total);
            ivaBadge.textContent = (parseFloat(ivaPct.value || 0)).toFixed(2) + '%';
            retefuenteBadge.textContent = (parseFloat(retefuentePct.value || 0)).toFixed(2) + '%';
            reteicaBadge.textContent = (parseFloat(reteicaPct.value || 0)).toFixed(3) + '%';
            reteivaBadge.textContent = (parseFloat(reteivaPct.value || 0)).toFixed(2) + '%';
        }

        function bindRow(row){
            row.querySelectorAll('input').forEach(inp => {
                inp.addEventListener('input', recalcTotal);
            });
            const rm = row.querySelector('.btn-remove-item');
            rm && rm.addEventListener('click', ()=>{ 
                if(container.querySelectorAll('.item-row').length > 1) {
                    row.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => {
                        row.remove(); 
                        recalcTotal();
                    }, 300);
                } else {
                    alert('Debe mantener al menos un ítem');
                }
            });
        }

    // Bind existing
        container.querySelectorAll('.item-row').forEach(bindRow);

        addBtn?.addEventListener('click', ()=>{
            const index = container.querySelectorAll('.item-row').length;
            const row = document.createElement('div');
            row.className = 'item-row';
            row.innerHTML = `
                <div class="form-group">
                    <label class="form-label">
                        <span class="material-symbols-rounded">label</span>
                        Nombre del Ítem
                    </label>
                    <div class="form-input-wrapper">
                        <input type="text" name="items[${index}][item]" placeholder="Ej: Desarrollo de software" class="form-input" required>
                        <span class="material-symbols-rounded form-icon">shopping_cart</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <span class="material-symbols-rounded">info</span>
                        Detalle
                    </label>
                    <div class="form-input-wrapper">
                        <input type="text" name="items[${index}][detalle]" placeholder="Detalle adicional" class="form-input">
                        <span class="material-symbols-rounded form-icon">description</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <span class="material-symbols-rounded">production_quantity_limits</span>
                        Cantidad
                    </label>
                    <div class="form-input-wrapper">
                        <input type="number" name="items[${index}][cantidad]" placeholder="1" class="form-input" min="1" value="1" required>
                        <span class="material-symbols-rounded form-icon">add_circle</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <span class="material-symbols-rounded">payments</span>
                        Precio Unitario
                    </label>
                    <div class="form-input-wrapper">
                        <input type="number" name="items[${index}][precio_unitario]" placeholder="0.00" class="form-input" step="0.01" required>
                        <span class="material-symbols-rounded form-icon">attach_money</span>
                    </div>
                </div>
                <button type="button" class="btn-remove-item">
                    <span class="material-symbols-rounded">close</span>
                </button>
            `;
            container.appendChild(row);
            bindRow(row);
            recalcTotal();
        });

        // Animación de entrada
        document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach((input, index) => {
            input.style.opacity = '0';
            input.style.transform = 'translateY(20px)';
            setTimeout(() => {
                input.style.transition = 'all 0.4s ease';
                input.style.opacity = '1';
                input.style.transform = 'translateY(0)';
            }, 50 * index);
        });

        // Animación slideOut
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOutRight {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(100px);
                }
            }
        `;
        document.head.appendChild(style);

        // Recalc on percentage changes
        [ivaPct, retefuentePct, reteicaPct, reteivaPct].forEach(el => {
            el?.addEventListener('input', recalcTotal);
            el?.addEventListener('change', recalcTotal);
        });

        // Inicial
        recalcTotal();
    })();
</script>
@endpush

