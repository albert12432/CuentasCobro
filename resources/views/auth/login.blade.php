@extends('layouts.guest')

@section('title', 'Iniciar Sesión - CuentasCobro')

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-logo">
            <div class="login-logo-icon">
                <span class="material-symbols-rounded">receipt_long</span>
            </div>
            <h1 class="login-title">CuentasCobro</h1>
            <p class="login-subtitle">Inicia sesión en tu cuenta</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <span class="material-symbols-rounded">error</span>
                <div class="alert-content">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <span class="material-symbols-rounded">check_circle</span>
                <div class="alert-content">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">
                    <span class="material-symbols-rounded">mail</span>
                    Correo electrónico
                </label>
                <input type="email" 
                       class="form-input @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="email" 
                       autofocus
                       placeholder="ejemplo@correo.com">
                @error('email')
                    <div class="invalid-feedback">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <span class="material-symbols-rounded">lock</span>
                    Contraseña
                </label>
                <input type="password" 
                       class="form-input @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required 
                       autocomplete="current-password"
                       placeholder="Ingresa tu contraseña">
                @error('password')
                    <div class="invalid-feedback">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Recordarme
                </label>
            </div>

            <button type="submit" class="btn-login">
                <span class="material-symbols-rounded">login</span>
                Iniciar Sesión
            </button>
        </form>

        <div class="login-footer">
            <p class="login-footer-text">
                ¿No tienes una cuenta? 
                <a href="{{ route('register') }}" class="login-footer-link">Regístrate aquí</a>
            </p>
        </div>
    </div>
</div>
@endsection