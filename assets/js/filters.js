// Fichier : filters.js
document.addEventListener('DOMContentLoaded', function () {
  const gallery = document.querySelector('.gallery');
  const galleryContainer = document.querySelector('.gallery-container');
  const loadMoreBtn = document.getElementById('load-more');
  let currentPage = 1;

  /**
   * Gère l'ouverture / fermeture des menus déroulants de filtre.
   */
  const customSelects = document.querySelectorAll('.custom-select');

  customSelects.forEach(select => {
    const trigger = select.querySelector('.custom-select-trigger');

    trigger.addEventListener('click', function (e) {
      e.stopPropagation();
      const isOpen = select.classList.contains('open');
      customSelects.forEach(s => s.classList.remove('open'));
      if (!isOpen) select.classList.add('open');
    });
  });

  // Ferme tous les menus si on clique ailleurs dans le document
  document.addEventListener('click', () => {
    customSelects.forEach(select => select.classList.remove('open'));
  });

  /**
   * Gère la sélection d'une option dans un menu.
   */
  customSelects.forEach(select => {
    const trigger = select.querySelector('.custom-select-trigger');
    const options = select.querySelectorAll('.custom-option');

    options.forEach(option => {
      option.addEventListener('click', function (e) {
        e.stopPropagation();

        // Met à jour le label et l'état du menu
        trigger.textContent = this.textContent;
        select.setAttribute('data-selected', this.dataset.value);
        options.forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');
        select.classList.remove('open');

        // Construit l'objet des filtres actifs
        const filters = {};
        document.querySelectorAll('.custom-select').forEach(f => {
          filters[f.dataset.name] = f.dataset.selected || '';
        });

        // Met à jour les filtres dans la galerie pour synchroniser le bouton "Charger plus"
        gallery.dataset.filters = JSON.stringify(filters);

        // Réinitialise la pagination
        currentPage = 1;
        if (loadMoreBtn) {
          loadMoreBtn.dataset.page = '1';
        }

        // Appel de l’API REST
        const url = new URL('/wp-json/nathalie/v1/photos', window.location.origin);
        url.searchParams.set('page', 1);
        Object.entries(filters).forEach(([key, value]) => {
          url.searchParams.set(key, value);
        });

        if (loadMoreBtn) {
          loadMoreBtn.disabled = true;
          loadMoreBtn.textContent = 'Chargement...';
        }

        fetch(url.toString())
          .then(response => response.json())
          .then(result => {
            galleryContainer.innerHTML = result.html;

            if (loadMoreBtn) {
              loadMoreBtn.dataset.maxPage = result.max_pages;
              loadMoreBtn.style.display = result.max_pages > 1 ? 'block' : 'none';
              loadMoreBtn.disabled = false;
              loadMoreBtn.textContent = 'Charger plus';
            }
          })
          .catch(error => {
            console.error('Erreur REST (filtres) :', error);
            if (loadMoreBtn) {
              loadMoreBtn.disabled = false;
              loadMoreBtn.textContent = 'Charger plus';
            }
          });
      });
    });
  });
});