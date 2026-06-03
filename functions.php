<?php
declare(strict_types=1);

define('VG_THEME_VERSION', '1.0.0');
define('VG_THEME_DIR',     get_template_directory());
define('VG_THEME_URI',     get_template_directory_uri());

require_once VG_THEME_DIR . '/inc/enqueue.php';
require_once VG_THEME_DIR . '/inc/menus.php';
require_once VG_THEME_DIR . '/inc/cpt.php';
require_once VG_THEME_DIR . '/inc/customizer.php';
require_once VG_THEME_DIR . '/inc/helpers.php';
require_once VG_THEME_DIR . '/inc/template-settings.php';
require_once VG_THEME_DIR . '/inc/elementor.php';
require_once VG_THEME_DIR . '/inc/contact-handler.php';

add_action('after_setup_theme', function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    load_theme_textdomain('venicegarden', VG_THEME_DIR . '/languages');
});

add_action('init', function (): void {
    add_image_size('vg-card',    600, 400, true);
    add_image_size('vg-hero',   1920, 1080, true);
    add_image_size('vg-square',  600, 600, true);
    add_image_size('vg-portrait', 480, 640, true);
});
