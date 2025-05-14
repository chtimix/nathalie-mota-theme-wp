<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
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
    </div>
</header>