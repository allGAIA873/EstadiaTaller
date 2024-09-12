// ------- MODAL EDITAR USUARIO -------//
document.addEventListener('DOMContentLoaded', function () {
    var editButtons = document.querySelectorAll('.dropdown-item[data-bs-target="#kt_modal_editar"]');

    editButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var usuarioId = this.getAttribute('data-id');
            var usuarioNombre = this.getAttribute('data-nombre');
            var usuarioEmail = this.getAttribute('data-email');
            var usuarioUdn = this.getAttribute('data-udn');

            var form = document.querySelector('#kt_modal_editar form');
            form.action = '/usuarios/' + usuarioId;
            document.querySelector('#kt_modal_editar #nombre').value = usuarioNombre;
            document.querySelector('#kt_modal_editar #email').value = usuarioEmail;
            document.querySelector('#kt_modal_editar #udn').value = usuarioUdn;
        });
    });
});


// ------- MODAL ELIMINAR USUARIO -------//
document.addEventListener('DOMContentLoaded', function () {
    var deleteModal = document.getElementById('kt_modal_eliminar');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var usuarioId = button.getAttribute('data-id');
        var form = deleteModal.querySelector('#deleteForm');
        form.action = '/usuarios/' + usuarioId;
        var modalBody = deleteModal.querySelector('.modal-body');
        modalBody.textContent = '¿Estás seguro que deseas eliminar este registro?';
    });
});

// ------- HIDE Y SHOW CONTRASEÑA -------//
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll(".toggle-password").forEach(function (button) {
        button.addEventListener("click", function () {
            let input = document.querySelector(button.getAttribute("toggle"));
            if (input.getAttribute("type") === "password") {
                input.setAttribute("type", "text");
                button.classList.remove("bi-eye");
                button.classList.add("bi-eye-slash");
            } else {
                input.setAttribute("type", "password");
                button.classList.remove("bi-eye-slash");
                button.classList.add("bi-eye");
            }
        });
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