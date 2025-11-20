@extends('layouts.app')

@section('content')
<style>
    :root {
        --apple-blue: #0071e3;
        --apple-dark: #1d1d1f;
        --apple-gray: #86868b;
        --apple-light-gray: #f5f5f7;
    }

    .form-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        color: var(--apple-gray);
        font-size: 0.9rem;
    }

    .form-breadcrumb a {
        color: var(--apple-blue);
        text-decoration: none;
        transition: opacity 0.3s ease;
    }

    .form-breadcrumb a:hover {
        opacity: 0.7;
    }

    .form-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem;
    }

    .form-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        animation: fadeInUp 0.6s ease;
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        animation: shimmer 3s infinite;
    }

    .form-header-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    .form-header h1 {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .form-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0.5rem 0 0;
        font-size: 1rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
        }
    }
</style>

<div class="form-container">
    <div class="form-breadcrumb">
        <a href="{{ route('cuentas_cobro.index') }}">Cuentas de Cobro</a>
        <span class="material-symbols-rounded" style="font-size: 1rem;">chevron_right</span>
        <span>Nueva cuenta de cobro</span>
    </div>

    <div class="form-card">
        <div class="form-header">
            <span class="material-symbols-rounded form-header-icon">receipt_long</span>
            <h1>Nueva Cuenta de Cobro</h1>
            <p>Completa los datos para crear una nueva cuenta de cobro</p>
        </div>

        <form action="{{ route('cuentas_cobro.store') }}" method="POST" id="cuentaCobroForm">
            @csrf
            @include('cuentas_cobro.partials.form', ['btnText' => 'Crear Cuenta de Cobro', 'cuenta' => null])
        </form>
    </div>
</div>
@endsection
