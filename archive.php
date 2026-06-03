<?php get_header(); ?>
<main id="main" class="vg-main">
    <div class="container" style="padding-top: calc(var(--nav-h) + 4rem); padding-bottom: 6rem;">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
        <div class="grid-3" style="margin-top: 3rem;">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('brand-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="brand-img">
                            <?php the_post_thumbnail('vg-card', ['loading' => 'lazy']); ?>
                        </div>
                    <?php endif; ?>
                    <div class="brand-body">
                        <div class="brand-name"><?php the_title(); ?></div>
                        <p class="brand-desc"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="margin-top:1rem;">
                            <?php esc_html_e('View', 'venicegarden'); ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; endif; ?>
        </div>
        <div style="margin-top: 3rem;">
            <?php the_posts_pagination(); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
