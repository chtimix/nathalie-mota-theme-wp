/* *
 * Ouverture / fermeture des menus
 * */
document.addEventListener('DOMContentLoaded', function () {
  const customSelects = document.querySelectorAll('.custom-select');

  customSelects.forEach(select => {
    const trigger = select.querySelector('.custom-select-trigger');

    trigger.addEventListener('click', function (e) {
      e.stopPropagation();

      // Si le menu est déjà ouvert, on le ferme
      const isOpen = select.classList.contains('open');

      // Ferme tous les autres menus
      customSelects.forEach(s => s.classList.remove('open'));

      // Si le menu cliqué n'était pas ouvert, on l’ouvre
      if (!isOpen) {
      select.classList.add('open');
      }
    });
  });

  // Ferme tous les menus si on clique ailleurs
  document.addEventListener('click', function () {
    customSelects.forEach(select => select.classList.remove('open'));
  });
});


/* *
 * Ouverture et fermeture PopUp Contact
 * */
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.querySelector('.modal-contact-overlay');
  const closeBtn = document.querySelector('.modal-close');
  const openBtns = document.querySelectorAll('.open-modal-contact');

  openBtns.forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const ref = this.getAttribute('data-ref');
      const photoRefInput = document.querySelector('#photo-ref');

      // Récupère la référence de la photo
      photoRefInput.value = ref;
      photoRefInput.disabled = true;
      // Ouvre la modale
      modal.classList.add('visible');
      requestAnimationFrame(() => {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
      });
    });
  });

  closeBtn.addEventListener('click', () => {
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
    setTimeout(() => {
      modal.classList.remove('visible');
    }, 300);
  });
});
  
/* *
 * Affichage de la photo miniature dans single-photo.php
 * */
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