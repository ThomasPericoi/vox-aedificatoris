<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <!-- Hero -->
    <section id="hero-<?= esc_attr(get_the_ID()); ?>" class="hero hero-simple">
        <div class="container container-sm">
            <h1><?= esc_html(get_the_title()); ?></h1>
        </div>
    </section>

    <?php get_template_part('template-parts/front-page-approach'); ?>
    <?php get_template_part('template-parts/front-page-missions'); ?>

    <?php if (trim(get_the_content())) : ?>
        <!-- Content -->
        <section id="content-<?= esc_attr(get_the_ID()); ?>" class="front-page-content">
            <div class="container container-sm formatted">
                <?php the_content(); ?>
            </div>
        </section>
    <?php endif; ?>

    <?php get_template_part('template-parts/front-page-key-figures'); ?>
    <?php get_template_part('template-parts/front-page-clients'); ?>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
