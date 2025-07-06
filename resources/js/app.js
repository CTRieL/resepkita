import './bootstrap';

// Drag & drop + preview
const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('file-upload');
const preview = document.getElementById('photo-preview');

if (dropArea && fileInput && preview) {
    // Highlight on drag    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.add('bg-primary/10');
        });
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.remove('bg-primary/10');
        });
    });
    // Handle drop
    dropArea.addEventListener('drop', e => {
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            fileInput.files = e.dataTransfer.files;
            showPreview(fileInput.files[0]);
        }
    });
    // Handle file input change
    fileInput.addEventListener('change', e => {
        if (fileInput.files && fileInput.files[0]) {
            showPreview(fileInput.files[0]);
        }
    });
    function showPreview(file) {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="mx-auto rounded-lg object-cover max-h-64 max-w-64 border border-gray-200" />`;
        };
        reader.readAsDataURL(file);
    }

}