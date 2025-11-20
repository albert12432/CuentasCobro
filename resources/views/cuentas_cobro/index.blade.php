@extends('layouts.app')

@section('title', 'Cuentas de Cobro')

@section('content')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--apple-dark);
        letter-spacing: -0.5px;
        margin: 0;
    }

    .table-container {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .table-actions {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-icon-view {
        background: var(--apple-blue-light);
        color: var(--apple-blue);
    }

    .btn-icon-view:hover {
        background: var(--apple-blue);
        color: white;
        transform: translateY(-2px);
    }

    .btn-icon-edit {
        background: rgba(255, 149, 0, 0.15);
        color: var(--apple-orange);
    }

    .btn-icon-edit:hover {
        background: var(--apple-orange);
        color: white;
        transform: translateY(-2px);
    }

    .btn-icon-delete {
        background: rgba(255, 59, 48, 0.15);
        color: var(--apple-red);
    }

    .btn-icon-delete:hover {
        background: var(--apple-red);
        color: white;
        transform: translateY(-2px);
    }

    .alert-custom {
        background: white;
        border-radius: 12px;
        padding: 16px 24px;
        margin-bottom: 24px;
        border-left: 4px solid var(--apple-green);
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideInUp 0.4s ease-out;
    }

    .empty-illustration {
        text-align: center;
        padding: 80px 32px;
    }

    .empty-illustration .material-symbols-rounded {
        font-size: 120px;
        color: var(--apple-blue);
        opacity: 0.2;
        margin-bottom: 24px;
    }

    .empty-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--apple-dark);
        margin-bottom: 12px;
    }

    .empty-text {
        font-size: 16px;
        color: var(--apple-gray);
        margin-bottom: 32px;
    }
</style>

<div class="page-header">
    <h1 class="page-title">Cuentas de Cobro</h1>
    <a href="{{ route('cuentas_cobro.create') }}" class="btn-apple">
        <span class="material-symbols-rounded" style="font-size: 20px;">add_circle</span>
        Nueva Cuenta
    </a>
</div>

@if(session('success'))
    <div class="alert-custom">
        <span class="material-symbols-rounded" style="color: var(--apple-green); font-size: 24px;">check_circle</span>
        <span style="flex: 1;">{!! session('success') !!}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; opacity: 0.5;">
            <span class="material-symbols-rounded">close</span>
        </button>
    </div>
@endif

<div class="table-container">
    @if($cuentas->count() > 0)
        <table class="apple-table">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Fecha Emisión</th>
                    <th>Valor Total</th>
                    <th>Departamento</th>
                    <th>Municipio</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuentas as $cuenta)
                    <tr>
                        <td><strong>{{ $cuenta->numero }}</strong></td>
                        <td style="color: var(--apple-gray);">{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</td>
                        <td><strong style="color: var(--apple-blue);">${{ number_format($cuenta->valor_total, 0, ',', '.') }}</strong></td>
                        <td>{{ $cuenta->departamento }}</td>
                        <td>{{ $cuenta->municipio }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('cuentas_cobro.show', $cuenta) }}" class="btn-icon btn-icon-view" title="Ver detalles">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">visibility</span>
                                </a>
                                <a href="{{ route('cuentas_cobro.edit', $cuenta) }}" class="btn-icon btn-icon-edit" title="Editar">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
                                </a>
                                <form action="{{ route('cuentas_cobro.destroy', $cuenta) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta cuenta de cobro?')" class="btn-icon btn-icon-delete" title="Eliminar">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-illustration">
            <span class="material-symbols-rounded">receipt_long</span>
            <h2 class="empty-title">No hay cuentas de cobro</h2>
            <p class="empty-text">Comienza creando tu primera cuenta de cobro</p>
            <a href="{{ route('cuentas_cobro.create') }}" class="btn-apple">
                <span class="material-symbols-rounded" style="font-size: 20px;">add_circle</span>
                Crear Primera Cuenta
            </a>
        </div>
    @endif
</div>

<!-- Floating Action Button for Mobile -->
<a href="{{ route('cuentas_cobro.create') }}" class="fab-create" title="Nueva cuenta" style="display: none;">
    <span class="material-symbols-rounded">add</span>
</a>

<style>
    @media (max-width: 768px) {
        .fab-create {
            display: flex !important;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        
        .page-header .btn-apple {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
