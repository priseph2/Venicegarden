<?php
declare(strict_types=1);

/**
 * Render a WordPress nav menu for use inside Elementor widgets.
 * Returns the HTML string so widgets can echo it inside their render().
 */
function vg_get_nav_menu(string $location, array $args = []): string {
    if (!has_nav_menu($location)) {
        return '';
    }
    ob_start();
    wp_nav_menu(array_merge([
        'theme_location' => $location,
        'container'      => false,
        'items_wrap'     => '%3$s',
        'fallback_cb'    => false,
        'walker'         => new VG_Nav_Walker(),
    ], $args));
    return ob_get_clean() ?: '';
}

/**
 * Return a list of registered WordPress nav menus for Elementor select controls.
 * Format: [ '' => 'Select a Menu', 'primary' => 'Primary Navigation', ... ]
 */
function vg_get_menus_for_select(): array {
    $options = ['' => esc_html__('— Select a Menu —', 'venicegarden')];
    $navs = wp_get_nav_menus();
    foreach ($navs as $nav) {
        $options[$nav->slug] = esc_html($nav->name);
    }
    return $options;
}

/**
 * Render a WordPress menu by slug (not location) for Elementor widgets.
 */
function vg_get_menu_by_slug(string $slug, array $args = []): string {
    if (empty($slug)) {
        return '';
    }
    $menu = wp_get_nav_menu_object($slug);
    if (!$menu) {
        return '';
    }
    ob_start();
    wp_nav_menu(array_merge([
        'menu'       => $menu,
        'container'  => false,
        'items_wrap' => '%3$s',
        'fallback_cb'=> false,
        'walker'     => new VG_Nav_Walker(),
    ], $args));
    return ob_get_clean() ?: '';
}

/**
 * Simple nav walker that outputs <a> tags only (no wrapping <li>).
 * Used in the VG Nav widget to replicate the original HTML structure.
 */
class VG_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0): void {
        $item    = $data_object;
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $class_str = implode(' ', array_filter($classes));

        $active = in_array('current-menu-item', $classes, true) || in_array('current_page_item', $classes, true);
        if ($active) {
            $class_str .= ' active';
        }

        $atts = [
            'href'   => $item->url ?? '#',
            'class'  => trim($class_str),
            'title'  => $item->attr_title ?? '',
            'target' => $item->target ?? '',
            'rel'    => $item->xfn ?? '',
        ];

        $att_str = '';
        foreach ($atts as $key => $val) {
            if (!empty($val)) {
                $att_str .= ' ' . esc_attr($key) . '="' . esc_attr($val) . '"';
            }
        }

        $output .= '<a' . $att_str . '>' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null): void {}
    public function start_lvl(&$output, $depth = 0, $args = null): void {}
    public function end_lvl(&$output, $depth = 0, $args = null): void {}
}

/**
 * Get the Elementor-built content of a page by its post ID.
 * Used to render header/footer Elementor templates.
 */
function vg_get_elementor_content(int $post_id): string {
    if (!$post_id || !class_exists('\Elementor\Plugin')) {
        return '';
    }

    $plugin = \Elementor\Plugin::$instance;

    // Skip nested Elementor rendering inside the editor or preview iframe —
    // calling get_builder_content_for_display() for a *different* post ID
    // while Elementor is editing another page causes the "content area not
    // found" error and breaks the editor.
    if (
        isset($plugin->editor)  && $plugin->editor->is_edit_mode()  ||
        isset($plugin->preview) && $plugin->preview->is_preview_mode()
    ) {
        return '';
    }

    return $plugin->frontend->get_builder_content_for_display($post_id, true);
}

/**
 * Escape and output a widget setting that may contain basic HTML.
 */
function vg_kses_post(string $html): string {
    return wp_kses_post($html);
}

/**
 * Arrow SVG used in CTA buttons.
 */
function vg_arrow_svg(): string {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';
}

/**
 * Send SVG icon.
 */
function vg_send_svg(): string {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>';
}
