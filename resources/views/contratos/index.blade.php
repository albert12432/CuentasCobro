@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Listado de Cuentas de Cobro</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('cuentas_cobro.create') }}" class="btn btn-primary mb-3">+ Nueva Cuenta</a>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Número</th>
                <th>Fecha Emisión</th>
                <th>Valor Total</th>
                <th>Departamento</th>
                <th>Municipio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
                <tr>
                    <td>{{ $cuenta->numero }}</td>
                    <td>{{ $cuenta->fecha_emision }}</td>
                    <td>${{ number_format($cuenta->valor_total, 0, ',', '.') }}</td>
                    <td>{{ $cuenta->departamento }}</td>
                    <td>{{ $cuenta->municipio }}</td>
                    <td>
                        <a href="{{ route('cuentas_cobro.edit', $cuenta) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('cuentas_cobro.destroy', $cuenta) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta cuenta?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $cuentas->links() }}
</div>
@endsection
