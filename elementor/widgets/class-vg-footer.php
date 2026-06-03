<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Footer extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-footer'; }
    public function get_title(): string     { return __('VG Footer', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-footer'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['footer', 'bottom', 'links', 'contact', 'venice']; }

    protected function register_controls(): void {
        /* ── Brand Column ─────────────────────────────────────────────── */
        $this->start_controls_section('section_brand', [
            'label' => __('Brand Column', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('logo_image',   ['label' => __('Logo Image', 'venicegarden'),    'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->add_control('logo_text',    ['label' => __('Logo Name', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'VENICE GARDENS']);
        $this->add_control('logo_sub',     ['label' => __('Logo Tagline', 'venicegarden'),  'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Distribution']);
        $this->add_control('logo_url',     ['label' => __('Logo URL', 'venicegarden'),      'type' => \Elementor\Controls_Manager::URL,      'default' => ['url' => '/']]);
        $this->add_control('about_text',   ['label' => __('About Text', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Africa\'s premier luxury beauty distribution network — connecting the world\'s finest fragrance and beauty brands with Africa\'s most discerning consumers.', 'rows' => 4]);
        $this->end_controls_section();

        /* ── Quick Links ──────────────────────────────────────────────── */
        $this->start_controls_section('section_links', [
            'label' => __('Quick Links Column', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('links_heading', ['label' => __('Column Heading', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Quick Links']);

        $nav_options = function_exists('vg_get_menus_for_select') ? vg_get_menus_for_select() : [];
        $nav_options = array_merge(['' => __('— None —', 'venicegarden')], $nav_options);

        $this->add_control('links_menu', [
            'label'   => __('WordPress Menu', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => $nav_options,
        ]);

        $link_rep = new \Elementor\Repeater();
        $link_rep->add_control('link_text', ['label' => __('Label', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'About Us']);
        $link_rep->add_control('link_url',  ['label' => __('URL', 'venicegarden'),   'type' => \Elementor\Controls_Manager::URL,  'default' => ['url' => '#']]);

        $this->add_control('quick_links', [
            'label'       => __('Fallback Links', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $link_rep->get_controls(),
            'description' => __('Used only when no WordPress menu is selected above.', 'venicegarden'),
            'default'     => [
                ['link_text' => 'About Us',         'link_url' => ['url' => '/about']],
                ['link_text' => 'Our Brands',        'link_url' => ['url' => '/brands']],
                ['link_text' => 'Partner Stores',    'link_url' => ['url' => '/partners']],
                ['link_text' => 'Contact',           'link_url' => ['url' => '/contact']],
            ],
            'title_field' => '{{{ link_text }}}',
        ]);
        $this->end_controls_section();

        /* ── Markets Column ───────────────────────────────────────────── */
        $this->start_controls_section('section_markets', [
            'label' => __('Markets Column', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('markets_heading', ['label' => __('Column Heading', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Our Markets']);

        $mkt_rep = new \Elementor\Repeater();
        $mkt_rep->add_control('mkt_flag',  ['label' => __('Flag Emoji', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🇳🇬']);
        $mkt_rep->add_control('mkt_name',  ['label' => __('Country', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Nigeria']);
        $mkt_rep->add_control('mkt_city',  ['label' => __('City / HQ', 'venicegarden'),  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Lagos']);
        $mkt_rep->add_control('mkt_url',   ['label' => __('URL', 'venicegarden'),         'type' => \Elementor\Controls_Manager::URL,  'default' => ['url' => '#']]);

        $this->add_control('markets', [
            'label'       => __('Markets', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $mkt_rep->get_controls(),
            'default'     => [
                ['mkt_flag' => '🇳🇬', 'mkt_name' => 'Nigeria', 'mkt_city' => 'Lagos (HQ)', 'mkt_url' => ['url' => '#']],
                ['mkt_flag' => '🇬🇭', 'mkt_name' => 'Ghana',   'mkt_city' => 'Accra',      'mkt_url' => ['url' => '#']],
                ['mkt_flag' => '🇷🇼', 'mkt_name' => 'Rwanda',  'mkt_city' => 'Kigali',     'mkt_url' => ['url' => '#']],
            ],
            'title_field' => '{{{ mkt_flag }}} {{{ mkt_name }}}',
        ]);
        $this->end_controls_section();

        /* ── Partners/Brands Column ───────────────────────────────────── */
        $this->start_controls_section('section_brands', [
            'label' => __('Partner Brands Column', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('brands_heading', ['label' => __('Column Heading', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Partner Brands']);

        $brand_rep = new \Elementor\Repeater();
        $brand_rep->add_control('brand_name', ['label' => __('Brand Name', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Brand Name']);
        $brand_rep->add_control('brand_url',  ['label' => __('URL', 'venicegarden'),         'type' => \Elementor\Controls_Manager::URL,  'default' => ['url' => '#']]);

        $this->add_control('brands', [
            'label'       => __('Brands', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $brand_rep->get_controls(),
            'default'     => [
                ['brand_name' => 'Fragrance One',   'brand_url' => ['url' => '#']],
                ['brand_name' => 'Parfums de Marly', 'brand_url' => ['url' => '#']],
                ['brand_name' => 'Initio Parfums',  'brand_url' => ['url' => '#']],
                ['brand_name' => 'Xerjoff',         'brand_url' => ['url' => '#']],
                ['brand_name' => 'Bvlgari',         'brand_url' => ['url' => '#']],
                ['brand_name' => 'Amouage',         'brand_url' => ['url' => '#']],
            ],
            'title_field' => '{{{ brand_name }}}',
        ]);
        $this->end_controls_section();

        /* ── Contact Column ───────────────────────────────────────────── */
        $this->start_controls_section('section_contact', [
            'label' => __('Contact Column', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('contact_heading', ['label' => __('Column Heading', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Get In Touch']);

        $con_rep = new \Elementor\Repeater();
        $con_rep->add_control('con_label', ['label' => __('Label', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'General']);
        $con_rep->add_control('con_value', ['label' => __('Value', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'info@venicegardensng.com']);
        $con_rep->add_control('con_is_email', ['label' => __('Is Email?', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes']);
        $con_rep->add_control('con_url',   ['label' => __('Custom URL (optional)', 'venicegarden'), 'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => ''], 'description' => __('Leave blank to auto-generate mailto: or use as plain text.', 'venicegarden')]);

        $this->add_control('contact_items', [
            'label'       => __('Contact Items', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $con_rep->get_controls(),
            'default'     => [
                ['con_label' => 'General',      'con_value' => 'info@venicegardensng.com',        'con_is_email' => 'yes'],
                ['con_label' => 'Partnerships', 'con_value' => 'partners@venicegardensng.com',    'con_is_email' => 'yes'],
                ['con_label' => 'HQ',           'con_value' => 'Lagos, Nigeria',                  'con_is_email' => ''],
            ],
            'title_field' => '{{{ con_label }}}',
        ]);
        $this->end_controls_section();

        /* ── Footer Bottom Bar ────────────────────────────────────────── */
        $this->start_controls_section('section_bottom', [
            'label' => __('Footer Bottom Bar', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('copyright',     ['label' => __('Copyright Text', 'venicegarden'),   'type' => \Elementor\Controls_Manager::TEXT,    'default' => '© 2024 Venice Gardens Distribution. All rights reserved.']);
        $this->add_control('bottom_tagline',['label' => __('Tagline', 'venicegarden'),           'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Africa\'s Premier Luxury Beauty Distribution Network']);

        $bl_rep = new \Elementor\Repeater();
        $bl_rep->add_control('bl_text', ['label' => __('Label', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Privacy Policy']);
        $bl_rep->add_control('bl_url',  ['label' => __('URL', 'venicegarden'),   'type' => \Elementor\Controls_Manager::URL,  'default' => ['url' => '#']]);

        $this->add_control('bottom_links', [
            'label'       => __('Bottom Links', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $bl_rep->get_controls(),
            'default'     => [
                ['bl_text' => 'Privacy Policy',  'bl_url' => ['url' => '#']],
                ['bl_text' => 'Terms of Use',    'bl_url' => ['url' => '#']],
            ],
            'title_field' => '{{{ bl_text }}}',
        ]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s      = $this->get_settings_for_display();
        $logo_url = esc_url($s['logo_url']['url'] ?? '/');
        $img_url  = esc_url($s['logo_image']['url'] ?? '');
        ?>
        <footer class="site-footer">
            <div class="container">
                <div class="footer-grid">

                    <!-- Brand Column -->
                    <div class="footer-brand">
                        <a href="<?php echo $logo_url; ?>" class="footer-logo">
                            <?php if ($img_url) : ?>
                            <img src="<?php echo $img_url; ?>" alt="<?php echo esc_attr($s['logo_text'] ?? 'Logo'); ?>" loading="lazy">
                            <?php else : ?>
                            <div class="nav-logo">
                                <?php if (!empty($s['logo_text'])) : ?>
                                <span class="nav-logo__name"><?php echo esc_html($s['logo_text']); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($s['logo_sub'])) : ?>
                                <span class="nav-logo__sub"><?php echo esc_html($s['logo_sub']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </a>
                        <?php if (!empty($s['about_text'])) : ?>
                        <p class="footer-about"><?php echo esc_html($s['about_text']); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Links Column -->
                    <div class="footer-col">
                        <?php if (!empty($s['links_heading'])) : ?>
                        <h5 class="footer-col__heading"><?php echo esc_html($s['links_heading']); ?></h5>
                        <?php endif; ?>
                        <?php
                        $menu_slug = $s['links_menu'] ?? '';
                        if ($menu_slug && function_exists('vg_get_menu_by_slug')) {
                            echo vg_get_menu_by_slug($menu_slug, ['menu_class' => 'footer-links', 'walker' => new VG_Nav_Walker()]);
                        } else {
                            $links = $s['quick_links'] ?? [];
                            if ($links) : ?>
                            <ul class="footer-links">
                                <?php foreach ($links as $link) : ?>
                                <li><a href="<?php echo esc_url($link['link_url']['url'] ?? '#'); ?>"><?php echo esc_html($link['link_text'] ?? ''); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif;
                        } ?>
                    </div>

                    <!-- Markets Column -->
                    <div class="footer-col">
                        <?php if (!empty($s['markets_heading'])) : ?>
                        <h5 class="footer-col__heading"><?php echo esc_html($s['markets_heading']); ?></h5>
                        <?php endif; ?>
                        <ul class="footer-markets">
                            <?php foreach (($s['markets'] ?? []) as $mkt) : ?>
                            <li>
                                <a href="<?php echo esc_url($mkt['mkt_url']['url'] ?? '#'); ?>">
                                    <span class="footer-market__flag"><?php echo esc_html($mkt['mkt_flag'] ?? ''); ?></span>
                                    <span>
                                        <strong><?php echo esc_html($mkt['mkt_name'] ?? ''); ?></strong>
                                        <?php if (!empty($mkt['mkt_city'])) : ?>
                                        <small><?php echo esc_html($mkt['mkt_city']); ?></small>
                                        <?php endif; ?>
                                    </span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Partner Brands Column -->
                    <div class="footer-col">
                        <?php if (!empty($s['brands_heading'])) : ?>
                        <h5 class="footer-col__heading"><?php echo esc_html($s['brands_heading']); ?></h5>
                        <?php endif; ?>
                        <ul class="footer-brands-list">
                            <?php foreach (($s['brands'] ?? []) as $brand) : ?>
                            <li><a href="<?php echo esc_url($brand['brand_url']['url'] ?? '#'); ?>"><?php echo esc_html($brand['brand_name'] ?? ''); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Contact Column -->
                    <div class="footer-col">
                        <?php if (!empty($s['contact_heading'])) : ?>
                        <h5 class="footer-col__heading"><?php echo esc_html($s['contact_heading']); ?></h5>
                        <?php endif; ?>
                        <ul class="footer-contact-list">
                            <?php foreach (($s['contact_items'] ?? []) as $item) :
                                $val      = $item['con_value']    ?? '';
                                $is_email = !empty($item['con_is_email']) && $item['con_is_email'] === 'yes';
                                $custom   = $item['con_url']['url'] ?? '';
                                $href     = $custom ? esc_url($custom) : ($is_email ? 'mailto:' . antispambot($val) : '');
                            ?>
                            <li>
                                <?php if (!empty($item['con_label'])) : ?>
                                <span class="footer-contact__label"><?php echo esc_html($item['con_label']); ?></span>
                                <?php endif; ?>
                                <?php if ($href) : ?>
                                <a href="<?php echo $href; ?>"><?php echo esc_html($val); ?></a>
                                <?php else : ?>
                                <span><?php echo esc_html($val); ?></span>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div><!-- .footer-grid -->
            </div><!-- .container -->

            <!-- Footer Bottom Bar -->
            <div class="footer-bottom">
                <div class="container">
                    <div class="footer-bottom__inner">
                        <div class="footer-bottom__left">
                            <?php if (!empty($s['copyright'])) : ?>
                            <span class="footer-copyright"><?php echo esc_html($s['copyright']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($s['bottom_tagline'])) : ?>
                            <span class="footer-tagline"><?php echo esc_html($s['bottom_tagline']); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php $bottom_links = $s['bottom_links'] ?? []; if ($bottom_links) : ?>
                        <ul class="footer-bottom__links">
                            <?php foreach ($bottom_links as $bl) : ?>
                            <li><a href="<?php echo esc_url($bl['bl_url']['url'] ?? '#'); ?>"><?php echo esc_html($bl['bl_text'] ?? ''); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </footer>
        <?php
    }
}
