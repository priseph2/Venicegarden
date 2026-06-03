<?php
declare(strict_types=1);

add_action('init', function (): void {
    register_nav_menus([
        'primary'   => __('Primary Navigation', 'venicegarden'),
        'footer'    => __('Footer Quick Links', 'venicegarden'),
        'markets'   => __('Footer Markets', 'venicegarden'),
        'partners'  => __('Footer Partners', 'venicegarden'),
    ]);
});
