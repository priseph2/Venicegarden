<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Logo_Ticker extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-logo-ticker'; }
    public function get_title(): string     { return __('VG Logo Ticker', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-animation-text'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['ticker', 'logos', 'partners', 'scroll', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_items', [
            'label' => __('Ticker Items', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('text', [
            'label'   => __('Name / Label', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Partner Name',
        ]);

        $this->add_control('items', [
            'label'       => __('Items', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['text' => 'Scentified by Cascades Luxury'],
                ['text' => 'Polo Luxury'],
                ['text' => 'Art of Essence'],
                ['text' => 'Aromas Perfumery'],
                ['text' => 'Dunes Stores'],
                ['text' => 'RIVAGE Skincare'],
                ['text' => 'Circle Mall'],
                ['text' => 'Ikeja City Mall'],
                ['text' => 'Jabi Lake Mall'],
                ['text' => 'Radisson Blu Lagos'],
                ['text' => 'Marriott Hotels'],
                ['text' => 'Transcorp Hilton'],
            ],
            'title_field' => '{{{ text }}}',
        ]);

        $this->add_control('speed', [
            'label'   => __('Animation Speed (seconds)', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => ['px' => ['min' => 10, 'max' => 90, 'step' => 5]],
            'default' => ['size' => 28],
        ]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s     = $this->get_settings_for_display();
        $items = $s['items'] ?? [];
        $speed = (int) ($s['speed']['size'] ?? 28);
        if (empty($items)) return;

        $doubled = array_merge($items, $items);
        ?>
        <div class="logo-ticker" aria-label="<?php esc_attr_e('Our partners', 'venicegarden'); ?>">
            <div class="ticker-track" aria-hidden="true" style="animation-duration:<?php echo $speed; ?>s">
                <?php foreach ($doubled as $item) : ?>
                <span class="ticker-item"><?php echo esc_html($item['text']); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
