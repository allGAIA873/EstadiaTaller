@extends('admin-layout')
@section('title', 'Usuarios')
@section('css')
    <style>
        .foo {
            color: red;
        }
    </style>
@endsection
@section('subtitle')
    <div class="d-flex justify-content-between align-items-center">
        <p class="fs-1 text fw-bold">Usuarios</p>
    </div>
@endsection
@section('content')
    <div class="mb-3 mt-3">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title">
                    <form action="{{ url('usuarios') }}" method="GET">
                        <div class="input-group rounded">
                            <input type="search" class="form-control form-control-solid" name="search"
                                placeholder="Buscar usuario" aria-label="Search" aria-describedby="search-addon" />
                            <span class="input-group-text border-0" id="search-addon">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-primary" href="#" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_agregar">
                        <i class="bi bi-person-plus-fill" style="margin-right: 8px"></i>
                        Agregar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <!-- Alertas de validación -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <table class="table table-responsive table-row-dashed table-row-gray-300">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Unidad de negocio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td class="align-middle">{{ $usuario->nombre }}</td>
                                    <td class="align-middle">{{ $usuario->email }}</td>
                                    <td class="align-middle">{{ $usuario->unidad->area }}</td>
                                    <td class="align-middle">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Acciones
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li class="d-flex">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_editar" data-id="{{ $usuario->id }}"
                                                        data-nombre="{{ $usuario->nombre }}"
                                                        data-email="{{ $usuario->email }}" data-udn="{{ $usuario->udn }}">
                                                        <i class="fas fa-edit me-2"></i>Editar
                                                    </a>
                                                </li>
                                                <li class="d-flex">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_eliminar" data-id="{{ $usuario->id }}"><i
                                                            class="fas fa-trash-alt me-2"></i>Eliminar</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- MODAL AGREGAR -->
                    <div class="modal fade" tabindex="-1" id="kt_modal_agregar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title fs-2 fw-bold">Agregar</h3>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </div>
                                </div>

                                <div class="modal-body">
                                    <form method="POST" action="" id="addForm"  class="form needs-validation" novalidate>
                                        @csrf
                                        <div>
                                            <label for="nombre" class="required form-label">Nombre completo</label>
                                            <input type="text" id="nombre" name="nombre"
                                                class="form-control form-control-solid" value=""
                                                placeholder="Nombre completo" required />
                                                <div class="invalid-feedback">
                                                    Campo obligatorio.
                                                </div>
                                        </div>
                                        <div>
                                            <label for="email" class="required form-label">Email</label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-solid" value=""
                                                placeholder="Email (Correo electrónico)" required />
                                                <div class="invalid-feedback">
                                                    Campo obligatorio.
                                                </div>
                                        </div>
                                        <div>
                                            <label for="udn" class="required form-label">Unidad de negocio</label>
                                            <select class="form-select form-select-solid" name="udn" id="udn"
                                                data-control="" data-placeholder="Selecciona una unidad de negocio"
                                                required>
                                                <option selected disabled value="">Selecciona una unidad de negocio</option>
                                                @foreach ($unidades as $unidad)
                                                    <option value="{{ $unidad->id }}"> {{ $unidad->area }} </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Campo obligatorio.
                                            </div>
                                        </div>
                                        <div>
                                            <label for="password" class="required form-label">Contraseña</label>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password"
                                                    class="form-control form-control-solid" value=""
                                                    placeholder="De 5 a 20 caracteres de longitud" required />
                                                <button class="btn btn-outline-dark toggle-password bi bi-eye"
                                                    type="button" toggle="#password"></button>
                                                    <div class="invalid-feedback">
                                                        Campo obligatorio.
                                                    </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="password_confirmation" class="required form-label">Repetir
                                                Contraseña</label>
                                            <div class="input-group">
                                                <input type="password" id="password_confirmation"
                                                    name="password_confirmation" class="form-control form-control-solid"
                                                    value="" placeholder="Repite la contraseña" required />
                                                <button class="btn btn-outline-dark toggle-password bi bi-eye"
                                                    type="button" toggle="#password_confirmation"></button>
                                                    <div class="invalid-feedback">
                                                        Campo obligatorio.
                                                    </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" id="btnGuardar" class="btn btn-primary"
                                        form="addForm">Guardar</button>
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
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </div>
                                </div>

                                <div class="modal-body">
                                    <form method="POST" action="" id="editForm" class="form needs-validation" novalidate>
                                        @method('PUT')
                                        @csrf
                                        <div>
                                            <label for="nombre" class="required form-label">Nombre completo</label>
                                            <input type="text" id="nombre" name="nombre"
                                                class="form-control form-control-solid" value=""
                                                placeholder="Nombre completo" required/>
                                                <div class="invalid-feedback">
                                                    Campo obligatorio.
                                                </div>
                                        </div>
                                        <div>
                                            <label for="email" class="required form-label">Email</label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-solid" value=""
                                                placeholder="Email (Correo electrónico)" required/>
                                                <div class="invalid-feedback">
                                                    Campo obligatorio.
                                                </div>
                                        </div>
                                        
                                        <div>
                                            <label for="udn" class="required form-label">Unidad de negocio</label>
                                            <select class="form-select form-select-solid" name="udn" id="udn"
                                                data-control="" data-placeholder="Selecciona una unidad de negocio"
                                                required>
                                                <option selected disabled value="">Selecciona una unidad de negocio</option>
                                                @foreach ($unidades as $unidad)
                                                    <option value="{{ $unidad->id }}"> {{ $unidad->area }} </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Campo obligatorio.
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="password" class="form-label">Contraseña (opcional)</label>
                                            <div class="input-group">
                                                <input type="password" id="password_edit" name="password"
                                                    class="form-control form-control-solid" value=""
                                                    placeholder="De 5 a 20 caracteres de longitud"/>
                                                <button class="btn btn-outline-dark toggle-password bi bi-eye"
                                                    type="button" toggle="#password_edit"></button>
                                        </div>
                                        <div>
                                            <label for="password_confirmation" class="form-label">Repetir Contraseña
                                                (opcional)</label>
                                            <div class="input-group">
                                                <input type="password" id="password_confirmation_edit"
                                                    name="password_confirmation" class="form-control form-control-solid"
                                                    value="" placeholder="Repite la contraseña"/>
                                                <button class="btn btn-outline-dark toggle-password bi bi-eye"
                                                    type="button" toggle="#password_confirmation_edit"></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" id="btnGuardar" class="btn btn-primary"
                                        form="editForm">Guardar</button>
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro que deseas eliminar este usuario?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <form id="deleteForm" method="POST" action="">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $usuarios->links('pagination::bootstrap-4') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/usuarios.js') }}"></script>

@endsection
