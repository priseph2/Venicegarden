<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Cta_Split extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-cta-split'; }
    public function get_title(): string     { return __('VG CTA Split', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-call-to-action'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['cta', 'split', 'image', 'call to action', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_image', [
            'label' => __('Image', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('image',    ['label' => __('Image', 'venicegarden'),    'type' => \Elementor\Controls_Manager::MEDIA]);
        $this->add_control('image_alt',['label' => __('Image Alt', 'venicegarden'),'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Venice Gardens']);
        $this->add_control('image_position', ['label' => __('Image Side', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'left', 'options' => ['left' => 'Left', 'right' => 'Right']]);
        $this->end_controls_section();

        $this->start_controls_section('section_content', [
            'label' => __('Content', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('eyebrow',     ['label' => __('Eyebrow', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Ready to Partner?']);
        $this->add_control('heading',     ['label' => __('Heading', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => "Let's Build Something Extraordinary Together"]);
        $this->add_control('description', ['label' => __('Description', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Whether you are a luxury retailer, hospitality group, or brand looking to enter the African market — Venice Gardens Distribution is your trusted partner of choice.', 'rows' => 4]);
        $this->add_control('primary_cta_text',   ['label' => __('Primary Button Text', 'venicegarden'),   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Start a Conversation']);
        $this->add_control('primary_cta_url',    ['label' => __('Primary Button URL', 'venicegarden'),    'type' => \Elementor\Controls_Manager::URL,  'default' => ['url' => '#']]);
        $this->add_control('secondary_cta_text', ['label' => __('Secondary Button Text', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Find a Store']);
        $this->add_control('secondary_cta_url',  ['label' => __('Secondary Button URL', 'venicegarden'),  'type' => \Elementor\Controls_Manager::URL,  'default' => ['url' => '#']]);
        $this->add_control('content_bg', ['label' => __('Content Background', 'venicegarden'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'var(--obsidian)']);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s       = $this->get_settings_for_display();
        $img_url = esc_url($s['image']['url'] ?? '');
        $img_alt = esc_attr($s['image_alt'] ?? '');
        $pos     = $s['image_position'] ?? 'left';
        $bg      = esc_attr($s['content_bg'] ?? 'var(--obsidian)');
        $p_url   = esc_url($s['primary_cta_url']['url'] ?? '#');
        $s_url   = esc_url($s['secondary_cta_url']['url'] ?? '#');
        ?>
        <div class="cta-split" aria-label="<?php esc_attr_e('Partnership call to action', 'venicegarden'); ?>"
             style="<?php echo $pos === 'right' ? 'direction:rtl' : ''; ?>">
            <?php if ($img_url) : ?>
            <div class="cta-img" style="<?php echo $pos === 'right' ? 'direction:ltr' : ''; ?>">
                <img src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>" loading="lazy">
            </div>
            <?php endif; ?>
            <div class="cta-content" style="background:<?php echo $bg; ?>;<?php echo $pos === 'right' ? 'direction:ltr' : ''; ?>">
                <?php if (!empty($s['eyebrow'])) : ?>
                <span class="eyebrow"><?php echo esc_html($s['eyebrow']); ?></span>
                <div class="gold-rule"></div>
                <?php endif; ?>
                <?php if (!empty($s['heading'])) : ?>
                <h2><?php echo esc_html($s['heading']); ?></h2>
                <?php endif; ?>
                <?php if (!empty($s['description'])) : ?>
                <p><?php echo esc_html($s['description']); ?></p>
                <?php endif; ?>
                <div class="cta-buttons">
                    <?php if (!empty($s['primary_cta_text'])) : ?>
                    <a href="<?php echo $p_url; ?>" class="btn btn-gold"><?php echo esc_html($s['primary_cta_text']); ?></a>
                    <?php endif; ?>
                    <?php if (!empty($s['secondary_cta_text'])) : ?>
                    <a href="<?php echo $s_url; ?>" class="btn btn-ghost"><?php echo esc_html($s['secondary_cta_text']); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
