@extends('layouts.guest')

@section('title', 'Registrar Usuario - CuentasCobro')

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-logo">
            <div class="login-logo-icon">
                <span class="material-symbols-rounded">person_add</span>
            </div>
            <h1 class="login-title">Crear Cuenta</h1>
            <p class="login-subtitle">Regístrate en CuentasCobro</p>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">
                    <span class="material-symbols-rounded">person</span>
                    Nombre completo
                </label>
                <input type="text" 
                       class="form-input @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       autocomplete="name" 
                       autofocus
                       placeholder="Juan Pérez">
                @error('name')
                    <div class="invalid-feedback">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

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
                       autocomplete="new-password"
                       placeholder="Mínimo 8 caracteres">
                @error('password')
                    <div class="invalid-feedback">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">
                    <span class="material-symbols-rounded">lock_reset</span>
                    Confirmar contraseña
                </label>
                <input type="password" 
                       class="form-input @error('password_confirmation') is-invalid @enderror" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password"
                       placeholder="Repite tu contraseña">
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                <span class="material-symbols-rounded">person_add</span>
                Crear Cuenta
            </button>
        </form>

        <div class="login-footer">
            <p class="login-footer-text">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="login-footer-link">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
</div>
@endsection