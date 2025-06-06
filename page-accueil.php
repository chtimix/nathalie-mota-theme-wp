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

        <!-- Filtres Catégories -->
        <div class="custom-select" data-name="categorie">
          <div class="custom-select-trigger">
            Catégories
          </div>
          <!-- Affichage dynamique des catégories -->
          <?php
          $terms = get_terms([
          'taxonomy'   => 'categorie',
          'hide_empty' => true, // n'affiche que les catégories utilisées
          ]);

          if (!empty($terms) && !is_wp_error($terms)) : ?>
          <ul class="custom-options">
            <li class="custom-option" data-value="">Toutes les catégories</li>
            <?php foreach ($terms as $term) : ?>
            <li class="custom-option" data-value="<?php echo esc_attr($term->slug); ?>">
            <?php echo esc_html($term->name); ?>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>

        <!-- Filtre Format -->
        <div class="custom-select" data-name="format">
          <div class="custom-select-trigger">
            Format
          </div>
          <?php
          $terms = get_terms([
          'taxonomy'   => 'format',
          'hide_empty' => true,
          ]);

          if (!empty($terms) && !is_wp_error($terms)) : ?>
          <ul class="custom-options">
            <li class="custom-option" data-value="">Tous les formats</li>
            <?php foreach ($terms as $term) : ?>
            <li class="custom-option" data-value="<?php echo esc_attr($term->slug); ?>">
            <?php echo esc_html($term->name); ?>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>

      </div>

      <div class="filters-right">

        <!-- Filtre Trier par -->
        <div class="custom-select" data-name="order">
          <div class="custom-select-trigger">
            Trier par
          </div>
          <ul class="custom-options">
            <li class="custom-option" data-value="date_desc">Date (plus récentes)</li>
            <li class="custom-option" data-value="date_asc">Date (plus anciennes)</li>
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
        'posts_per_page' => 6, // Affiche 6 photos max par “page”
        'paged'          => get_query_var('paged') ?: 1 // Permet la pagination. Si aucune variable paged n’est définie dans l’URL, on prend la page 1
      ];
      $photo_query = new WP_Query($photo_args);

      // Boucle affichage photos
      if ($photo_query->have_posts()) : // Vérifie s’il y a des résultats à afficher 
        while ($photo_query->have_posts()) : $photo_query->the_post(); // the_post() prépare le post courant (accès à the_title(), get_the_ID(), etc.)
          get_template_part('templates_part/photo-bloc');
        endwhile;
        wp_reset_postdata(); // Restaure la boucle WordPress globale (main loop) -> évite les bugs avec d’autres the_title(), the_permalink() etc. plus bas dans la page
        else :
          echo '<p>Aucune photo trouvée.</p>';
      endif;
    ?>
  </div>

  <!-- Bouton Charger plus -->

  <?php
    $total_photos = wp_count_posts('photo')->publish; // Compte le nbre de CPT Photo avec le statut "publié".
    $photos_per_page = 6; // Nbre de photo par page. À chaque clic, on affiche 6 photos supplémentaires
    $current_page = 1; // Page actuelle définie à 1 (au chargement de la page d'accueil)

    $max_pages = ceil($total_photos / $photos_per_page); // On compte le nombre maximum de pages, arrondi vers le haut avec ceil()
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