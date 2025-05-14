// Ouverture et fermeture PopUp Contact
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.querySelector('.modal-contact-overlay');
    const closeBtn = document.querySelector('.modal-close');
    const openBtn = document.querySelectorAll('.open-modal-contact');
  
    openBtn.forEach(btn =>
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        modal.classList.add('visible'); // affichage immédiat
        requestAnimationFrame(() => { // petite pause pour permettre à l'affichage de s'effectuer
          modal.classList.add('active'); // déclenche le fondu CSS
          document.body.style.overflow = 'hidden';
        });
      })
    );
  
    closeBtn.addEventListener('click', () => {
      modal.classList.remove('active'); // démarre le fade-out
      document.body.style.overflow = 'auto';
  
      // attendre la fin de la transition avant de cacher
      setTimeout(() => {
        modal.classList.remove('visible'); // repasse display: none
      }, 300); // même durée que la transition CSS
    });
  });
  
  // Affichage de la photo miniature dans la navigation single-photo.php
  jQuery(document).ready(function ($) {
    const $photoPreview = $('.photo-preview');
    const originalImg = $photoPreview.data('current-thumbnail');
  
    // Injection initiale de l'image courante
    $photoPreview.html(`<img src="${originalImg}" alt="Prévisualisation photo courante">`);
  
    $('.nav-link').on('mouseenter', function () {
      const thumbnailUrl = $(this).data('thumbnail');
  
      if (thumbnailUrl) {
        $photoPreview.find('img').stop(true, true).fadeOut(100, function () {
          $(this).attr('src', thumbnailUrl).fadeIn(150);
        });
      }
    });
  
    $('.nav-link').on('mouseleave', function () {
      $photoPreview.find('img').stop(true, true).fadeOut(100, function () {
        $(this).attr('src', originalImg).fadeIn(150);
      });
    });
  });