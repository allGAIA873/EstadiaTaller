@extends('admin-layout')
@section('title', 'Especificación de movimiento')

@section('volver')
    <a class="btn btn-light hover-elevate-up" href="{{ url('/estados-cuenta') }}"> Volver </a>
@endsection

@section('control')
@section('control')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($error->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('subtitle')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="ms-auto" style=""> Especificación de movimiento </div>
    </div>
@endsection
@section('content')
    <div>
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Movimientos</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-row-dashed table-row-gray-300 text-center">
                    <thead>
                        <tr class="fw-semibold fs-3 text-gray-800 border-bottom border-gray-100">
                            <th class="fs-5">Cuenta</th>
                            <th class="fs-5">Concepto</th>
                            <th class="fs-5">Deposito</th>
                            <th class="fs-5">Retiro</th>
                            <th class="fs-5">Detallado</th>
                            <th class="fs-5">Unidad de Negocio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="align-middle">
                            <td>
                                {{ $estadosCuenta->cuentasBancarias && $estadosCuenta->cuentasBancarias->banco ? $estadosCuenta->cuentasBancarias->banco->nombre : 'No especificado' }}<br>
                                {{ $estadosCuenta->cuentasBancarias ? $estadosCuenta->cuentasBancarias->num_cuenta : 'No especificado' }}
                            </td>
                            <td>{{ $estadosCuenta->concepto }}</td>
                            <td class="text-success">{{ $estadosCuenta->deposito }}</td>
                            <td class="text-danger">{{ $estadosCuenta->retiro }}</td>
                            <td>{{ $estadosCuenta->descripcion_detallada ?? 'N/A' }}</td>
                            <td class="fw-bolder no-interaction">
                                <div class="flex gap-3">
                                    @foreach ($todasUnidades as $unidad)
                                        <div class="form-check form-check-custom form-check-solid form-check-sm">
                                            <input class="form-check-input" type="checkbox" value="{{ $unidad->id }}"
                                                id="unidad-{{ $unidad->id }}"
                                                {{ in_array($unidad->id, $unidadesAsociadas) ? 'checked' : '' }} />
                                            <label class="form-check-label" for="unidad-{{ $unidad->id }}">
                                                {{ $unidad->area }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        .no-interaction {
            pointer-events: none;
            user-select: none;
        }
    </style>
@endsection
