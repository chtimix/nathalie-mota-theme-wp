// Script pour le bouton "Charger plus" dans la galerie : écoute du clic et appel Ajax
document.addEventListener('DOMContentLoaded', function () {
  const galleryContainer = document.querySelector('.gallery-container');
  const gallerySection = document.querySelector('.gallery');

  // Écoute le bouton "Charger plus"
  document.addEventListener('click', function (e) {
    const loadMoreBtn = e.target.closest('#load-more');
    if (!loadMoreBtn) return;

    const currentPage = parseInt(loadMoreBtn.dataset.page);
    const maxPage = parseInt(loadMoreBtn.dataset.maxPage);
    const nextPage = currentPage + 1;

    // Filtres actifs (stockés dans data-filters du container)
    let filters = {};
    if (gallerySection?.dataset.filters) {
      try {
        filters = JSON.parse(gallerySection.dataset.filters);
      } catch (err) {
        console.warn('Erreur parsing des filtres :', err);
      }
    }

    loadMoreBtn.disabled = true;
    loadMoreBtn.textContent = 'Chargement...';

    // Construction de l’URL
    const url = new URL(nathalie_ajax.ajaxurl);
    url.searchParams.set('action', 'load_more_photos');
    url.searchParams.set('nonce', nathalie_ajax.nonce);
    url.searchParams.set('page', nextPage);

    // Ajout des filtres actifs
    Object.entries(filters).forEach(([key, value]) => {
      url.searchParams.set(key, value);
    });

    fetch(url.toString())
      .then(response => response.text())
      .then(data => {
        galleryContainer.insertAdjacentHTML('beforeend', data);
        loadMoreBtn.dataset.page = nextPage;
        loadMoreBtn.disabled = false;
        loadMoreBtn.textContent = 'Charger plus';

        if (nextPage >= maxPage) {
          loadMoreBtn.style.display = 'none';
        }
      })
      .catch(error => {
        console.error('Erreur lors du chargement :', error);
        loadMoreBtn.disabled = false;
        loadMoreBtn.textContent = 'Charger plus';
      });
  });
});