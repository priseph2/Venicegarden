<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Team_Grid extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-team-grid'; }
    public function get_title(): string     { return __('VG Team Grid', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-person'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['team', 'people', 'members', 'staff', 'venice']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_header', [
            'label' => __('Section Header', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('show_header', ['label' => __('Show Header', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes']);
        $this->add_control('eyebrow',     ['label' => __('Eyebrow', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Our People', 'condition' => ['show_header' => 'yes']]);
        $this->add_control('heading',     ['label' => __('Heading', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'The Backbone of Venice Gardens', 'condition' => ['show_header' => 'yes']]);
        $this->add_control('description', ['label' => __('Description', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Spooling professionals from various industries — our people are the unalloyed pride of our existence.', 'rows' => 3, 'condition' => ['show_header' => 'yes']]);
        $this->end_controls_section();

        $this->start_controls_section('section_members', [
            'label' => __('Team Members', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('image', ['label' => __('Photo', 'venicegarden'), 'type' => \Elementor\Controls_Manager::MEDIA]);
        $repeater->add_control('name',  ['label' => __('Name / Title', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Executive Leadership']);
        $repeater->add_control('role',  ['label' => __('Role / Division', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'C-Suite']);

        $this->add_control('members', [
            'label'       => __('Team Members', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['name' => 'Executive Leadership', 'role' => 'C-Suite'],
                ['name' => 'Brand Management',     'role' => 'Brand Division'],
                ['name' => 'Sales & Distribution', 'role' => 'Commercial Division'],
                ['name' => 'Creative & Marketing', 'role' => 'Marketing Division'],
            ],
            'title_field' => '{{{ name }}}',
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_layout', [
            'label' => __('Layout', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('columns',        ['label' => __('Columns', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'grid-4', 'options' => ['grid-4' => '4 Columns', 'grid-3' => '3 Columns', 'grid-2' => '2 Columns']]);
        $this->add_control('grayscale',      ['label' => __('Grayscale Images', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes']);
        $this->add_control('bg_color',       ['label' => __('Section Background', 'venicegarden'), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'var(--cream)']);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s         = $this->get_settings_for_display();
        $members   = $s['members'] ?? [];
        $cols      = esc_attr($s['columns'] ?? 'grid-4');
        $grayscale = !empty($s['grayscale']) && $s['grayscale'] === 'yes';
        $bg        = esc_attr($s['bg_color'] ?? 'var(--cream)');
        $img_style = $grayscale ? 'filter:grayscale(25%);transition:filter .4s;' : '';
        ?>
        <section class="section" style="background:<?php echo $bg; ?>">
            <div class="container">
                <?php if (!empty($s['show_header']) && $s['show_header'] === 'yes') : ?>
                <div class="text-center reveal" style="margin-bottom:4rem">
                    <?php if (!empty($s['eyebrow'])) : ?>
                    <span class="eyebrow"><?php echo esc_html($s['eyebrow']); ?></span>
                    <div class="gold-rule gold-rule--center"></div>
                    <?php endif; ?>
                    <?php if (!empty($s['heading'])) : ?>
                    <h2><?php echo esc_html($s['heading']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($s['description'])) : ?>
                    <p class="lead" style="max-width:580px;margin:1rem auto 0"><?php echo esc_html($s['description']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="<?php echo $cols; ?>" style="gap:1.5rem">
                    <?php foreach ($members as $i => $member) :
                        $d       = ($i % 4) + 1;
                        $img_url = esc_url($member['image']['url'] ?? '');
                    ?>
                    <div class="team-member-card reveal d<?php echo $d; ?>">
                        <div class="team-member-photo">
                            <?php if ($img_url) : ?>
                            <img src="<?php echo $img_url; ?>"
                                 alt="<?php echo esc_attr($member['name'] ?? ''); ?>"
                                 loading="lazy"
                                 style="<?php echo esc_attr($img_style); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="team-member-name"><?php echo esc_html($member['name'] ?? ''); ?></div>
                        <div class="team-member-role"><?php echo esc_html($member['role'] ?? ''); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
