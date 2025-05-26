<footer class="site-footer">
    <div class="site-wrapper">
        <nav class="footer-navigation" aria-label="Pied de page">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer_menu',
                'container' => false,
                'menu_class' => 'footer-menu',
            ]);
            ?>
        </nav>
    </div>

    <!-- Modale de contact -->
    <?php get_template_part('templates_part/modal-contact'); ?>

    <!-- Lightbox photo -->
    <?php get_template_part('templates_part/lightbox'); ?>

    <?php wp_footer(); ?>
</footer>
</body>
</html>