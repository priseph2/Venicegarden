<?php
$footer_id = vg_get_footer_template_id();
if ($footer_id) {
    echo vg_get_elementor_content($footer_id);
}
?>
<?php wp_footer(); ?>
</body>
</html>
