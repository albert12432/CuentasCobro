@extends('layouts.app')

@section('title', 'Reportes')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/views/reportes.css') }}">
@endpush

@section('content')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--apple-dark);
        letter-spacing: -0.5px;
        margin: 0;
    }

    .btn-report {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: var(--apple-blue);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-report:hover {
        background: #0059b3;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 113, 227, 0.3);
    }

    .btn-report-success {
        background: var(--apple-green);
    }

    .btn-report-success:hover {
        background: #2dbf54;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        padding: 20px 24px;
        border-radius: 14px;
        box-shadow: var(--shadow-sm);
        border-left: 4px solid var(--apple-blue);
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-card.success { border-left-color: var(--apple-green); }
    .stat-card.warning { border-left-color: var(--apple-orange); }
    .stat-card.danger { border-left-color: var(--apple-red); }

    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--apple-gray);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--apple-dark);
        line-height: 1;
    }

    .stat-subtitle {
        font-size: 12px;
        color: var(--apple-gray);
        margin-top: 4px;
    }

    .section-card {
        background: white;
        border-radius: 18px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--apple-dark);
        margin: 0 0 20px 0;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: -0.3px;
    }

    .section-title .material-symbols-rounded {
        color: var(--apple-blue);
        font-size: 24px;
    }

    .chart-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
    }

    .chart-card {
        background: var(--apple-light-gray);
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        transition: all 0.2s;
    }

    .chart-card:hover {
        box-shadow: var(--shadow-sm);
    }

    .chart-title {
        font-size: 12px;
        font-weight: 600;
        color: var(--apple-gray);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .chart-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--apple-blue);
        line-height: 1;
        margin-bottom: 4px;
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

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background: rgba(48, 209, 88, 0.15);
        color: var(--apple-green);
    }

    .badge-warning {
        background: rgba(255, 149, 0, 0.15);
        color: var(--apple-orange);
    }

    .badge-danger {
        background: rgba(255, 59, 48, 0.15);
        color: var(--apple-red);
    }

    .badge-info {
        background: rgba(0, 113, 227, 0.15);
        color: var(--apple-blue);
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
        padding: 32px;
        color: var(--apple-gray);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .chart-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .table {
            font-size: 12px;
        }

        .table th, .table td {
            padding: 10px 8px;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">📊 Reportes</h1>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="{{ route('reportes.exportar', 'general') }}" class="btn-report">
            <span class="material-symbols-rounded">download</span>
            Exportar General
        </a>
        <a href="{{ route('reportes.exportar', 'pagos') }}" class="btn-report btn-report-success">
            <span class="material-symbols-rounded">download</span>
            Exportar Pagos
        </a>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total de Cuentas</div>
        <div class="stat-value">{{ $totalCuentas }}</div>
        <div class="stat-subtitle">Registradas en el sistema</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-label">Valor Total</div>
        <div class="stat-value">${{ number_format($totalValor, 0, ',', '.') }}</div>
        <div class="stat-subtitle">Monto acumulado</div>
    </div>
    <div class="stat-card success">
        <div class="stat-label">Pagado</div>
        <div class="stat-value">${{ number_format($totalPagado, 0, ',', '.') }}</div>
        <div class="stat-subtitle">{{ round(($totalPagado/$totalValor)*100, 1) }}% del total</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-label">Pendiente</div>
        <div class="stat-value">${{ number_format($totalPendiente, 0, ',', '.') }}</div>
        <div class="stat-subtitle">Por cobrar/procesar</div>
    </div>
    <div class="stat-card success">
        <div class="stat-label">Este Mes</div>
        <div class="stat-value">${{ number_format($pagadasEsteMes, 0, ',', '.') }}</div>
        <div class="stat-subtitle">Pagado en {{ \Carbon\Carbon::now()->monthName }} {{ now()->year }}</div>
    </div>
</div>

<!-- Distribución por Estado -->
<div class="section-card">
    <h2 class="section-title">
        <span class="material-symbols-rounded">pie_chart</span>
        Distribución por Estado
    </h2>
    <div class="chart-container">
        @foreach($porEstado as $estado)
        <div class="chart-card">
            <div class="chart-title">{{ ucfirst(str_replace('_', ' ', $estado->estado_aprobacion)) }}</div>
            <div class="chart-value">{{ $estado->total }}</div>
            <div style="font-size: 12px; color: var(--apple-gray); margin-top: 4px;">
                ${{ number_format($estado->valor, 0, ',', '.') }}
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Por Departamento -->
<div class="section-card">
    <h2 class="section-title">
        <span class="material-symbols-rounded">map</span>
        Distribución por Departamento
    </h2>
    <table class="table">
        <thead>
            <tr>
                <th>Departamento</th>
                <th style="text-align: right;">Cantidad</th>
                <th style="text-align: right;">Valor Total</th>
                <th style="text-align: center;">Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($porDepartamento as $dept)
            <tr>
                <td>{{ $dept->departamento }}</td>
                <td style="text-align: right;">{{ $dept->total }}</td>
                <td style="text-align: right;">${{ number_format($dept->valor, 0, ',', '.') }}</td>
                <td style="text-align: center;">
                    <a href="{{ route('reportes.departamento', $dept->departamento) }}" class="link-cell">
                        <span class="material-symbols-rounded" style="font-size: 18px;">arrow_forward</span>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: var(--apple-gray); padding: 32px;">No hay datos</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Antigüedad (Aging) -->
<div class="section-card">
    <h2 class="section-title">
        <span class="material-symbols-rounded">schedule</span>
        Antigüedad de Cuentas (Enviadas al Cliente)
    </h2>
    <div class="chart-container">
        <div class="chart-card">
            <div class="chart-title">0-30 días</div>
            <div class="chart-value" style="color: var(--apple-green);">{{ $aging['0_30'] }}</div>
        </div>
        <div class="chart-card">
            <div class="chart-title">31-60 días</div>
            <div class="chart-value" style="color: var(--apple-orange);">{{ $aging['31_60'] }}</div>
        </div>
        <div class="chart-card">
            <div class="chart-title">61-90 días</div>
            <div class="chart-value" style="color: #FF6B5E;">{{ $aging['61_90'] }}</div>
        </div>
        <div class="chart-card">
            <div class="chart-title">90+ días</div>
            <div class="chart-value" style="color: var(--apple-red);">{{ $aging['90_plus'] }}</div>
        </div>
    </div>
    <p style="margin: 16px 0 0 0; font-size: 13px; color: var(--apple-gray);">
        <a href="{{ route('reportes.aging') }}" style="color: var(--apple-blue); text-decoration: none; font-weight: 600; transition: all 0.2s;">
            Ver detalle de antigüedad →
        </a>
    </p>
</div>

<!-- Cuentas Recientes -->
<div class="section-card">
    <h2 class="section-title">
        <span class="material-symbols-rounded">history</span>
        Últimas Cuentas Creadas
    </h2>
    <table class="table">
        <thead>
            <tr>
                <th>Número</th>
                <th>Beneficiario</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentesCreadas as $c)
            <tr>
                <td><a href="{{ route('cuentas_cobro.show', $c->id) }}" class="link-cell">{{ $c->numero }}</a></td>
                <td>{{ $c->nombre_beneficiario }}</td>
                <td>${{ number_format($c->valor_total, 0, ',', '.') }}</td>
                <td>
                    @php
                        $estadoBadge = match($c->estado_aprobacion) {
                            'pendiente' => 'badge-warning',
                            'en_revision' => 'badge-info',
                            'aprobado' => 'badge-success',
                            'rechazado' => 'badge-danger',
                            'enviado_cliente' => 'badge-info',
                            'pagado' => 'badge-success',
                            default => 'badge-info'
                        };
                    @endphp
                    <span class="badge {{ $estadoBadge }}">{{ ucfirst(str_replace('_', ' ', $c->estado_aprobacion)) }}</span>
                </td>
                <td>{{ is_string($c->fecha_emision) ? $c->fecha_emision : $c->fecha_emision->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--apple-gray); padding: 32px;">No hay cuentas</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
