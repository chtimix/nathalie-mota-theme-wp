<?php
/**
 * Template part: Lightbox
 */
?>

<div id="lightbox-overlay" class="lightbox-overlay" aria-hidden="true">
  <div class="lightbox-content" role="dialog" aria-modal="true">
    
    <button class="lightbox-close" aria-label="Fermer la lightbox">×</button>

    <button class="lightbox-prev" aria-label="Photo précédente">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left-arrow.png" alt="">
      <span>Précédente</span>
    </button>

    <div class="lightbox-image-wrapper">
      <img id="lightbox-image" src="" alt="">
    </div>

    <button class="lightbox-next" aria-label="Photo suivante">
      <span>Suivante</span>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right-arrow.png" alt="">
    </button>

    <div class="lightbox-infos">
      <span class="lightbox-category"></span>
      <span class="lightbox-reference"></span>
    </div>

  </div>
</div>