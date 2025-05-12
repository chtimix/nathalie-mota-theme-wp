<?php

// Chargement des fichiers CSS et JS
function nathaliemota_enqueue_assets() {
    wp_enqueue_style('nathaliemota-style', get_template_directory_uri() . '/assets/css/style.css', [], '1.0');
    wp_enqueue_script('nathaliemota-scripts', get_template_directory_uri() . '/js/scripts.js', [], '1.0', true);
  }
  add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_assets');

// Activation du support des menus
add_theme_support('menus');

// Activation du support des balises <title> dynamiques
add_theme_support('title-tag');

// Activation des images mises en avant
add_theme_support('post-thumbnails');

// Enregistrement du menu principal
function nathaliemota_register_menus() {
    register_nav_menus([
        'main_menu' => 'Menu principal',
    ]);
}
add_action('after_setup_theme', 'nathaliemota_register_menus');

// Création du CPT "photo" et des taxonomies "catégories" et "format" 
require_once get_template_directory() . '/inc/cpt-photo.php';
