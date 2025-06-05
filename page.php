<?php get_header(); ?>

<main id="main" class="site-main site-wrapper">
    <div class="page-standard-container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h1><?php the_title(); ?></h1>
                    <div class="page-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile;
        else :
            echo '<p>Aucun contenu trouvé.</p>';
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>