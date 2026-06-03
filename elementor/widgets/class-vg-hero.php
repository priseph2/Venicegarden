<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Hero extends \Elementor\Widget_Base {

    public function get_name(): string    { return 'venicegarden-hero'; }
    public function get_title(): string   { return __('VG Hero', 'venicegarden'); }
    public function get_icon(): string    { return 'eicon-slider-full-screen'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array { return ['hero', 'banner', 'fullscreen', 'venice']; }

    protected function register_controls(): void {

        /* ── Label ─────────────────────────────────────────────── */
        $this->start_controls_section('section_label', [
            'label' => __('Top Label', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('label_text', [
            'label'   => __('Label Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => "Africa's Pride & Distributor of Note",
        ]);
        $this->add_control('show_label_dot', [
            'label'        => __('Show Dot', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);
        $this->end_controls_section();

        /* ── Heading ───────────────────────────────────────────── */
        $this->start_controls_section('section_heading', [
            'label' => __('Heading', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('heading_line_1', [
            'label'   => __('Heading Line 1', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'The Premier',
        ]);
        $this->add_control('heading_italic_line', [
            'label'       => __('Italic / Accent Line', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'Perfumes & Beauty',
            'description' => __('Displayed in italics with gold accent color.', 'venicegarden'),
        ]);
        $this->add_control('heading_line_3', [
            'label'   => __('Heading Line 3', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Distributor',
        ]);
        $this->end_controls_section();

        /* ── Description ───────────────────────────────────────── */
        $this->start_controls_section('section_desc', [
            'label' => __('Description', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('description', [
            'label'   => __('Description Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Venice Gardens connects the world\'s finest luxury fragrance and beauty brands with Africa\'s most discerning markets across Nigeria, Ghana and Rwanda.',
            'rows'    => 4,
        ]);
        $this->end_controls_section();

        /* ── CTA Buttons ───────────────────────────────────────── */
        $this->start_controls_section('section_cta', [
            'label' => __('CTA Buttons', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('primary_cta_text', [
            'label'   => __('Primary Button Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Partner With Us',
        ]);
        $this->add_control('primary_cta_url', [
            'label'   => __('Primary Button URL', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => ['url' => '#contact'],
        ]);
        $this->add_control('show_primary_arrow', [
            'label'        => __('Show Arrow Icon', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);
        $this->add_control('secondary_cta_text', [
            'label'   => __('Secondary Button Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Explore Our Brands',
        ]);
        $this->add_control('secondary_cta_url', [
            'label'   => __('Secondary Button URL', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => ['url' => '#brands'],
        ]);
        $this->end_controls_section();

        /* ── Location Tag ──────────────────────────────────────── */
        $this->start_controls_section('section_location', [
            'label' => __('Location Tag', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('show_location', [
            'label'        => __('Show Location Tag', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);
        $this->add_control('location_label', [
            'label'     => __('Label', 'venicegarden'),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Presence in',
            'condition' => ['show_location' => 'yes'],
        ]);
        $this->add_control('location_highlight', [
            'label'     => __('Highlighted Text', 'venicegarden'),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Nigeria · Ghana · Rwanda',
            'condition' => ['show_location' => 'yes'],
        ]);
        $this->end_controls_section();

        /* ── Background ────────────────────────────────────────── */
        $this->start_controls_section('section_bg', [
            'label' => __('Background', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('bg_image', [
            'label' => __('Background Image', 'venicegarden'),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ]);
        $this->add_control('bg_position', [
            'label'   => __('Image Position', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'center center',
            'options' => [
                'center center' => 'Center Center',
                'center top'    => 'Center Top',
                'center bottom' => 'Center Bottom',
                'left center'   => 'Left Center',
                'right center'  => 'Right Center',
            ],
        ]);
        $this->end_controls_section();

        /* ── Scroll Cue ────────────────────────────────────────── */
        $this->start_controls_section('section_scroll', [
            'label' => __('Scroll Cue', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('show_scroll_cue', [
            'label'        => __('Show Scroll Cue', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);
        $this->add_control('scroll_cue_text', [
            'label'     => __('Scroll Cue Text', 'venicegarden'),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Scroll',
            'condition' => ['show_scroll_cue' => 'yes'],
        ]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s = $this->get_settings_for_display();

        $bg_url  = !empty($s['bg_image']['url']) ? esc_url($s['bg_image']['url']) : '';
        $bg_pos  = esc_attr($s['bg_position'] ?? 'center center');
        $bg_style = $bg_url ? "background-image:url('{$bg_url}');background-position:{$bg_pos};" : '';

        $p_url = esc_url($s['primary_cta_url']['url'] ?? '#');
        $s_url = esc_url($s['secondary_cta_url']['url'] ?? '#');
        ?>
        <section class="hero" aria-label="<?php esc_attr_e('Hero', 'venicegarden'); ?>">
            <div class="hero-bg" style="<?php echo $bg_style; ?>"></div>
            <div class="hero-content">
                <div class="container">
                    <?php if (!empty($s['label_text'])) : ?>
                    <div class="hero-label">
                        <?php if ($s['show_label_dot'] === 'yes') : ?>
                        <span class="hero-label-dot"></span>
                        <?php endif; ?>
                        <span class="hero-label-text"><?php echo esc_html($s['label_text']); ?></span>
                    </div>
                    <?php endif; ?>

                    <h1>
                        <?php if (!empty($s['heading_line_1'])) echo esc_html($s['heading_line_1']); ?>
                        <?php if (!empty($s['heading_italic_line'])) : ?>
                        <span class="italic-line"><?php echo esc_html($s['heading_italic_line']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($s['heading_line_3'])) echo esc_html($s['heading_line_3']); ?>
                    </h1>

                    <?php if (!empty($s['description'])) : ?>
                    <div class="hero-desc">
                        <p><?php echo esc_html($s['description']); ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="hero-actions">
                        <?php if (!empty($s['primary_cta_text'])) : ?>
                        <a href="<?php echo $p_url; ?>" class="btn btn-gold">
                            <?php echo esc_html($s['primary_cta_text']); ?>
                            <?php if ($s['show_primary_arrow'] === 'yes') echo vg_arrow_svg(); ?>
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($s['secondary_cta_text'])) : ?>
                        <a href="<?php echo $s_url; ?>" class="btn btn-ghost">
                            <?php echo esc_html($s['secondary_cta_text']); ?>
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($s['show_location']) && $s['show_location'] === 'yes') : ?>
                        <div class="hero-divider" aria-hidden="true"></div>
                        <div class="hero-location">
                            <?php echo esc_html($s['location_label'] ?? 'Presence in'); ?>
                            <span><?php echo esc_html($s['location_highlight'] ?? ''); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (!empty($s['show_scroll_cue']) && $s['show_scroll_cue'] === 'yes') : ?>
            <div class="hero-scroll-cue" aria-hidden="true">
                <div class="scroll-mouse"></div>
                <span><?php echo esc_html($s['scroll_cue_text'] ?? 'Scroll'); ?></span>
            </div>
            <?php endif; ?>
        </section>
        <?php
    }
}
