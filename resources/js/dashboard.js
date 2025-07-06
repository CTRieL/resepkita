// Like button AJAX and infinite scroll for dashboard

document.addEventListener('DOMContentLoaded', function() {
    // Like button AJAX
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
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

    // Infinite scroll
    let loading = false;
    let nextPageUrl = document.querySelector('#next-page-url')?.value;
    window.addEventListener('scroll', function() {
        if (!nextPageUrl || loading) return;
        if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 300)) {
            loading = true;
            fetch(nextPageUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newCards = doc.querySelectorAll('.recipe-card');
                    const container = document.querySelector('#recipe-container');
                    newCards.forEach(card => container.appendChild(card));
                    // Update next page url
                    const newNext = doc.querySelector('#next-page-url');
                    nextPageUrl = newNext ? newNext.value : null;
                    loading = false;
                });
        }
    });
});
