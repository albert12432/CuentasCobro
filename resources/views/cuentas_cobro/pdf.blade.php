<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta de Cobro {{ $cuenta->numero ?? $cuenta->id }}</title>
    <style>
        @page { margin: 28mm 18mm; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #111; font-size: 12px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .brand { text-align: right; }
        .brand h1 { font-size: 18px; margin: 0 0 4px 0; }
        .brand small { color: #555; display: block; }
        .logo { width: 120px; height: 40px; background:#ddd; color:#777; display:flex; align-items:center; justify-content:center; border-radius:4px; font-size:12px; }
        .divider { height: 1px; background: #444; margin: 12px 0 14px; }
        .box-title { background: #efefef; padding: 8px 10px; border: 1px solid #e0e0e0; font-weight: 700; }
        .info { border: 1px solid #e0e0e0; border-top: none; padding: 10px 12px; }
        .row { display: flex; gap: 18px; }
        .col { flex: 1; }
        .label { color: #444; font-weight: 700; }
        .muted { color: #666; }
        table { border-collapse: collapse; width: 100%; margin-top: 12px; }
        th, td { border: 1px solid #e0e0e0; padding: 8px 8px; }
        thead th { background: #f5f5f5; text-align: left; }
        tfoot td { border: none; }
        .right { text-align: right; }
        .total-box { margin-top: 8px; display: flex; justify-content: flex-end; }
        .total { font-size: 14px; font-weight: 800; border: 1px solid #e0e0e0; padding: 8px 12px; background: #fafafa; }
        .sign { text-align: center; margin-top: 36px; }
        .sign .line { height: 1px; background: #222; width: 320px; margin: 32px auto 6px; }
        .small { font-size: 11px; color:#666; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Logo</div>
        <div class="brand">
            <h1>{{ $appName ?? 'Entidad Pública' }}</h1>
            @if(!empty(config('app.url')))
                <small class="muted">{{ config('app.url') }}</small>
            @endif
        </div>
    </div>

    <div class="divider"></div>

    <div class="box-title">Cuenta de Cobro #{{ $cuenta->numero ?? $cuenta->id }}</div>
    <div class="info">
        <div class="row">
            <div class="col">
                <div><span class="label">Fecha de emisión:</span> {{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</div>
                <div><span class="label">Beneficiario:</span> {{ $cuenta->nombre_beneficiario }}</div>
                <div><span class="label">Identificación:</span> {{ $cuenta->tipo_identificacion }} {{ $cuenta->identificacion }}</div>
            </div>
            <div class="col">
                <div><span class="label">Departamento:</span> {{ $cuenta->departamento }}</div>
                <div><span class="label">Municipio:</span> {{ $cuenta->municipio }}</div>
                <div><span class="label">Contrato asociado:</span> {{ optional($cuenta->contrato)->numero ?? 'N/A' }}</div>
            </div>
        </div>
        @if(!empty($cuenta->descripcion))
        <div style="margin-top:8px"><span class="label">Descripción:</span> <span class="muted">{{ $cuenta->descripcion }}</span></div>
        @endif
    </div>

    <div class="box-title" style="margin-top:12px;">Detalle de ítems</div>
    <table>
        <thead>
            <tr>
                <th style="width: 28px;">#</th>
                <th>Descripción</th>
                <th style="width: 90px;" class="right">Cantidad</th>
                <th style="width: 120px;" class="right">Valor Unitario</th>
                <th style="width: 120px;" class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuenta->items as $i => $it)
                <tr>
                    <td class="right">{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ $it->item }}</strong>
                        @if(!empty($it->detalle))
                            <div class="small">{{ $it->detalle }}</div>
                        @endif
                    </td>
                    <td class="right">{{ number_format($it->cantidad ?? 0, 0, ',', '.') }}</td>
                    <td class="right">$ {{ number_format($it->precio_unitario ?? 0, 2, ',', '.') }}</td>
                    <td class="right">$ {{ number_format(($it->cantidad ?? 0) * ($it->precio_unitario ?? 0), 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="small">No hay ítems registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width: 380px; margin-left: auto; margin-top: 12px; border: none;">
        <tbody>
            <tr>
                <td class="small">Subtotal</td>
                <td class="right">$ {{ number_format($subtotal ?? 0, 2, ',', '.') }}</td>
            </tr>
            @if(isset($iva) && $iva > 0)
            <tr>
                <td class="small">IVA</td>
                <td class="right">$ {{ number_format($iva, 2, ',', '.') }}</td>
            </tr>
            @endif
            @if(isset($retFuente) && $retFuente > 0)
            <tr>
                <td class="small">ReteFuente</td>
                <td class="right">- $ {{ number_format($retFuente, 2, ',', '.') }}</td>
            </tr>
            @endif
            @if(isset($retIca) && $retIca > 0)
            <tr>
                <td class="small">ReteICA</td>
                <td class="right">- $ {{ number_format($retIca, 2, ',', '.') }}</td>
            </tr>
            @endif
            @if(isset($retIva) && $retIva > 0)
            <tr>
                <td class="small">ReteIVA</td>
                <td class="right">- $ {{ number_format($retIva, 2, ',', '.') }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding-top:10px; font-weight:700">TOTAL A PAGAR</td>
                <td class="right" style="padding-top:10px; font-weight:700">$ {{ number_format($total ?? ($cuenta->valor_total ?? 0), 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="sign">
        <div class="line"></div>
        <div>{{ $cuenta->nombre_beneficiario }}</div>
        <div class="small">Firma del Beneficiario</div>
    </div>

    <p class="small" style="margin-top: 18px;">
        Nota: Este documento refleja el detalle de cobro por los bienes y/o servicios prestados. Cualquier inconsistencia favor notificar a la entidad.
    </p>
</body>
</html>
