// ------- MODAL EDITAR UNIDAD DE NEGOCIO ------- //
document.addEventListener("DOMContentLoaded", function() {
    // Evento al abrir el modal
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Botón que activó el modal
        const id = button.getAttribute('data-id');
        const tipoFactura = button.getAttribute('data-tipo_factura');
        const complementoPago = button.getAttribute('data-complemento_pago');

        // Setear los valores en el modal
        const modalForm = document.getElementById('editFacturaForm');
        modalForm.action = `{{ route('asignacion-facturas.update', '') }}/${id}`;

        const tipoFacturaSelect = document.getElementById('tipo_factura');
        tipoFacturaSelect.value = tipoFactura;

        const complementoPagoContainer = document.getElementById('complemento_pago_container');
        const complementoPagoInput = document.getElementById('complemento_pago');
        complementoPagoInput.value = complementoPago;

        // Mostrar u ocultar el campo "Complemento de pago"
        if (tipoFactura === 'PPD') {
            complementoPagoContainer.style.display = 'block';
            complementoPagoInput.required = true;
        } else {
            complementoPagoContainer.style.display = 'none';
            complementoPagoInput.required = false;
        }
    });

    // Evento al cambiar el select de "Tipo de factura"
    const tipoFacturaSelect = document.getElementById('tipo_factura');
    tipoFacturaSelect.addEventListener('change', function() {
        const complementoPagoContainer = document.getElementById('complemento_pago_container');
        const complementoPagoInput = document.getElementById('complemento_pago');

        if (this.value === 'PPD') {
            complementoPagoContainer.style.display = 'block';
            complementoPagoInput.required = true;
        } else {
            complementoPagoContainer.style.display = 'none';
            complementoPagoInput.required = false;
        }
    });
});
