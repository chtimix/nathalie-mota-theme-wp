document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('lightbox-overlay');
    const lightboxImg = document.getElementById('lightbox-image');
    const closeBtn = document.querySelector('.lightbox-close');
    const prevBtn = document.querySelector('.lightbox-prev');
    const nextBtn = document.querySelector('.lightbox-next');
    const categoryLabel = document.querySelector('.lightbox-category');
    const referenceLabel = document.querySelector('.lightbox-reference');
  
    let currentIndex = 0;
    let images = [];
  
    function openLightbox(index) {
      const img = images[index];
      lightboxImg.src = img.dataset.full;
      lightboxImg.alt = img.alt;
      categoryLabel.textContent = img.dataset.category;
      referenceLabel.textContent = img.dataset.reference;
      overlay.style.display = 'flex';
      overlay.setAttribute('aria-hidden', 'false');
      currentIndex = index;
    }
  
    function closeLightbox() {
      overlay.style.display = 'none';
      overlay.setAttribute('aria-hidden', 'true');
    }
  
    function showNext() {
      if (currentIndex < images.length - 1) {
        openLightbox(currentIndex + 1);
      }
    }
  
    function showPrev() {
      if (currentIndex > 0) {
        openLightbox(currentIndex - 1);
      }
    }
  
    // Ajout des événements
    closeBtn.addEventListener('click', closeLightbox);
    nextBtn.addEventListener('click', showNext);
    prevBtn.addEventListener('click', showPrev);
  
    // Initialisation des déclencheurs
    images = document.querySelectorAll('.gallery-item img[data-full]');
    images.forEach((img, index) => {
      const trigger = img.closest('.gallery-item').querySelector('.fullscreen-icon');
      if (trigger) {
        trigger.addEventListener('click', function () {
          openLightbox(index);
        });
      }
    });
  });