<?php
// Fichier : inc/cpt-photo.php

// Enregistrement du CPT "photo"
function nm_register_cpt_photo() {
    $labels = array(
        'name'               => 'Photos',
        'singular_name'      => 'Photo',
        'menu_name'          => 'Photos',
        'name_admin_bar'     => 'Photo',
        'add_new'            => 'Ajouter une nouvelle',
        'add_new_item'       => 'Ajouter une nouvelle photo',
        'new_item'           => 'Nouvelle photo',
        'edit_item'          => 'Modifier la photo',
        'view_item'          => 'Voir la photo',
        'all_items'          => 'Toutes les photos',
        'search_items'       => 'Rechercher des photos',
        'not_found'          => 'Aucune photo trouvée',
        'not_found_in_trash' => 'Aucune photo trouvée dans la corbeille',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-format-image',
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite'            => array('slug' => 'photos'),
    );

    register_post_type('photo', $args);
}
add_action('init', 'nm_register_cpt_photo');

// Taxonomie "catégorie"
function nm_register_taxonomy_categorie() {
    $labels = array(
        'name'          => 'Catégories',
        'singular_name' => 'Catégorie',
        'search_items'  => 'Rechercher des catégories',
        'all_items'     => 'Toutes les catégories',
        'edit_item'     => 'Modifier la catégorie',
        'update_item'   => 'Mettre à jour la catégorie',
        'add_new_item'  => 'Ajouter une nouvelle catégorie',
        'new_item_name' => 'Nom de la nouvelle catégorie',
        'menu_name'     => 'Catégories',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'categorie'),
    );

    register_taxonomy('categorie', array('photo'), $args);
}
add_action('init', 'nm_register_taxonomy_categorie');

// Taxonomie "format"
function nm_register_taxonomy_format() {
    $labels = array(
        'name'          => 'Formats',
        'singular_name' => 'Format',
        'search_items'  => 'Rechercher des formats',
        'all_items'     => 'Tous les formats',
        'edit_item'     => 'Modifier le format',
        'update_item'   => 'Mettre à jour le format',
        'add_new_item'  => 'Ajouter un nouveau format',
        'new_item_name' => 'Nom du nouveau format',
        'menu_name'     => 'Formats',
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'format'),
    );

    register_taxonomy('format', array('photo'), $args);
}
add_action('init', 'nm_register_taxonomy_format');