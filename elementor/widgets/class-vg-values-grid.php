<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Values_Grid extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-values-grid'; }
    public function get_title(): string     { return __('VG Values / Services Grid', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-inner-section'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['values', 'services', 'grid', 'cards', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_header', [
            'label' => __('Section Header', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('eyebrow', ['label' => __('Eyebrow', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'What Sets Us Apart']);
        $this->add_control('heading', ['label' => __('Heading', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Our Unique Service Offering']);
        $this->end_controls_section();

        $this->start_controls_section('section_values', [
            'label' => __('Value / Service Cards', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('number',      ['label' => __('Number', 'venicegarden'),      'type' => \Elementor\Controls_Manager::TEXT,     'default' => '01']);
        $repeater->add_control('title',       ['label' => __('Title', 'venicegarden'),       'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Integrity First']);
        $repeater->add_control('description', ['label' => __('Description', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Character and integrity are the backbone of all interactions.', 'rows' => 3]);

        $this->add_control('values', [
            'label'       => __('Values', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['number' => '01', 'title' => 'Integrity First',      'description' => 'Character and integrity are the major backbone to all interactions with partners, clients and stakeholders across our markets.'],
                ['number' => '02', 'title' => 'Continuous Training',  'description' => 'Our team undergoes regular training through experience sharing and structured professional development — staying ahead of the curve.'],
                ['number' => '03', 'title' => 'Full Transparency',    'description' => 'Partner brands receive regular, complete transparency in business reports and detailed market analytics — no grey areas.'],
                ['number' => '04', 'title' => 'Strategic Marketing',  'description' => 'Collaborative brand promotion executed strategically in each market to create the desired impact and drive measurable ROI.'],
                ['number' => '05', 'title' => 'UHNWI Network',        'description' => 'Exclusive access to our database of Ultra High Net Worth Individuals, social influencers and corporate titans across Africa.'],
                ['number' => '06', 'title' => 'Multi-Channel Reach',  'description' => 'Premium placements spanning international airports, 5-star hotels, flagship malls and luxury retail chains across 3 nations.'],
            ],
            'title_field' => '{{{ number }}} — {{{ title }}}',
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_style', [
            'label' => __('Style', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('card_style', [
            'label'   => __('Card Style', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'light',
            'options' => ['light' => 'Light (on white/cream)', 'dark' => 'Dark (on obsidian)'],
        ]);
        $this->add_control('bg_color', ['label' => __('Section Background', 'venicegarden'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '']);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s        = $this->get_settings_for_display();
        $values   = $s['values'] ?? [];
        $is_dark  = ($s['card_style'] ?? 'light') === 'dark';
        $card_cls = $is_dark ? 'val-card val-card--dark' : 'val-card';
        $bg       = !empty($s['bg_color']) ? 'background:' . esc_attr($s['bg_color']) . ';' : '';
        ?>
        <section class="section" style="<?php echo $bg; ?>">
            <div class="container">
                <div class="text-center reveal" style="margin-bottom:4rem">
                    <?php if (!empty($s['eyebrow'])) : ?>
                    <span class="eyebrow"><?php echo esc_html($s['eyebrow']); ?></span>
                    <div class="gold-rule gold-rule--center"></div>
                    <?php endif; ?>
                    <?php if (!empty($s['heading'])) : ?>
                    <h2 <?php echo $is_dark ? 'style="color:var(--cream)"' : ''; ?>><?php echo esc_html($s['heading']); ?></h2>
                    <?php endif; ?>
                </div>
                <div class="val-grid">
                    <?php foreach ($values as $i => $val) :
                        $d = ($i % 3) + 1;
                    ?>
                    <div class="<?php echo esc_attr($card_cls); ?> reveal d<?php echo $d; ?>">
                        <div class="val-num"><?php echo esc_html($val['number']); ?></div>
                        <h4><?php echo esc_html($val['title']); ?></h4>
                        <p><?php echo esc_html($val['description']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
