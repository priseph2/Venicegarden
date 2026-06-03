<?php
declare(strict_types=1);

if (!is_admin()) return;

/* ── Admin menu ─────────────────────────────────────────────── */
add_action('admin_menu', function(): void {
    add_theme_page(
        __('Import Demo Content', 'venicegarden'),
        __('Import Demo Content', 'venicegarden'),
        'manage_options',
        'vg-demo-import',
        'vg_render_demo_import_page'
    );
});

/* ── Admin page ─────────────────────────────────────────────── */
function vg_render_demo_import_page(): void {
    if (!current_user_can('manage_options')) return;

    $imported = (bool) get_option('vg_demo_imported', false);
    $log      = [];

    if (
        isset($_POST['vg_import_nonce']) &&
        wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['vg_import_nonce'])), 'vg_do_import')
    ) {
        $log     = vg_run_demo_import();
        $imported = true;
        update_option('vg_demo_imported', true);
    }
    ?>
    <div class="wrap vg-admin-wrap">
        <h1>
            <?php esc_html_e('Venice Gardens — Demo Content', 'venicegarden'); ?>
            <span class="vg-badge-gold">One Click</span>
        </h1>
        <p class="vg-admin-subtitle"><?php esc_html_e('Import sample pages, menus, and content entries to get started quickly.', 'venicegarden'); ?></p>

        <?php if (!empty($log)) : ?>
        <div class="notice notice-success is-dismissible">
            <p><strong><?php esc_html_e('Demo content imported!', 'venicegarden'); ?></strong></p>
            <ul style="list-style:disc;padding-left:1.5em;margin:.4em 0">
                <?php foreach ($log as $item) : ?>
                <li><?php echo esc_html($item); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="vg-admin-card">
            <h2><?php esc_html_e('One-Click Import', 'venicegarden'); ?></h2>

            <?php if ($imported && empty($log)) : ?>
            <p style="color:#856404;background:#fff3cd;border:1px solid #ffc107;padding:.75em 1em;border-radius:3px;margin:0 0 1.25em">
                <?php esc_html_e('Demo content was previously imported. Running again will skip already-existing items.', 'venicegarden'); ?>
            </p>
            <?php endif; ?>

            <p><?php esc_html_e('Creates sample pages with Elementor header & footer templates pre-configured, navigation menus, and CPT sample entries. Existing content is never overwritten.', 'venicegarden'); ?></p>

            <form method="post">
                <?php wp_nonce_field('vg_do_import', 'vg_import_nonce'); ?>
                <p>
                    <button type="submit" class="button button-primary button-large">
                        <?php echo $imported ? esc_html__('Re-run Demo Import', 'venicegarden') : esc_html__('Import Demo Content', 'venicegarden'); ?>
                    </button>
                </p>
            </form>

            <div class="vg-admin-guide">
                <h3><?php esc_html_e('What gets created', 'venicegarden'); ?></h3>
                <ol>
                    <li><strong><?php esc_html_e('Header & Footer Templates', 'venicegarden'); ?></strong>
                        — <?php esc_html_e('Elementor pages with VG Nav and VG Footer widgets pre-placed and auto-assigned in Theme Settings', 'venicegarden'); ?></li>
                    <li><strong><?php esc_html_e('Site Pages', 'venicegarden'); ?></strong>
                        — <?php esc_html_e('Home, About, Brands, Partners, Contact, Privacy Policy (open each in Elementor editor to build the layout)', 'venicegarden'); ?></li>
                    <li><strong><?php esc_html_e('Navigation Menus', 'venicegarden'); ?></strong>
                        — <?php esc_html_e('Primary, Footer, Markets, Partners menus with items, assigned to all theme locations', 'venicegarden'); ?></li>
                    <li><strong><?php esc_html_e('Sample CPT Entries', 'venicegarden'); ?></strong>
                        — <?php esc_html_e('4 Brands, 4 Team Members, 3 Testimonials, 3 Partner Stores', 'venicegarden'); ?></li>
                    <li><strong><?php esc_html_e('WordPress Settings', 'venicegarden'); ?></strong>
                        — <?php esc_html_e('Sets Home as static front page and auto-configures the header/footer template IDs in Theme Settings', 'venicegarden'); ?></li>
                </ol>
            </div>
        </div>
    </div>
    <?php
}

/* ── Elementor single-widget page JSON ───────────────────────── */
function vg_elementor_widget_json(string $widget_type, array $settings = []): string {
    static $idx = 0;
    $idx++;
    $i   = str_pad((string) $idx, 3, '0', STR_PAD_LEFT);

    return (string) wp_json_encode([
        [
            'id'       => 'vgs' . $i,
            'elType'   => 'section',
            'settings' => [
                'layout'  => 'full_width',
                'gap'     => 'no',
                'padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true],
                'margin'  => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true],
            ],
            'elements' => [
                [
                    'id'       => 'vgc' . $i,
                    'elType'   => 'column',
                    'settings' => ['_column_size' => 100, '_inline_size' => null],
                    'elements' => [
                        [
                            'id'         => 'vgw' . $i,
                            'elType'     => 'widget',
                            'widgetType' => $widget_type,
                            'settings'   => empty($settings) ? new \stdClass() : $settings,
                            'elements'   => [],
                            'isInner'    => false,
                        ],
                    ],
                    'isInner' => false,
                ],
            ],
            'isInner' => false,
        ],
    ]);
}

/* ── Create page if not already present ──────────────────────── */
function vg_demo_create_page(string $slug, string $title, string $elementor_json = ''): int {
    $existing = get_page_by_path($slug, OBJECT, 'page');
    if ($existing instanceof \WP_Post) {
        return (int) $existing->ID;
    }

    $id = wp_insert_post([
        'post_title'    => $title,
        'post_name'     => $slug,
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_content'  => '',
        'page_template' => 'default',
    ]);

    if (is_wp_error($id) || !$id) return 0;

    update_post_meta($id, '_elementor_edit_mode',    'builder');
    update_post_meta($id, '_elementor_template_type', 'page');
    update_post_meta($id, '_wp_page_template',        'default');

    if ($elementor_json !== '') {
        update_post_meta($id, '_elementor_data', wp_slash($elementor_json));
    }

    return $id;
}

/* ── Create CPT entry if slug doesn't exist ──────────────────── */
function vg_demo_create_cpt(
    string $post_type,
    string $title,
    string $slug,
    string $content = '',
    array  $meta    = [],
    array  $terms   = []
): int {
    $existing = get_posts([
        'post_type'      => $post_type,
        'name'           => $slug,
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ]);
    if (!empty($existing)) return (int) $existing[0];

    $id = wp_insert_post([
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_status'  => 'publish',
        'post_type'    => $post_type,
        'post_content' => $content,
    ]);

    if (is_wp_error($id) || !$id) return 0;

    foreach ($meta as $key => $value) {
        update_post_meta($id, $key, $value);
    }

    foreach ($terms as $taxonomy => $names) {
        $ids = [];
        foreach ($names as $name) {
            $t = term_exists($name, $taxonomy);
            if (!$t) {
                $t = wp_insert_term($name, $taxonomy);
            }
            if (!is_wp_error($t) && is_array($t)) {
                $ids[] = (int) $t['term_id'];
            }
        }
        if ($ids) {
            wp_set_object_terms($id, $ids, $taxonomy);
        }
    }

    return $id;
}

/* ── Main import runner ──────────────────────────────────────── */
function vg_run_demo_import(): array {
    $log = [];

    /* 1 ── Header template */
    $nav_json = vg_elementor_widget_json('venicegarden-nav', [
        'logo_name'          => 'VENICE GARDENS',
        'logo_tagline'       => 'Distribution',
        'cta_text'           => 'Get in Touch',
        'cta_url'            => ['url' => '/contact', 'is_external' => '', 'nofollow' => ''],
        'transparent_on_top' => 'yes',
    ]);
    $header_id = vg_demo_create_page('vg-header-template', 'Site Header', $nav_json);
    if ($header_id) {
        update_option('vg_header_template_id', $header_id);
        $log[] = "Header template page created (ID {$header_id}) and set in Theme Settings";
    }

    /* 2 ── Footer template */
    $footer_json = vg_elementor_widget_json('venicegarden-footer', [
        'logo_name'  => 'VENICE GARDENS',
        'logo_sub'   => 'Distribution',
        'about_text' => "Africa's premier luxury beauty distribution network — connecting the world's finest fragrance and beauty brands with Africa's most discerning consumers.",
        'copyright'  => '© 2024 Venice Gardens Distribution. All rights reserved.',
        'bottom_tagline' => "Africa's Premier Luxury Beauty Distribution Network",
    ]);
    $footer_id = vg_demo_create_page('vg-footer-template', 'Site Footer', $footer_json);
    if ($footer_id) {
        update_option('vg_footer_template_id', $footer_id);
        $log[] = "Footer template page created (ID {$footer_id}) and set in Theme Settings";
    }

    /* 3 ── Pages */
    $page_defs = [
        'home'           => 'Home',
        'about'          => 'About Us',
        'brands'         => 'Our Brands',
        'partners'       => 'Partner Stores',
        'contact'        => 'Contact',
        'privacy-policy' => 'Privacy Policy',
    ];
    $page_ids = [];
    foreach ($page_defs as $slug => $title) {
        $pid = vg_demo_create_page($slug, $title);
        if ($pid) {
            $page_ids[$slug] = $pid;
            $log[] = "Page: {$title} (ID {$pid})";
        }
    }

    /* Set static front page */
    if (!empty($page_ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_ids['home']);
        $log[] = 'Set static front page → Home';
    }

    /* 4 ── Brands */
    $brands = [
        ['Fragrance One',       'fragrance-one',       'Fragrance', 'A contemporary fragrance house built for the modern connoisseur.'],
        ['Parfums de Marly',    'parfums-de-marly',    'Fragrance', 'Inspired by 18th-century French royal court perfumery traditions.'],
        ['Initio Parfums Privés','initio-parfums-prives','Fragrance', 'Science-driven luxury fragrances that stimulate powerful emotions.'],
        ['Xerjoff',             'xerjoff',              'Fragrance', 'Italian niche perfumery fusing art, craftsmanship, and rare materials.'],
    ];
    foreach ($brands as [$name, $slug, $cat, $desc]) {
        $id = vg_demo_create_cpt('vg_brand', $name, $slug, $desc, [], ['vg_brand_category' => [$cat]]);
        if ($id) $log[] = "Brand: {$name}";
    }

    /* 5 ── Team Members */
    $members = [
        ['Executive Leadership',  'executive-leadership', 'C-Suite'],
        ['Brand Management',      'brand-management',     'Brand Division'],
        ['Sales & Distribution',  'sales-distribution',   'Commercial Division'],
        ['Creative & Marketing',  'creative-marketing',   'Marketing Division'],
    ];
    foreach ($members as [$name, $slug, $div]) {
        $id = vg_demo_create_cpt('vg_team_member', $name, $slug, '', [], ['vg_team_division' => [$div]]);
        if ($id) $log[] = "Team Member: {$name}";
    }

    /* 6 ── Testimonials */
    $testimonials = [
        [
            'Testimonial — Luxury Retailer',
            'testimonial-luxury-retailer',
            'Venice Gardens has been an exceptional distribution partner. Their professionalism and market reach across Africa is unmatched.',
            ['_vg_testimonial_author' => 'CEO, Premium Retail Group', '_vg_testimonial_company' => 'Premium Retail Group'],
        ],
        [
            'Testimonial — Fragrance House',
            'testimonial-fragrance-house',
            'The team at Venice Gardens understands luxury. They positioned our brand perfectly in the African market and delivered outstanding results.',
            ['_vg_testimonial_author' => 'Brand Director', '_vg_testimonial_company' => 'European Fragrance House'],
        ],
        [
            'Testimonial — Hotel Partner',
            'testimonial-hotel-partner',
            'Our boutique partnership with Venice Gardens has elevated the guest experience at our properties across three African capitals.',
            ['_vg_testimonial_author' => 'Head of Partnerships', '_vg_testimonial_company' => '5-Star Hotel Group'],
        ],
    ];
    foreach ($testimonials as [$title, $slug, $content, $meta]) {
        $id = vg_demo_create_cpt('vg_testimonial', $title, $slug, $content, $meta);
        if ($id) $log[] = "Testimonial: {$title}";
    }

    /* 7 ── Partner Stores */
    $stores = [
        ['Ikeja City Mall',           'ikeja-city-mall',           'Nigeria', 'Shopping Mall', 'Ikeja, Lagos, Nigeria'],
        ['Accra Mall',                'accra-mall',                'Ghana',   'Shopping Mall', 'Spintex Road, Accra, Ghana'],
        ['Kigali Convention Centre',  'kigali-convention-centre',  'Rwanda',  'Flagship Hub',  'KG 2 Roundabout, Kigali, Rwanda'],
    ];
    foreach ($stores as [$name, $slug, $country, $type, $address]) {
        $id = vg_demo_create_cpt(
            'vg_partner_store', $name, $slug, '',
            ['_vg_store_address' => $address],
            ['vg_store_country' => [$country], 'vg_store_type' => [$type]]
        );
        if ($id) $log[] = "Partner Store: {$name}";
    }

    /* 8 ── Navigation menus */
    $menu_defs = [
        'primary' => [
            'label' => 'Primary Navigation',
            'items' => [
                ['Home',           home_url('/')],
                ['About Us',       home_url('/about/')],
                ['Our Brands',     home_url('/brands/')],
                ['Partner Stores', home_url('/partners/')],
                ['Contact',        home_url('/contact/')],
            ],
        ],
        'footer' => [
            'label' => 'Footer Navigation',
            'items' => [
                ['About Us',       home_url('/about/')],
                ['Our Brands',     home_url('/brands/')],
                ['Partner Stores', home_url('/partners/')],
                ['Contact',        home_url('/contact/')],
                ['Privacy Policy', home_url('/privacy-policy/')],
            ],
        ],
        'markets' => [
            'label' => 'Our Markets',
            'items' => [
                ['🇳🇬 Nigeria', home_url('/partners/#nigeria')],
                ['🇬🇭 Ghana',   home_url('/partners/#ghana')],
                ['🇷🇼 Rwanda',  home_url('/partners/#rwanda')],
            ],
        ],
        'partners' => [
            'label' => 'Partner Brands',
            'items' => [
                ['Fragrance One',    '#'],
                ['Parfums de Marly', '#'],
                ['Initio Parfums',   '#'],
                ['Xerjoff',          '#'],
            ],
        ],
    ];

    $registered_locations = [];
    foreach ($menu_defs as $location => $def) {
        $existing = wp_get_nav_menu_object($def['label']);
        $menu_id  = $existing ? (int) $existing->term_id : (int) wp_create_nav_menu($def['label']);

        if (!$menu_id || is_wp_error($menu_id)) continue;

        /* Only populate items if menu is empty */
        if (empty(wp_get_nav_menu_items($menu_id))) {
            foreach ($def['items'] as $pos => [$title, $url]) {
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title'    => $title,
                    'menu-item-url'      => $url,
                    'menu-item-status'   => 'publish',
                    'menu-item-type'     => 'custom',
                    'menu-item-position' => $pos + 1,
                ]);
            }
        }

        $registered_locations[$location] = $menu_id;
        $log[] = "Menu: {$def['label']}";
    }

    /* Assign menus to theme locations */
    if (!empty($registered_locations)) {
        $current = get_theme_mod('nav_menu_locations', []);
        set_theme_mod('nav_menu_locations', array_merge($current, $registered_locations));
        $log[] = 'Menus assigned to all theme locations';
    }

    $log[] = '✓ Import complete — go to Appearance › VG Theme Settings to confirm header/footer templates';
    return $log;
}
