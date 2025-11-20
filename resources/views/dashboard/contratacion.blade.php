@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Panel Contratación</h1>
    <p>Bienvenido, {{ $user->name }} 👋</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <a href="{{ route('contratacion.contratos.index') }}" class="btn btn-primary w-100">
                📄 Gestionar Contratos
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('cuentas_cobro.index') }}" class="btn btn-success w-100">
                📑 Cuentas de Cobro Asociadas
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.reports') }}" class="btn btn-info w-100">
                📊 Reportes de Contratos
            </a>
        </div>
    </div>
</div>
@endsection
