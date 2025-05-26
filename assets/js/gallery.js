/**
 * ==========================================
 * Fichier : gallery.js
 * ==========================================
 *
 * Rôle :
 * Gère la galerie photo de la page d’accueil, incluant :
 * - Les filtres personnalisés (catégorie, format, tri)
 * - Le bouton "Charger plus" pour la pagination
 * - Les appels à l’API REST personnalisée WordPress
 *
 * Fonctionnalités :
 * - Ouverture/fermeture des menus custom
 * - Sélection des filtres et mise à jour dynamique de la galerie
 * - Requête REST dynamique avec fetch()
 * - Insertion du HTML retourné
 * - Synchronisation complète avec le bouton de pagination
 */

document.addEventListener('DOMContentLoaded', function () {
    const gallery = document.querySelector('.gallery');
    const galleryContainer = document.querySelector('.gallery-container');
    const loadMoreBtn = document.getElementById('load-more');
    let currentPage = 1;
    let currentFilters = {}; // synchronisé à chaque action utilisateur
  
    /**
     * OUVERTURE / FERMETURE DES MENUS DE FILTRE
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
  
    document.addEventListener('click', () => {
      customSelects.forEach(select => select.classList.remove('open'));
    });
  
    /**
     * GESTION DE LA SÉLECTION DES FILTRES
     */
    customSelects.forEach(select => {
      const trigger = select.querySelector('.custom-select-trigger');
      const options = select.querySelectorAll('.custom-option');
  
      options.forEach(option => {
        option.addEventListener('click', function (e) {
          e.stopPropagation();
  
          // Visuel du select
          trigger.textContent = this.textContent;
          select.setAttribute('data-selected', this.dataset.value);
          options.forEach(o => o.classList.remove('selected'));
          this.classList.add('selected');
          select.classList.remove('open');
  
          // Mise à jour des filtres actifs
          currentFilters = {};
          document.querySelectorAll('.custom-select').forEach(f => {
            currentFilters[f.dataset.name] = f.dataset.selected || '';
          });
  
          // Rechargement page 1 avec les filtres
          currentPage = 1;
          if (loadMoreBtn) loadMoreBtn.dataset.page = '1';
  
          fetchPhotos(1, currentFilters);
        });
      });
    });
  
    /**
     * GESTION DU CLIC SUR "CHARGER PLUS"
     */
    if (loadMoreBtn) {
      loadMoreBtn.addEventListener('click', function (e) {
        e.preventDefault();
        fetchPhotos(currentPage + 1, currentFilters);
      });
    }
  
    /**
     * FONCTION CENTRALE : FETCH + RENDU
     */
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
          if (page === 1) {
            galleryContainer.innerHTML = data.html;
          } else {
            galleryContainer.insertAdjacentHTML('beforeend', data.html);
          }

          // Réinitialise la lightbox sur les nouvelles photos chargées
          if (typeof initLightbox === 'function') {
            initLightbox();
          }
  
          currentPage = page;
          if (loadMoreBtn) {
            loadMoreBtn.dataset.page = currentPage;
            loadMoreBtn.dataset.maxPage = data.max_pages;
            loadMoreBtn.disabled = false;
            loadMoreBtn.textContent = 'Charger plus';
            loadMoreBtn.style.display = currentPage >= data.max_pages ? 'none' : 'block';
          }
        })
        .catch(error => {
          console.error('Erreur REST :', error);
          if (loadMoreBtn) {
            loadMoreBtn.disabled = false;
            loadMoreBtn.textContent = 'Charger plus';
          }
        });
    }
  });
  