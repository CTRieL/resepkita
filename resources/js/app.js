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

    // Like button AJAX
    document.querySelectorAll('.like-btn').forEach(btn => {
        
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            const recipeId = this.dataset.recipeId;
            const type = this.dataset.type;
            fetch(`/recipe/${recipeId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ type })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update all like counts
                    ['thumbs_up','love','tasty'].forEach(t => {
                        const countSpan = document.querySelector(`#like-count-${t}-${recipeId}`);
                        if (countSpan && data.like_counts && typeof data.like_counts[t] !== 'undefined') {
                            countSpan.textContent = data.like_counts[t];
                        }
                    });
                    // Update button states
                    document.querySelectorAll(`.like-btn[data-recipe-id='${recipeId}']`).forEach(b => {
                        const isLiked = b.dataset.type === data.liked_type;
                        b.classList.toggle('liked', isLiked);
                    });
                }
            });
        });
    });
}