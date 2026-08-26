<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
$post_id = get_the_ID();
$content = trim(get_the_content());
$subtitle = get_the_excerpt();
$format = get_field('realisation_format', $post_id);
$client = get_field('realisation_client', $post_id);
$pdf = $format === 'pdf' ? get_field('realisation_pdf', $post_id) : false;
$video = $format === 'video' ? get_field('realisation_video', $post_id) : false;
$pdf_url = $pdf ? wp_get_attachment_url($pdf) : '';
$video_url = $video ? wp_get_attachment_url($video) : '';
?>

<!-- Hero -->
<section id="realisation-hero-<?= esc_attr($post_id); ?>" class="hero hero-simple realisation-single-hero">
    <div class="container container-sm formatted">
        <h1><?= esc_html(get_the_title()); ?></h1>

        <?php if ($client): ?>
            <p class="realisation-single-client"><?= esc_html($client); ?></p>
        <?php endif; ?>

        <?php if ($subtitle) : ?>
            <p class="description"><?= wp_kses_post($subtitle); ?></p>
        <?php endif; ?>

        <?php if (has_post_thumbnail()) : ?>
            <figure class="hero-media">
                <?php the_post_thumbnail('full'); ?>
            </figure>
        <?php endif; ?>
    </div>
</section>

<?php if ($content || $pdf_url || $video_url) : ?>
    <!-- Content -->
    <section id="realisation-content-<?= esc_attr($post_id); ?>" class="realisation-single-content">
        <div class="container container-lg">
            <?php if ($pdf_url): ?>
                <div class="realisation-pdf-viewer">
                    <iframe src="<?= esc_url(get_template_directory_uri() . '/assets/js/pdfjs/web/viewer.html?file=' . rawurlencode($pdf_url)); ?>" loading="lazy" allowfullscreen title="<?= esc_attr(sprintf(__('Document PDF : %s', 'vox-aedificatoris'), get_the_title())); ?>"></iframe>

                    <a class="btn btn-primary" href="<?= esc_url($pdf_url); ?>" download>
                        <?= esc_html__('Télécharger le PDF', 'vox-aedificatoris'); ?>
                    </a>
                </div>
            <?php elseif ($video_url): ?>
                <video class="realisation-single-video" controls playsinline preload="metadata"<?= has_post_thumbnail() ? ' poster="' . esc_url(get_the_post_thumbnail_url($post_id, 'full')) . '"' : ''; ?>>
                    <source src="<?= esc_url($video_url); ?>" type="<?= esc_attr(get_post_mime_type($video)); ?>">
                </video>
            <?php endif; ?>

            <?php if ($content): ?>
                <div class="realisation-single-body formatted">
                    <?php the_content(); ?>
                    <?php
                    wp_link_pages(array(
                        'before' => '<nav class="page-links" aria-label="' . esc_attr__('Navigation de la page', 'vox-aedificatoris') . '">',
                        'after' => '</nav>',
                    ));
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
