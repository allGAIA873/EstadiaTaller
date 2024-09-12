//Editar cuenta
document.addEventListener('DOMContentLoaded', function () {
    let editModalCuenta = document.getElementById('kt_modal_updateCuenta');

    editModalCuenta.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let clientId = button.getAttribute('data-id');
        let cuentaId = button.getAttribute('data-cuenta-id');
        let banco_id = button.getAttribute('data-banco');
        let num_cuenta = button.getAttribute('data-num_cuenta');
        let clabe = button.getAttribute('data-clabe');

        let form = editModalCuenta.querySelector('#kt_update_form');
        form.action = `/clientes/${clientId}/detalle/${cuentaId}`;

        // Asignar valores y volver a inicializar select2
        $('#edit_banco').val(banco_id).trigger('change');
        document.getElementById('edit_num_cuenta').value = num_cuenta || '';
        document.getElementById('edit_clabe').value = clabe || '';
    });

    // Inicializar select2 cuando el modal se muestra completamente
    editModalCuenta.addEventListener('shown.bs.modal', function () {
        $('#edit_banco').select2({
            dropdownParent: $('#kt_modal_updateCuenta')
        });
    });
});
//Borrar cuenta
document.addEventListener('DOMContentLoaded', function() {
    let deleteCuentaModal = document.getElementById('modal_deleteCuenta');
    deleteCuentaModal.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let cuentaId = button.getAttribute('data-id');
        let clienteId = button.getAttribute('data-cliente-id');
        let action = `/clientes/${clienteId}/detalle/${cuentaId}`;

        let form = deleteCuentaModal.querySelector('#formDelete');
        form.action = action;
    });
});
