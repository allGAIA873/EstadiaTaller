@extends('admin-layout')
@section('title', 'Cuentas bancarias')
@section('css')
    <link rel="stylesheet" href="css/plugins.bundle.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
@endsection

@section('control')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3"> </div>
@endsection

@section('subtitle')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="ms-auto fs-1 fw-bold" style=""> Cuentas Bancarias </div>
</div>
@endsection
@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">
            <div>
                <form action="{{ url('cuentas-bancarias') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control-lg form-control-solid px-15" placeholder="Buscar" aria-label="Buscar" value="{{ $search ?? '' }}">
                        <div>
                            <button title="Buscar" type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </h3>
        <div class="card-toolbar">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1" style="margin-right: 3%; display: flex; align-items: center">
                <i class="bi bi-plus" style="margin-right: 8px"></i>
                Agregar
            </button>
        </div>
    </div>
<div class="card-body">
    <div>
            <div>
                <table class="table table-responsive table-row-dashed table-row-gray-300">
                    <thead>
                        <tr class="fw-semibold fs-3 text-gray-800 border-bottom border-gray-100">
                            <th>Número de cuenta</th>
                            <th>CABLE</th>
                            <th>Cliente</th>
                            <th>Banco</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuentas as $cuenta)
                        <tr>
                            <td>{{$cuenta->num_cuenta??'No encontrado'}}</td>
                            <td>{{$cuenta->clabe??'No encontrado'}}</td>
                            <td>{{$cuenta->cliente?->razon_social??'No encontrado'}}</td>
                            <td>{{$cuenta->banco?->nombre??'No encontrado'}}</td>
                            <td>
                                <div class="card-toolbar dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <button type="button" class="btn btn-light dropdown-item" data-bs-toggle="modal" data-bs-target="#kt_modal_updateCuentaGen" data-cuenta-id="{{ $cuenta->id }}" data-banco-id="{{ $cuenta->banco_id }}" data-num_cuenta="{{ $cuenta->num_cuenta }}" data-clabe="{{ $cuenta->clabe }}" data-cliente-id="{{ $cuenta->cliente_id }}">
                                                <i class="fas fa-edit me-2"></i> 
                                                Editar
                                            </button>
                                        </li>
                                        </li>
                                        <li>
                                            <button class="btn btn-danger dropdown-item" data-bs-toggle="modal" data-bs-target="#modal_deleteCuentaGen" data-id="{{ $cuenta->id }}" data-cliente-id="{{ $cuenta->cliente_id }}">
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
                            <td colspan="4">No se encontraron cuentas.</td>
                        </tr>
                        @endforelse   
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $cuentas->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!--Modal Agregar-->
<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <form action="{{ route('cuentas-bancarias.storeGeneralView') }}" method="POST" id="kt_docs_formvalidation_text" class="form needs-validation" novalidate>
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Agregar cuenta</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
    
                <div class="modal-body">
                    <!--begin::Form-->
                    <div class="fv-row mb-10">
                        <label class="required fw-semibold fs-6 mb-2">Número de cuenta</label>
                        <input type="text" name="num_cuenta" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value="" required data-parsley-required-message="Este campo es obligatorio" />
                        <div class="invalid-feedback">
                            Campo obligatorio.
                        </div>
                    </div>
    
                    <div class="fv-row mb-10">
                        <label class="required fw-semibold fs-6 mb-2">CLABE</label>
                        <input type="text" name="clabe" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value="" required data-parsley-required-message="Este campo es obligatorio" />
                        <div class="invalid-feedback">
                            Campo obligatorio.
                        </div>
                    </div>

                    <div class="fv-row mb-10">
                        <label class="required fw-semibold fs-6 mb-2">Cliente</label>
                        <select class="form-select form-select-solid" id="cliente_id" name="cliente_id" data-control="" data-placeholder="Seleccionar cliente" required>
                            <option selected disabled value="">Seleccionar cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->razon_social }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Campo obligatorio.
                        </div>
                    </div>
    
                    <div class="fv-row mb-10">
                        <label class="required fw-semibold fs-6 mb-2">Banco</label>
                        <select class="form-select form-select-solid" id="banco_id" name="banco_id" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Seleccionar banco">
                            <option selected disabled value="">Seleccionar banco</option>
                            @foreach($bancos as $banco)
                                <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                            @endforeach
                        </select>
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

<!--Modal Editar-->
<div class="modal fade" id="kt_modal_updateCuentaGen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <div class="fv-row mb-10">
                        <label class="required fw-semibold fs-6 mb-2">Número de cuenta</label>
                        <input type="text" id="edit_num_cuenta" name="num_cuenta" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value="" required data-parsley-required-message="Este campo es obligatorio" />
                        <div class="invalid-feedback">
                            Campo obligatorio.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_clabe" class="form-label">CLABE</label>
                        <input type="text" class="form-control form-control-solid mb-3 mb-lg-0" id="edit_clabe" name="clabe" required>
                        <div class="invalid-feedback">
                            Campo obligatorio.
                        </div>
                    </div>

                    <div class="fv-row mb-10">
                        <label class="required fw-semibold fs-6 mb-2">Cliente</label>
                        <select class="form-select form-select-solid" id="edit_cliente_id" name="cliente_id" data-control="" data-placeholder="Seleccionar cliente">
                            <option selected disabled value="">Seleccionar cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->razon_social }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Campo obligatorio.
                        </div>
                    </div>

                    <div class="fv-row mb-10">
                        <label class="required fw-semibold fs-6 mb-2">Banco</label>
                        <select class="form-select form-select-solid" id="edit_banco_id" name="banco_id" data-control="select2" data-placeholder="Seleccionar banco">
                            @foreach($bancos as $banco)
                                <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal eliminar cuenta -->
<div class="modal fade" tabindex="-1" id="modal_deleteCuentaGen">
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

<script src="{{ asset('js/cuentas_general.js') }}"></script>
<script src="{{ asset('js/plugins.bundle.js') }}"></script>

@endsection

