@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Panel Supervisor</h1>
    <p>Bienvenido, {{ $user->name }} 👋</p>

    <div class="row mt-4">
        <div class="col-md-6">
            <a href="{{ route('cuentas_cobro.index') }}" class="btn btn-success w-100">📄 Revisar Cuentas de Cobro</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.reports') }}" class="btn btn-info w-100">📊 Ver Reportes</a>
        </div>
    </div>
</div>
@endsection
