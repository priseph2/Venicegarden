<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Offices_Strip extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-offices-strip'; }
    public function get_title(): string     { return __('VG Offices Strip', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-map-pin'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['offices', 'locations', 'countries', 'strip', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_offices', [
            'label' => __('Offices', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('flag',      ['label' => __('Flag Emoji', 'venicegarden'),   'type' => \Elementor\Controls_Manager::TEXT,    'default' => '🇳🇬']);
        $repeater->add_control('country',   ['label' => __('Country', 'venicegarden'),      'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Nigeria']);
        $repeater->add_control('city',      ['label' => __('City', 'venicegarden'),         'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Lagos (HQ)']);
        $repeater->add_control('sub_label', ['label' => __('Sub-label', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXT,    'default' => '34+ Locations']);

        $this->add_control('offices', [
            'label'       => __('Offices', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['flag' => '🇳🇬', 'country' => 'Nigeria', 'city' => 'Lagos (HQ)',   'sub_label' => '34+ Locations'],
                ['flag' => '🇬🇭', 'country' => 'Ghana',   'city' => 'Accra',        'sub_label' => '5 Partners'],
                ['flag' => '🇷🇼', 'country' => 'Rwanda',  'city' => 'Kigali',       'sub_label' => '1 Hub'],
            ],
            'title_field' => '{{{ flag }}} {{{ country }}}',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style', [
            'label' => __('Style', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('bg_color',      ['label' => __('Background', 'venicegarden'),  'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'var(--obsidian)']);
        $this->add_control('padding_y',     ['label' => __('Vertical Padding (rem)', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 1, 'max' => 12]], 'default' => ['size' => 4.5], 'selectors' => ['{{WRAPPER}} .offices-strip' => 'padding: {{SIZE}}rem 0;']]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s       = $this->get_settings_for_display();
        $offices = $s['offices'] ?? [];
        $bg      = esc_attr($s['bg_color'] ?? 'var(--obsidian)');
        ?>
        <section class="offices-strip" style="background:<?php echo $bg; ?>;padding:4.5rem 0">
            <div class="container">
                <div class="offices-strip__inner">
                    <?php foreach ($offices as $office) : ?>
                    <div class="offices-strip__item">
                        <div class="offices-strip__flag"><?php echo esc_html($office['flag'] ?? ''); ?></div>
                        <div class="offices-strip__country"><?php echo esc_html($office['country'] ?? ''); ?></div>
                        <div class="offices-strip__city"><?php echo esc_html($office['city'] ?? ''); ?></div>
                        <div class="offices-strip__sub"><?php echo esc_html($office['sub_label'] ?? ''); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
