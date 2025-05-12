<footer class="site-footer">
    <div class="footer-container">
        <a href="<?php echo esc_url(home_url('/mentions-legales')); ?>">Mentions légales</a>
        <a href="<?php echo esc_url(home_url('/vie-privee')); ?>">Vie privée</a>
        <span>Tous droits réservés</span>
        <span><?= get_field('telephone','option'); ?></span>
    </div>
    <?php get_template_part('templates_part/modal-contact'); ?>
    <?php wp_footer(); ?>
</footer>
</body>
</html>