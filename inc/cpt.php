<?php
declare(strict_types=1);

add_action('init', 'vg_register_post_types');

function vg_register_post_types(): void {

    /* ── Brands ──────────────────────────────────────────────── */
    register_post_type('vg_brand', [
        'labels' => [
            'name'               => __('Brands', 'venicegarden'),
            'singular_name'      => __('Brand', 'venicegarden'),
            'add_new_item'       => __('Add New Brand', 'venicegarden'),
            'edit_item'          => __('Edit Brand', 'venicegarden'),
            'new_item'           => __('New Brand', 'venicegarden'),
            'view_item'          => __('View Brand', 'venicegarden'),
            'search_items'       => __('Search Brands', 'venicegarden'),
            'not_found'          => __('No brands found', 'venicegarden'),
        ],
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-store',
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'rewrite'      => ['slug' => 'brands'],
    ]);

    register_taxonomy('vg_brand_category', 'vg_brand', [
        'labels' => [
            'name'          => __('Brand Categories', 'venicegarden'),
            'singular_name' => __('Brand Category', 'venicegarden'),
            'add_new_item'  => __('Add New Category', 'venicegarden'),
        ],
        'public'       => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'brand-category'],
    ]);

    /* ── Team Members ────────────────────────────────────────── */
    register_post_type('vg_team_member', [
        'labels' => [
            'name'               => __('Team Members', 'venicegarden'),
            'singular_name'      => __('Team Member', 'venicegarden'),
            'add_new_item'       => __('Add Team Member', 'venicegarden'),
            'edit_item'          => __('Edit Team Member', 'venicegarden'),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-groups',
        'supports'     => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'rewrite'      => ['slug' => 'team'],
    ]);

    register_taxonomy('vg_team_division', 'vg_team_member', [
        'labels' => [
            'name'          => __('Divisions', 'venicegarden'),
            'singular_name' => __('Division', 'venicegarden'),
        ],
        'public'       => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'division'],
    ]);

    /* ── Partner Stores ──────────────────────────────────────── */
    register_post_type('vg_partner_store', [
        'labels' => [
            'name'               => __('Partner Stores', 'venicegarden'),
            'singular_name'      => __('Partner Store', 'venicegarden'),
            'add_new_item'       => __('Add Partner Store', 'venicegarden'),
            'edit_item'          => __('Edit Partner Store', 'venicegarden'),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-location-alt',
        'supports'     => ['title', 'custom-fields'],
        'rewrite'      => ['slug' => 'partner-stores'],
    ]);

    register_taxonomy('vg_store_country', 'vg_partner_store', [
        'labels' => [
            'name'          => __('Countries', 'venicegarden'),
            'singular_name' => __('Country', 'venicegarden'),
        ],
        'public'       => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'store-country'],
    ]);

    register_taxonomy('vg_store_type', 'vg_partner_store', [
        'labels' => [
            'name'          => __('Store Types', 'venicegarden'),
            'singular_name' => __('Store Type', 'venicegarden'),
        ],
        'public'       => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'store-type'],
    ]);

    /* ── Testimonials ────────────────────────────────────────── */
    register_post_type('vg_testimonial', [
        'labels' => [
            'name'               => __('Testimonials', 'venicegarden'),
            'singular_name'      => __('Testimonial', 'venicegarden'),
            'add_new_item'       => __('Add Testimonial', 'venicegarden'),
            'edit_item'          => __('Edit Testimonial', 'venicegarden'),
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => ['title', 'editor', 'custom-fields'],
    ]);
}
