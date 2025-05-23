/* *
 * Interactions avec les menus
 * */

document.addEventListener('DOMContentLoaded', function () {

  // Gestion ouverture/fermeture des menus
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

  // Gestion de la sélection d'une option
  document.querySelectorAll('.custom-select').forEach(select => {
    const trigger = select.querySelector('.custom-select-trigger');
    const options = select.querySelectorAll('.custom-option');
  
    options.forEach(option => {
      option.addEventListener('click', function (e) {
        e.stopPropagation();
  
        // Met à jour le texte affiché dans le trigger
        trigger.textContent = this.textContent;
  
        // Stocke la valeur sélectionnée sur l'élément parent
        select.setAttribute('data-selected', this.dataset.value);
  
        // Met à jour l’état visuel : retire la classe 'selected' des autres
        options.forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');
  
        // Ferme le menu
        select.classList.remove('open');
  
        // Lecture des filtres sélectionnés
        const filters = document.querySelectorAll('.custom-select');
        const filterData = {};

        filters.forEach(f => {
          const name = f.dataset.name; // ex: categorie, format, order
          const value = f.dataset.selected || '';
          filterData[name] = value;
        });

        // Appel Ajax avec les filtres
        fetch(`${nathalie_ajax.ajaxurl}?action=filter_photos&nonce=${nathalie_ajax.nonce}&categorie=${filterData.categorie}&format=${filterData.format}&order=${filterData.order}`)
        .then(response => response.json())
        .then(result => {
          const gallery = document.querySelector('.gallery-container');
          gallery.innerHTML = result.data.html;

          const loadMoreBtn = document.getElementById('load-more');

          if (result.data.max_pages > 1) {
            // Met à jour le bouton
            if (!loadMoreBtn) {
              const wrapper = document.createElement('div');
              wrapper.classList.add('load-more-wrapper');

              const button = document.createElement('button');
              button.id = 'load-more';
              button.className = 'load-more-button';
              button.textContent = 'Charger plus';
              document.querySelector('.gallery').appendChild(wrapper);
              wrapper.appendChild(button);
            } else {
              loadMoreBtn.dataset.page = 1;
              loadMoreBtn.dataset.maxPage = result.data.max_pages;
              loadMoreBtn.style.display = 'block';
            }

            // Stocke les filtres actifs dans des attributs data-*
            const container = document.querySelector('.gallery');
            container.dataset.filters = JSON.stringify(filterData);
          } else if (loadMoreBtn) {
            loadMoreBtn.style.display = 'none';
          }
        });
      });
    });
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

  