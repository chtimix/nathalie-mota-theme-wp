/**
 * ==========================================
 * Fichier : lightbox.js
 * ==========================================
 *
 * Rôle :
 * Gère l'affichage de la lightbox pour une photo cliquée.
 *
 * Fonctionnalités :
 * - Ouvre la lightbox au clic sur l’icône “plein écran”
 * - Injecte dynamiquement l’image, la référence, la catégorie
 * - Permet la navigation entre les photos visibles
 * - Ferme la lightbox proprement
 */

document.addEventListener('DOMContentLoaded', function () {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = lightbox.querySelector('.lightbox-image');
    const lightboxRef = lightbox.querySelector('.lightbox-ref');
    const lightboxCategory = lightbox.querySelector('.lightbox-category');
    const closeBtn = lightbox.querySelector('.lightbox-close');
    const prevBtn = lightbox.querySelector('.lightbox-prev');
    const nextBtn = lightbox.querySelector('.lightbox-next');
  
    let currentIndex = -1;
    let photoBlocs = [];
  
    /**
     * INITIALISATION
     * - Récupère tous les blocs photo visibles
     * - Attache les événements à chaque icône plein écran
     */
    window.initLightbox = function () {
      photoBlocs = Array.from(document.querySelectorAll('.photo-bloc'));
      photoBlocs.forEach((bloc, index) => {
        const trigger = bloc.querySelector('.lightbox-icon-container');
        if (trigger) {
          trigger.addEventListener('click', () => {
            openLightbox(index);
          });
        }
      });
    }
  
    /**
     * OUVERTURE DE LA LIGHTBOX
     */
    function openLightbox(index) {
      const bloc = photoBlocs[index];
      const img = bloc.querySelector('img');
      const title = bloc.querySelector('.title')?.textContent || '';
      const category = bloc.querySelector('.category')?.textContent || '';
      const ref = bloc.querySelector('.lightbox-icon-container')?.dataset.ref || '';
  
      lightboxImage.src = img.dataset.full || img.src;
      lightboxImage.alt = title;
      lightboxRef.textContent = ref;
      lightboxCategory.textContent = category;
  
      lightbox.classList.add('active');
      lightbox.setAttribute('aria-hidden', 'false');
      currentIndex = index;
    }
  
    /**
     * FERMETURE DE LA LIGHTBOX
     */
    function closeLightbox() {
      lightbox.classList.remove('active');
      lightbox.setAttribute('aria-hidden', 'true');
      currentIndex = -1;
    }
  
    /**
     * NAVIGATION PRÉCÉDENTE / SUIVANTE
     */
    function navigateLightbox(direction) {
      if (currentIndex === -1) return;
      let newIndex = currentIndex + direction;
  
      if (newIndex < 0) newIndex = photoBlocs.length - 1;
      if (newIndex >= photoBlocs.length) newIndex = 0;
  
      openLightbox(newIndex);
    }
  
    // Écouteurs d’événements
    closeBtn.addEventListener('click', closeLightbox);
    prevBtn.addEventListener('click', () => navigateLightbox(-1));
    nextBtn.addEventListener('click', () => navigateLightbox(1));
  
    // Initialiser la lightbox au chargement
    initLightbox();
  });