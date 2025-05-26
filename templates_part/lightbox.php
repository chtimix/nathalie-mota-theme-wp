<?php
/**
 * ==========================================
 * Fichier : templates_part/lightbox.php
 * ==========================================
 *
 * Rôle :
 * Génère le HTML de la lightbox utilisée pour afficher une photo 
 * en plein écran à partir de la galerie.
 * 
 * Comportement attendu (piloté en JavaScript) :
 * - Affichage en overlay noir semi-transparent couvrant toute la fenêtre
 * - Affichage dynamique de la photo sélectionnée en taille maximale
 * - Navigation entre les photos avec boutons "Précédente" et "Suivante"
 * - Affichage des informations associées : référence et catégorie
 * - Fermeture de la lightbox via un bouton (X)
 *
 * Intégration :
 * - Ce fichier est inclus dans footer.php via get_template_part()
 * - Le JavaScript de contrôle est externalisé (lightbox.js)
 * - Les images (flèches, etc.) sont situées dans /assets/img/
 *
 * Accessibilité :
 * - Utilisation de aria-hidden pour cacher la lightbox par défaut
 * - Boutons avec des aria-label pour les lecteurs d’écran
 * - Le focus sera géré dynamiquement via JS (non inclus ici)
 *
 * À compléter :
 * - Le CSS pour la mise en forme et l’animation
 * - Le JavaScript pour la gestion des événements (ouverture, navigation, fermeture)
 */
?>

<div class="lightbox-overlay" id="lightbox" aria-hidden="true">
<div class="lightbox-content">
  <!-- Fermeture -->
  <button class="lightbox-close" aria-label="Fermer la lightbox">&times;</button>

  <!-- Photo et navigation -->
  <div class="lightbox-body">

    <div class="lightbox-prev" role="button" aria-label="Photo précédente">
      <img src="<?= get_template_directory_uri(); ?>/assets/img/left-arrow-white.png" alt="">
      <span class="lightbox-nav-text">Précédente</span>
    </div>

    <!-- Photo + infos -->
    <div class="lightbox-main">
        <div class="lightbox-media">
            <img src="" alt="" class="lightbox-image">
        </div>
        <div class="lightbox-info">
            <div class="lightbox-category">CATÉGORIE</div>
            <div class="lightbox-ref">RÉFÉRENCE</div>
        </div>
    </div>

    <div class="lightbox-next" role="button" aria-label="Photo suivante">
      <span class="lightbox-nav-text">Suivante</span>
      <img src="<?= get_template_directory_uri(); ?>/assets/img/right-arrow-white.png" alt="">
    </div>
  </div>

  
</div>
</div>