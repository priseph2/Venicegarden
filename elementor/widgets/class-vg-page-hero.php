<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Page_Hero extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-page-hero'; }
    public function get_title(): string     { return __('VG Page Hero', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-banner'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['page hero', 'inner page', 'breadcrumb', 'banner', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_breadcrumb', [
            'label' => __('Breadcrumb', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('show_breadcrumb', ['label' => __('Show Breadcrumb', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes']);
        $this->add_control('home_text',       ['label' => __('Home Label', 'venicegarden'),      'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Home', 'condition' => ['show_breadcrumb' => 'yes']]);
        $this->add_control('home_url',        ['label' => __('Home URL', 'venicegarden'),        'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => '{home_url}'], 'condition' => ['show_breadcrumb' => 'yes']]);
        $this->add_control('current_label',   ['label' => __('Current Page Label', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => __('Leave empty to use the page title automatically.', 'venicegarden'), 'condition' => ['show_breadcrumb' => 'yes']]);
        $this->end_controls_section();

        $this->start_controls_section('section_content', [
            'label' => __('Content', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('eyebrow',     ['label' => __('Eyebrow', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Our Story & Overview']);
        $this->add_control('show_rule',   ['label' => __('Show Gold Rule', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes']);
        $this->add_control('heading',     ['label' => __('Heading', 'venicegarden'),     'type'    => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Africa's Pride &\nDistributor of Note", 'rows' => 2]);
        $this->add_control('description', ['label' => __('Description', 'venicegarden'), 'type'    => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'An amalgamation of professionals with relentless excellence in delivering service.', 'rows' => 3]);
        $this->end_controls_section();

        $this->start_controls_section('section_layout', [
            'label' => __('Layout', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('text_align',       ['label' => __('Text Alignment', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'left', 'options' => ['left' => 'Left', 'center' => 'Center']]);
        $this->add_control('container_width',  ['label' => __('Container Width', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'default', 'options' => ['default' => 'Default', 'sm' => 'Small (900px)']]);
        $this->add_control('gold_rule_center', ['label' => __('Center Gold Rule', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '', 'condition' => ['show_rule' => 'yes']]);
        $this->add_control('gold_rule_wide',   ['label' => __('Wide Gold Rule', 'venicegarden'),   'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '', 'condition' => ['show_rule' => 'yes']]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s = $this->get_settings_for_display();

        $align        = $s['text_align'] ?? 'left';
        $center_cls   = $align === 'center' ? ' style="text-align:center"' : '';
        $cont_cls     = ($s['container_width'] ?? 'default') === 'sm' ? 'container container--sm' : 'container';
        $home_url     = !empty($s['home_url']['url']) ? esc_url($s['home_url']['url']) : esc_url(home_url('/'));
        $current      = !empty($s['current_label']) ? esc_html($s['current_label']) : esc_html(get_the_title());

        $rule_cls = 'gold-rule';
        if (!empty($s['gold_rule_center']) && $s['gold_rule_center'] === 'yes') $rule_cls .= ' gold-rule--center';
        if (!empty($s['gold_rule_wide'])   && $s['gold_rule_wide']   === 'yes') $rule_cls .= ' gold-rule--wide';
        ?>
        <section class="page-hero"<?php echo $center_cls; ?>>
            <div class="<?php echo esc_attr($cont_cls); ?>">
                <?php if (!empty($s['show_breadcrumb']) && $s['show_breadcrumb'] === 'yes') : ?>
                <nav class="breadcrumb<?php echo $align === 'center' ? '" style="justify-content:center' : ''; ?>" aria-label="<?php esc_attr_e('Breadcrumb', 'venicegarden'); ?>">
                    <a href="<?php echo $home_url; ?>"><?php echo esc_html($s['home_text'] ?? 'Home'); ?></a>
                    <span class="sep">›</span>
                    <span class="current"><?php echo $current; ?></span>
                </nav>
                <?php endif; ?>

                <?php if (!empty($s['eyebrow'])) : ?>
                <span class="eyebrow"><?php echo esc_html($s['eyebrow']); ?></span>
                <?php endif; ?>

                <?php if (!empty($s['show_rule']) && $s['show_rule'] === 'yes') : ?>
                <div class="<?php echo esc_attr($rule_cls); ?>"></div>
                <?php endif; ?>

                <?php if (!empty($s['heading'])) : ?>
                <h1><?php echo wp_kses_post(nl2br(esc_html($s['heading']))); ?></h1>
                <?php endif; ?>

                <?php if (!empty($s['description'])) : ?>
                <p class="lead"><?php echo esc_html($s['description']); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
