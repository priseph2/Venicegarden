<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Brand_Grid extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-brand-grid'; }
    public function get_title(): string     { return __('VG Brand Grid', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-gallery-grid'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['brands', 'grid', 'filter', 'cards', 'venice']; }

    protected function register_controls(): void {

        /* ── Section Header ────────────────────────────────────── */
        $this->start_controls_section('section_header', [
            'label' => __('Section Header', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('show_header', ['label' => __('Show Section Header', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes']);
        $this->add_control('eyebrow',     ['label' => __('Eyebrow', 'venicegarden'),             'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Partners for Retail & Distribution', 'condition' => ['show_header' => 'yes']]);
        $this->add_control('heading',     ['label' => __('Heading', 'venicegarden'),             'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'World-Class Brands We Carry', 'condition' => ['show_header' => 'yes']]);
        $this->add_control('description', ['label' => __('Description', 'venicegarden'),         'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "From Italian luxury fragrances to opulent Arabian perfumery — the finest brands, delivered with precision across Africa's premium channels.", 'rows' => 3, 'condition' => ['show_header' => 'yes']]);
        $this->end_controls_section();

        /* ── Filter ────────────────────────────────────────────── */
        $this->start_controls_section('section_filter', [
            'label' => __('Filter Tabs', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('show_filter',       ['label' => __('Show Filter Tabs', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes']);
        $this->add_control('filter_all_label',  ['label' => __('All Tab Label', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'All Brands', 'condition' => ['show_filter' => 'yes']]);

        $filter_repeater = new \Elementor\Repeater();
        $filter_repeater->add_control('filter_label', ['label' => __('Label', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Fragrance']);
        $filter_repeater->add_control('filter_key',   ['label' => __('Key (no spaces)', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'fragrance']);

        $this->add_control('filters', [
            'label'       => __('Filter Categories', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $filter_repeater->get_controls(),
            'default'     => [
                ['filter_label' => 'Fragrance', 'filter_key' => 'fragrance'],
                ['filter_label' => 'Skincare',  'filter_key' => 'skincare'],
                ['filter_label' => 'Beauty Retail', 'filter_key' => 'beauty'],
            ],
            'title_field' => '{{{ filter_label }}}',
            'condition'   => ['show_filter' => 'yes'],
        ]);
        $this->end_controls_section();

        /* ── Brands ────────────────────────────────────────────── */
        $this->start_controls_section('section_brands', [
            'label' => __('Brands', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('image',           ['label' => __('Image', 'venicegarden'),           'type' => \Elementor\Controls_Manager::MEDIA]);
        $repeater->add_control('filter_category', ['label' => __('Filter Category Key', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'fragrance', 'description' => __('Must match a filter key above.', 'venicegarden')]);
        $repeater->add_control('category_label',  ['label' => __('Category Label', 'venicegarden'),  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Luxury Fragrance']);
        $repeater->add_control('name',            ['label' => __('Brand Name', 'venicegarden'),      'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Brand Name']);
        $repeater->add_control('description',     ['label' => __('Description', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Brand description goes here.', 'rows' => 3]);
        $repeater->add_control('overlay_text',    ['label' => __('Image Overlay Text', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore →']);
        $repeater->add_control('link',            ['label' => __('Card Link', 'venicegarden'),        'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => '#']]);

        $this->add_control('brands', [
            'label'       => __('Brands', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['category_label' => 'Luxury Fragrance', 'name' => 'Milano',        'description' => 'Timeless Italian luxury crafted for the modern connoisseur.', 'filter_category' => 'fragrance'],
                ['category_label' => 'Arabian Perfumery', 'name' => 'Oman Luxury',  'description' => 'Opulent Oriental scents embodying the rich heritage of Arabian perfumery.', 'filter_category' => 'fragrance'],
                ['category_label' => 'Luxury Skincare',  'name' => 'RIVAGE Skincare', 'description' => 'Premium science-backed formulations for the ultra-discerning beauty enthusiast.', 'filter_category' => 'skincare'],
            ],
            'title_field' => '{{{ name }}}',
        ]);
        $this->end_controls_section();

        /* ── CTA ───────────────────────────────────────────────── */
        $this->start_controls_section('section_cta', [
            'label' => __('Footer CTA', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('show_cta',  ['label' => __('Show CTA Button', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes']);
        $this->add_control('cta_text',  ['label' => __('CTA Text', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View All Our Brands', 'condition' => ['show_cta' => 'yes']]);
        $this->add_control('cta_url',   ['label' => __('CTA URL', 'venicegarden'),  'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => '#'], 'condition' => ['show_cta' => 'yes']]);
        $this->end_controls_section();

        /* ── Layout ────────────────────────────────────────────── */
        $this->start_controls_section('section_layout', [
            'label' => __('Layout', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('layout', ['label' => __('Grid Layout', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'auto', 'options' => ['auto' => 'Auto-fill (Responsive)', 'grid-3' => '3 Columns', 'grid-2' => '2 Columns']]);
        $this->add_control('bg_color', ['label' => __('Section Background', 'venicegarden'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'var(--cream)']);
        $this->add_control('section_padding', ['label' => __('Padding', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '6rem 0']);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s       = $this->get_settings_for_display();
        $brands  = $s['brands'] ?? [];
        $layout  = $s['layout'] ?? 'auto';
        $grid_cls = $layout === 'grid-3' ? 'grid-3' : ($layout === 'grid-2' ? 'grid-2' : 'grid-auto');
        $bg      = esc_attr($s['bg_color'] ?? 'var(--cream)');
        $padding = esc_attr($s['section_padding'] ?? '6rem 0');
        ?>
        <section class="section" style="background:<?php echo $bg; ?>;padding:<?php echo $padding; ?>">
            <div class="container">
                <?php if (!empty($s['show_header']) && $s['show_header'] === 'yes') : ?>
                <div class="text-center reveal" style="margin-bottom:3.5rem">
                    <?php if (!empty($s['eyebrow'])) : ?>
                    <span class="eyebrow"><?php echo esc_html($s['eyebrow']); ?></span>
                    <div class="gold-rule gold-rule--center gold-rule--wide"></div>
                    <?php endif; ?>
                    <?php if (!empty($s['heading'])) : ?>
                    <h2><?php echo esc_html($s['heading']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($s['description'])) : ?>
                    <p class="lead" style="max-width:540px;margin:1rem auto 0"><?php echo esc_html($s['description']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($s['show_filter']) && $s['show_filter'] === 'yes' && !empty($s['filters'])) : ?>
                <div class="tab-row reveal" data-brand-filter>
                    <button class="tab-btn active" data-filter="all"><?php echo esc_html($s['filter_all_label'] ?? 'All Brands'); ?></button>
                    <?php foreach ($s['filters'] as $filter) : ?>
                    <button class="tab-btn" data-filter="<?php echo esc_attr($filter['filter_key']); ?>"><?php echo esc_html($filter['filter_label']); ?></button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="<?php echo esc_attr($grid_cls); ?>" data-brand-grid>
                    <?php foreach ($brands as $i => $brand) :
                        $d = ($i % 3) + 1;
                        $img_url  = esc_url($brand['image']['url'] ?? '');
                        $card_url = esc_url($brand['link']['url'] ?? '#');
                        $overlay  = esc_html($brand['overlay_text'] ?? 'Explore →');
                    ?>
                    <article class="brand-card reveal d<?php echo $d; ?>"
                             data-category="<?php echo esc_attr($brand['filter_category'] ?? 'fragrance'); ?>"
                             tabindex="0">
                        <?php if ($img_url) : ?>
                        <div class="brand-img">
                            <img src="<?php echo $img_url; ?>" alt="<?php echo esc_attr($brand['name'] ?? ''); ?>" loading="lazy">
                            <div class="brand-img-overlay">
                                <span style="font-size:.65rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--gold-light)"><?php echo $overlay; ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="brand-body">
                            <div class="brand-cat"><?php echo esc_html($brand['category_label'] ?? ''); ?></div>
                            <div class="brand-name"><?php echo esc_html($brand['name'] ?? ''); ?></div>
                            <p class="brand-desc"><?php echo esc_html($brand['description'] ?? ''); ?></p>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($s['show_cta']) && $s['show_cta'] === 'yes' && !empty($s['cta_text'])) : ?>
                <div class="text-center" style="margin-top:3rem">
                    <a href="<?php echo esc_url($s['cta_url']['url'] ?? '#'); ?>" class="btn btn-gold">
                        <?php echo esc_html($s['cta_text']); ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
