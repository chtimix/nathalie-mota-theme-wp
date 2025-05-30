<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="site-wrapper">
        <div class="header-container">
            <div class="logo">
                <?php 
                $logo = get_field('logo', 'option');
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo $logo['url']; ?>" alt="<?php bloginfo('name'); ?>">
                </a>
            </div>

            <nav class="main-navigation">
                <?php
                    wp_nav_menu([
                        'theme_location' => 'main_menu',
                        'container' => false,
                        'menu_class' => 'menu',
                    ]);
                ?>
            </nav>

            <!-- bouton toggle -->
            <button class="menu__toggle" id="menu-toggle" aria-label="Ouvrir le menu">
                <span class="menu__toggle-bar"></span>
                <span class="menu__toggle-bar"></span>
                <span class="menu__toggle-bar"></span>
            </button>
        </div>

        <!-- Menu mobile -->
        <div class="menu__mobile" id="mobile-menu" aria-label="Menu mobile">
            <?php
                wp_nav_menu([
                'theme_location' => 'main_menu',
                'container' => false,
                'menu_class' => 'menu__list',
                ]);
            ?>
        </div>
    </div>
</header>