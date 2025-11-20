@extends('layouts.app')

@section('title', 'Notificaciones')

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

    .notif-container {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .notif-item {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        padding: 24px;
        border-bottom: 1px solid #e5e5e7;
        transition: all 0.3s;
        position: relative;
    }

    .notif-item:hover {
        background: #f5f7fa;
    }

    .notif-item.no-leida {
        background: rgba(0, 113, 227, 0.03);
        border-left: 4px solid var(--apple-blue);
    }

    .notif-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .notif-icon.cuenta_cobro {
        background: linear-gradient(135deg, #0071e3, #00c6ff);
    }

    .notif-icon.aprobacion {
        background: linear-gradient(135deg, #30d158, #5de88a);
    }

    .notif-icon.rechazo {
        background: linear-gradient(135deg, #ff3b30, #ff6b5e);
    }

    .notif-icon.informativa {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .notif-icon .material-symbols-rounded {
        font-size: 28px;
        color: white;
    }

    .notif-content {
        flex: 1;
        min-width: 0;
    }

    .notif-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .notif-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--apple-dark);
        margin: 0;
    }

    .notif-badge {
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 100px;
        background: var(--apple-blue);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .notif-message {
        font-size: 14px;
        color: var(--apple-gray);
        line-height: 1.6;
        margin-bottom: 8px;
    }

    .notif-footer {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 13px;
        color: var(--apple-gray);
    }

    .notif-date {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .notif-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-notif {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-notif-primary {
        background: var(--apple-blue);
        color: white;
    }

    .btn-notif-primary:hover {
        background: #0059b3;
        transform: translateY(-2px);
    }

    .btn-notif-secondary {
        background: var(--apple-light-gray);
        color: var(--apple-dark);
    }

    .btn-notif-secondary:hover {
        background: #e0e0e2;
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
    }

    .stats-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 12px;
        background: rgba(0, 113, 227, 0.1);
        color: var(--apple-blue);
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .notif-item {
            flex-direction: column;
            gap: 16px;
        }

        .notif-actions {
            width: 100%;
            flex-direction: column;
        }

        .btn-notif {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Notificaciones</h1>
        @if($noLeidas > 0)
            <span class="stats-badge">
                <span class="material-symbols-rounded" style="font-size: 18px;">notifications_active</span>
                {{ $noLeidas }} sin leer
            </span>
        @endif
    </div>
    <div style="display: flex; gap: 12px;">
        @if($noLeidas > 0)
            <form action="{{ route('notificaciones.marcarTodasLeidas') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-apple btn-apple-secondary">
                    <span class="material-symbols-rounded" style="font-size: 20px;">done_all</span>
                    Marcar todas como leídas
                </button>
            </form>
        @endif
        <a href="{{ route('dashboard') }}" class="btn-apple">
            <span class="material-symbols-rounded" style="font-size: 20px;">arrow_back</span>
            Volver al Dashboard
        </a>
    </div>
</div>

<div class="notif-container">
    @forelse($notificaciones as $notif)
        <div class="notif-item {{ !$notif->leida ? 'no-leida' : '' }}">
            <div class="notif-icon {{ $notif->tipo }}">
                @switch($notif->tipo)
                    @case('cuenta_cobro')
                        <span class="material-symbols-rounded">receipt_long</span>
                        @break
                    @case('aprobacion')
                        <span class="material-symbols-rounded">check_circle</span>
                        @break
                    @case('rechazo')
                        <span class="material-symbols-rounded">cancel</span>
                        @break
                    @default
                        <span class="material-symbols-rounded">info</span>
                @endswitch
            </div>

            <div class="notif-content">
                <div class="notif-header">
                    <h3 class="notif-title">{{ $notif->titulo }}</h3>
                    @if(!$notif->leida)
                        <span class="notif-badge">Nueva</span>
                    @endif
                </div>

                <p class="notif-message">{{ $notif->mensaje }}</p>

                <div class="notif-footer">
                    <span class="notif-date">
                        <span class="material-symbols-rounded" style="font-size: 16px;">schedule</span>
                        {{ $notif->created_at->diffForHumans() }}
                    </span>
                    @if($notif->leida && $notif->fecha_leida)
                        <span>
                            <span class="material-symbols-rounded" style="font-size: 16px;">visibility</span>
                            Leída {{ $notif->fecha_leida->diffForHumans() }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="notif-actions">
                @if($notif->cuenta_cobro_id)
                    <a href="{{ route('cuentas_cobro.show', $notif->cuenta_cobro_id) }}" class="btn-notif btn-notif-primary">
                        <span class="material-symbols-rounded" style="font-size: 16px;">visibility</span>
                        Ver Cuenta
                    </a>
                @endif
                
                @if(!$notif->leida)
                    <form action="{{ route('notificaciones.marcarLeida', $notif->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-notif btn-notif-secondary">
                            <span class="material-symbols-rounded" style="font-size: 16px;">done</span>
                            Marcar leída
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-illustration">
            <span class="material-symbols-rounded">notifications_off</span>
            <h2 class="empty-title">No tienes notificaciones</h2>
            <p class="empty-text">Cuando recibas notificaciones, aparecerán aquí</p>
        </div>
    @endforelse
</div>

@if($notificaciones->hasPages())
    <div style="margin-top: 24px;">
        {{ $notificaciones->links() }}
    </div>
@endif

@endsection
