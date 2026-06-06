<?php
declare(strict_types=1);

/* ── Palette definitions (single source of truth) ────────────── */
function vg_get_color_palettes(): array {
    return [
        'a' => [
            'label'    => __('Option A — Platinum & Champagne', 'venicegarden'),
            'gold'     => '#b09a5b',
            'obsidian' => '#111111',
            'cream'    => '#f7f7f7',
        ],
        'b' => [
            'label'    => __('Option B — Classic Black & Gold', 'venicegarden'),
            'gold'     => '#c4a747',
            'obsidian' => '#1a1a1a',
            'cream'    => '#fafaf8',
        ],
        'c' => [
            'label'    => __('Option C — Monochrome & Brass', 'venicegarden'),
            'gold'     => '#a8893a',
            'obsidian' => '#0d0d0d',
            'cream'    => '#f4f4f4',
        ],
        'custom' => [
            'label' => __('Custom Colors', 'venicegarden'),
        ],
    ];
}

/* Returns the three active colours regardless of mode (preset or custom) */
function vg_get_active_palette_colors(): array {
    $key      = get_theme_mod('vg_color_palette', 'a');
    $palettes = vg_get_color_palettes();

    if ($key !== 'custom' && isset($palettes[$key])) {
        return $palettes[$key];
    }

    return [
        'gold'     => get_theme_mod('vg_color_gold',     '#b09a5b'),
        'obsidian' => get_theme_mod('vg_color_obsidian', '#111111'),
        'cream'    => get_theme_mod('vg_color_cream',    '#f7f7f7'),
    ];
}

/* ── Customizer registration ─────────────────────────────────── */
add_action('customize_register', function (WP_Customize_Manager $wp_customize): void {

    /* Panel */
    $wp_customize->add_panel('vg_panel', [
        'title'       => __('Venice Gardens Theme', 'venicegarden'),
        'description' => __('Global theme settings. Most content is editable inside Elementor widgets.', 'venicegarden'),
        'priority'    => 10,
    ]);

    /* ── Section: Brand Colors ───────────────────────────────── */
    $wp_customize->add_section('vg_colors', [
        'title'    => __('Brand Colors', 'venicegarden'),
        'panel'    => 'vg_panel',
        'priority' => 10,
    ]);

    /* Palette selector */
    $palettes     = vg_get_color_palettes();
    $palette_opts = [];
    foreach ($palettes as $key => $data) {
        $palette_opts[$key] = $data['label'];
    }

    $wp_customize->add_setting('vg_color_palette', [
        'default'           => 'a',
        'sanitize_callback' => function (string $v) use ($palettes): string {
            return array_key_exists($v, $palettes) ? $v : 'a';
        },
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('vg_color_palette', [
        'label'       => __('Colour Palette', 'venicegarden'),
        'description' => implode('<br>', [
            '<strong>A</strong> — Champagne #b09a5b · White #f7f7f7 · Black #111',
            '<strong>B</strong> — Gold #c4a747 · Off-white #fafaf8 · Charcoal #1a1a1a',
            '<strong>C</strong> — Brass #a8893a · Light grey #f4f4f4 · Near-black #0d0d0d',
            '<strong>Custom</strong> — Use the colour pickers below',
        ]),
        'section' => 'vg_colors',
        'type'    => 'select',
        'choices' => $palette_opts,
        'priority' => 1,
    ]);

    /* Individual colour pickers — shown only in Custom mode */
    $custom_colors = [
        'vg_color_gold'     => ['label' => __('Accent / Gold', 'venicegarden'),         'default' => '#b09a5b'],
        'vg_color_obsidian' => ['label' => __('Dark Background / Obsidian', 'venicegarden'), 'default' => '#111111'],
        'vg_color_cream'    => ['label' => __('Light Background / Cream', 'venicegarden'),   'default' => '#f7f7f7'],
    ];

    $priority = 10;
    foreach ($custom_colors as $key => $opts) {
        $wp_customize->add_setting($key, [
            'default'           => $opts['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $key, [
            'label'           => $opts['label'],
            'section'         => 'vg_colors',
            'priority'        => $priority++,
            'active_callback' => function (): bool {
                return get_theme_mod('vg_color_palette', 'a') === 'custom';
            },
        ]));
    }

    /* ── Section: Contact Details ────────────────────────────── */
    $wp_customize->add_section('vg_contact', [
        'title'    => __('Contact Details', 'venicegarden'),
        'panel'    => 'vg_panel',
        'priority' => 20,
    ]);

    $contact_fields = [
        'vg_email_general'      => ['label' => __('General Email', 'venicegarden'),        'default' => 'info@venicegardensdistribution.com'],
        'vg_email_partnerships' => ['label' => __('Partnerships Email', 'venicegarden'),    'default' => 'partnerships@venicegardensdistribution.com'],
        'vg_hq_city'            => ['label' => __('HQ City', 'venicegarden'),               'default' => 'Lagos, Nigeria'],
        'vg_offices_text'       => ['label' => __('Regional Offices Text', 'venicegarden'),  'default' => 'Accra, Ghana · Kigali, Rwanda'],
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

/* ── Output CSS custom properties ────────────────────────────── */
add_action('wp_head', function (): void {
    $colors = vg_get_active_palette_colors();
    echo '<style id="vg-customizer-colors">:root{'
        . '--gold:'     . esc_attr($colors['gold'])     . ';'
        . '--obsidian:' . esc_attr($colors['obsidian']) . ';'
        . '--cream:'    . esc_attr($colors['cream'])    . ';'
        . '}</style>' . "\n";
}, 20);

