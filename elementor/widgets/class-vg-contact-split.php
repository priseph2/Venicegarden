<?php
declare(strict_types=1);
namespace VeniceGarden\Widgets;

class VG_Contact_Split extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'venicegarden-contact-split'; }
    public function get_title(): string     { return __('VG Contact Split', 'venicegarden'); }
    public function get_icon(): string      { return 'eicon-form-horizontal'; }
    public function get_categories(): array { return ['venicegarden']; }
    public function get_keywords(): array   { return ['contact', 'form', 'enquiry', 'split', 'venice']; }

    protected function register_controls(): void {

        /* ── Left: Contact Info ─────────────────────────────────── */
        $this->start_controls_section('section_info', [
            'label' => __('Contact Info (Left)', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('info_eyebrow',     ['label' => __('Eyebrow', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Reach Us Directly']);
        $this->add_control('info_heading',     ['label' => __('Heading', 'venicegarden'),     'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Always Open\nfor Partnership", 'rows' => 2]);
        $this->add_control('info_description', ['label' => __('Description', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Venice Gardens Distribution is Africa\'s premier luxury fragrance and beauty distributor. We welcome enquiries from retailers, brand owners, hotel groups and hospitality partners.', 'rows' => 4]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('label', ['label' => __('Row Label', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'General Enquiries']);
        $repeater->add_control('value', ['label' => __('Row Value', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'info@venicegardensdistribution.com']);
        $repeater->add_control('is_email',  ['label' => __('Is Email Link', 'venicegarden'),    'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '']);
        $repeater->add_control('icon_type', ['label' => __('Icon', 'venicegarden'), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'email', 'options' => ['email' => 'Email', 'location' => 'Location Pin', 'globe' => 'Globe']]);

        $this->add_control('contact_rows', [
            'label'       => __('Contact Rows', 'venicegarden'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['label' => 'General Enquiries', 'value' => 'info@venicegardensdistribution.com', 'is_email' => 'yes', 'icon_type' => 'email'],
                ['label' => 'Partnerships & Distribution', 'value' => 'partnerships@venicegardensdistribution.com', 'is_email' => 'yes', 'icon_type' => 'email'],
                ['label' => 'Head Office',       'value' => 'Lagos, Nigeria',        'is_email' => '',    'icon_type' => 'location'],
                ['label' => 'Regional Offices',  'value' => 'Accra, Ghana · Kigali, Rwanda', 'is_email' => '', 'icon_type' => 'globe'],
            ],
            'title_field' => '{{{ label }}}',
        ]);

        $this->add_control('partnership_note_label', ['label' => __('Note Label', 'venicegarden'),   'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Partnership Enquiries']);
        $this->add_control('partnership_note_text',  ['label' => __('Note Text', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXTAREA,  'default' => 'Retailers, hotel groups and brand owners are welcome to enquire about distribution, stocking and promotional partnerships across our African network.', 'rows' => 3]);
        $this->end_controls_section();

        /* ── Right: Form ────────────────────────────────────────── */
        $this->start_controls_section('section_form', [
            'label' => __('Enquiry Form (Right)', 'venicegarden'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('form_eyebrow',       ['label' => __('Form Eyebrow', 'venicegarden'),       'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Send an Enquiry']);
        $this->add_control('form_heading',       ['label' => __('Form Heading', 'venicegarden'),       'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Tell Us About Your Business']);
        $this->add_control('name_label',         ['label' => __('Full Name Label', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Full Name']);
        $this->add_control('email_label',        ['label' => __('Email Label', 'venicegarden'),        'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Email Address']);
        $this->add_control('company_label',      ['label' => __('Company Label', 'venicegarden'),      'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Company / Organisation']);
        $this->add_control('country_label',      ['label' => __('Country Label', 'venicegarden'),      'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Country']);
        $this->add_control('country_options',    ['label' => __('Country Options', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "nigeria:Nigeria\nghana:Ghana\nrwanda:Rwanda\nother-africa:Other African Country\ninternational:International", 'rows' => 5, 'description' => __('Format: value:Label (one per line)', 'venicegarden')]);
        $this->add_control('interest_label',     ['label' => __('Enquiry Type Label', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Nature of Enquiry']);
        $this->add_control('interest_options',   ['label' => __('Enquiry Options', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "retail-distribution:Retail / Distribution Partnership\nbrand-distribution:Brand Distribution in Africa\nhotel-stocking:Hotel / Hospitality Stocking\nairport-stocking:Airport Retail\ngeneral:General Enquiry\npress:Press / Media", 'rows' => 6, 'description' => __('Format: value:Label (one per line)', 'venicegarden')]);
        $this->add_control('message_label',      ['label' => __('Message Label', 'venicegarden'),      'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Message']);
        $this->add_control('submit_text',        ['label' => __('Submit Button Text', 'venicegarden'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Send Enquiry']);
        $this->add_control('privacy_note',       ['label' => __('Privacy Note', 'venicegarden'),       'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '* Required fields. Your information is handled with complete confidentiality. We do not share your details with third parties. We aim to respond within 2 business days.', 'rows' => 3]);
        $this->add_control('success_heading',    ['label' => __('Success Heading', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Thank You!']);
        $this->add_control('success_text',       ['label' => __('Success Text', 'venicegarden'),       'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Your enquiry has been received. A member of the Venice Gardens team will be in touch within 2 business days.', 'rows' => 3]);
        $this->add_control('success_tagline',    ['label' => __('Success Tagline', 'venicegarden'),    'type' => \Elementor\Controls_Manager::TEXT, 'default' => "Africa's Pride & Distributor of Note"]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $s = $this->get_settings_for_display();

        /* Parse select options from multiline textarea */
        $parse_opts = static function (string $raw): array {
            $lines = array_filter(array_map('trim', explode("\n", $raw)));
            $opts  = [];
            foreach ($lines as $line) {
                $parts = explode(':', $line, 2);
                if (count($parts) === 2) {
                    $opts[trim($parts[0])] = trim($parts[1]);
                }
            }
            return $opts;
        };

        $country_opts  = $parse_opts($s['country_options']  ?? '');
        $interest_opts = $parse_opts($s['interest_options'] ?? '');

        $icons = [
            'email'    => '<svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>',
            'location' => '<svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>',
            'globe'    => '<svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253"/></svg>',
        ];
        ?>
        <section class="section">
            <div class="container">
                <div class="contact-split">

                    <!-- Left: Contact Info -->
                    <div class="contact-side reveal">
                        <?php if (!empty($s['info_eyebrow'])) : ?>
                        <span class="eyebrow"><?php echo esc_html($s['info_eyebrow']); ?></span>
                        <?php endif; ?>
                        <div class="ornament" style="margin:1rem 0 1.5rem">
                            <div class="ornament-line"></div>
                            <div class="ornament-diamond"></div>
                            <div class="ornament-line right"></div>
                        </div>
                        <?php if (!empty($s['info_heading'])) : ?>
                        <h2 style="font-size:clamp(1.8rem,2.8vw,2.8rem)"><?php echo wp_kses_post(nl2br(esc_html($s['info_heading']))); ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($s['info_description'])) : ?>
                        <p style="margin-top:1rem;color:var(--text-muted);font-size:.92rem;line-height:1.8"><?php echo esc_html($s['info_description']); ?></p>
                        <?php endif; ?>

                        <div style="margin-top:2.5rem">
                            <?php foreach (($s['contact_rows'] ?? []) as $row) :
                                $icon_html = $icons[$row['icon_type'] ?? 'email'] ?? $icons['email'];
                                $val_display = esc_html($row['value'] ?? '');
                                $val_html = !empty($row['is_email']) && $row['is_email'] === 'yes'
                                    ? '<a href="mailto:' . esc_attr($row['value']) . '">' . $val_display . '</a>'
                                    : $val_display;
                            ?>
                            <div class="contact-row">
                                <div class="contact-ico"><?php echo $icon_html; ?></div>
                                <div>
                                    <div class="contact-lbl"><?php echo esc_html($row['label'] ?? ''); ?></div>
                                    <div class="contact-val"><?php echo $val_html; ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (!empty($s['partnership_note_text'])) : ?>
                        <div style="margin-top:2rem;padding:1.5rem;background:var(--cream);border:1px solid var(--border-light);border-radius:var(--r-lg)">
                            <?php if (!empty($s['partnership_note_label'])) : ?>
                            <p style="font-size:.65rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);margin-bottom:.6rem"><?php echo esc_html($s['partnership_note_label']); ?></p>
                            <?php endif; ?>
                            <p style="font-size:.88rem;color:var(--text-muted);line-height:1.72"><?php echo esc_html($s['partnership_note_text']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Right: Form -->
                    <div class="reveal d2">
                        <div class="contact-card">
                            <?php if (!empty($s['form_eyebrow'])) : ?>
                            <span class="eyebrow"><?php echo esc_html($s['form_eyebrow']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($s['form_heading'])) : ?>
                            <h3 style="margin-top:.5rem;margin-bottom:2.25rem;font-size:1.6rem"><?php echo esc_html($s['form_heading']); ?></h3>
                            <?php endif; ?>

                            <form class="vg-contact-form" novalidate>
                                <?php wp_nonce_field('vg_contact_form', '_nonce'); ?>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="vg-name"><?php echo esc_html($s['name_label'] ?? 'Full Name'); ?> <span style="color:var(--gold)">*</span></label>
                                        <input type="text" id="vg-name" name="name" placeholder="<?php esc_attr_e('Your full name', 'venicegarden'); ?>" required autocomplete="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="vg-email"><?php echo esc_html($s['email_label'] ?? 'Email Address'); ?> <span style="color:var(--gold)">*</span></label>
                                        <input type="email" id="vg-email" name="email" placeholder="<?php esc_attr_e('your@email.com', 'venicegarden'); ?>" required autocomplete="email">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="vg-company"><?php echo esc_html($s['company_label'] ?? 'Company'); ?></label>
                                        <input type="text" id="vg-company" name="company" placeholder="<?php esc_attr_e('Your company name', 'venicegarden'); ?>" autocomplete="organization">
                                    </div>
                                    <div class="form-group">
                                        <label for="vg-country"><?php echo esc_html($s['country_label'] ?? 'Country'); ?></label>
                                        <select id="vg-country" name="country">
                                            <option value="" disabled selected><?php esc_html_e('Select your country', 'venicegarden'); ?></option>
                                            <?php foreach ($country_opts as $val => $label) : ?>
                                            <option value="<?php echo esc_attr($val); ?>"><?php echo esc_html($label); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="vg-interest"><?php echo esc_html($s['interest_label'] ?? 'Nature of Enquiry'); ?></label>
                                    <select id="vg-interest" name="interest">
                                        <option value="" disabled selected><?php esc_html_e('What are you enquiring about?', 'venicegarden'); ?></option>
                                        <?php foreach ($interest_opts as $val => $label) : ?>
                                        <option value="<?php echo esc_attr($val); ?>"><?php echo esc_html($label); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="vg-message"><?php echo esc_html($s['message_label'] ?? 'Message'); ?> <span style="color:var(--gold)">*</span></label>
                                    <textarea id="vg-message" name="message" placeholder="<?php esc_attr_e("Tell us about your business and how you'd like to work with Venice Gardens Distribution…", 'venicegarden'); ?>" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center;padding:1.05rem">
                                    <?php echo esc_html($s['submit_text'] ?? 'Send Enquiry'); ?>
                                    <?php echo vg_send_svg(); ?>
                                </button>

                                <?php if (!empty($s['privacy_note'])) : ?>
                                <p class="form-note"><?php echo esc_html($s['privacy_note']); ?></p>
                                <?php endif; ?>
                            </form>

                            <!-- Success State -->
                            <div class="form-success">
                                <div class="success-circle">
                                    <svg viewBox="0 0 24 24"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 style="font-family:var(--font-serif)"><?php echo esc_html($s['success_heading'] ?? 'Thank You!'); ?></h3>
                                <p style="color:var(--text-muted);margin-top:.85rem;max-width:360px;margin-left:auto;margin-right:auto;font-size:.92rem">
                                    <?php echo esc_html($s['success_text'] ?? ''); ?>
                                </p>
                                <?php if (!empty($s['success_tagline'])) : ?>
                                <p style="margin-top:1.75rem;font-size:.62rem;font-weight:700;letter-spacing:.28em;text-transform:uppercase;color:var(--gold)">
                                    <?php echo esc_html($s['success_tagline']); ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <?php
    }
}
