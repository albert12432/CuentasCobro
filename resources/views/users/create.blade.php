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
        max-width: 900px;
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

    .form-body {
        padding: 3rem 2.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--apple-dark);
        margin-bottom: 0.75rem;
    }

    .form-label .material-symbols-rounded {
        font-size: 1.2rem;
        color: var(--apple-blue);
    }

    .form-input-wrapper {
        position: relative;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        font-size: 1rem;
        border: 2px solid #e5e5e7;
        border-radius: 12px;
        outline: none;
        transition: all 0.3s ease;
        background: var(--apple-light-gray);
        color: var(--apple-dark);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .form-input:focus,
    .form-select:focus {
        border-color: var(--apple-blue);
        background: white;
        box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
    }

    .form-input.is-invalid,
    .form-select.is-invalid {
        border-color: #ff3b30;
        background: #fff5f5;
    }

    .form-input.is-invalid:focus,
    .form-select.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(255, 59, 48, 0.1);
    }

    .form-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--apple-gray);
        font-size: 1.3rem;
        pointer-events: none;
        transition: color 0.3s ease;
    }

    .form-input:focus ~ .form-icon,
    .form-select:focus ~ .form-icon {
        color: var(--apple-blue);
    }

    .form-error {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        color: #ff3b30;
        font-size: 0.85rem;
    }

    .form-error .material-symbols-rounded {
        font-size: 1rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e5e7;
    }

    .btn-cancel,
    .btn-submit {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
    }

    .btn-cancel {
        background: var(--apple-light-gray);
        color: var(--apple-dark);
    }

    .btn-cancel:hover {
        background: #e0e0e2;
        transform: translateY(-2px);
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-submit:hover {
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        transform: translateY(-2px);
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
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-container {
            padding: 1rem;
        }

        .form-body {
            padding: 2rem 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="form-container">
    <div class="form-breadcrumb">
        <a href="{{ route('admin.users.index') }}">Usuarios</a>
        <span class="material-symbols-rounded" style="font-size: 1rem;">chevron_right</span>
        <span>Crear nuevo usuario</span>
    </div>

    <div class="form-card">
        <div class="form-header">
            <span class="material-symbols-rounded form-header-icon">person_add</span>
            <h1>Crear Nuevo Usuario</h1>
            <p>Completa los datos para agregar un nuevo usuario al sistema</p>
        </div>

        <div class="form-body">
            <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <span class="material-symbols-rounded">badge</span>
                            Nombre completo
                        </label>
                        <div class="form-input-wrapper">
                            <input 
                                type="text" 
                                name="name" 
                                id="name"
                                class="form-input @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" 
                                placeholder="Juan Pérez García"
                                required
                            >
                            <span class="material-symbols-rounded form-icon">person</span>
                        </div>
                        @error('name')
                            <div class="form-error">
                                <span class="material-symbols-rounded">error</span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <span class="material-symbols-rounded">alternate_email</span>
                            Correo electrónico
                        </label>
                        <div class="form-input-wrapper">
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                class="form-input @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" 
                                placeholder="ejemplo@correo.com"
                                required
                            >
                            <span class="material-symbols-rounded form-icon">mail</span>
                        </div>
                        @error('email')
                            <div class="form-error">
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
                        <div class="form-input-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                class="form-input @error('password') is-invalid @enderror"
                                placeholder="Mínimo 8 caracteres"
                                required
                            >
                            <span class="material-symbols-rounded form-icon">key</span>
                        </div>
                        @error('password')
                            <div class="form-error">
                                <span class="material-symbols-rounded">error</span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role_id" class="form-label">
                            <span class="material-symbols-rounded">workspace_premium</span>
                            Rol del usuario
                        </label>
                        <div class="form-input-wrapper">
                            <select 
                                name="role_id" 
                                id="role_id"
                                class="form-select @error('role_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Selecciona un rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="material-symbols-rounded form-icon">shield_person</span>
                        </div>
                        @error('role_id')
                            <div class="form-error">
                                <span class="material-symbols-rounded">error</span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn-cancel">
                        <span class="material-symbols-rounded">close</span>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-submit">
                        <span class="material-symbols-rounded">save</span>
                        Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createUserForm');
    const inputs = form.querySelectorAll('.form-input, .form-select');

    // Animación de entrada para los campos
    inputs.forEach((input, index) => {
        input.style.opacity = '0';
        input.style.transform = 'translateY(20px)';
        setTimeout(() => {
            input.style.transition = 'all 0.4s ease';
            input.style.opacity = '1';
            input.style.transform = 'translateY(0)';
        }, 100 * index);
    });

    // Validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Validación del email
    const emailInput = document.getElementById('email');
    emailInput.addEventListener('blur', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (this.value && !emailRegex.test(this.value)) {
            this.classList.add('is-invalid');
        }
    });

    // Validación de la contraseña
    const passwordInput = document.getElementById('password');
    passwordInput.addEventListener('input', function() {
        if (this.value.length > 0 && this.value.length < 8) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
@endsection