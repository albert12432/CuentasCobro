<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta de Cobro {{ $cuenta->numero ?? $cuenta->id }}</title>
    <style>
        @page { 
            margin: 20mm 15mm; 
        }
        
        * {
            box-sizing: border-box;
        }
        
        body { 
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif; 
            color: #1f2937; 
            font-size: 11px; 
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        
        .header { 
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 15px;
        }
        
        .header-left {
            display: table-cell;
            width: 60%;
            vertical-align: middle;
        }
        
        .header-right {
            display: table-cell;
            width: 40%;
            text-align: right;
            vertical-align: middle;
        }
        
        .brand h1 { 
            font-size: 20px; 
            margin: 0 0 4px 0; 
            color: #4F46E5;
            font-weight: 700;
        }
        
        .brand small { 
            color: #6B7280; 
            display: block; 
            font-size: 10px;
        }
        
        .logo { 
            width: 100px; 
            height: 36px; 
            background: linear-gradient(135deg, #4F46E5, #7C3AED); 
            color: white; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 6px; 
            font-size: 11px;
            font-weight: 600;
        }
        
        .document-number {
            background: #EEF2FF;
            border: 2px solid #4F46E5;
            border-radius: 8px;
            padding: 10px 16px;
            display: inline-block;
        }
        
        .document-number .label {
            font-size: 9px;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .document-number .value {
            font-size: 16px;
            font-weight: 700;
            color: #4F46E5;
        }
        
        .info-section {
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: #4F46E5;
            margin: 0 0 10px 0;
            padding-bottom: 6px;
            border-bottom: 1px solid #E5E7EB;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-col {
            display: table-cell;
            width: 50%;
            padding: 4px 0;
            vertical-align: top;
        }
        
        .label { 
            color: #6B7280; 
            font-weight: 600;
            font-size: 10px;
        }
        
        .value {
            color: #1F2937;
            font-weight: 500;
        }
        
        .muted { 
            color: #9CA3AF; 
        }
        
        /* Items table */
        table.items-table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-top: 16px; 
            border-radius: 8px;
            overflow: hidden;
        }
        
        table.items-table th, 
        table.items-table td { 
            border: 1px solid #E5E7EB; 
            padding: 10px 12px; 
        }
        
        table.items-table thead th { 
            background: #4F46E5; 
            color: white;
            text-align: left; 
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        table.items-table tbody tr:nth-child(even) {
            background: #F9FAFB;
        }
        
        table.items-table tbody td {
            font-size: 11px;
        }
        
        .right { 
            text-align: right; 
        }
        
        .center {
            text-align: center;
        }
        
        /* Totals section */
        .totals-section {
            width: 300px;
            margin-left: auto;
            margin-top: 16px;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .totals-section table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .totals-section td {
            padding: 8px 12px;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .totals-section tr:last-child td {
            border-bottom: none;
        }
        
        .totals-section .total-row {
            background: #4F46E5;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }
        
        .totals-section .total-row td {
            padding: 12px;
        }
        
        /* Signature section */
        .signature-section { 
            margin-top: 50px; 
            text-align: center; 
        }
        
        .signature-line { 
            width: 280px; 
            height: 1px; 
            background: #1F2937; 
            margin: 40px auto 8px; 
        }
        
        .signature-name {
            font-weight: 700;
            font-size: 12px;
            color: #1F2937;
        }
        
        .signature-label {
            font-size: 10px;
            color: #6B7280;
        }
        
        /* Footer note */
        .footer-note { 
            margin-top: 30px; 
            font-size: 9px; 
            color: #9CA3AF; 
            text-align: center;
            padding: 12px;
            background: #F9FAFB;
            border-radius: 6px;
            border: 1px dashed #E5E7EB;
        }
        
        /* Estado badge */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-revision { background: #FEF3C7; color: #92400E; }
        .status-aprobado { background: #D1FAE5; color: #065F46; }
        .status-rechazado { background: #FEE2E2; color: #991B1B; }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <div class="brand">
                <h1>{{ $appName ?? 'Entidad Pública' }}</h1>
                <small>Sistema de Gestión de Cuentas de Cobro</small>
                @if(!empty(config('app.url')))
                    <small class="muted">{{ config('app.url') }}</small>
                @endif
            </div>
        </div>
        <div class="header-right">
            <div class="document-number">
                <div class="label">Cuenta de Cobro</div>
                <div class="value">#{{ $cuenta->numero ?? $cuenta->id }}</div>
            </div>
        </div>
    </div>

    {{-- Información General --}}
    <div class="info-section">
        <div class="section-title">Información de la Cuenta</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-col">
                    <span class="label">Fecha de Emisión:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</span>
                </div>
                <div class="info-col">
                    <span class="label">Contrato Asociado:</span>
                    <span class="value">{{ optional($cuenta->contrato)->numero ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-col">
                    <span class="label">Departamento:</span>
                    <span class="value">{{ $cuenta->departamento }}</span>
                </div>
                <div class="info-col">
                    <span class="label">Municipio:</span>
                    <span class="value">{{ $cuenta->municipio }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Información del Beneficiario --}}
    <div class="info-section">
        <div class="section-title">Datos del Beneficiario</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-col">
                    <span class="label">Nombre/Razón Social:</span>
                    <span class="value" style="font-weight: 700;">{{ $cuenta->nombre_beneficiario }}</span>
                </div>
                <div class="info-col">
                    <span class="label">Tipo de Cliente:</span>
                    <span class="value">{{ $cuenta->tipo_cliente === 'natural' ? 'Persona Natural' : 'Persona Jurídica' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-col">
                    <span class="label">Tipo de Identificación:</span>
                    <span class="value">{{ $cuenta->tipo_identificacion }}</span>
                </div>
                <div class="info-col">
                    <span class="label">Número de Identificación:</span>
                    <span class="value">{{ $cuenta->identificacion }}</span>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($cuenta->descripcion))
    <div class="info-section">
        <div class="section-title">Descripción</div>
        <p style="margin: 0; color: #4B5563;">{{ $cuenta->descripcion }}</p>
    </div>
    @endif

    {{-- Detalle de Items --}}
    <div class="section-title" style="margin-top: 20px;">Detalle de Conceptos</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 30px;" class="center">#</th>
                <th>Descripción</th>
                <th style="width: 80px;" class="right">Cantidad</th>
                <th style="width: 100px;" class="right">Valor Unit.</th>
                <th style="width: 100px;" class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuenta->items as $i => $it)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ $it->item }}</strong>
                        @if(!empty($it->detalle))
                            <br><span class="muted" style="font-size: 10px;">{{ $it->detalle }}</span>
                        @endif
                    </td>
                    <td class="right">{{ number_format($it->cantidad ?? 0, 0, ',', '.') }}</td>
                    <td class="right">$ {{ number_format($it->precio_unitario ?? 0, 2, ',', '.') }}</td>
                    <td class="right"><strong>$ {{ number_format(($it->cantidad ?? 0) * ($it->precio_unitario ?? 0), 2, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="center muted">No hay ítems registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Totales --}}
    <div class="totals-section">
        <table>
            <tr>
                <td class="label">Subtotal</td>
                <td class="right value">$ {{ number_format($subtotal ?? 0, 2, ',', '.') }}</td>
            </tr>
            @if(isset($iva) && $iva > 0)
            <tr>
                <td class="label">IVA</td>
                <td class="right value">+ $ {{ number_format($iva, 2, ',', '.') }}</td>
            </tr>
            @endif
            @if(isset($retFuente) && $retFuente > 0)
            <tr>
                <td class="label">Retención en la Fuente</td>
                <td class="right value">- $ {{ number_format($retFuente, 2, ',', '.') }}</td>
            </tr>
            @endif
            @if(isset($retIca) && $retIca > 0)
            <tr>
                <td class="label">ReteICA</td>
                <td class="right value">- $ {{ number_format($retIca, 2, ',', '.') }}</td>
            </tr>
            @endif
            @if(isset($retIva) && $retIva > 0)
            <tr>
                <td class="label">ReteIVA</td>
                <td class="right value">- $ {{ number_format($retIva, 2, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>TOTAL A PAGAR</td>
                <td class="right">$ {{ number_format($total ?? ($cuenta->valor_total ?? 0), 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    {{-- Firma --}}
    <div class="signature-section">
        <div class="signature-line"></div>
        <div class="signature-name">{{ $cuenta->nombre_beneficiario }}</div>
        <div class="signature-label">Firma del Beneficiario</div>
        <div class="signature-label" style="margin-top: 4px;">{{ $cuenta->tipo_identificacion }} {{ $cuenta->identificacion }}</div>
    </div>

    {{-- Nota al pie --}}
    <div class="footer-note">
        <strong>Nota:</strong> Este documento refleja el detalle de cobro por los bienes y/o servicios prestados. 
        Cualquier inconsistencia favor notificar a la entidad dentro de los siguientes 5 días hábiles.
        <br><br>
        Documento generado el {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
