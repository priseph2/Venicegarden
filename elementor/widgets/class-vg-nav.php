<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Nav extends \Elementor\Widget_Base {

    public function get_name(): string    { return 'venicegarden-nav'; }
    public function get_title(): string   { return __('VG Navigation', 'venicegarden'); }
    public function get_icon(): string    { return 'eicon-nav-menu'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array { return ['nav', 'menu', 'header', 'navigation', 'venice']; }

    protected function register_controls(): void {

        /* ── Logo ──────────────────────────────────────────────── */
        $this->start_controls_section('section_logo', [
            'label' => __('Logo', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('logo_image', [
            'label'   => __('Logo Image', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => ['url' => ''],
        ]);
        $this->add_control('logo_name', [
            'label'   => __('Brand Name', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Venice Gardens',
        ]);
        $this->add_control('logo_tagline', [
            'label'   => __('Brand Tagline / Subtitle', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Distribution',
        ]);
        $this->add_control('logo_url', [
            'label'       => __('Logo Link URL', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => home_url('/'),
            'default'     => ['url' => home_url('/')],
        ]);
        $this->end_controls_section();

        /* ── Navigation Menu ───────────────────────────────────── */
        $this->start_controls_section('section_menu', [
            'label' => __('Navigation Menu', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('nav_menu', [
            'label'   => __('Select Menu', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => vg_get_menus_for_select(),
            'description' => __('Manage menu items via Appearance → Menus.', 'venicegarden'),
        ]);
        $this->end_controls_section();

        /* ── CTA Button ────────────────────────────────────────── */
        $this->start_controls_section('section_cta', [
            'label' => __('CTA Button', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('cta_text', [
            'label'   => __('Button Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Partner With Us',
        ]);
        $this->add_control('cta_url', [
            'label'       => __('Button URL', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => '#contact',
            'default'     => ['url' => '#'],
        ]);
        $this->end_controls_section();

        /* ── Mobile Menu ───────────────────────────────────────── */
        $this->start_controls_section('section_mobile', [
            'label' => __('Mobile Menu', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('mobile_footer_text', [
            'label'   => __('Mobile Menu Footer Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => "Africa's Pride & Distributor of Note",
        ]);
        $this->end_controls_section();

        /* ── Behaviour ─────────────────────────────────────────── */
        $this->start_controls_section('section_behaviour', [
            'label' => __('Behaviour', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('transparent_on_top', [
            'label'        => __('Transparent until scrolled', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'venicegarden'),
            'label_off'    => __('No', 'venicegarden'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);
        $this->add_control('force_scrolled', [
            'label'        => __('Always show scrolled style', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'venicegarden'),
            'label_off'    => __('No', 'venicegarden'),
            'return_value' => 'yes',
            'default'      => '',
        ]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s = $this->get_settings_for_display();

        $logo_url   = !empty($s['logo_url']['url']) ? esc_url($s['logo_url']['url']) : esc_url(home_url('/'));
        $logo_name  = esc_html($s['logo_name'] ?? 'Venice Gardens');
        $logo_sub   = esc_html($s['logo_tagline'] ?? 'Distribution');
        $logo_img   = !empty($s['logo_image']['url']) ? esc_url($s['logo_image']['url']) : '';
        $cta_text   = esc_html($s['cta_text'] ?? 'Partner With Us');
        $cta_url    = !empty($s['cta_url']['url']) ? esc_url($s['cta_url']['url']) : '#';
        $mob_footer = wp_kses_post($s['mobile_footer_text'] ?? '');
        $scrolled   = !empty($s['force_scrolled']) && $s['force_scrolled'] === 'yes' ? ' scrolled' : '';
        $menu_slug  = $s['nav_menu'] ?? '';
        $menu_html  = $menu_slug ? vg_get_menu_by_slug($menu_slug) : '';
        ?>
        <nav class="site-nav<?php echo esc_attr($scrolled); ?>" aria-label="<?php esc_attr_e('Main navigation', 'venicegarden'); ?>">
            <div class="nav-wrap">
                <a href="<?php echo $logo_url; ?>" class="nav-logo" aria-label="<?php echo $logo_name; ?> — <?php esc_attr_e('Home', 'venicegarden'); ?>">
                    <?php if ($logo_img) : ?>
                    <div class="nav-logo-icon">
                        <img src="<?php echo $logo_img; ?>" alt="<?php echo $logo_name; ?>" width="46" height="46">
                    </div>
                    <?php endif; ?>
                    <div class="nav-logo-text">
                        <span class="ln"><?php echo $logo_name; ?></span>
                        <span class="ls"><?php echo $logo_sub; ?></span>
                    </div>
                </a>

                <div class="nav-links" role="list">
                    <?php echo $menu_html; ?>
                </div>

                <div class="nav-cta">
                    <a href="<?php echo $cta_url; ?>" class="btn btn-gold"><?php echo $cta_text; ?></a>
                </div>

                <button class="nav-toggle" aria-label="<?php esc_attr_e('Open menu', 'venicegarden'); ?>" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </nav>

        <div class="mobile-menu" role="dialog" aria-label="<?php esc_attr_e('Mobile navigation', 'venicegarden'); ?>">
            <?php echo $menu_html; ?>
            <?php if ($mob_footer) : ?>
            <div class="mobile-menu-footer"><?php echo $mob_footer; ?></div>
            <?php endif; ?>
        </div>
        <?php
    }
}
