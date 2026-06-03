<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="page-transition" aria-hidden="true"></div>

<?php
$header_id = vg_get_header_template_id();
if ($header_id) {
    echo vg_get_elementor_content($header_id);
}
