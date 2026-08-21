<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <a class="skip-link screen-reader-text" href="#main"><?= esc_html__('Aller au contenu', 'vox-aedificatoris'); ?></a>

    <!-- Header -->
    <header id="header" class="header">
        <div class="container container-lg">
            <div class="inner-header">
                <?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?= esc_url(home_url('/')); ?>" class="sitename logo-link"><?= esc_html(get_bloginfo('name')); ?></a>
                <?php endif; ?>

                <?php if (has_nav_menu('header-menu')) : ?>
                    <nav class="nav-wrapper" aria-label="<?= esc_attr__('Navigation principale', 'vox-aedificatoris'); ?>">
                        <?php wp_nav_menu(array(
                            'theme_location' => 'header-menu',
                            'menu_class' => 'menu menu-header',
                            'items_wrap' => '<ul id="header-menu" class="%2$s">%3$s</ul>',
                            'container' => false,
                            'depth' => 1,
                            'fallback_cb' => false,
                        )); ?>
                    </nav>

                    <div class="menu-toggle-col">
                        <button id="menu-toggle" class="menu-toggle" type="button" aria-controls="header-menu" aria-expanded="false" data-label-open="<?= esc_attr__('Ouvrir le menu', 'vox-aedificatoris'); ?>" data-label-close="<?= esc_attr__('Fermer le menu', 'vox-aedificatoris'); ?>">
                            <span class="screen-reader-text"><?= esc_html__('Ouvrir le menu', 'vox-aedificatoris'); ?></span>
                            <span class="menu-toggle-wrapper" aria-hidden="true">
                                <span class="menu-toggle-open">
                                    <span aria-hidden="true"></span>
                                </span>
                            </span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main id="main">
