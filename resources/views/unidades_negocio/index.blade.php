@extends('admin-layout')
@section('title', 'Unidades de negocio')
@section('subtitle')
    <div class="d-flex justify-content-between align-items-center">
        <p class="fs-1 text fw-bold">Unidades de negocio<span class="text-body-secondary m-5">({{ $count }})</span>
        </p>
    </div>
@endsection
@section('content')
    <div class="mb-3 mt-3">
        <div class="d-flex justify-content-end">
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_agregar" style="margin-right: 3%; display: flex; align-items: center">
                <i class="bi bi-plus" style="margin-right: 8px"></i>
                Agregar
            </a>
        </div>
        <div class="container">
            <div class="row row-cols-4 justify-content-start">
                @foreach ($udn as $udn_)
                    <div class="col">
                        <div class="card text-center mt-4 mb-4">
                            <div class="card-body">
                                <div>
                                    <h3 class="card-title fs-2 text fw-bold pt-5 pb-5">
                                        {{ $udn_->area }}
                                    </h3>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="d-flex">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_editar" data-udnId="{{ $udn_->id }}"
                                                    data-area="{{ $udn_->area }}">
                                                    <i class="fas fa-edit me-2"></i>Editar
                                                </a>
                                            </li>
                                            <li class="d-flex">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_eliminar" data-udnId="{{ $udn_->id }}"><i
                                                        class="fas fa-trash-alt me-2"></i>Eliminar</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- MODAL AGREGAR -->
        <div class="modal fade" tabindex="-1" id="kt_modal_agregar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-2 fw-bold">Agregar</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="" id="addForm">
                            @csrf
                            <div>
                                <label for="area" class="required form-label">Nombre</label>
                                <input type="text" id="area" name="area" class="form-control form-control-solid"
                                    value="" placeholder="Nombre de la unidad de negocio" />
                                <span class="text-danger" id="addError" style="display:none;">El campo se encuentra
                                    vacío</span>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-primary" form="addForm">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL EDITAR -->
        <div class="modal fade" tabindex="-1" id="kt_modal_editar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-2 fw-bold">Editar</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="" id="editForm">
                            @method('PUT')
                            @csrf
                            <div>
                                <label for="edit_area" class="required form-label">Nombre</label>
                                <input type="text" id="edit_area" name="area" class="form-control form-control-solid"
                                    value="" placeholder="Nombre de la unidad de negocio" />
                                <span class="text-danger" id="editError" style="display:none;">El campo se encuentra
                                    vacío</span>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-primary" form="editForm">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL ELIMINAR -->
        <div class="modal fade" tabindex="-1" id="kt_modal_eliminar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-2 fw-bold" id="exampleModalLabel">Eliminar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro que deseas eliminar esta unidad de negocio?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <form id="deleteForm" method="POST" action="">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="{{ asset('js/unidades_negocio.js') }}"></script>
@endsection
