document.addEventListener('DOMContentLoaded', function () {
    let editModalCuenta = document.getElementById('kt_modal_updateCuentaGen');
    editModalCuenta.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let cuentaId = button.getAttribute('data-cuenta-id');
        let banco_id = button.getAttribute('data-banco-id');
        let num_cuenta = button.getAttribute('data-num_cuenta');
        let clabe = button.getAttribute('data-clabe');
        let cliente_id = button.getAttribute('data-cliente-id');

        let form = editModalCuenta.querySelector('#kt_update_form');
        form.action = `/cuentas-bancarias/` + cuentaId;

        // Asignar valores
        document.getElementById('edit_banco_id').value = banco_id || '';
        document.getElementById('edit_num_cuenta').value = num_cuenta || '';
        document.getElementById('edit_clabe').value = clabe || '';
        document.getElementById('edit_cliente_id').value = cliente_id || '';

        // Inicializar select2
        $('#edit_banco_id').select2({
            dropdownParent: $('#kt_modal_updateCuentaGen')
        }).trigger('change');

        $('#edit_cliente_id').select2({
            dropdownParent: $('#kt_modal_updateCuentaGen')
        }).trigger('change');
    });
});

//Borrar cuenta vista general
document.addEventListener('DOMContentLoaded', function() {
    let deleteCuentaModal = document.getElementById('modal_deleteCuentaGen');
    deleteCuentaModal.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let cuentaId = button.getAttribute('data-id');
        let clienteId = button.getAttribute('data-cliente-id');
        let action = `/cuentas-bancarias/` + cuentaId;

        let form = deleteCuentaModal.querySelector('#formDelete');
        form.action = action;
    });
});

document.addEventListener('DOMContentLoaded', function() {
  $('#banco_id').select2({
      dropdownParent: $('#kt_modal_1'),
      placeholder: "Seleccionar banco"
  });

  (() => {
      'use strict'
      
      const forms = document.querySelectorAll('.needs-validation')
      
      Array.from(forms).forEach(form => {
          form.addEventListener('submit', event => {
              const selectBanco = $('#banco_id');
              if (selectBanco.val() === null || selectBanco.val() === "") {
                  event.preventDefault();
                  event.stopPropagation();
                  selectBanco.addClass('is-invalid');
              } else {
                  selectBanco.removeClass('is-invalid');
              }

              if (!form.checkValidity()) {
                  event.preventDefault();
                  event.stopPropagation();
              }

              form.classList.add('was-validated');
          }, false);
      });
  })();
});
