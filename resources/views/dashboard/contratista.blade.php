@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Bienvenido, {{ $user->name }}</h1>
    <p>Gestiona tus cuentas de cobro y consulta su estado.</p>

    <div class="row mt-4">
        <div class="col-md-6">
            <a href="{{ route('cuentas_cobro.create') }}" class="btn btn-primary w-100">➕ Nueva Cuenta de Cobro</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('cuentas_cobro.index') }}" class="btn btn-success w-100">📄 Mis Cuentas de Cobro</a>
        </div>
    </div>
</div>
@endsection
