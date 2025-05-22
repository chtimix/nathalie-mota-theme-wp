<?php
/* Template pour la page d’accueil du site Natalie Mota */
get_header(); ?>

<!-- Hero -->

<?php
// Requête aléatoire WP_Query pour la photo du hero
$args = [
  'post_type'      => 'photo',
  'posts_per_page' => 1,
  'orderby'        => 'rand',
  'tax_query'      => [
    [
      'taxonomy' => 'format',
      'field'    => 'slug',
      'terms'    => 'paysage',
    ]
  ]
];

$random_photo = new WP_Query($args);

if ($random_photo->have_posts()) :
  while ($random_photo->have_posts()) : $random_photo->the_post();
    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
    
    <section class="hero" style="background-image: url('<?php echo esc_url($image_url); ?>');">
        <div class="hero-overlay">
            <h1 class="hero-title">PHOTOGRAPHE EVENT</h1>
        </div>
    </section>

  <?php endwhile;
  wp_reset_postdata();
endif;
?>

<!-- Galerie Photos -->

<section class="gallery site-wrapper" id="galerie">

  <!-- Filtres -->

  <section class="filters">
    <div class="filters-container">
      <div class="filters-left">

        <!-- Menu Catégories -->
        <div class="custom-select" data-name="categorie">
          <div class="custom-select-trigger">
            Catégories
          </div>
          <ul class="custom-options">
            <li class="custom-option" data-value="">Réception</li>
            <li class="custom-option" data-value="concert">Télévision</li>
            <li class="custom-option" data-value="mode">Concert</li>
            <li class="custom-option" data-value="evenement">Mariage</li>
            <!-- Ces options seront injectées dynamiquement en PHP plus tard -->
          </ul>
        </div>

        <!-- Menu Format -->
        <div class="custom-select" data-name="format">
          <div class="custom-select-trigger">
            Format
          </div>
          <ul class="custom-options">
            <li class="custom-option" data-value="">Tous les formats</li>
            <li class="custom-option" data-value="paysage">Paysage</li>
            <li class="custom-option" data-value="portrait">Portrait</li>
            <!-- À injecter dynamiquement aussi -->
          </ul>
        </div>

      </div>

      <div class="filters-right">

        <!-- Menu Trier par -->
        <div class="custom-select" data-name="order">
          <div class="custom-select-trigger">
            Trier par
          </div>
          <ul class="custom-options">
            <li class="custom-option" data-value="date_desc">Date (plus récentes)</li>
            <li class="custom-option" data-value="date_asc">Date (plus anciennes)</li>
            <li class="custom-option" data-value="title_asc">Titre (A–Z)</li>
            <li class="custom-option" data-value="title_desc">Titre (Z–A)</li>
            <li class="custom-option" data-value="rand">Aléatoire</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Photos -->

  <div class="gallery-container">
    <?php
      // Arguments de la requête WP_Query
      $photo_args = [
        'post_type'      => 'photo',
        'posts_per_page' => 6, // On affiche 6 photos au départ
        'paged'          => get_query_var('paged') ?: 1
      ];
      $photo_query = new WP_Query($photo_args);

      // Boucle affichage photos
      if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();
          get_template_part('templates_part/photo-bloc');
        endwhile;
        wp_reset_postdata();
        else :
          echo '<p>Aucune photo trouvée.</p>';
      endif;
    ?>
  </div>

  <!-- Bouton Charger plus -->

  <?php
    $total_photos = wp_count_posts('photo')->publish;
    $photos_per_page = 6; // Au clic, on affiche 6 photos supplémentaires
    $current_page = 1;

    $max_pages = ceil($total_photos / $photos_per_page); // On compte le nombre maximum de pages
  ?>

  <?php if ($max_pages > 1) : ?>
    <div class="load-more-wrapper">
      <button
        id="load-more"
        class="load-more-button button-base"
        data-page="<?php echo $current_page; ?>"
        data-max-page="<?php echo $max_pages; ?>"
      >
      Charger plus
      </button>
    </div>
  <?php endif; ?>

</section>

<!-- Footer -->

<?php get_footer(); ?>