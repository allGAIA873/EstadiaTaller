// ------- MODAL EDITAR UNIDAD DE NEGOCIO ------- //
document.addEventListener('DOMContentLoaded', function() {
    var editButtons = document.querySelectorAll('.dropdown-item[data-bs-target="#kt_modal_editar"]');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var unidadnegocioId = this.getAttribute('data-udnId');
            var unidadnegocioArea = this.getAttribute('data-area');

            var form = document.querySelector('#kt_modal_editar form');
            form.action = '/unidadesnegocio/' + unidadnegocioId;
            document.querySelector('#edit_area').value = unidadnegocioArea;
        });
    });
});

// ------- MODAL ELIMINAR UNIDAD DE NEGOCIO ------- //
document.addEventListener('DOMContentLoaded', function () {
    var deleteModal = document.getElementById('kt_modal_eliminar');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var unidadnegocioId = button.getAttribute('data-udnId');
        var form = deleteModal.querySelector('#deleteForm');
        form.action = '/unidadesnegocio/' + unidadnegocioId;
        var modalBody = deleteModal.querySelector('.modal-body');
        modalBody.textContent = '¿Estás seguro que deseas eliminar esta unidad de negocio?';
    });
});

// ------- MENSAJE "CAMPO VACÍO" EN MODALS UNIDADES DE NEGOCIO ------- //
document.getElementById('addForm').addEventListener('submit', function(event) {
    const area = document.getElementById('area').value.trim();
    const error = document.getElementById('addError');
    if (area === '') {
        event.preventDefault();
        error.style.display = 'block';
    } else {
        error.style.display = 'none';
    }
});

document.getElementById('editForm').addEventListener('submit', function(event) {
    const area = document.getElementById('edit_area').value.trim();
    const error = document.getElementById('editError');
    if (area === '') {
        event.preventDefault();
        error.style.display = 'block';
    } else {
        error.style.display = 'none';
    }
});
