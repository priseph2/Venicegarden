<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Stores_Section extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-stores-section'; }
    public function get_title(): string     { return __('VG Partner Stores', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-store'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['stores', 'partners', 'locations', 'tabs', 'venice']; }

    protected function register_controls(): void {
        /* ── Section Header ───────────────────────────────────────────── */
        $this->start_controls_section('section_header', [
            'label' => __('Section Header', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('eyebrow',     ['label' => __('Eyebrow', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Where to Find Us']);
        $this->add_control('heading',     ['label' => __('Heading', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Our Partner Store Network']);
        $this->add_control('description', ['label' => __('Description', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Find Venice Gardens products across premium retail touchpoints — from international airports to flagship malls and five-star hotel boutiques.', 'rows' => 3]);
        $this->end_controls_section();

        /* ── Tab Labels ───────────────────────────────────────────────── */
        $this->start_controls_section('section_tabs', [
            'label' => __('Country Tabs', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('tab_all_label', ['label' => __('All Countries Tab Label', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'All Markets']);

        $tab_repeater = new \Elementor\Repeater();
        $tab_repeater->add_control('tab_key',   ['label' => __('Key (no spaces)', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'nigeria']);
        $tab_repeater->add_control('tab_label', ['label' => __('Label', 'venicegarden'),            'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Nigeria']);

        $this->add_control('tabs', [
            'label'       => __('Country Tabs', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $tab_repeater->get_controls(),
            'default'     => [
                ['tab_key' => 'nigeria', 'tab_label' => 'Nigeria'],
                ['tab_key' => 'ghana',   'tab_label' => 'Ghana'],
                ['tab_key' => 'rwanda',  'tab_label' => 'Rwanda'],
            ],
            'title_field' => '{{{ tab_label }}}',
        ]);
        $this->end_controls_section();

        /* ── Store Groups ─────────────────────────────────────────────── */
        $this->start_controls_section('section_groups', [
            'label' => __('Store Categories', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('group_notice', [
            'type'            => \Elementor\Controls_Manager::RAW_HTML,
            'raw'             => __('<p style="color:#888;font-size:12px">Add store category groups (e.g. Malls, Airports, Hotels). Each group has a country key and multiple store entries.</p>', 'venicegarden'),
            'content_classes' => 'elementor-descriptor',
        ]);

        $store_rep = new \Elementor\Repeater();
        $store_rep->add_control('country_key',   ['label' => __('Country Key', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'nigeria', 'description' => __('Must match a Country Tab key exactly.', 'venicegarden')]);
        $store_rep->add_control('group_heading', ['label' => __('Category Heading', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT,   'default' => 'Shopping Malls']);
        $store_rep->add_control('stores',        ['label' => __('Stores (one per line)', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Ikeja City Mall\nThe Palms Mall\nVictoria Island Mall", 'rows' => 5, 'description' => __('One store name per line.', 'venicegarden')]);

        $this->add_control('store_groups', [
            'label'       => __('Store Groups', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $store_rep->get_controls(),
            'default'     => [
                ['country_key' => 'nigeria', 'group_heading' => 'Shopping Malls',        'stores' => "Ikeja City Mall\nThe Palms Shopping Mall\nVictoria Island Mall\nAlaba International Market\nShopping Complex Lekki"],
                ['country_key' => 'nigeria', 'group_heading' => 'International Airports', 'stores' => "Murtala Muhammed International Airport — Duty Free\nAbuja Nnamdi Azikiwe Int\'l Airport"],
                ['country_key' => 'nigeria', 'group_heading' => '5-Star Hotels',          'stores' => "Eko Hotel & Suites\nFour Points by Sheraton\nRadisson Blu Anchorage Hotel"],
                ['country_key' => 'ghana',   'group_heading' => 'Shopping Malls',         'stores' => "Accra Mall\nWest Hills Mall\nMarina Mall"],
                ['country_key' => 'ghana',   'group_heading' => 'International Airports',  'stores' => "Kotoka International Airport — Duty Free"],
                ['country_key' => 'ghana',   'group_heading' => '5-Star Hotels',           'stores' => "Kempinski Hotel Gold Coast City\nLabone Lodge"],
                ['country_key' => 'rwanda',  'group_heading' => 'Flagship Hub',            'stores' => "Kigali Convention Centre\nKigali City Tower"],
                ['country_key' => 'rwanda',  'group_heading' => 'International Airports',  'stores' => "Kigali International Airport — Duty Free"],
            ],
            'title_field' => '{{{ country_key }}} — {{{ group_heading }}}',
        ]);
        $this->end_controls_section();

        /* ── Style ────────────────────────────────────────────────────── */
        $this->start_controls_section('section_style', [
            'label' => __('Style', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('bg_color', ['label' => __('Section Background', 'venicegarden'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'var(--cream)']);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s            = $this->get_settings_for_display();
        $tabs         = $s['tabs']         ?? [];
        $store_groups = $s['store_groups'] ?? [];
        $bg           = esc_attr($s['bg_color'] ?? 'var(--cream)');
        $all_label    = esc_html($s['tab_all_label'] ?? 'All Markets');

        /* collect unique country keys for "all" tab rendering */
        $all_keys = array_unique(array_map(fn($g) => $g['country_key'] ?? '', $store_groups));
        ?>
        <section class="section stores-section" style="background:<?php echo $bg; ?>">
            <div class="container">
                <?php if (!empty($s['eyebrow']) || !empty($s['heading'])) : ?>
                <div class="text-center reveal" style="margin-bottom:3rem">
                    <?php if (!empty($s['eyebrow'])) : ?>
                    <span class="eyebrow"><?php echo esc_html($s['eyebrow']); ?></span>
                    <div class="gold-rule gold-rule--center"></div>
                    <?php endif; ?>
                    <?php if (!empty($s['heading'])) : ?>
                    <h2><?php echo esc_html($s['heading']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($s['description'])) : ?>
                    <p class="lead" style="max-width:620px;margin:1rem auto 0"><?php echo esc_html($s['description']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Tab Nav -->
                <div class="stores-tabs" data-tabs="stores-panels">
                    <button class="stores-tab active" data-target="all"><?php echo $all_label; ?></button>
                    <?php foreach ($tabs as $tab) : ?>
                    <button class="stores-tab" data-target="<?php echo esc_attr($tab['tab_key'] ?? ''); ?>">
                        <?php echo esc_html($tab['tab_label'] ?? ''); ?>
                    </button>
                    <?php endforeach; ?>
                </div>

                <!-- Tab Panels -->
                <div class="stores-panels" id="stores-panels">
                    <!-- All Markets panel -->
                    <div class="stores-panel active" data-panel="all">
                        <?php $this->render_country_groups($store_groups, $all_keys); ?>
                    </div>

                    <!-- Per-country panels -->
                    <?php foreach ($tabs as $tab) :
                        $key = $tab['tab_key'] ?? '';
                        $country_groups = array_filter($store_groups, fn($g) => ($g['country_key'] ?? '') === $key);
                    ?>
                    <div class="stores-panel" data-panel="<?php echo esc_attr($key); ?>">
                        <?php $this->render_country_groups($country_groups, [$key]); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    private function render_country_groups(array $groups, array $keys): void {
        foreach ($keys as $key) {
            $matching = array_filter($groups, fn($g) => ($g['country_key'] ?? '') === $key);
            if (empty($matching)) continue;
            ?>
            <div class="stores-country-block">
                <?php foreach ($matching as $group) :
                    $stores_raw  = $group['stores'] ?? '';
                    $store_lines = array_filter(array_map('trim', explode("\n", $stores_raw)));
                ?>
                <div class="stores-group">
                    <h4 class="stores-group__heading"><?php echo esc_html($group['group_heading'] ?? ''); ?></h4>
                    <ul class="stores-group__list">
                        <?php foreach ($store_lines as $store) : ?>
                        <li><?php echo esc_html($store); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
            <?php
        }
    }
}
