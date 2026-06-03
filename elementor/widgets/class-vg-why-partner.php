<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Why_Partner extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-why-partner'; }
    public function get_title(): string     { return __('VG Why Partner', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-check-circle'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['why', 'partner', 'checklist', 'brands', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_left', [
            'label' => __('Left Column', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('eyebrow',     ['label' => __('Eyebrow', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Why Partner With Us']);
        $this->add_control('heading',     ['label' => __('Heading', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Africa's Most Trusted\nDistribution Network", 'rows' => 2]);
        $this->add_control('description', ['label' => __('Description', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'We deliver luxury brands to Africa\'s most discerning consumers through an unrivalled network of premium retail touchpoints.', 'rows' => 3]);
        $this->add_control('cta_text',    ['label' => __('CTA Button Text', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Become a Brand Partner']);
        $this->add_control('cta_url',     ['label' => __('CTA Button URL', 'venicegarden'),  'type' => \Elementor\Controls_Manager::URL,  'default' => ['url' => '#']]);
        $this->end_controls_section();

        $this->start_controls_section('section_right', [
            'label' => __('Right Column — Checklist', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('item', ['label' => __('Item', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Exclusive market access across 3 African nations']);

        $this->add_control('checklist', [
            'label'       => __('Checklist Items', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['item' => 'Exclusive access to UHNWI consumer networks'],
                ['item' => 'Presence in international airports & 5-star hotels'],
                ['item' => 'Dedicated in-market brand management teams'],
                ['item' => 'Full transparency in sales reporting & analytics'],
                ['item' => 'Strategic co-marketing and influencer campaigns'],
                ['item' => 'Logistics, warehousing & last-mile delivery covered'],
            ],
            'title_field' => '{{{ item }}}',
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_style', [
            'label' => __('Style', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('bg_color',      ['label' => __('Background', 'venicegarden'),      'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'var(--obsidian)']);
        $this->add_control('check_color',   ['label' => __('Checkmark Colour', 'venicegarden'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'var(--gold)']);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s         = $this->get_settings_for_display();
        $checklist = $s['checklist'] ?? [];
        $bg        = esc_attr($s['bg_color']    ?? 'var(--obsidian)');
        $chk_clr   = esc_attr($s['check_color'] ?? 'var(--gold)');
        $cta_url   = esc_url($s['cta_url']['url'] ?? '#');
        ?>
        <section class="why-partner section" style="background:<?php echo $bg; ?>">
            <div class="container">
                <div class="why-partner__grid">
                    <div class="why-partner__left reveal">
                        <?php if (!empty($s['eyebrow'])) : ?>
                        <span class="eyebrow"><?php echo esc_html($s['eyebrow']); ?></span>
                        <div class="gold-rule"></div>
                        <?php endif; ?>
                        <?php if (!empty($s['heading'])) : ?>
                        <h2 style="color:var(--cream)"><?php echo wp_kses_post(nl2br(esc_html($s['heading']))); ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($s['description'])) : ?>
                        <p style="color:rgba(255,255,255,.75);margin:1.25rem 0 2rem"><?php echo esc_html($s['description']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($s['cta_text'])) : ?>
                        <a href="<?php echo $cta_url; ?>" class="btn btn-gold"><?php echo esc_html($s['cta_text']); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="why-partner__right reveal d2">
                        <ul class="why-partner__list">
                            <?php foreach ($checklist as $row) : ?>
                            <li style="--chk:<?php echo $chk_clr; ?>"><?php echo esc_html($row['item'] ?? ''); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
