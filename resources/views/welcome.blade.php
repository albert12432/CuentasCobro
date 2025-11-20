@extends('layouts.app')

@section('title', 'Bienvenido - Dewey Accounts')

@section('content')
<style>
    .welcome-header {
        background: linear-gradient(135deg, #0071e3 0%, #00c6ff 100%);
        color: white;
        padding: 48px;
        border-radius: 24px;
        margin-bottom: 32px;
    }

    .welcome-title {
        font-size: 36px;
        font-weight: 700;
        margin: 0 0 8px 0;
        letter-spacing: -0.8px;
    }

    .welcome-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
    }

    .quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
        margin-top: 24px;
    }

    .quick-link-btn {
        background: white;
        color: var(--apple-blue);
        padding: 16px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
    }

    .quick-link-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,113,227,0.25);
    }

    .welcome-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .welcome-card {
        background: white;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        text-align: center;
    }

    .welcome-card-icon {
        font-size: 40px;
        margin-bottom: 12px;
    }

    .welcome-card-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--apple-dark);
        margin: 8px 0;
    }

    .welcome-card-label {
        font-size: 13px;
        color: var(--apple-gray);
    }
</style>

<div class="welcome-header">
    <h1 class="welcome-title">¡Hola, {{ Auth::user()->name }}! 👋</h1>
    <p class="welcome-subtitle">Bienvenido a Dewey Accounts - Gestión moderna de cuentas de cobro</p>
    
    <div class="quick-links">
        <a href="{{ route('cuentas_cobro.create') }}" class="quick-link-btn">
            <span class="material-symbols-rounded">add_circle</span>
            Nueva Cuenta
        </a>
        <a href="{{ route('cuentas_cobro.index') }}" class="quick-link-btn">
            <span class="material-symbols-rounded">receipt_long</span>
            Ver Cuentas
        </a>
        <a href="{{ route('cuentas_cobro.pagos') }}" class="quick-link-btn">
            <span class="material-symbols-rounded">payments</span>
            Pagos
        </a>
        <a href="{{ route('reportes.index') }}" class="quick-link-btn">
            <span class="material-symbols-rounded">pie_chart</span>
            Reportes
        </a>
    </div>
</div>

<div class="welcome-cards">
    <div class="welcome-card">
        <div class="welcome-card-icon">📊</div>
        <div class="welcome-card-value">0</div>
        <div class="welcome-card-label">Cuentas Registradas</div>
    </div>
    <div class="welcome-card">
        <div class="welcome-card-icon">✅</div>
        <div class="welcome-card-value">0</div>
        <div class="welcome-card-label">Pagadas</div>
    </div>
    <div class="welcome-card">
        <div class="welcome-card-icon">⏳</div>
        <div class="welcome-card-value">0</div>
        <div class="welcome-card-label">Pendientes</div>
    </div>
    <div class="welcome-card">
        <div class="welcome-card-icon">💰</div>
        <div class="welcome-card-value">$0</div>
        <div class="welcome-card-label">Total Facturado</div>
    </div>
</div>

@endsection