<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Presence extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-presence'; }
    public function get_title(): string     { return __('VG Presence / Countries', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-globe'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['presence', 'countries', 'geographic', 'africa', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_header', [
            'label' => __('Section Header', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('eyebrow',     ['label' => __('Eyebrow', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Pan-African Footprint']);
        $this->add_control('heading',     ['label' => __('Heading', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Operating Across 3 Countries']);
        $this->add_control('description', ['label' => __('Description', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Premium airport concourses, luxury hotel lobbies, flagship retail malls — our network reaches Africa's most coveted distribution touchpoints.", 'rows' => 3]);
        $this->end_controls_section();

        $this->start_controls_section('section_countries', [
            'label' => __('Country Cards', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('flag',        ['label' => __('Flag Emoji', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🇳🇬']);
        $repeater->add_control('name',        ['label' => __('Country Name', 'venicegarden'),   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Nigeria']);
        $repeater->add_control('sub',         ['label' => __('Sub-label', 'venicegarden'),      'type' => \Elementor\Controls_Manager::TEXT, 'default' => '34+ Branches']);
        $repeater->add_control('description', ['label' => __('Description', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Lagos, Abuja, Port Harcourt, Kano and more.', 'rows' => 2]);

        $this->add_control('countries', [
            'label'       => __('Countries', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['flag' => '🇳🇬', 'name' => 'Nigeria', 'sub' => '34+ Branches',  'description' => 'Lagos, Abuja, Port Harcourt, Kano, Asaba, Enugu, Owerri and more.'],
                ['flag' => '🇬🇭', 'name' => 'Ghana',   'sub' => '5 Partners',    'description' => "Accra's premier luxury retail destinations and the Marriott Hotel Airport City."],
                ['flag' => '🇷🇼', 'name' => 'Rwanda',  'sub' => 'Kigali Hub',    'description' => "Art of Essence, Kigali — serving East Africa's fastest-growing luxury market."],
            ],
            'title_field' => '{{{ name }}}',
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_cta', [
            'label' => __('CTA', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('show_cta', ['label' => __('Show CTA', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes']);
        $this->add_control('cta_text', ['label' => __('CTA Text', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Find a Store Near You', 'condition' => ['show_cta' => 'yes']]);
        $this->add_control('cta_url',  ['label' => __('CTA URL', 'venicegarden'),  'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => '#'], 'condition' => ['show_cta' => 'yes']]);
        $this->add_control('bg_color', ['label' => __('Background Color', 'venicegarden'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'var(--warm-dark)']);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s  = $this->get_settings_for_display();
        $bg = esc_attr($s['bg_color'] ?? 'var(--warm-dark)');
        ?>
        <section class="presence-wrap" aria-label="<?php esc_attr_e('Geographic presence', 'venicegarden'); ?>" style="background:<?php echo $bg; ?>">
            <div class="container">
                <div class="text-center reveal">
                    <?php if (!empty($s['eyebrow'])) : ?>
                    <span class="eyebrow" style="color:rgba(201,151,42,0.75)"><?php echo esc_html($s['eyebrow']); ?></span>
                    <div class="gold-rule gold-rule--center gold-rule--wide"></div>
                    <?php endif; ?>
                    <?php if (!empty($s['heading'])) : ?>
                    <h2 style="color:var(--cream)"><?php echo esc_html($s['heading']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($s['description'])) : ?>
                    <p class="lead" style="max-width:560px;margin:1rem auto 0"><?php echo esc_html($s['description']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="country-cards">
                    <?php foreach (($s['countries'] ?? []) as $i => $country) :
                        $d = ($i % 3) + 1;
                    ?>
                    <div class="country-card reveal d<?php echo $d; ?>">
                        <?php if (!empty($country['flag'])) : ?>
                        <div class="country-flag"><?php echo esc_html($country['flag']); ?></div>
                        <?php endif; ?>
                        <div class="country-name"><?php echo esc_html($country['name'] ?? ''); ?></div>
                        <?php if (!empty($country['sub'])) : ?>
                        <div class="country-sub"><?php echo esc_html($country['sub']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($country['description'])) : ?>
                        <p class="country-desc"><?php echo esc_html($country['description']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($s['show_cta']) && $s['show_cta'] === 'yes' && !empty($s['cta_text'])) : ?>
                <div class="text-center" style="margin-top:3.5rem">
                    <a href="<?php echo esc_url($s['cta_url']['url'] ?? '#'); ?>" class="btn btn-outline" style="border-color:rgba(201,151,42,0.5)">
                        <?php echo esc_html($s['cta_text']); ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
