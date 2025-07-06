// Like button AJAX and infinite scroll for dashboard

document.addEventListener('DOMContentLoaded', function() {

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
