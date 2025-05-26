<footer class="site-footer">
    <div class="site-wrapper">
        <nav class="footer-navigation">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer_menu',
                'container' => false,
                'menu_class' => 'footer-menu',
            ]);
            ?>
            <!-- <span><?= get_field('telephone','option'); ?></span> -->
        </nav>
    </div>

    <!-- Modale Contact -->
    <?php get_template_part('template_parts/modal-contact'); ?>

    <!-- Lightbox -->
    <!-- <?php get_template_part('template_parts/lightbox'); ?> -->

    <?php wp_footer(); ?>
</footer>
</body>
</html>