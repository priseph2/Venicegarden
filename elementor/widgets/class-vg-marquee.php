<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Marquee extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-marquee'; }
    public function get_title(): string     { return __('VG Marquee Strip', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-scroll'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['marquee', 'ticker', 'scrolling', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_items', [
            'label' => __('Marquee Items', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('text', [
            'label'   => __('Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Marquee Item',
        ]);

        $this->add_control('items', [
            'label'       => __('Items', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['text' => 'Most Innovative Company 2024'],
                ['text' => 'Nigeria · Ghana · Rwanda'],
                ['text' => 'Premier Luxury Distributor'],
                ['text' => 'Airports · Malls · Hotels'],
                ['text' => 'Authenticity in Every Market'],
                ['text' => 'UHNWI Clientele Network'],
                ["text" => "Africa's Pride & Distributor of Note"],
            ],
            'title_field' => '{{{ text }}}',
        ]);

        $this->add_control('speed', [
            'label'   => __('Animation Speed (seconds)', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => ['px' => ['min' => 10, 'max' => 120, 'step' => 5]],
            'default' => ['size' => 35],
        ]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s     = $this->get_settings_for_display();
        $items = $s['items'] ?? [];
        $speed = (int) ($s['speed']['size'] ?? 35);

        if (empty($items)) return;

        $doubled = array_merge($items, $items);
        ?>
        <div class="marquee-strip" aria-hidden="true" style="--marquee-speed: <?php echo $speed; ?>s">
            <div class="marquee-track" style="animation-duration:<?php echo $speed; ?>s">
                <?php foreach ($doubled as $item) : ?>
                <span class="marquee-item">
                    <?php echo esc_html($item['text']); ?>
                    <span class="marquee-sep"></span>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
