@extends('admin-layout')
@section('title', 'Dashboard')
@section('css')
    <style>
        .foo {
            color: red;
        }
    </style>
@endsection
@section('content')
    <!--div class="foo">Hello</div-->
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Contenido</h3>
            <!--div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light">
                    Action
                </button>
            </div-->
        </div>
        <div class="card-body py-5">
            <div class="row">
                <!-- Primera fila de cards -->
                <div class="card-body col-md-4 mb-4">
                    <a href="{{route('clientes.index')}}" class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body align-items">
                            <span class="svg-icon fs-1"><i class="bi bi-person-vcard-fill"></i></span>
                            <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">Clientes</span>
                        </div>
                    </a>
                </div>
                <div class="card-body col-md-4 mb-4">
                    <a href="{{route('estados-cuenta.index')}}" class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body align-items">
                            <span class="svg-icon fs-1"><i class="bi bi-file-text-fill"></i></span>
                            <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">Estados de Cuenta</span>
                        </div>
                    </a>
                </div>
                <div class="card-body col-md-4 mb-4">
                    <a href="{{route('cuentas-bancarias.index')}}" class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body align-items">
                            <span class="svg-icon fs-1"><i class="bi bi-coin"></i></span>
                            <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">Cuentas Bancarias</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Segunda fila de cards -->
                <div class="card-body col-md-4 mb-4">
                    <a href="{{route('asignacion-facturas.index')}}" class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body align-items">
                            <span class="svg-icon fs-1"><i class="bi bi-file-earmark-ruled-fill"></i></i></span>
                            <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">Asignación de Facturas</span>
                        </div>
                    </a>
                </div>
                <div class="card-body col-md-4 mb-4">
                    <a href="{{route('usuarios.index')}}" class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body align-items">
                            <span class="svg-icon fs-1"><i class="bi bi-person-workspace"></i></span>
                            <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">Usuarios</span>
                        </div>
                    </a>
                </div>
                <div class="card-body col-md-4 mb-4">
                    <a href="{{route('unidades_negocio.index')}}" class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body align-items">
                            <span class="svg-icon fs-1"><i class="bi bi-building-fill"></i></i></span>
                            <span class="ms-3 text-gray-700 parent-hover-primary fs-6 fw-bold">Unidades de Negocio</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        console.log('hello world!')
    </script>
@endsection
