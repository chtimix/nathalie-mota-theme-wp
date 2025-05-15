<?php
// Chargement des fichiers CSS et JS
function nathaliemota_enqueue_assets() {
    wp_enqueue_style('nathaliemota-style', get_template_directory_uri() . '/assets/css/style.css', [], filemtime(get_template_directory() . '/assets/css/style.css'));
    wp_enqueue_script('jquery');
    wp_enqueue_script('nathaliemota-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), filemtime(get_template_directory() . '/js/scripts.js'), true);
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