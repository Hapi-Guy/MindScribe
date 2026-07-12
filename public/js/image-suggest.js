// Suggest a cover image via AJAX. Uses fetch + async/await + try/catch, and
// updates only the preview <img> without reloading the page.

const suggestBtn = document.getElementById('suggestCoverBtn');

if (suggestBtn) {
    suggestBtn.addEventListener('click', async function () {
        const preview = document.getElementById('coverPreview');
        const titleInput = document.getElementById('title');
        const url = suggestBtn.dataset.url;
        const query = titleInput ? titleInput.value.trim() : '';

        if (!query) {
            alert('Please type a title first to use as the search term.');
            return;
        }

        const originalText = suggestBtn.textContent;
        suggestBtn.disabled = true;
        suggestBtn.textContent = 'Loading...';

        try {
            const response = await fetch(url + '?query=' + encodeURIComponent(query), {
                headers: { 'Accept': 'application/json' },
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Request failed.');
            }

            preview.src = data.url;
            preview.classList.remove('hidden');
        } catch (error) {
            preview.classList.add('hidden');
            alert(error.message);
        } finally {
            suggestBtn.disabled = false;
            suggestBtn.textContent = originalText;
        }
    });
}
