<?php
/* Template pour la page d’accueil du site Natalie Mota */
get_header(); ?>

<!-- Hero -->
<?php
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

<section class="gallery" id="galerie">
  <div class="gallery-container">
    <?php
    $args = [
      'post_type'      => 'photo',
      'posts_per_page' => 12, // pagination prévue plus tard
      'paged'          => get_query_var('paged') ?: 1
    ];
    $photos = new WP_Query($args);

    if ($photos->have_posts()) :
      while ($photos->have_posts()) : $photos->the_post();
        get_template_part('templates-part/photo-bloc');
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p>Aucune photo trouvée.</p>';
    endif;
    ?>
  </div>
</section>

<?php get_footer(); ?>