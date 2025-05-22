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
	// Vérification du nonce
	if (
		!isset($_GET['nonce']) ||
		!wp_verify_nonce($_GET['nonce'], 'load_more_nonce')
	) {
		wp_send_json_error('Requête non autorisée', 403);
		wp_die();
	}

	$paged = isset($_GET['page']) ? intval($_GET['page']) : 1;
  
	$args = [
	  'post_type'      => 'photo',
	  'posts_per_page' => 6,
	  'paged'          => $paged,
	];
  
	$query = new WP_Query($args);
  
	if ($query->have_posts()) {
	  ob_start(); // Permet de capturer tout le HTML généré par get_template_part() dans une chaîne, sans l’afficher tout de suite.
	  while ($query->have_posts()) {
		$query->the_post();
		get_template_part('templates_part/photo-bloc');
	  }
	  wp_reset_postdata();
	  echo ob_get_clean();
	} else {
	  echo '';
	}
  
	wp_die(); // Termine l’exécution sans charger le reste de WordPress (comme le footer, etc.).
}
add_action('wp_ajax_load_more_photos', 'nathalie_load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'nathalie_load_more_photos');

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