//Modal Editar
document.addEventListener('DOMContentLoaded', function () {
  let editModal = document.getElementById('kt_modal_update');

  editModal.addEventListener('show.bs.modal', function (event) {
      let button = event.relatedTarget;
      let clientId = button.getAttribute('data-id');
      let nombre = button.getAttribute('data-nombre');
      let razon_social = button.getAttribute('data-razon_social');
      let rfc = button.getAttribute('data-rfc');
      let unidadNegocios = JSON.parse(button.getAttribute('data-unidad_negocio'));

      let form = editModal.querySelector('#kt_update_form');
      form.action = '/clientes/' + clientId;

      document.getElementById('edit_nombre').value = nombre;
      document.getElementById('edit_razon_social').value = razon_social;
      document.getElementById('edit_rfc').value = rfc;

      let selectUnidades = $('#edit_unidad_negocio');
      selectUnidades.val(unidadNegocios).trigger('change');
  });
});
//Modal Editar 2
document.addEventListener('DOMContentLoaded', function () {
  let editModal2 = document.getElementById('kt_modal_update2');

  editModal2.addEventListener('show.bs.modal', function (event) {
      let button2 = event.relatedTarget;
      let clientId2 = button2.getAttribute('data-id');
      let nombre2 = button2.getAttribute('data-nombre');
      let razonSocial2 = button2.getAttribute('data-razon_social');
      let rfc2 = button2.getAttribute('data-rfc');
      let unidadNegocios2 = JSON.parse(button2.getAttribute('data-unidad_negocios'));

      let form2 = editModal2.querySelector('#kt_docs_formvalidation_text');
      form2.action = `/clientes/${clientId2}/detalle/${cuentaId}`;

      document.getElementById('edit_nombre2').value = nombre2;
      document.getElementById('edit_razon_social2').value = razonSocial2;
      document.getElementById('edit_rfc2').value = rfc2;

      let selectUnidades2 = $('#edit_unidad_negocio2');
      selectUnidades2.val(unidadNegocios2).trigger('change');
  });
});

//Modal Borrar
document.addEventListener('DOMContentLoaded', function () {
    let deleteModal = document.getElementById('modal_delete');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let clientId = button.getAttribute('data-id');
        let form = deleteModal.querySelector('#deleteForm');
        form.action = '/clientes/' + clientId;
        let modalBody = deleteModal.querySelector('.modal-body');
        modalBody.textContent = '¿Estás seguro que deseas eliminar este registro?';
    });
});

//Validación
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'
      
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')
      
        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
          form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
      
            form.classList.add('was-validated')
          }, false)
        })
      })()