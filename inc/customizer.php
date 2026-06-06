<?php
declare(strict_types=1);

add_action('customize_register', function (WP_Customize_Manager $wp_customize): void {

    /* Panel */
    $wp_customize->add_panel('vg_panel', [
        'title'       => __('Venice Gardens Theme', 'venicegarden'),
        'description' => __('Global theme settings. Most content is editable inside Elementor widgets.', 'venicegarden'),
        'priority'    => 10,
    ]);

    /* ── Section: Contact Details ────────────────────────────── */
    $wp_customize->add_section('vg_contact', [
        'title'    => __('Contact Details', 'venicegarden'),
        'panel'    => 'vg_panel',
        'priority' => 10,
    ]);

    $contact_fields = [
        'vg_email_general'      => ['label' => __('General Email', 'venicegarden'),           'default' => 'info@venicegardensdistribution.com'],
        'vg_email_partnerships' => ['label' => __('Partnerships Email', 'venicegarden'),       'default' => 'partnerships@venicegardensdistribution.com'],
        'vg_hq_city'            => ['label' => __('HQ City', 'venicegarden'),                  'default' => 'Lagos, Nigeria'],
        'vg_offices_text'       => ['label' => __('Regional Offices Text', 'venicegarden'),    'default' => 'Accra, Ghana · Kigali, Rwanda'],
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
        'priority' => 20,
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
