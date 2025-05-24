/**
 * Affichage dynamique de la miniature dans single-photo.php
 * Lorsqu'on survole un lien de navigation (photo précédente/suivante),
 * la miniature change temporairement pour afficher un aperçu de la photo ciblée.
 */

jQuery(document).ready(function ($) {
    const $photoPreview = $('.photo-preview');
  
    // URL de l’image courante, stockée en data-attribute
    const originalImg = $photoPreview.data('current-thumbnail');
  
    // Affiche l’image courante au chargement de la page
    $photoPreview.html(`<img src="${originalImg}" alt="Prévisualisation photo courante">`);
  
    // Survol d’un lien : affiche l’aperçu temporaire
    $('.nav-link').on('mouseenter', function () {
      const thumbnailUrl = $(this).data('thumbnail');
      if (thumbnailUrl) {
        $photoPreview.find('img').stop(true, true).fadeOut(100, function () {
          $(this).attr('src', thumbnailUrl).fadeIn(150);
        });
      }
    });
  
    // Quitte le survol : revient à l’image d’origine
    $('.nav-link').on('mouseleave', function () {
      $photoPreview.find('img').stop(true, true).fadeOut(100, function () {
        $(this).attr('src', originalImg).fadeIn(150);
      });
    });
  });
  