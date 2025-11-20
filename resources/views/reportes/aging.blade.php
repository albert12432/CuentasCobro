@extends('layouts.app')

@section('title', 'Antigüedad de Cuentas')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/views/reportes.css') }}">
@endpush

@section('content')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--apple-blue);
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 16px;
        transition: all 0.2s;
    }

    .back-link:hover {
        gap: 12px;
        text-decoration: underline;
    }

    .report-header {
        margin-bottom: 32px;
    }

    .report-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--apple-dark);
        letter-spacing: -0.5px;
        margin: 0 0 8px 0;
    }

    .report-subtitle {
        color: var(--apple-gray);
        font-size: 15px;
        margin: 8px 0 0 0;
    }

    .bucket-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--apple-dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: -0.3px;
    }

    .bucket-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        background: rgba(0, 113, 227, 0.15);
        color: var(--apple-blue);
    }

    .stats-mini {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 16px;
    }

    .stat-mini {
        background: var(--apple-light-gray);
        padding: 12px;
        border-radius: 10px;
    }

    .stat-mini-label {
        font-size: 12px;
        color: var(--apple-gray);
        font-weight: 600;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-mini-value {
        font-size: 20px;
        font-weight: 700;
        color: var(--apple-dark);
    }

    .section-card {
        background: white;
        border-radius: 18px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
        border-left: 4px solid var(--apple-blue);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background: var(--apple-light-gray);
        padding: 14px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--apple-gray);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    .table td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        font-size: 14px;
        color: var(--apple-dark);
    }

    .table tr:hover {
        background: var(--apple-light-gray);
    }

    .link-cell {
        color: var(--apple-blue);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }

    .link-cell:hover {
        text-decoration: underline;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: var(--apple-gray);
    }

    .empty-state .material-symbols-rounded {
        font-size: 48px;
        opacity: 0.3;
        display: block;
        margin-bottom: 16px;
    }

    .info-box {
        background: var(--apple-light-gray);
        border-left: 4px solid var(--apple-blue);
        border-radius: 12px;
        padding: 16px 20px;
        margin-top: 32px;
    }

    .info-box h3 {
        font-size: 14px;
        font-weight: 600;
        color: var(--apple-dark);
        margin: 0 0 12px 0;
    }

    .info-box ul {
        margin: 0;
        padding-left: 20px;
        color: var(--apple-gray);
        font-size: 14px;
        line-height: 1.8;
    }

    .info-box li {
        margin-bottom: 4px;
    }

    .info-box strong {
        color: var(--apple-dark);
    }

    .bucket-0-30 { border-left-color: var(--apple-green) !important; }
    .bucket-31-60 { border-left-color: var(--apple-orange) !important; }
    .bucket-61-90 { border-left-color: #FF6B5E !important; }
    .bucket-90-plus { border-left-color: var(--apple-red) !important; }

    .days-badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .stats-mini {
            grid-template-columns: 1fr;
        }

        .table {
            font-size: 12px;
        }

        .table th, .table td {
            padding: 10px 8px;
        }
    }
</style>

<div class="report-header">
    <a href="{{ route('reportes.index') }}" class="back-link">
        <span class="material-symbols-rounded">arrow_back</span>
        Volver a reportes
    </a>
    <h1 class="report-title">⏱️ Antigüedad de Cuentas</h1>
    <p class="report-subtitle">Análisis de cuentas enviadas al cliente por tiempo de antigüedad</p>
</div>

@php
    $bucketColors = [
        0 => ['color' => '#30D158', 'bgColor' => 'rgba(48, 209, 88, 0.15)', 'textColor' => '#30D158'],
        1 => ['color' => '#FF9500', 'bgColor' => 'rgba(255, 149, 0, 0.15)', 'textColor' => '#FF9500'],
        2 => ['color' => '#FF6B5E', 'bgColor' => 'rgba(255, 107, 94, 0.15)', 'textColor' => '#FF6B5E'],
        3 => ['color' => '#FF3B30', 'bgColor' => 'rgba(255, 59, 48, 0.15)', 'textColor' => '#FF3B30'],
    ];
@endphp

@foreach($buckets as $index => $bucket)
<div class="section-card bucket-{{ str_replace('+', 'plus', strtolower(str_replace('-', '_', str_replace(' ', '', $bucket['rango'])))) }}" style="border-left-color: {{ $bucketColors[$index]['color'] }};">
    <div class="bucket-title">
        <span class="material-symbols-rounded" style="color: {{ $bucketColors[$index]['color'] }}; font-size: 24px;">schedule</span>
        {{ $bucket['rango'] }}
        <span class="bucket-badge" style="background: {{ $bucketColors[$index]['bgColor'] }}; color: {{ $bucketColors[$index]['textColor'] }};">
            {{ $bucket['total'] }} cuenta{{ $bucket['total'] !== 1 ? 's' : '' }}
        </span>
    </div>

    <div class="stats-mini">
        <div class="stat-mini">
            <div class="stat-mini-label">Total de Cuentas</div>
            <div class="stat-mini-value">{{ $bucket['total'] }}</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-label">Valor Acumulado</div>
            <div class="stat-mini-value">${{ number_format($bucket['valor'], 0, ',', '.') }}</div>
        </div>
    </div>

    @if($bucket['cuentas']->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Beneficiario</th>
                    <th>Contratista</th>
                    <th>Valor</th>
                    <th>Fecha Envío</th>
                    <th>Días</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bucket['cuentas'] as $cuenta)
                <tr>
                    <td><a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" class="link-cell">{{ $cuenta->numero }}</a></td>
                    <td>{{ $cuenta->nombre_beneficiario }}</td>
                    <td>{{ $cuenta->user?->name ?? 'N/A' }}</td>
                    <td>${{ number_format($cuenta->valor_total, 0, ',', '.') }}</td>
                    <td>{{ is_string($cuenta->fecha_envio_cliente) ? $cuenta->fecha_envio_cliente : ($cuenta->fecha_envio_cliente?->format('d/m/Y') ?? 'N/A') }}</td>
                    <td>
                        <span class="days-badge" style="background: {{ $bucketColors[$index]['bgColor'] }}; color: {{ $bucketColors[$index]['textColor'] }};">
                            {{ $cuenta->dias_antiguedad ?? 0 }} días
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <span class="material-symbols-rounded">inbox</span>
            <p>No hay cuentas en este rango</p>
        </div>
    @endif
</div>
@endforeach

<div class="info-box">
    <h3>📌 Interpretación de Antigüedad</h3>
    <ul>
        <li><strong style="color: var(--apple-green);">0-30 días:</strong> Cuentas recientes, seguimiento inicial</li>
        <li><strong style="color: var(--apple-orange);">31-60 días:</strong> Cuentas moderadas, requieren seguimiento activo</li>
        <li><strong style="color: #FF6B5E;">61-90 días:</strong> Cuentas críticas, requieren acción urgente</li>
        <li><strong style="color: var(--apple-red);">90+ días:</strong> Cuentas vencidas, gestión de cobranza necesaria</li>
    </ul>
</div>

@endsection
