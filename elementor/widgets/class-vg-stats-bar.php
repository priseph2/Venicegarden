<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Stats_Bar extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-stats-bar'; }
    public function get_title(): string     { return __('VG Stats Bar', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-counter'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['stats', 'counter', 'numbers', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_stats', [
            'label' => __('Statistics', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('number', [
            'label'   => __('Number', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '40',
        ]);
        $repeater->add_control('suffix', [
            'label'   => __('Suffix (e.g. +)', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '+',
        ]);
        $repeater->add_control('label', [
            'label'   => __('Label', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Partner Branches',
        ]);

        $this->add_control('stats', [
            'label'       => __('Statistics', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['number' => '40',   'suffix' => '+',  'label' => 'Partner Branches'],
                ['number' => '3',    'suffix' => '',   'label' => 'African Markets'],
                ['number' => '7',    'suffix' => '',   'label' => 'Retail Partners'],
                ['number' => '2024', 'suffix' => '',   'label' => 'Most Innovative Co.'],
            ],
            'title_field' => '{{{ label }}}',
        ]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s     = $this->get_settings_for_display();
        $stats = $s['stats'] ?? [];
        if (empty($stats)) return;
        ?>
        <section class="stats-bar" aria-label="<?php esc_attr_e('Key statistics', 'venicegarden'); ?>">
            <div class="container">
                <div class="stats-grid">
                    <?php foreach ($stats as $stat) : ?>
                    <div class="stat-item">
                        <div class="stat-num"
                             data-count="<?php echo esc_attr($stat['number']); ?>"
                             <?php if (!empty($stat['suffix'])) : ?>data-suffix="<?php echo esc_attr($stat['suffix']); ?>"<?php endif; ?>>
                            0<?php echo esc_html($stat['suffix'] ?? ''); ?>
                        </div>
                        <div class="stat-label"><?php echo esc_html($stat['label']); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
