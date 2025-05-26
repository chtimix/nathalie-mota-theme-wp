<?php
// Fichier : templates_part/photo-bloc.php

if (!isset($post)) return;

$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
$title = get_the_title();
$reference = get_field('reference');
$categories = get_the_terms(get_the_ID(), 'categorie');
$category_name = $categories ? $categories[0]->name : '';

$template_dir = get_template_directory_uri();
$eye_icon = $template_dir . '/assets/img/eye-icon.png';
$maximize_icon = $template_dir . '/assets/img/maximize-icon.png';
?>

<article class="photo-bloc">
    <img src="<?= esc_url($thumbnail_url); ?>" alt="<?= esc_attr($title); ?>">

    <div class="photo-hover">

        <!-- Icône œil centrée -->
        <a href="<?= get_permalink(); ?>" class="eye-icon" title="Voir la fiche">
            <img src="<?= esc_url($eye_icon); ?>" alt="Voir la fiche">
        </a>

        <!-- Icône Lightbox -->
        <div class="lightbox-icon-container">
            <img src="<?= esc_url($maximize_icon); ?>" alt="Plein écran">
        </div>

        <!-- Titre en bas à gauche -->
        <div class="photo-meta title"><?= esc_html($title); ?></div>

        <!-- Catégorie en bas à droite -->
        <?php if ($category_name): ?>
            <div class="photo-meta category"><?= esc_html($category_name); ?></div>
        <?php endif; ?>

    </div>
</article>