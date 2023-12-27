<?php /*ěščřžýáíéúů*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, maximum-scale=5">

    <?php /* TITLE ================================================================================================================================ */ ?>
    <title><?php wp_title("&laquo;", true, "right"); ?></title>

    <?php /* HEAD SCRIPTS ========================================================================================================================= */ ?>
    <?php wp_head(); ?>

    <?php the_field("addedcode_head", "option"); ?>

    <?php /* MINI ADMIN BAR CORRECTION
    ========================================================================================================================= */ ?>
    <?php if (Theme::get_wp_config("enable_mini_admin_bar")) : ?>
        <style>
            html {
                margin-top: 0 !important;
            }
        </style>
    <?php endif; ?>

</head>

<body <?php body_class(); ?>>
    <?php the_field("addedcode_bodystart", "option"); ?>
    <?php ob_start(); ?>
    <header class="site-header">
        <div class="container">
            <div class="site-header__left-col">
                <a href="<?php echo apply_filters('wpml_home_url', get_option('home')); ?>" class="logo" title="<?php echo esc_attr(get_bloginfo('name')); ?>">
                    <?php Theme::print_image('300', 'fullsize') ?>
                </a>
            </div>
            <div class="site-header__right-col">
                <nav class="menu-primary">
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'menu-primary',
                        'menu'            => '',
                        'container'       => '',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'menu',
                        'menu_id'         => '',
                        'echo'            => true,
                        'fallback_cb'     => '',
                        'before'          => '',
                        'after'           => '',
                        'link_before'     => '',
                        'link_after'      => '',
                        'items_wrap'      => '<ul>%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => ''
                    ));
                    ?>
                </nav>
                <?php if (!Theme::get_wp_config("disable_search")) : ?>
                    <div class="site-header__search">
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>
                <button id="mobileMenu" class="hamburger hamburger--htx" title="<?php _e('Menu', THEME_TEXT_DOMAIN); ?>" aria-label="<?php _e('Menu', THEME_TEXT_DOMAIN); ?>"><span>&nbsp;</span></button>
            </div>
        </div>
    </header>
    <?php
    $header = ob_get_clean();
    $header = Theme::strip_spaces_between_tags($header);
    echo $header;
    ?>

    <main>