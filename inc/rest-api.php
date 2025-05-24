<?php
// Enregistrement de la route REST personnalisée pour charger les photos
add_action('rest_api_init', function () {
  register_rest_route('nathalie/v1', '/photos', [
    'methods'             => 'GET',
    'callback'            => 'nathalie_rest_get_photos',
    'permission_callback' => '__return_true',
  ]);
});

// Callback REST : récupère les photos filtrées et paginées
function nathalie_rest_get_photos($request) {
  $page      = $request->get_param('page') ?? 1;
  $categorie = sanitize_text_field($request->get_param('categorie') ?? '');
  $format    = sanitize_text_field($request->get_param('format') ?? '');
  $order     = sanitize_text_field($request->get_param('order') ?? '');

  $query = nathalie_get_filtered_photos_query([
    'page'      => $page,
    'categorie' => $categorie,
    'format'    => $format,
    'order'     => $order,
  ]);

  if (!$query->have_posts()) {
    return rest_ensure_response([
      'html'         => '<p>Aucune photo trouvée.</p>',
      'max_pages'    => 0,
      'current_page' => (int) $page,
    ]);
  }

  ob_start();
  while ($query->have_posts()) {
    $query->the_post();
    get_template_part('templates_part/photo-bloc');
  }
  wp_reset_postdata();

  return rest_ensure_response([
    'html'         => ob_get_clean(),
    'max_pages'    => $query->max_num_pages,
    'current_page' => (int) $page,
  ]);
}

// Fonction utilitaire de WP_Query avec les paramètres de filtre
function nathalie_get_filtered_photos_query(array $params): WP_Query {
  $paged     = isset($params['page']) ? intval($params['page']) : 1;
  $categorie = sanitize_text_field($params['categorie'] ?? '');
  $format    = sanitize_text_field($params['format'] ?? '');
  $order     = sanitize_text_field($params['order'] ?? '');

  $args = [
    'post_type'      => 'photo',
    'posts_per_page' => 6,
    'paged'          => $paged,
  ];

  switch ($order) {
    case 'date_asc':
      $args['orderby'] = 'date';
      $args['order']   = 'ASC';
      break;
    case 'date_desc':
      $args['orderby'] = 'date';
      $args['order']   = 'DESC';
      break;
  }

  $tax_query = [];

  if (!empty($categorie)) {
    $tax_query[] = [
      'taxonomy' => 'categorie',
      'field'    => 'slug',
      'terms'    => $categorie,
    ];
  }

  if (!empty($format)) {
    $tax_query[] = [
      'taxonomy' => 'format',
      'field'    => 'slug',
      'terms'    => $format,
    ];
  }

  if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
  }

  return new WP_Query($args);
}
