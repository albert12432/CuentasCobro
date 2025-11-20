@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Panel de Administración</h1>
    <p>Bienvenido, {{ $user->name }} 👋</p>

    <div class="row mt-4">
        <div class="col-md-3">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100">👤 Gestionar Usuarios</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary w-100">🛠️ Gestionar Roles</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('cuentas_cobro.index') }}" class="btn btn-success w-100">📄 Cuentas de Cobro</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.reports') }}" class="btn btn-info w-100">📊 Reportes</a>
        </div>
    </div>
</div>
@endsection
