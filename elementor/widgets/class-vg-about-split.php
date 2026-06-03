<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_About_Split extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-about-split'; }
    public function get_title(): string     { return __('VG About Split', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-columns'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['about', 'split', 'image', 'text', 'venice']; }

    protected function register_controls(): void {

        /* ── Image ─────────────────────────────────────────────── */
        $this->start_controls_section('section_image', [
            'label' => __('Image', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('image', [
            'label' => __('Image', 'venicegarden'),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ]);
        $this->add_control('image_alt', [
            'label'   => __('Image Alt Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'About Venice Gardens',
        ]);
        $this->add_control('show_badge', [
            'label'        => __('Show Badge', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);
        $this->add_control('badge_year', [
            'label'     => __('Badge Year/Number', 'venicegarden'),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => '2024',
            'condition' => ['show_badge' => 'yes'],
        ]);
        $this->add_control('badge_desc', [
            'label'     => __('Badge Description', 'venicegarden'),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'default'   => "Most Innovative\nCompany Award",
            'rows'      => 2,
            'condition' => ['show_badge' => 'yes'],
        ]);
        $this->add_control('image_position', [
            'label'   => __('Image Side', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'left',
            'options' => ['left' => 'Left', 'right' => 'Right'],
        ]);
        $this->end_controls_section();

        /* ── Content ───────────────────────────────────────────── */
        $this->start_controls_section('section_content', [
            'label' => __('Content', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('eyebrow', [
            'label'   => __('Eyebrow', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Our Story & Overview',
        ]);
        $this->add_control('show_ornament', [
            'label'        => __('Show Ornament', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);
        $this->add_control('heading', [
            'label'   => __('Heading', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Diligence, Authenticity & Dependability',
        ]);
        $this->add_control('quote_text', [
            'label'   => __('Quote Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => '"We always understood that identifying and distributing world-class brands requires diligence and a sound knowledge of the operating territory."',
            'rows'    => 4,
        ]);
        $this->add_control('body_text', [
            'label'   => __('Body Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => '<p>We understand the need for authenticity in every market, eliminating the bottlenecks and risks associated with unqualified middlemen. Intentional and dependable — we seek to earn your trust and build a long-lasting, mutually beneficial relationship.</p>',
        ]);
        $this->end_controls_section();

        /* ── Pills ─────────────────────────────────────────────── */
        $this->start_controls_section('section_pills', [
            'label' => __('Value Pills', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('pill_text', [
            'label'   => __('Pill Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Integrity',
        ]);
        $this->add_control('pills', [
            'label'       => __('Pills', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['pill_text' => 'Integrity'],
                ['pill_text' => 'Transparency'],
                ['pill_text' => 'Innovation'],
                ['pill_text' => 'Excellence'],
            ],
            'title_field' => '{{{ pill_text }}}',
        ]);
        $this->end_controls_section();

        /* ── Buttons ───────────────────────────────────────────── */
        $this->start_controls_section('section_buttons', [
            'label' => __('Buttons', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('primary_cta_text', ['label' => __('Primary Button Text', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Our Full Story']);
        $this->add_control('primary_cta_url',  ['label' => __('Primary Button URL', 'venicegarden'),  'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => '#']]);
        $this->add_control('secondary_cta_text', ['label' => __('Secondary Button Text', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Brands']);
        $this->add_control('secondary_cta_url',  ['label' => __('Secondary Button URL', 'venicegarden'),  'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => '#']]);
        $this->end_controls_section();

        /* ── Background ────────────────────────────────────────── */
        $this->start_controls_section('section_bg', [
            'label' => __('Section Background', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('section_padding', [
            'label'   => __('Padding', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '8.5rem 0',
        ]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s = $this->get_settings_for_display();

        $img_url  = $s['image']['url'] ?? '';
        $img_alt  = esc_attr($s['image_alt'] ?? '');
        $pos      = $s['image_position'] ?? 'left';
        $p_url    = esc_url($s['primary_cta_url']['url'] ?? '#');
        $sec_url  = esc_url($s['secondary_cta_url']['url'] ?? '#');
        $padding  = esc_attr($s['section_padding'] ?? '8.5rem 0');
        ?>
        <section class="section" style="padding:<?php echo $padding; ?>">
            <div class="container">
                <div class="about-split" style="<?php echo $pos === 'right' ? 'direction:rtl' : ''; ?>">
                    <div class="img-frame reveal reveal-left" style="<?php echo $pos === 'right' ? 'direction:ltr' : ''; ?>">
                        <?php if ($img_url) : ?>
                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo $img_alt; ?>" loading="lazy" width="600" height="600">
                        <?php endif; ?>
                        <?php if (!empty($s['show_badge']) && $s['show_badge'] === 'yes') : ?>
                        <div class="img-badge" style="<?php echo $pos === 'right' ? 'direction:ltr;left:-28px;right:auto;' : ''; ?>">
                            <div class="badge-year"><?php echo esc_html($s['badge_year'] ?? ''); ?></div>
                            <div class="badge-desc"><?php echo nl2br(esc_html($s['badge_desc'] ?? '')); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="reveal d2" style="<?php echo $pos === 'right' ? 'direction:ltr' : ''; ?>">
                        <?php if (!empty($s['eyebrow'])) : ?>
                        <span class="eyebrow"><?php echo esc_html($s['eyebrow']); ?></span>
                        <?php endif; ?>

                        <?php if (!empty($s['show_ornament']) && $s['show_ornament'] === 'yes') : ?>
                        <div class="ornament">
                            <div class="ornament-line"></div>
                            <div class="ornament-diamond"></div>
                            <div class="ornament-line right"></div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($s['heading'])) : ?>
                        <h2><?php echo esc_html($s['heading']); ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($s['quote_text'])) : ?>
                        <p class="lead" style="margin-top:1.5rem"><?php echo esc_html($s['quote_text']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($s['body_text'])) : ?>
                        <div style="margin-top:1.25rem"><?php echo wp_kses_post($s['body_text']); ?></div>
                        <?php endif; ?>

                        <?php if (!empty($s['pills'])) : ?>
                        <div class="value-pills" style="margin-top:2rem">
                            <?php foreach ($s['pills'] as $pill) : ?>
                            <span class="pill"><?php echo esc_html($pill['pill_text']); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-top:2.75rem">
                            <?php if (!empty($s['primary_cta_text'])) : ?>
                            <a href="<?php echo $p_url; ?>" class="btn btn-gold"><?php echo esc_html($s['primary_cta_text']); ?></a>
                            <?php endif; ?>
                            <?php if (!empty($s['secondary_cta_text'])) : ?>
                            <a href="<?php echo $sec_url; ?>" class="btn btn-outline"><?php echo esc_html($s['secondary_cta_text']); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
