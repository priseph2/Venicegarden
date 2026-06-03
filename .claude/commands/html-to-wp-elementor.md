# HTML → WordPress + Elementor Free Theme Conversion

You are an expert WordPress theme developer. When invoked, your task is to convert an HTML/CSS/JS template into a fully functional, standalone WordPress theme that works with **Elementor Free** page builder.

## Non-Negotiable Rules

1. **Zero hardcoded content** — no static text, images, or links anywhere in PHP template files. Every word, image, URL, and color must be an Elementor widget control. Default values in controls are demo content only.
2. **Elementor Free only** — no Elementor Pro features (`\Elementor\Controls_Manager`, `\Elementor\Widget_Base`, `\Elementor\Repeater` only).
3. **Standalone theme** — no parent theme dependency.
4. **PHP 8.1+ with `declare(strict_types=1)`** on every file.
5. **WordPress 6.4+** compatibility.
6. Widget names prefixed with the theme slug: `themeslug-widget-name`.
7. All widgets in namespace `ThemeNamespace\Widgets\`.

---

## Folder Structure to Create

```
theme-folder/
├── style.css                          # Theme header comment only
├── functions.php                      # Bootstrap + includes
├── index.php                          # Empty fallback
├── front-page.php                     # get_header/content/get_footer
├── page.php
├── single.php
├── archive.php
├── 404.php
├── header.php                         # Renders Elementor header template
├── footer.php                         # Renders Elementor footer template
├── inc/
│   ├── enqueue.php                    # CSS/JS enqueue
│   ├── menus.php                      # Nav menu locations
│   ├── cpt.php                        # Custom post types
│   ├── helpers.php                    # Utility functions
│   ├── customizer.php                 # Theme options
│   ├── template-settings.php          # Header/footer template admin page
│   ├── elementor.php                  # Widget registration (critical - see pitfalls)
│   ├── contact-handler.php            # AJAX form handler
│   └── demo-importer.php              # One-click demo content
├── elementor/
│   └── widgets/
│       └── class-themeslug-*.php      # One file per widget
└── assets/
    ├── css/
    │   ├── theme.css                  # All front-end styles
    │   └── admin.css                  # Admin page styles
    └── js/
        └── theme.js                   # All front-end JS
```

---

## Critical Pitfall — Widget Registration Timing

**NEVER wrap Elementor hooks inside `add_action('plugins_loaded', ...)`** when registering from a theme.

`plugins_loaded` fires **before** `functions.php` is loaded. By the time the theme code runs, that action has already completed — callbacks registered inside it are never called. All widgets silently fail to register with no error.

**WRONG (silent failure):**
```php
add_action('plugins_loaded', function(): void {
    add_action('elementor/widgets/register', function($wm): void {
        // This NEVER runs — plugins_loaded already fired
    });
});
```

**CORRECT:**
```php
// Register directly — elementor/widgets/register fires during WordPress
// init, which is after functions.php loads. No wrapper needed.
add_action('elementor/widgets/register', function($widgets_manager): void {
    // load and register widgets here
});

add_action('elementor/elements/categories_registered', function($elements_manager): void {
    $elements_manager->add_category('themeslug', [
        'title' => __('Theme Name', 'themeslug'),
        'icon'  => 'eicon-gallery-grid',
    ]);
});
```

---

## inc/elementor.php Pattern

```php
<?php
declare(strict_types=1);

add_action('elementor/elements/categories_registered', function ($elements_manager): void {
    $elements_manager->add_category('themeslug', [
        'title' => __('Theme Name', 'themeslug'),
        'icon'  => 'eicon-gallery-grid',
    ]);
});

add_action('elementor/widgets/register', function ($widgets_manager): void {
    $widget_files = [
        'class-themeslug-nav',
        'class-themeslug-hero',
        // ... all widget file names without .php
    ];

    foreach ($widget_files as $file) {
        $path = VG_THEME_DIR . '/elementor/widgets/' . $file . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }

    // Auto-derive FQCN: class-themeslug-about-split → ThemeNS\Widgets\ThemeSlug_About_Split
    $namespace = 'ThemeNamespace\\Widgets\\';
    foreach ($widget_files as $file) {
        $class_suffix = str_replace(['class-themeslug-', '-'], ['ThemeSlug_', '_'], $file);
        $class_suffix = implode('_', array_map('ucfirst', explode('_', $class_suffix)));
        $fqcn = $namespace . $class_suffix;
        if (class_exists($fqcn)) {
            $widgets_manager->register(new $fqcn());
        }
    }
});
```

---

## Widget File Template

Every widget follows this exact pattern. File name determines class name automatically.

```php
<?php
declare(strict_types=1);
namespace ThemeNamespace\Widgets;

class ThemeSlug_Widget_Name extends \Elementor\Widget_Base {

    public function get_name(): string      { return 'themeslug-widget-name'; }
    public function get_title(): string     { return __('Theme Widget Name', 'themeslug'); }
    public function get_icon(): string      { return 'eicon-banner'; }      // Elementor icon
    public function get_categories(): array { return ['themeslug']; }
    public function get_keywords(): array   { return ['keyword', 'themeslug']; }

    protected function register_controls(): void {
        $this->start_controls_section('section_content', [
            'label' => __('Content', 'themeslug'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        // TEXT
        $this->add_control('heading', [
            'label'   => __('Heading', 'themeslug'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Default Heading Text',
        ]);

        // TEXTAREA
        $this->add_control('description', [
            'label'   => __('Description', 'themeslug'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Default description text.',
            'rows'    => 3,
        ]);

        // WYSIWYG (rich text)
        $this->add_control('body', [
            'label'   => __('Body', 'themeslug'),
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => '<p>Default body content.</p>',
        ]);

        // IMAGE
        $this->add_control('image', [
            'label' => __('Image', 'themeslug'),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ]);

        // URL
        $this->add_control('link', [
            'label'   => __('Link', 'themeslug'),
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => ['url' => '#'],
        ]);

        // COLOR
        $this->add_control('bg_color', [
            'label'   => __('Background', 'themeslug'),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
        ]);

        // SELECT
        $this->add_control('layout', [
            'label'   => __('Layout', 'themeslug'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'left',
            'options' => ['left' => 'Left', 'right' => 'Right'],
        ]);

        // SWITCHER (toggle)
        $this->add_control('show_button', [
            'label'        => __('Show Button', 'themeslug'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        // SLIDER
        $this->add_control('speed', [
            'label'   => __('Speed (s)', 'themeslug'),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => ['px' => ['min' => 10, 'max' => 120]],
            'default' => ['size' => 40],
        ]);

        // REPEATER
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('item_title', ['label' => __('Title', 'themeslug'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Item']);
        $repeater->add_control('item_desc',  ['label' => __('Desc', 'themeslug'),  'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Description.']);

        $this->add_control('items', [
            'label'       => __('Items', 'themeslug'),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['item_title' => 'Item One', 'item_desc' => 'First item description.'],
                ['item_title' => 'Item Two', 'item_desc' => 'Second item description.'],
            ],
            'title_field' => '{{{ item_title }}}',
        ]);

        // CONDITIONAL CONTROL (shown only when another control has a value)
        $this->add_control('button_text', [
            'label'     => __('Button Text', 'themeslug'),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Click Here',
            'condition' => ['show_button' => 'yes'],
        ]);

        $this->end_controls_section();
    }

    protected function render(): void {
        $s = $this->get_settings_for_display();
        // Always use $s['control_name'] — never hardcode content
        $img_url  = esc_url($s['image']['url'] ?? '');
        $link_url = esc_url($s['link']['url'] ?? '#');
        $bg       = esc_attr($s['bg_color'] ?? '#fff');
        $items    = $s['items'] ?? [];
        ?>
        <section style="background:<?php echo $bg; ?>">
            <?php if (!empty($s['heading'])) : ?>
            <h2><?php echo esc_html($s['heading']); ?></h2>
            <?php endif; ?>
            <?php foreach ($items as $item) : ?>
            <div>
                <h4><?php echo esc_html($item['item_title'] ?? ''); ?></h4>
                <p><?php echo esc_html($item['item_desc'] ?? ''); ?></p>
            </div>
            <?php endforeach; ?>
        </section>
        <?php
    }
}
```

---

## Header / Footer Without Elementor Pro

Elementor Pro has a Theme Builder. Without it, use this pattern:

**`inc/template-settings.php`** — admin page at Appearance › VG Theme Settings where the user picks which WordPress page is the global header and which is the footer. Stores IDs in `wp_options`.

**`inc/helpers.php`** — render function:
```php
function vg_get_elementor_content(int $post_id): string {
    if (!$post_id || !class_exists('\Elementor\Plugin')) return '';
    return \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($post_id, true);
}
```

**`header.php`:**
```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head><?php wp_head(); ?></head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$header_id = vg_get_header_template_id(); // reads wp_options
if ($header_id) echo vg_get_elementor_content($header_id);
```

**`footer.php`:**
```php
<?php
$footer_id = vg_get_footer_template_id();
if ($footer_id) echo vg_get_elementor_content($footer_id);
?>
<?php wp_footer(); ?>
</body></html>
```

---

## Navigation Menus in Widgets

Instead of hardcoding links, expose a SELECT control listing registered WordPress menus. Use a custom Walker that outputs bare `<a>` tags matching the original HTML structure.

```php
// In helpers.php
function vg_get_menus_for_select(): array {
    $menus = wp_get_nav_menus();
    $options = [];
    foreach ($menus as $menu) {
        $options[$menu->slug] = $menu->name;
    }
    return $options;
}

class VG_Nav_Walker extends \Walker_Nav_Menu {
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0): void {
        $output .= '<a href="' . esc_url($data_object->url) . '">' . esc_html($data_object->title) . '</a>';
    }
    public function start_lvl(&$output, $depth = 0, $args = null): void {}
    public function end_lvl(&$output, $depth = 0, $args = null): void {}
    public function end_el(&$output, $data_object, $depth = 0, $args = null): void {}
}
```

---

## Demo Content Importer Pattern

Create `inc/demo-importer.php` — programmatic importer, no plugin dependency.

```php
add_action('admin_menu', function(): void {
    add_theme_page('Import Demo Content', 'Import Demo Content', 'manage_options', 'vg-demo-import', 'vg_render_demo_import_page');
});

function vg_run_demo_import(): array {
    $log = [];

    // 1. Create header/footer template pages with Elementor widget JSON pre-embedded
    // 2. Create content pages (Home, About, etc.)
    // 3. Set WordPress static front page
    // 4. Create nav menus and assign to theme locations
    // 5. Create CPT sample entries with taxonomy terms
    // 6. Store header/footer template IDs in wp_options

    return $log;
}

// Helper: generate Elementor JSON for a single widget on a page
function vg_elementor_widget_json(string $widget_type, array $settings = []): string {
    static $idx = 0; $idx++;
    $i = str_pad((string)$idx, 3, '0', STR_PAD_LEFT);
    return (string) wp_json_encode([[
        'id' => 'vgs'.$i, 'elType' => 'section',
        'settings' => ['layout' => 'full_width', 'gap' => 'no',
            'padding' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>true]],
        'elements' => [[
            'id' => 'vgc'.$i, 'elType' => 'column',
            'settings' => ['_column_size' => 100],
            'elements' => [[
                'id' => 'vgw'.$i, 'elType' => 'widget',
                'widgetType' => $widget_type,
                'settings' => empty($settings) ? new \stdClass() : $settings,
                'elements' => [], 'isInner' => false,
            ]],
            'isInner' => false,
        ]],
        'isInner' => false,
    ]]);
}
```

---

## Workflow When Starting a New Conversion

1. **Study the HTML** — identify every distinct section/component as a future widget
2. **Plan widgets** — name them `themeslug-component-name`, one file each
3. **Create theme scaffold** — `style.css`, `functions.php`, `index.php`, all `inc/` files
4. **Port CSS** — convert all styles to `assets/css/theme.css` using CSS custom properties for the color system
5. **Port JS** — convert animations, interactions to `assets/js/theme.js`; add Elementor re-init hook:
   ```js
   if (window.elementorFrontend) {
       window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
           initReveal(); initCounters(); // re-init all JS after Elementor renders
       });
   }
   ```
6. **Build widgets** — for each HTML section, create a widget file; every piece of content becomes a control; HTML structure becomes the `render()` method
7. **Register correctly** — use direct `add_action('elementor/widgets/register', ...)` (no `plugins_loaded` wrapper)
8. **Build demo importer** — programmatic, idempotent, creates pages + menus + CPTs
9. **PHP syntax check** — `for f in elementor/widgets/*.php inc/*.php *.php; do php -l $f; done`
10. **Verify class derivation** — run the FQCN derivation logic in PHP CLI before deploying

---

## Escaping Quick Reference

```php
echo esc_html($s['text']);          // plain text output
echo esc_attr($s['attr']);          // HTML attribute values
echo esc_url($s['url']['url']);     // URLs
echo wp_kses_post($s['wysiwyg']);   // rich text (allows safe HTML tags)
echo antispambot($email);           // email addresses
echo wp_json_encode($array);        // JSON output
```

---

## Common Elementor Icon Names

```
eicon-banner          eicon-nav-menu        eicon-slider-full-screen
eicon-columns         eicon-counter         eicon-gallery-grid
eicon-blockquote      eicon-globe           eicon-inner-section
eicon-call-to-action  eicon-form-horizontal eicon-person
eicon-store           eicon-footer          eicon-map-pin
eicon-scroll          eicon-animation-text  eicon-check-circle
```

---

## Quality Checklist Before Delivery

- [ ] Zero hardcoded text/images/links in any PHP file
- [ ] Every widget has meaningful default values (demo content)
- [ ] All 3 `get_*` template tags use `esc_*` functions
- [ ] `inc/elementor.php` uses direct `add_action` (no `plugins_loaded` wrapper)
- [ ] Class names match file names via auto-derivation
- [ ] All widget names return `'themeslug-widget-name'` from `get_name()`
- [ ] All widgets return `['themeslug']` from `get_categories()`
- [ ] PHP syntax clean on all files (`php -l`)
- [ ] JS re-init hook wired for Elementor editor
- [ ] Demo importer is idempotent (safe to run twice)
- [ ] Header/footer template system tested end-to-end
