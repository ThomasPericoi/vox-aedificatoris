<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
$post_id = get_the_ID();
$content = trim(get_the_content());
?>

<!-- Hero -->
<section id="hero-<?= esc_attr($post_id); ?>" class="hero hero-simple">
    <div class="container container-sm">
        <h1><?= esc_html(get_the_title()); ?></h1>
        <?php if (has_post_thumbnail()) : ?>
            <figure class="hero-media">
                <?php the_post_thumbnail('full'); ?>
            </figure>
        <?php endif; ?>
    </div>
</section>

<?php if ($content) : ?>
    <!-- Content -->
    <section id="content-<?= esc_attr($post_id); ?>">
        <div class="container container-sm formatted">
            <?php the_content(); ?>
            <?php
            wp_link_pages(array(
                'before' => '<nav class="page-links" aria-label="' . esc_attr__('Navigation de la page', 'vox-aedificatoris') . '">',
                'after' => '</nav>',
            ));
            ?>
        </div>
    </section>
<?php endif; ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
