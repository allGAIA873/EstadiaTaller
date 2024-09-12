@extends('admin-layout')
@section('title', 'Estados de cuenta')
@section('subtitle')
    <div class="d-flex justify-content-between align-items-center">
        <p class="fs-1 fw-bold">Estados de cuenta</p>
    </div>
@endsection
@section('volver')
    <div class="m-4">
        <a class="btn btn-sm btn-primary" role="button">Subir archivo CSV</a>
        <button type="button" class="btn btn-sm btn-primary">Generar reporte</button>
    </div>
@endsection
@section('control')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
@section('content')
    <div class="card card-xl-stretch mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Historial de estado de cuenta</span>
            </h3>
            <div class="card-toolbar">
                <ul class="nav" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 me-1 active"
                            data-bs-toggle="tab" href="#kt_table_widget_5_tab_1" aria-selected="true"
                            role="tab">Todo</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 me-1"
                            data-bs-toggle="tab" href="#kt_table_widget_5_tab_2" aria-selected="false" tabindex="-1"
                            role="tab">Mes</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4"
                            data-bs-toggle="tab" href="#kt_table_widget_5_tab_3" aria-selected="false" tabindex="-1"
                            role="tab">Año</a>
                    </li>
                </ul>
            </div>
        </div>

        <form action="id="kt_update_form" method="POST" action="" class="form" novalidate">
            @csrf
            @method('PUT')
            <div class="card-body py-3">
                <div class="tab-content">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center table-row-bordered gy-4">
                            <thead class="table-active">
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th>Estado</th>
                                    <th>Banco</th>
                                    <th>Número de cuenta</th>
                                    <th>Periodo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estadosCuenta as $estadoCuenta)
                                    <tr>
                                        <td>
                                            @if ($estadoCuenta->estado === 'incompleto')
                                                <span class="badge badge-light-danger">Incompleto</span>
                                            @else
                                                <span class="badge badge-light-success">Completo</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $estadoCuenta->cuentasBancarias && $estadoCuenta->cuentasBancarias->banco ? $estadoCuenta->cuentasBancarias->banco->nombre : 'No especificado' }}
                                        </td>
                                        <td>{{ $estadoCuenta->cuentasBancarias ? $estadoCuenta->cuentasBancarias->num_cuenta : 'No especificado' }}
                                        </td>
                                        <td>{{ $estadoCuenta->fecha_emision }}</td>
                                        <td>
                                            <a href="{{ url('/estados-cuenta/' . $estadoCuenta->id . '/movimientos') }}"
                                                class="btn btn-sm btn-secondary">Ver más</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- PAGINACIÓN  -->
    <div class="d-flex justify-content-center mt-4">
        {{ $estadosCuenta->links('pagination::bootstrap-4') }}
    </div>

    <!-- MODAL DROPFILE CSV -->
    <div class="container">
        <div id="dropfile-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="card">
                        <form method="POST" action="{{ route('estados-cuenta.store') }}" enctype="multipart/form-data"
                            id="uploadForm">
                            @csrf
                            <div class="card-body">
                                <div id="drop-area" class="border rounded d-flex justify-content-center align-items-center"
                                    style="height: 210px; cursor: pointer; position: relative;">
                                    <div class="text-center" id="drop-message">
                                        <i class="bi bi-cloud-arrow-up" style="font-size: 48px"></i>
                                        <p class="mt-3">
                                            Seleccione un archivo.
                                        </p>
                                        <p class="text-muted mt-3">
                                            CSV, tamaño de archivo no superior a 10 MB.
                                        </p>
                                        <div class="mt-2">
                                            <button type="button"
                                                class="btn btn-sm btn-outline btn-outline-primary btn-active-light-primary">Seleccionar
                                                archivo</button>
                                        </div>
                                    </div>
                                    <!-- Archivo seleccionado -->
                                    <div id="file-selected" class="text-center" style="display: none;">
                                        <i class="bi bi-check-circle-fill text-success" style="font-size: 48px"></i>
                                        <p id="file-name" class="mt-3 fw-bold"></p>
                                        <p class="text-success mt-3">Archivo seleccionado con éxito</p>
                                    </div>
                                    <!-- Indicador de carga -->
                                    <div id="loading-spinner" class="text-center" style="display: none;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                        <p class="mt-2">Cargando...</p>
                                    </div>
                                </div>
                                <input type="file" id="fileElem" name="document_csv" class="d-none" />
                                <div class="m-2 d-flex justify-content-center">
                                    <button type="submit" value="import CSV"
                                        class="btn btn-sm btn-primary">Importar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <link href="{{ asset('css/estado-cuenta-mdoal.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/estados_cuenta.js') }}"></script>
@endsection
