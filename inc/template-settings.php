<?php
declare(strict_types=1);

/**
 * Venice Gardens Theme Settings — Header & Footer Template Assignment.
 *
 * Adds an admin page under Appearance > VG Theme Settings where the site owner
 * can pick which Elementor-built pages serve as the global header and footer.
 * No content is hardcoded: if templates are set, Elementor renders them;
 * otherwise the page renders without a header/footer until they are configured.
 */

add_action('admin_menu', function (): void {
    add_theme_page(
        __('VG Theme Settings', 'venicegarden'),
        __('VG Theme Settings', 'venicegarden'),
        'manage_options',
        'vg-theme-settings',
        'vg_render_theme_settings_page'
    );
});

add_action('admin_init', function (): void {
    register_setting('vg_theme_settings', 'vg_header_template_id', [
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
        'default'           => 0,
    ]);
    register_setting('vg_theme_settings', 'vg_footer_template_id', [
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
        'default'           => 0,
    ]);

    add_settings_section('vg_templates_section', __('Header & Footer Templates', 'venicegarden'), '__return_false', 'vg-theme-settings');

    add_settings_field('vg_header_template_id', __('Header Template Page', 'venicegarden'), 'vg_render_template_field', 'vg-theme-settings', 'vg_templates_section', ['key' => 'vg_header_template_id', 'label' => __('Select the Elementor-built page to use as the site header.', 'venicegarden')]);
    add_settings_field('vg_footer_template_id', __('Footer Template Page', 'venicegarden'), 'vg_render_template_field', 'vg-theme-settings', 'vg_templates_section', ['key' => 'vg_footer_template_id', 'label' => __('Select the Elementor-built page to use as the site footer.', 'venicegarden')]);
});

function vg_render_template_field(array $args): void {
    $key     = $args['key'];
    $current = (int) get_option($key, 0);
    $pages   = get_posts([
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ]);
    echo '<select name="' . esc_attr($key) . '" id="' . esc_attr($key) . '">';
    echo '<option value="0">' . esc_html__('— None —', 'venicegarden') . '</option>';
    foreach ($pages as $page) {
        $selected = selected($current, $page->ID, false);
        echo '<option value="' . esc_attr((string) $page->ID) . '"' . $selected . '>' . esc_html($page->post_title) . ' (ID: ' . esc_html((string) $page->ID) . ')</option>';
    }
    echo '</select>';
    echo '<p class="description">' . esc_html($args['label']) . '</p>';
}

function vg_render_theme_settings_page(): void {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <p><?php esc_html_e('Build your header and footer as regular pages in Elementor (using the VG Nav and VG Footer widgets), then assign them below. All content is 100% controlled through Elementor.', 'venicegarden'); ?></p>
        <hr>
        <form method="post" action="options.php">
            <?php
            settings_fields('vg_theme_settings');
            do_settings_sections('vg-theme-settings');
            submit_button(__('Save Settings', 'venicegarden'));
            ?>
        </form>
        <hr>
        <h2><?php esc_html_e('Quick Setup Guide', 'venicegarden'); ?></h2>
        <ol>
            <li><?php esc_html_e('Create a new Page and title it "Site Header".', 'venicegarden'); ?></li>
            <li><?php esc_html_e('Set its page template to "Elementor Canvas" so it renders without a header/footer of its own.', 'venicegarden'); ?></li>
            <li><?php esc_html_e('Edit the page with Elementor and add the VG Nav widget.', 'venicegarden'); ?></li>
            <li><?php esc_html_e('Repeat for "Site Footer" using the VG Footer widget.', 'venicegarden'); ?></li>
            <li><?php esc_html_e('Assign both pages above and save.', 'venicegarden'); ?></li>
        </ol>
    </div>
    <?php
}

function vg_get_header_template_id(): int {
    return (int) get_option('vg_header_template_id', 0);
}

function vg_get_footer_template_id(): int {
    return (int) get_option('vg_footer_template_id', 0);
}

/* ── Admin bar shortcuts: Edit Header / Edit Footer ──────────── */
add_action('admin_bar_menu', function (\WP_Admin_Bar $admin_bar): void {
    if (!current_user_can('edit_pages')) return;

    $header_id = vg_get_header_template_id();
    $footer_id = vg_get_footer_template_id();

    if (!$header_id && !$footer_id) return;

    $admin_bar->add_node([
        'id'    => 'vg-templates',
        'title' => '⚡ VG Templates',
        'href'  => admin_url('themes.php?page=vg-theme-settings'),
    ]);

    if ($header_id) {
        $admin_bar->add_node([
            'id'     => 'vg-edit-header',
            'parent' => 'vg-templates',
            'title'  => 'Edit Header',
            'href'   => admin_url('post.php?post=' . $header_id . '&action=elementor'),
            'meta'   => ['target' => '_blank'],
        ]);
    }

    if ($footer_id) {
        $admin_bar->add_node([
            'id'     => 'vg-edit-footer',
            'parent' => 'vg-templates',
            'title'  => 'Edit Footer',
            'href'   => admin_url('post.php?post=' . $footer_id . '&action=elementor'),
            'meta'   => ['target' => '_blank'],
        ]);
    }
}, 100);
