<div class="modal-contact-overlay">
  <div class="modal-contact">
    <button class="modal-close" aria-label="Fermer la modale">×</button>
    <div class="modal-header-image"></div>
    <div class="modal-form-container">
      <?php echo do_shortcode('[contact-form-7 id="'.get_field('contact_form_id','option').'" title="Formulaire de contact"]'); ?>
    </div>
  </div>
</div>
