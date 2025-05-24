// Fichier : load-more.js
document.addEventListener('DOMContentLoaded', function () {
  const gallery = document.querySelector('.gallery');
  const galleryContainer = document.querySelector('.gallery-container');
  const loadMoreBtn = document.getElementById('load-more');
  let currentPage = 1;

  function getStoredFilters() {
    try {
      return gallery.dataset.filters ? JSON.parse(gallery.dataset.filters) : {};
    } catch (err) {
      console.warn('Erreur parsing des filtres :', err);
      return {};
    }
  }

  function fetchPhotos(page = 1, filters = {}) {
    const url = new URL('/wp-json/nathalie/v1/photos', window.location.origin);
    url.searchParams.set('page', page);
    Object.entries(filters).forEach(([key, value]) => {
      url.searchParams.set(key, value);
    });

    if (loadMoreBtn) {
      loadMoreBtn.disabled = true;
      loadMoreBtn.textContent = 'Chargement...';
    }

    fetch(url.toString())
      .then(response => response.json())
      .then(data => {
        galleryContainer.insertAdjacentHTML('beforeend', data.html);

        currentPage = page;
        const maxPage = data.max_pages;

        if (loadMoreBtn) {
          loadMoreBtn.dataset.page = currentPage;
          loadMoreBtn.dataset.maxPage = maxPage;
          loadMoreBtn.disabled = false;
          loadMoreBtn.textContent = 'Charger plus';

          if (currentPage >= maxPage) {
            loadMoreBtn.style.display = 'none';
          }
        }
      })
      .catch(error => {
        console.error('Erreur lors du chargement Ajax :', error);
        if (loadMoreBtn) {
          loadMoreBtn.disabled = false;
          loadMoreBtn.textContent = 'Charger plus';
        }
      });
  }

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function (e) {
      e.preventDefault();
      const filters = getStoredFilters(); // 🔁 récupère les filtres depuis dataset
      fetchPhotos(currentPage + 1, filters);
    });
  }
});