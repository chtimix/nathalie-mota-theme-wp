<?php
// Fichier : single-photo.php
get_header();

// On vérifie qu'on est bien sur un post
if (have_posts()) :
    while (have_posts()) : the_post();

    // Récupération des champs ACF et taxonomies
    $reference = get_field('reference');
    $type = get_field('type');
    $categories = get_the_terms(get_the_ID(), 'categorie');
    $formats = get_the_terms(get_the_ID(), 'format');
    $annee = get_the_date('Y'); // date de publication
    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<main class="single-photo">
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
    <section class="photo-footer">
        <div class="photo-contact">
            <span>Cette photo vous intéresse ?</span>
            <button 
                class="open-modal-contact" 
                data-ref="<?= esc_attr($reference); ?>"
            >Contact</button>
        </div>
        <div class="photo-navigation">
            <!-- Liens suivant / précédent avec preview -->
            <?php 
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>
            <?php if ($prev_post): ?>
                <a href="<?= get_permalink($prev_post->ID); ?>" class="nav-link prev-photo" data-thumbnail="<?= get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); ?>">←</a>
            <?php endif; ?>
            <?php if ($next_post): ?>
                <a href="<?= get_permalink($next_post->ID); ?>" class="nav-link next-photo" data-thumbnail="<?= get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>">→</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Zone des photos apparentées -->
    <section class="related-photos">
        <h2>Vous aimerez aussi</h2>
        <div class="related-wrapper">
            <?php 
            // Paramètres de la requête WP_Query
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
            $related_query = new WP_Query($related_args); // requête personnalisée
            while ($related_query->have_posts()) : $related_query->the_post(); // Boucle
                get_template_part('templates_parts/photo-bloc'); // Composant php pour afficher chaque photo
            endwhile;
            wp_reset_postdata(); // Réinitialise la boucle principale de WordPress à l’état d’origine (celle du post principal)
            ?>
        </div>
    </section>

</main>

<?php
    endwhile;
endif;

get_footer();