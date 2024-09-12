@extends('admin-layout')
@section('title', 'Detalle')
@section('css')
    <link rel="stylesheet" href="/css/plugins.bundle.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
@endsection

@section('volver')
    <a class="btn btn-light hover-elevate-up" href="{{ url('/clientes') }}"> <i class="bi bi-box-arrow-left"></i> Volver </a>
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
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('subtitle')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="ms-auto" style=""> Información detallada </div>
    </div>
@endsection
@section('content')
    <div>
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Detalle del cliente</h3>
                <div class="card-toolbar dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Acciones
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <button type="button" class="btn btn-light dropdown-item" data-id="{{ $client->id }}"
                                data-nombre="{{ $client->nombre }}" data-razon_social="{{ $client->razon_social }}"
                                data-rfc="{{ $client->rfc }}" data-unidad_negocios='@json($client->unidades->pluck('id'))'
                                data-bs-toggle="modal" data-bs-target="#kt_modal_update2">
                                <i class="fas fa-edit me-2"></i>
                                Editar
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-danger dropdown-item" style="margin-right: 3%"
                                data-bs-toggle="modal" data-id="{{ $client->id }}" data-bs-target="#modal_delete">
                                <i class="fas fa-trash-alt me-2"></i>
                                Eliminar
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <h6 class="card-title"><strong>Nombre: </strong>
                    {{ $client->nombre ?? 'No encontrado' }}
                </h6>
            </div>

            <div class="card-body">
                <h6 class="card-title"><strong>Razón Social: </strong>
                    {{ $client->razon_social ?? 'No encontrado' }}
                </h6>
            </div>

            <div class="card-body">
                <h6 class="card-title"><strong>RFC: </strong>
                    {{ $client->rfc ?? 'No encontrado' }}
                </h6>
            </div>

            <div class="card-body">
                <h6 class="card-title"><strong>Unidad de negocio: </strong>
                    @if ($client->unidades->isNotEmpty())
                        {{ $client->unidades->pluck('area')->implode(', ') }}
                    @else
                        No disponible
                    @endif
                </h6>
            </div>
        </div>
    </div>
    <br>
    <div>
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Cuentas</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_addCuenta" style="margin-right: 3%; display: flex; align-items: center">
                    <i class="bi bi-plus" style="margin-right: 8px"></i>
                    Agregar
                </button>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <table class="table table-responsive table-row-dashed table-row-gray-300">
                        <thead>
                            <tr class="fw-semibold fs-3 text-gray-800 border-bottom border-gray-100">
                                <th>Banco</th>
                                <th>Número de cuenta</th>
                                <th>CABLE</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($client->cuentasBancarias as $cuenta)
                                <tr>
                                    <td>{{ $cuenta->banco?->nombre ?? 'No encontrado' }}</td>
                                    <td>{{ $cuenta->num_cuenta }}</td>
                                    <td>{{ $cuenta->clabe }}</td>
                                    <td style="padding: 12px;">
                                        <div class="card-toolbar dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Acciones
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <button type="button" class="btn btn-light dropdown-item"
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_updateCuenta"
                                                        data-id="{{ $cuenta->cliente_id }}"
                                                        data-cuenta-id="{{ $cuenta->id }}"
                                                        data-banco="{{ $cuenta->banco->id ?? 'N/A' }}"
                                                        data-num_cuenta="{{ $cuenta->num_cuenta }}"
                                                        data-clabe="{{ $cuenta->clabe }}">
                                                        <i class="fas fa-edit me-2"></i>
                                                        Editar
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="btn btn-danger dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#modal_deleteCuenta" data-id="{{ $cuenta->id }}"
                                                        data-cliente-id="{{ $cuenta->cliente_id }}">
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
                                    <td colspan="4">No se encontraron cuentas bancarias.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!--Modal editar cliente-->
    <div class="modal fade" tabindex="-1" id="kt_modal_update2">
        <form action="{{ url('/clientes/' . $client->id . '/detalle') }}" method="POST" id="kt_update_form2"
            class="form needs-validation" novalidate>
            @method('PUT')
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Acutalzar información.</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <!--begin::Form-->
                        <form id="kt_docs_formvalidation_text" class="form" action="#" autocomplete="off">
                            <div class="fv-row mb-10">
                                <label class="required fw-semibold fs-6 mb-2">Nombre</label>
                                <input type="text" name="nombre" id="edit_nombre2"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                    value="{{ $client->nombre }}" required
                                    data-parsley-required-message="Este campo es obligatorio" />
                                <div class="invalid-feedback">
                                    Campo obligatorio.
                                </div>
                            </div>

                            <div class="fv-row mb-10">
                                <label class="required fw-semibold fs-6 mb-2">Razón social</label>
                                <input type="text" name="razon_social" id="edit_razon_social2"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                    value="{{ $client->razon_social }}" required
                                    data-parsley-required-message="Este campo es obligatorio" />
                                <div class="invalid-feedback">
                                    Campo obligatorio.
                                </div>
                            </div>

                            <div class="fv-row mb-10">
                                <label class="required fw-semibold fs-6 mb-2">RFC</label>
                                <input type="text" name="rfc" id="edit_rfc2"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                    value="{{ $client->rfc }}" required
                                    data-parsley-required-message="Este campo es obligatorio" />
                                <div class="invalid-feedback">
                                    Campo obligatorio.
                                </div>
                            </div>

                            <div class="fv-row mb-10">
                                <label class="required fw-semibold fs-6 mb-2">Unidades de negocio</label>
                                <select class="form-select form-select-solid" name="unidad_id[]"
                                    id="edit_unidad_negocio2" data-control="select2" data-close-on-select="false"
                                    data-placeholder="Seleccionar unidades" data-allow-clear="true" multiple="multiple"
                                    required>
                                    @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad->id }}"
                                            @if (in_array($unidad->id, $client->unidades->pluck('id')->toArray())) selected @endif>
                                            {{ $unidad->area }}
                                        </option>
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
                        </form>
                        <!--end::Form-->
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

    <!-- Modal eliminar cliente-->
    <div class="modal fade" tabindex="-1" id="modal_delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Registro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro que deseas eliminar este registro?
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

    <!--Cuentas-->
    <!--Modal agregar cuenta-->
    <div class="modal fade" tabindex="-1" id="kt_modal_addCuenta">
        <form action="{{ url('/clientes/' . $client->id . '/detalle') }}" method="POST"
            id="kt_docs_formvalidation_text" class="form needs-validation" novalidate>
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Agregar cuenta.</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <!--begin::Form-->
                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">Banco</label>
                            <select class="form-select form-select-solid" id="banco_id" name="banco_id"
                                data-control="select2" data-dropdown-parent="#kt_modal_addCuenta"
                                data-placeholder="Seleccionar banco" required>
                                <option selected disabled value="">Seleccionar banco</option>
                                @foreach ($bancos as $banco)
                                    <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                        </div>

                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">Número de cuenta</label>
                            <input type="text" name="num_cuenta" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="" value="" required
                                data-parsley-required-message="Este campo es obligatorio" />
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
                        </div>

                        <div class="fv-row mb-10">
                            <label class="required fw-semibold fs-6 mb-2">CLABE</label>
                            <input type="text" name="clabe" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="" value="" required
                                data-parsley-required-message="Este campo es obligatorio" />
                            <div class="invalid-feedback">
                                Campo obligatorio.
                            </div>
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

    <!--Modal editar cuentas-->
    <div id="editCuenta">
        <div class="modal fade" id="kt_modal_updateCuenta" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Cuenta Bancaria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="kt_update_form" method="POST" action="" class="form" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_banco" class="form-label">Banco</label>
                                <select class="form-select form-select-solid" id="edit_banco" name="banco_id"
                                    data-control="select2" data-placeholder="Select an option" required>
                                    @foreach ($bancos as $banco)
                                        <option value="{{ $banco->id }}"> {{ $banco->nombre }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Campo obligatorio.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_num_cuenta" class="form-label">Número de Cuenta</label>
                                <input type="text" class="form-control form-control-solid mb-3 mb-lg-0"
                                    id="edit_num_cuenta" name="num_cuenta" required>
                                <div class="invalid-feedback">
                                    Campo obligatorio.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_clabe" class="form-label">CLABE</label>
                                <input type="text" class="form-control form-control-solid mb-3 mb-lg-0"
                                    id="edit_clabe" name="clabe" required>
                                <div class="invalid-feedback">
                                    Campo obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal eliminar cuenta -->
    <div class="modal fade" tabindex="-1" id="modal_deleteCuenta">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Cuenta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro que deseas eliminar esta cuenta?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form id="formDelete" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="{{ asset('js/clientes.js') }}"></script>
    <script src="{{ asset('js/cuentas.js') }}"></script>
    <script src="{{ asset('js/plugins.bundle.js') }}"></script>

@endsection
