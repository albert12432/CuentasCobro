@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Panel Ordenador de Gasto</h1>
    <p>Bienvenido, {{ $user->name }} 👋</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <a href="{{ route('cuentas_cobro.index') }}" class="btn btn-success w-100">📄 Gestionar Cuentas de Cobro</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.reports') }}" class="btn btn-info w-100">📊 Ver Reportes</a>
        </div>
    </div>
</div>
@endsection
