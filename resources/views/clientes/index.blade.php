@extends('admin-layout')
@section('title', 'Clientes')
@section('css')
    <link rel="stylesheet" href="/css/plugins.bundle.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
@endsection
@section('control')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <!--<div class="ms-auto" style="padding-left: 60%; padding-right: 5%">
                                <a href="#" class="btn btn-light hover-elevate-up"><i class="fa-solid fa-filter"></i></a>
                            </div> -->
    </div>
@endsection

@section('subtitle')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="ms-auto fs-1 fw-bold" style=""> Clientes </div>
    </div>
@endsection
@section('content')

    <!--Modal Agregar-->
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <form action="{{ url('/clientes') }}" method="POST" id="kt_docs_formvalidation_text" class="form needs-validation"
            novalidate>
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Agregar cliente.</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <!--begin::Form-->
                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">Nombre</label>
                            <input type="text" name="nombre" id="nombre"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value=""
                                required />
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                            @if ($errors->has('nombre'))
                                <div class="error">{{ $errors->first('nombre') }}</div>
                            @endif
                        </div>

                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">Razón social</label>
                            <input type="text" name="razon_social" id="razon_social"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value=""
                                required />
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                            @if ($errors->has('razon_social'))
                                <div class="error">{{ $errors->first('razon_social') }}</div>
                            @endif
                        </div>

                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">RFC</label>
                            <input type="text" name="rfc" id="rfc"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value=""
                                required />
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                            @if ($errors->has('rfc'))
                                <div class="error">{{ $errors->first('rfc') }}</div>
                            @endif
                        </div>

                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">Unidades de negocio</label>
                            <select class="form-select form-select-solid" name="unidad_id[]" id="unidad_id"
                                data-control="select2" data-close-on-select="false" data-placeholder="Select an option"
                                data-allow-clear="true" multiple="multiple">
                                @foreach ($unidades as $unidad)
                                    <option value="{{ $unidad->id }}">{{ $unidad->area }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                            @if ($errors->has('unidad_id'))
                                <div class="error">{{ $errors->first('unidad_id') }}</div>
                            @endif
                        </div>
                        <!--end::Input group-->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Guardar
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <style>
        .error {
            color: red;
            font-size: 0.875em;
            margin-top: 0.25em;
        }
    </style>

    <!-- Modal Editar-->
    <div class="modal fade" tabindex="-1" id="kt_modal_update">
        <form action="" method="POST" id="kt_update_form" class="form needs-validation" novalidate>
            @method('PUT')
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Editar información.</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <!--begin::Form-->
                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">Nombre</label>
                            <input type="text" name="nombre" id="edit_nombre"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value=""
                                required data-parsley-required-message="Este campo es obligatorio" />
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                        </div>

                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">Razón social</label>
                            <input type="text" name="razon_social" id="edit_razon_social"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value=""
                                required data-parsley-required-message="Este campo es obligatorio" />
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                        </div>

                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">RFC</label>
                            <input type="text" name="rfc" id="edit_rfc"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value=""
                                required data-parsley-required-message="Este campo es obligatorio" />
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                        </div>

                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">Unidades de negocio</label>
                            <select class="form-select form-select-solid" name="unidad_id[]" id="edit_unidad_negocio"
                                data-control="select2" data-close-on-select="false" data-placeholder="Select an option"
                                data-allow-clear="true" multiple="multiple">
                                @foreach ($unidades as $unidad)
                                    <option value="{{ $unidad->id }}">{{ $unidad->area }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                            @if ($errors->has('unidad_id'))
                                <div class="error">{{ $errors->first('unidad_id') }}</div>
                            @endif
                        </div>
                        <!--end::Input group-->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button id="kt_update_form_submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Guardar
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal eliminar-->
    <div class="modal fade" tabindex="-1" id="modal_delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    驴Est谩s seguro que deseas eliminar este cliente?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">
                <div>
                    <form action="{{ url('clientes') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search"
                                class="form-control form-control-lg form-control-solid px-15" placeholder="Buscar"
                                aria-label="Buscar">
                            <div>
                                <button title="Buscar" type="submit" class="btn btn-primary"><i
                                        class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1"
                style="margin-right: 3%; display: flex; align-items: center">
                <i class="bi bi-person-plus-fill" style="margin-right: 8px"></i>
                    Agregar
                </button>
            </div>
        </div>
        <div class="card-body">
            <!--Tabla-->
            <div>
                <div>
                    <table class="table table-responsive table-row-dashed table-row-gray-300">
                        <thead>
                            <tr class="fw-semibold fs-3 text-gray-800 border-bottom border-gray-100">
                                <th>Nombre</th>
                                <th>Razón social</th>
                                <th>RFC</th>
                                <th>Unidad de negocio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($listClients as $client)
                            <tr>
                                <td>{{$client->nombre ?? 'No encontado'}}</td>
                                <td>{{$client->razon_social ?? 'No encontado'}}</td>
                                <td>{{$client->rfc ?? 'No encontado'}}</td>
                                <td>
                                    @forelse ($client->unidades as $unidad)
                                        {{ $unidad->area }}<br>
                                    @empty
                                        No disponible
                                    @endforelse
                                </td>
                                <td>
                                    <div class="card-toolbar dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a href="{{url('/clientes/' .$client->id. '/detalle')}}" class="btn btn-light dropdown-item">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    Ver más
                                                </a>
                                            </li>
                                            <li>
                                                <button
                                                    type="button" class="btn btn-light dropdown-item" 
                                                    data-id="{{ $client->id }}"
                                                    data-nombre="{{ $client->nombre }}"
                                                    data-razon_social="{{ $client->razon_social }}"
                                                    data-rfc="{{ $client->rfc }}"
                                                    data-unidad_negocio='@json($client->unidades->pluck("id"))'
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_update">
                                                        <i class="fas fa-edit me-2"></i>
                                                        Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn btn-danger dropdown-item"
                                                        style="margin-right: 3%" data-bs-toggle="modal"
                                                        data-id="{{ $client->id }}" data-bs-target="#modal_delete">
                                                        <i class="fas fa-trash-alt me-2"></i>
                                                        Eliminar
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No se encontraron clientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $listClients->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script src="{{ asset('js/clientes.js') }}"></script>
    <script src="{{ asset('js/plugins.bundle.js') }}"></script>

@endsection
