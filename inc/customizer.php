<?php
declare(strict_types=1);

/**
 * WordPress Customizer settings for Venice Gardens Distribution theme.
 * These provide site-wide defaults that widgets can reference, but every
 * setting is also editable directly inside Elementor widget controls.
 */
add_action('customize_register', function (WP_Customize_Manager $wp_customize): void {

    /* ── Panel: Venice Gardens ───────────────────────────────── */
    $wp_customize->add_panel('vg_panel', [
        'title'       => __('Venice Gardens Theme', 'venicegarden'),
        'description' => __('Global theme settings. Most content is also editable in Elementor widgets.', 'venicegarden'),
        'priority'    => 10,
    ]);

    /* ── Section: Brand Colors ───────────────────────────────── */
    $wp_customize->add_section('vg_colors', [
        'title'    => __('Brand Colors', 'venicegarden'),
        'panel'    => 'vg_panel',
        'priority' => 10,
    ]);

    $colors = [
        'vg_color_gold'     => ['label' => __('Gold (Primary Accent)', 'venicegarden'),    'default' => '#C9972A'],
        'vg_color_obsidian' => ['label' => __('Obsidian (Dark Background)', 'venicegarden'), 'default' => '#0D0D0D'],
        'vg_color_cream'    => ['label' => __('Cream (Light Background)', 'venicegarden'),  'default' => '#F7F3EC'],
    ];

    foreach ($colors as $key => $opts) {
        $wp_customize->add_setting($key, [
            'default'           => $opts['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $key, [
            'label'   => $opts['label'],
            'section' => 'vg_colors',
        ]));
    }

    /* ── Section: Contact Details ────────────────────────────── */
    $wp_customize->add_section('vg_contact', [
        'title'    => __('Contact Details', 'venicegarden'),
        'panel'    => 'vg_panel',
        'priority' => 20,
    ]);

    $contact_fields = [
        'vg_email_general'      => ['label' => __('General Email', 'venicegarden'),       'default' => 'info@venicegardensdistribution.com'],
        'vg_email_partnerships' => ['label' => __('Partnerships Email', 'venicegarden'),   'default' => 'partnerships@venicegardensdistribution.com'],
        'vg_hq_city'            => ['label' => __('HQ City', 'venicegarden'),              'default' => 'Lagos, Nigeria'],
        'vg_offices_text'       => ['label' => __('Regional Offices Text', 'venicegarden'), 'default' => 'Accra, Ghana · Kigali, Rwanda'],
    ];

    foreach ($contact_fields as $key => $opts) {
        $wp_customize->add_setting($key, [
            'default'           => $opts['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control($key, [
            'label'   => $opts['label'],
            'section' => 'vg_contact',
            'type'    => 'text',
        ]);
    }

    /* ── Section: Footer ─────────────────────────────────────── */
    $wp_customize->add_section('vg_footer_settings', [
        'title'    => __('Footer Text', 'venicegarden'),
        'panel'    => 'vg_panel',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('vg_footer_tagline', [
        'default'           => "Africa's Pride & Distributor of Note",
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('vg_footer_tagline', [
        'label'   => __('Footer Tagline', 'venicegarden'),
        'section' => 'vg_footer_settings',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('vg_copyright', [
        'default'           => '© ' . gmdate('Y') . ' Venice Gardens Distribution. All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('vg_copyright', [
        'label'   => __('Copyright Text', 'venicegarden'),
        'section' => 'vg_footer_settings',
        'type'    => 'text',
    ]);
});

/**
 * Output dynamic CSS custom properties for color overrides.
 * This lets Customizer color changes take effect globally.
 */
add_action('wp_head', function (): void {
    $gold     = get_theme_mod('vg_color_gold', '#C9972A');
    $obsidian = get_theme_mod('vg_color_obsidian', '#0D0D0D');
    $cream    = get_theme_mod('vg_color_cream', '#F7F3EC');

    if ($gold === '#C9972A' && $obsidian === '#0D0D0D' && $cream === '#F7F3EC') {
        return;
    }

    echo '<style id="vg-customizer-colors">:root{';
    if ($gold !== '#C9972A') {
        echo '--gold:' . esc_attr($gold) . ';';
    }
    if ($obsidian !== '#0D0D0D') {
        echo '--obsidian:' . esc_attr($obsidian) . ';';
    }
    if ($cream !== '#F7F3EC') {
        echo '--cream:' . esc_attr($cream) . ';';
    }
    echo '}</style>';
}, 20);
