<?php
declare(strict_types=1);

add_action('wp_enqueue_scripts', function (): void {
    wp_enqueue_style(
        'vg-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Raleway:wght@200;300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'vg-theme',
        VG_THEME_URI . '/assets/css/theme.css',
        ['vg-fonts'],
        VG_THEME_VERSION
    );

    wp_enqueue_script(
        'vg-theme',
        VG_THEME_URI . '/assets/js/theme.js',
        [],
        VG_THEME_VERSION,
        true
    );

    wp_localize_script('vg-theme', 'vgAjax', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('vg_contact_form'),
    ]);
});

add_action('admin_enqueue_scripts', function (string $hook): void {
    $vg_pages = ['appearance_page_vg-theme-settings', 'appearance_page_vg-demo-import'];
    if (!in_array($hook, $vg_pages, true)) {
        return;
    }
    wp_enqueue_style('vg-admin', VG_THEME_URI . '/assets/css/admin.css', [], VG_THEME_VERSION);
});
