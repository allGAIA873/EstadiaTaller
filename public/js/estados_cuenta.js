// ------- MODAL DROPFILE CSV -------//
document.querySelector('.btn-primary').addEventListener('click', function() {
    $('#dropfile-modal').modal('show');
});

let dropArea = document.getElementById('drop-area');
let fileElem = document.getElementById('fileElem');
let dropMessage = document.getElementById('drop-message');
let fileSelected = document.getElementById('file-selected');
let fileName = document.getElementById('file-name');
let uploadForm = document.getElementById('uploadForm');
let loadingSpinner = document.getElementById('loading-spinner');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false);
});

dropArea.addEventListener('drop', handleDrop, false);

dropArea.addEventListener('click', () => {
    fileElem.click();
});

fileElem.addEventListener('change', function (e) {
    handleFiles(this.files);
});

uploadForm.addEventListener('submit', function(e) {
    // Mostrar el indicador de carga
    loadingSpinner.style.display = 'block';
    // Ocultar los elementos de selección de archivos
    dropMessage.style.display = 'none';
    fileSelected.style.display = 'none';
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    dropArea.classList.add('highlight');
}

function unhighlight(e) {
    dropArea.classList.remove('highlight');
}

function handleDrop(e) {
    let dt = e.dataTransfer;
    let files = dt.files;
    handleFiles(files);
}

function handleFiles(files) {
    files = [...files];
    if (files.length > 0) {
        let file = files[0];
        fileElem.files = new DataTransfer().files;
        let dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileElem.files = dataTransfer.files;

        previewFile(file);
    }
}

function previewFile(file) {
    dropMessage.style.display = 'none';
    fileSelected.style.display = 'block';
    fileName.textContent = file.name;
}
