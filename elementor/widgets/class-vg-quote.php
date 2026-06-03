<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Quote extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-quote'; }
    public function get_title(): string     { return __('VG Pull Quote', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-blockquote'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['quote', 'blockquote', 'pull quote', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_quote', [
            'label' => __('Quote', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('quote_text', [
            'label'   => __('Quote Text', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'We are intentional and dependable — as we seek to earn your trust and build a <em>long-lasting, mutually beneficial</em> relationship.',
            'rows'    => 5,
            'description' => __('Wrap text in &lt;em&gt; tags for gold accent styling.', 'venicegarden'),
        ]);
        $this->add_control('attribution', [
            'label'   => __('Attribution', 'venicegarden'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Venice Gardens Distribution',
        ]);
        $this->add_control('show_ornament', [
            'label'        => __('Show Ornament', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);
        $this->add_control('show_cta', [
            'label'        => __('Show CTA Button', 'venicegarden'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ]);
        $this->add_control('cta_text', ['label' => __('CTA Text', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Get in Touch', 'condition' => ['show_cta' => 'yes']]);
        $this->add_control('cta_url',  ['label' => __('CTA URL', 'venicegarden'),  'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => '#'], 'condition' => ['show_cta' => 'yes']]);
        $this->add_control('bg_color', ['label' => __('Background Color', 'venicegarden'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'var(--obsidian)']);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s = $this->get_settings_for_display();

        $allowed = ['em' => [], 'strong' => [], 'a' => ['href' => [], 'target' => []]];
        $quote   = wp_kses($s['quote_text'] ?? '', $allowed);
        $attr    = esc_html($s['attribution'] ?? '');
        $bg      = esc_attr($s['bg_color'] ?? 'var(--obsidian)');
        ?>
        <div class="quote-wrap" aria-label="<?php esc_attr_e('Brand ethos', 'venicegarden'); ?>" style="background:<?php echo $bg; ?>">
            <div class="container container--sm">
                <div class="quote-inner text-center">
                    <?php if (!empty($s['show_ornament']) && $s['show_ornament'] === 'yes') : ?>
                    <div class="ornament ornament--center reveal">
                        <div class="ornament-line"></div>
                        <div class="ornament-diamond-lg"></div>
                        <div class="ornament-line right"></div>
                    </div>
                    <?php endif; ?>

                    <?php if ($quote) : ?>
                    <p class="quote-text reveal d1">&ldquo;<?php echo $quote; ?>&rdquo;</p>
                    <?php endif; ?>

                    <?php if ($attr) : ?>
                    <p class="quote-attr reveal d2"><?php echo $attr; ?></p>
                    <?php endif; ?>

                    <?php if (!empty($s['show_cta']) && $s['show_cta'] === 'yes' && !empty($s['cta_text'])) : ?>
                    <a href="<?php echo esc_url($s['cta_url']['url'] ?? '#'); ?>" class="btn btn-gold reveal d3" style="margin-top:2.5rem">
                        <?php echo esc_html($s['cta_text']); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
