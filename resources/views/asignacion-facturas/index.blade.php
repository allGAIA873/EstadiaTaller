@extends('admin-layout')
@section('title', 'Asignación de facturas')

@section('subtitle')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="ms-auto fs-1 fw-bold" style=""> Asignación de facturas </div>
    </div>
@endsection
@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">
                <div>Movimientos</div>
            </h3>
        </div>
        <div class="card-body">
            <!--Tabla-->
            <div>
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 text-center align-middle">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-100">
                                <th>Cuenta</th>
                                <th>Concepto</th>
                                <th>Depósito</th>
                                <th>Retiro</th>
                                <th>Detallado</th>
                                <th>Folio</th>
                                <th>Tipo de factura</th>
                                <th>Complemento de pago</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($facturas as $factura)
                                <tr>
                                    <td>{{ $factura->cuentasBancarias?->num_cuenta ?? 'No encontrado' }}</td>
                                    <td>{{ $factura->concepto ?? 'No encontrado' }}</td>
                                    <td class="text-success">{{ $factura->deposito }}</td>
                                    <td class="text-danger">{{ $factura->retiro }}</td>
                                    <td class="fs-8">{{ $factura->detalle ?? 'No encontrado' }}</td>
                                    <td>{{ $factura->folio }}</td>
                                    <td>{{ $factura->tipo_factura }}</td>
                                    <td>{{ $factura->complemento_pago }}</td>
                                    <td>
                                        @if ($factura->tipo_factura)
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#editFacturaModal_{{ $factura->id }}">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No se encontraron facturas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR PPD/PUE -->
    @foreach ($facturas as $factura)
        @if ($factura->tipo_factura)
            <div class="modal fade" id="editFacturaModal_{{ $factura->id }}" tabindex="-1"
                aria-labelledby="editFacturaLabel_{{ $factura->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('asignacion-facturas.update', $factura->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editFacturaLabel_{{ $factura->id }}">Editar Factura</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tipo_factura_{{ $factura->id }}" class="form-label">Tipo de
                                        factura</label>
                                    <select class="form-select form-select-solid" id="tipo_factura_{{ $factura->id }}"
                                        name="tipo_factura">
                                        <option value="PPD" {{ $factura->tipo_factura == 'PPD' ? 'selected' : '' }}>PPD
                                        </option>
                                        <option value="PUE" {{ $factura->tipo_factura == 'PUE' ? 'selected' : '' }}>PUE
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3" id="complemento_pago_container_{{ $factura->id }}"
                                    style="{{ $factura->tipo_factura == 'PUE' ? 'display:none;' : '' }}">
                                    <label for="complemento_pago_{{ $factura->id }}" class="form-label">Complemento de
                                        pago</label>
                                    <input type="text" class="form-control form-control-solid"
                                        id="complemento_pago_{{ $factura->id }}" name="complemento_pago"
                                        value="{{ $factura->complemento_pago }}" required>
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
        @endif
    @endforeach


    <!-- PAGINACIÓN  -->
    <div class="d-flex justify-content-center mt-4">
        {{ $facturas->links('pagination::bootstrap-4') }}
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('js/facturas.js') }}"></script>
@endsection
