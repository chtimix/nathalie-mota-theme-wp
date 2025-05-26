<?php
// Chargement des fichiers CSS et JS
function nathaliemota_enqueue_assets() {
	// CSS
	wp_enqueue_style(
	  'nathaliemota-style',
	  get_template_directory_uri() . '/assets/css/style.css',
	  [],
	  filemtime(get_template_directory() . '/assets/css/style.css')
	);
  
	// JS avec cache-busting par filemtime()
	$scripts = [
	  'main.js',
	  'gallery.js',
	  'modal-contact.js',
	];
  
	foreach ($scripts as $script) {
	  wp_enqueue_script(
		'nathaliemota-' . basename($script, '.js'),
		get_template_directory_uri() . '/assets/js/' . $script,
		[],
		filemtime(get_template_directory() . '/assets/js/' . $script),
		true
	  );
	}
  
	// jQuery uniquement sur les pages nécessaires
	if (is_singular('photo')) {
	  wp_enqueue_script(
		'nathaliemota-photo-preview',
		get_template_directory_uri() . '/assets/js/photo-preview.js',
		['jquery'],
		filemtime(get_template_directory() . '/assets/js/photo-preview.js'),
		true
	  );
	}
  
	// Localisation (si nécessaire pour compatibilité)
	wp_localize_script('nathaliemota-load-more', 'nathalie_ajax', [
	  'ajaxurl' => admin_url('admin-ajax.php'),
	  'nonce'   => wp_create_nonce('load_more_nonce'),
	]);
  }
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_assets');

// Activation du support des menus
add_theme_support('menus');

// Activation du support des balises <title> dynamiques
add_theme_support('title-tag');

// Activation des images mises en avant
add_theme_support('post-thumbnails');

// Enregistrement des menus
function nathaliemota_register_menus() {
  register_nav_menus([
    'main_menu'   => 'Menu du header',
    'footer_menu' => 'Menu du footer',
  ]);
}
add_action('after_setup_theme', 'nathaliemota_register_menus');

// Création du CPT "photo" et des taxonomies "catégories" et "format"
require_once get_template_directory() . '/inc/cpt-photo.php';

// ACF : Ajout d'une sous-page d'options
add_action('acf/init', function () {
  \acf_add_options_sub_page([
    'page_title'  => 'Developper settings',
    'menu_title'  => 'Developper settings',
    'parent_slug' => 'options-general.php',
  ]);
});

// Sauvegarde/chargement JSON des champs ACF
add_filter('acf/settings/load_json', function ($paths) {
  unset($paths[0]);
  $paths[] = get_stylesheet_directory() . '/acf-json';
  return $paths;
});

add_filter('acf/settings/save_json', function ($path) {
  return get_stylesheet_directory() . '/acf-json';
});

// API Rest
require_once get_template_directory() . '/inc/rest-api.php';
