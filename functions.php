<?php

// Chargement des fichiers CSS et JS
function nathaliemota_enqueue_assets() {
    wp_enqueue_style('nathaliemota-style', get_stylesheet_uri(), [], '1.0');
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_assets');

// Activation du support des menus
add_theme_support('menus');

// Activation du support des balises <title> dynamiques
add_theme_support('title-tag');

// Activation des images mises en avant
add_theme_support('post-thumbnails');