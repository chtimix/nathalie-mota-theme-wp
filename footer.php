<footer class="site-footer">
    <div class="footer-container">
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
    <?php get_template_part('templates_part/modal-contact'); ?>
    <?php wp_footer(); ?>
</footer>
</body>
</html>