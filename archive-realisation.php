<?php get_header(); ?>

<!-- Hero -->
<section id="realisations-archive-hero" class="hero hero-simple">
    <div class="container container-sm">
        <h1><?= esc_html(post_type_archive_title('', false)); ?></h1>
        <?php if (get_the_archive_description()) : ?>
            <div class="description formatted">
                <?= wp_kses_post(get_the_archive_description()); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Réalisations -->
<section id="realisations-archive-loop" class="realisations-archive">
    <div class="container container-lg">
        <?php if (have_posts()) : ?>
            <div class="grid realisations">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/item', 'realisation', array(
                        'index' => $wp_query->current_post,
                    )); ?>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(array(
                'prev_text' => esc_html__('Page précédente', 'vox-aedificatoris'),
                'next_text' => esc_html__('Page suivante', 'vox-aedificatoris'),
            )); ?>
        <?php else : ?>
            <div class="formatted">
                <p><?= esc_html__('Aucune réalisation trouvée.', 'vox-aedificatoris'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
