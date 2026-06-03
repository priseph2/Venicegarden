<?php
declare(strict_types=1);

/**
 * Elementor integration: registers the Venice Gardens widget category
 * and loads all 18 custom widgets.
 */

/* ── Guard: only proceed if Elementor is active ─────────────── */
add_action('plugins_loaded', function (): void {
    if (!did_action('elementor/loaded')) {
        return;
    }

    /* Register custom widget category */
    add_action('elementor/elements/categories_registered', function ($elements_manager): void {
        $elements_manager->add_category('venicegarden', [
            'title' => __('Venice Gardens', 'venicegarden'),
            'icon'  => 'eicon-gallery-grid',
        ]);
    });

    /* Register all widgets */
    add_action('elementor/widgets/register', function ($widgets_manager): void {

        $widget_files = [
            'class-vg-nav',
            'class-vg-hero',
            'class-vg-stats-bar',
            'class-vg-marquee',
            'class-vg-about-split',
            'class-vg-brand-grid',
            'class-vg-logo-ticker',
            'class-vg-quote',
            'class-vg-presence',
            'class-vg-values-grid',
            'class-vg-cta-split',
            'class-vg-page-hero',
            'class-vg-team-grid',
            'class-vg-contact-split',
            'class-vg-offices-strip',
            'class-vg-stores-section',
            'class-vg-why-partner',
            'class-vg-footer',
        ];

        foreach ($widget_files as $file) {
            $path = VG_THEME_DIR . '/elementor/widgets/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }

        /* Derive class name from file name: class-vg-hero → VG_Hero */
        $namespace = 'VeniceGarden\\Widgets\\';
        foreach ($widget_files as $file) {
            $class_suffix = str_replace(['class-vg-', '-'], ['VG_', '_'], $file);
            $class_suffix = implode('_', array_map('ucfirst', explode('_', $class_suffix)));
            $fqcn = $namespace . $class_suffix;
            if (class_exists($fqcn)) {
                $widgets_manager->register(new $fqcn());
            }
        }
    });

    /* Allow Elementor to use the canvas template on any page */
    add_action('elementor/page_templates/canvas/before_content', '__return_false');
});
