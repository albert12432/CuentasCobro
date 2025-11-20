@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h4 m-0"><i class="fi fi-rr-pencil me-2"></i>Editar Cuenta de Cobro</h1>
        <a href="{{ route('cuentas_cobro.index') }}" class="btn btn-outline-brand"><i class="fi fi-rr-arrow-left me-1"></i>Volver</a>
    </div>

    <form action="{{ route('cuentas_cobro.update', $cuenta) }}" method="POST">
        @csrf
        @method('PUT')

        @if(!empty($readonly) && $readonly)
            <fieldset disabled>
                @include('cuentas_cobro.partials.form', ['btnText' => 'Actualizar', 'hideSubmit' => true, 'readonly' => true])
            </fieldset>
            <div class="alert alert-info mt-3">Vista de solo lectura (Tesorería).</div>
            <a href="{{ route('cuentas_cobro.pdf', $cuenta->id) }}" target="_blank" class="btn btn-danger mt-2" style="border-radius:12px;">
                <i class="fi fi-rr-file-pdf me-1"></i> Descargar PDF
            </a>
        @else
            @include('cuentas_cobro.partials.form', ['btnText' => 'Actualizar'])
        @endif
    </form>
</div>
@endsection
