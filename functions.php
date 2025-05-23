<?php
// Chargement des fichiers CSS et JS
function nathaliemota_enqueue_assets() {
    wp_enqueue_style('nathaliemota-style', get_template_directory_uri() . '/assets/css/style.css', [], filemtime(get_template_directory() . '/assets/css/style.css'));
    wp_enqueue_script('jquery');
    wp_enqueue_script('nathaliemota-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), filemtime(get_template_directory() . '/js/scripts.js'), true);
	wp_enqueue_script('load-more-js', get_template_directory_uri() . '/js/load-more.js',[], null, true);
	// Envoi de ajaxurl + nonce au JS
	wp_localize_script('load-more-js', 'nathalie_ajax', [
		'ajaxurl' => admin_url('admin-ajax.php'),
		'nonce'   => wp_create_nonce('load_more_nonce'),
	  ]);
  }
  add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_assets');

// Requête "charger plus"
function nathalie_load_more_photos() {
	// Sécurité : vérification du nonce
	if (
	  !isset($_GET['nonce']) ||
	  !wp_verify_nonce($_GET['nonce'], 'load_more_nonce')
	) {
	  wp_die('Non autorisé', 403);
	}
  
	// Récupération des paramètres
	$paged     = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$categorie = sanitize_text_field($_GET['categorie'] ?? '');
	$format    = sanitize_text_field($_GET['format'] ?? '');
	$order     = sanitize_text_field($_GET['order'] ?? '');
  
	// Construction de la requête WP_Query
	$args = [
	  'post_type'      => 'photo',
	  'posts_per_page' => 6,
	  'paged'          => $paged,
	];
  
	// Tri personnalisé
	switch ($order) {
	  case 'date_asc':
		$args['orderby'] = 'date';
		$args['order'] = 'ASC';
		break;
	  case 'date_desc':
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
		break;
	}
  
	// Taxonomies
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
  
	// Lancement de la requête
	$query = new WP_Query($args);
  
	if ($query->have_posts()) {
	  ob_start();
	  while ($query->have_posts()) {
		$query->the_post();
		get_template_part('templates_part/photo-bloc');
	  }
	  wp_reset_postdata();
	  echo ob_get_clean();
	} else {
	  echo ''; // Rien à charger
	}
  
	wp_die();
  }
  
  add_action('wp_ajax_load_more_photos', 'nathalie_load_more_photos');
  add_action('wp_ajax_nopriv_load_more_photos', 'nathalie_load_more_photos');

// Filtres photos
function nathalie_filter_photos() {
	// Vérifie le nonce de sécurité
	if (
	  !isset($_GET['nonce']) ||
	  !wp_verify_nonce($_GET['nonce'], 'load_more_nonce')
	) {
	  wp_send_json_error('Requête non autorisée', 403);
	  wp_die();
	}
  
	// Récupère les paramètres
	$categorie = sanitize_text_field($_GET['categorie'] ?? '');
	$format    = sanitize_text_field($_GET['format'] ?? '');
	$order     = sanitize_text_field($_GET['order'] ?? '');
  
	// Prépare les arguments WP_Query
	$args = [
	  'post_type'      => 'photo',
	  'posts_per_page' => 6,
	  'paged'          => 1,
	];
  
	// Tri
	switch ($order) {
	  case 'date_asc':
		$args['orderby'] = 'date';
		$args['order'] = 'ASC';
		break;
	  case 'date_desc':
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
		break;
	}
  
	// Taxonomies
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
  
	// Requête WP
	$query = new WP_Query($args);

	if ($query->have_posts()) {
  		ob_start();
  		while ($query->have_posts()) {
    		$query->the_post();
    		get_template_part('templates_part/photo-bloc');
  		}
  		wp_reset_postdata();

  		wp_send_json_success([
    		'html'      => ob_get_clean(),
    		'max_pages' => $query->max_num_pages,
    		'current_page' => 1,
  		]);
	} else {
  		wp_send_json_success([
    		'html' => '<p>Aucune photo trouvée.</p>',
    		'max_pages' => 0,
    		'current_page' => 1,
  		]);
	}

	wp_die();
  }
  
  add_action('wp_ajax_filter_photos', 'nathalie_filter_photos');
  add_action('wp_ajax_nopriv_filter_photos', 'nathalie_filter_photos');

// Activation du support des menus
add_theme_support('menus');

// Activation du support des balises <title> dynamiques
add_theme_support('title-tag');

// Activation des images mises en avant
add_theme_support('post-thumbnails');

// Enregistrement des menus
function nathaliemota_register_menus() {
    register_nav_menus([
        'main_menu' => 'Menu du header',
        'footer_menu' => 'Menu du footer',
    ]);
}
add_action('after_setup_theme', 'nathaliemota_register_menus');

// Création du CPT "photo" et des taxonomies "catégories" et "format" 
require_once get_template_directory() . '/inc/cpt-photo.php';

// ACF
add_action('acf/init', function(){
	\acf_add_options_sub_page([
		'page_title'=> 'Developper settings',
		'menu_title'=> 'Developper settings',
		'parent_slug' => 'options-general.php',
	]);

});


/**
 * Save and load ACF fields from JSON
 */

add_filter('acf/settings/load_json', function ($paths) {
	unset($paths[0]);
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
});

add_filter('acf/settings/save_json', function ($path) {
	$path = get_stylesheet_directory() . '/acf-json';
	return $path;
});