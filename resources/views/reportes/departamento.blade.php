@extends('layouts.app')

@section('title', 'Reporte - ' . $departamento)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/views/reportes.css') }}">
@endpush

@section('content')
<style>
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

    .report-subtitle {
        color: var(--apple-gray);
        font-size: 15px;
        margin: 8px 0 0 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
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

    .chart-item {
        background: var(--apple-light-gray);
        padding: 16px;
        border-radius: 12px;
        text-align: center;
        transition: all 0.2s;
    }

    .chart-item:hover {
        box-shadow: var(--shadow-sm);
    }

    .chart-label {
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

    .chart-amount {
        font-size: 12px;
        color: var(--apple-gray);
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

    .pagination-section {
        margin-top: 20px;
        text-align: center;
    }

    @media (max-width: 768px) {
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

<div class="report-header">
    <a href="{{ route('reportes.index') }}" class="back-link">
        <span class="material-symbols-rounded">arrow_back</span>
        Volver a reportes
    </a>
    <h1 class="report-title">📍 {{ $departamento }}</h1>
    <p class="report-subtitle">Reporte detallado de cuentas de cobro</p>
</div>

<!-- Estadísticas -->
<div class="section-card">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total de Cuentas</div>
            <div class="stat-value">{{ $cuentas->total() }}</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-label">Valor Total</div>
            <div class="stat-value">${{ number_format($totalValor, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<!-- Distribución por Estado -->
<div class="section-card">
    <h2 class="section-title">
        <span class="material-symbols-rounded">pie_chart</span>
        Distribución por Estado
    </h2>
    <div class="chart-container">
        @foreach($distribucion as $dist)
        <div class="chart-item">
            <div class="chart-label">{{ ucfirst(str_replace('_', ' ', $dist->estado_aprobacion)) }}</div>
            <div class="chart-value">{{ $dist->total }}</div>
            <div class="chart-amount">${{ number_format($dist->valor, 0, ',', '.') }}</div>
        </div>
        @endforeach
    </div>
</div>

<!-- Lista de Cuentas -->
<div class="section-card">
    <h2 class="section-title">
        <span class="material-symbols-rounded">receipt_long</span>
        Cuentas de Cobro
    </h2>
    <table class="table">
        <thead>
            <tr>
                <th>Número</th>
                <th>Beneficiario</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Contratista</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuentas as $c)
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
                <td>{{ $c->user?->name ?? 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--apple-gray); padding: 32px;">No hay cuentas en este departamento</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($cuentas->hasPages())
    <div class="pagination-section">
        {{ $cuentas->links() }}
    </div>
    @endif
</div>

@endsection
