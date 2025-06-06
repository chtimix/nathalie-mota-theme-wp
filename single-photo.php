<?php
// Fichier : single-photo.php
get_header();

    // Récupération des champs ACF et taxonomies
    $reference = get_field('reference');
    $type = get_field('type');
    $categories = get_the_terms(get_the_ID(), 'categorie');
    $formats = get_the_terms(get_the_ID(), 'format');
    $annee = get_the_date('Y'); // date de publication
    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<main class=" single-photo site-wrapper">

    <!-- Zone principale : bloc infos photo + bloc photo -->
    <section class="photo-content">

        <!-- Bloc gauche : infos photo -->
        <div class="photo-infos">
            <h1 class="photo-title"><?php the_title(); ?></h1>
            <ul>
                <li>Référence : <?= esc_html($reference); ?></li>
                <?php if ($categories): ?>
                    <li>Catégorie : <?= esc_html($categories[0]->name); ?></li>
                <?php endif; ?>
                <?php if ($formats): ?>
                    <li>Format : <?= esc_html($formats[0]->name); ?></li>
                <?php endif; ?>
                <li>Type : <?= esc_html($type); ?></li>
                <li>Année : <?= esc_html($annee); ?></li>
            </ul>
        </div>

        <!-- Bloc droit : photo -->
        <div class="photo-image">
            <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr(get_the_title()); ?>">
        </div>
    </section>

    <!-- Bloc contact + navigation -->
    <section class="photo-footer single-container">
        <div class="photo-contact">
            <p>Cette photo vous intéresse ?</p>
            <button 
                class="open-modal-contact button-base" 
                data-ref="<?= esc_attr($reference); ?>"
            >Contact</button>
        </div>
        <div class="photo-navigation">
            <div class="photo-preview-container">
                <?php
                    $current_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                ?>
                <div class="photo-preview" data-current-thumbnail="<?= esc_url($current_thumbnail); ?>">
                </div>
                <div class="photo-preview-arrows">
                    <?php 
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        $template_dir = get_template_directory_uri();
                        $left_arrow_icon = $template_dir . '/assets/img/left-arrow.png';
                        $right_arrow_icon = $template_dir . '/assets/img/right-arrow.png';
                    ?>
                    <?php if ($prev_post): ?>
                        <div class="photo-navigation-arrow-left">
                            <a href="<?= get_permalink($prev_post->ID); ?>" class="nav-link prev-photo" data-thumbnail="<?= get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); ?>"><img src="<?= esc_url($left_arrow_icon); ?>" alt="Photo précédente"></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($next_post): ?>
                        <div class="photo-navigation-arrow-right">
                            <a href="<?= get_permalink($next_post->ID); ?>" class="nav-link next-photo" data-thumbnail="<?= get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>"><img src="<?= esc_url($right_arrow_icon); ?>" alt="Photo suivante"></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Zone des photos apparentées -->
    <section class="related-photos single-container">
        <h2>Vous aimerez aussi</h2>
        <div class="related-wrapper">
            <?php 
            $related_args = array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie',
                        'field' => 'term_id',
                        'terms' => $categories[0]->term_id ?? 0,
                    ),
                ),
            );
            $related_query = new WP_Query($related_args);
            while ($related_query->have_posts()) : $related_query->the_post();
                get_template_part('templates_part/photo-bloc');
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </section>

</main>

<?php

get_footer();