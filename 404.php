<?php get_header(); ?>
<main id="main" class="vg-main">
    <section class="page-hero" style="text-align:center;">
        <div class="container container--sm">
            <span class="eyebrow"><?php esc_html_e('Error 404', 'venicegarden'); ?></span>
            <div class="gold-rule gold-rule--center gold-rule--wide"></div>
            <h1><?php esc_html_e('Page Not Found', 'venicegarden'); ?></h1>
            <p class="lead" style="margin:1.5rem auto 3rem;">
                <?php esc_html_e('The page you are looking for may have moved or no longer exists.', 'venicegarden'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-gold">
                <?php esc_html_e('Return Home', 'venicegarden'); ?>
            </a>
        </div>
    </section>
</main>
<?php get_footer(); ?>
