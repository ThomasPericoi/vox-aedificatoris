<?php
$format = get_field('realisation_format');
$client = get_field('realisation_client');
$format_labels = [
    'article' => __('Article', 'vox-aedificatoris'),
    'pdf' => __('PDF', 'vox-aedificatoris'),
    'video' => __('Vidéo', 'vox-aedificatoris'),
];
$cta_labels = [
    'article' => __('Lire', 'vox-aedificatoris'),
    'pdf' => __('Télécharger', 'vox-aedificatoris'),
    'video' => __('Visionner', 'vox-aedificatoris'),
];
?>

<article id="realisation-<?= esc_attr(get_the_ID()); ?>" <?php post_class('item-realisation'); ?>>
    <a class="item-realisation-link" href="<?= esc_url(get_permalink()); ?>">
        <?php if (has_post_thumbnail()): ?>
            <div class="item-realisation-media<?= $format === 'video' ? ' is-video' : ''; ?>">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <div class="item-realisation-content">
            <?php if (!empty($format_labels[$format])): ?>
                <p class="item-realisation-format"><?= esc_html($format_labels[$format]); ?></p>
            <?php endif; ?>

            <h3 class="h4-size item-realisation-title"><?= esc_html(get_the_title()); ?></h3>

            <?php if ($client): ?>
                <p class="item-realisation-client"><?= esc_html($client); ?></p>
            <?php endif; ?>

            <?php if (!empty($cta_labels[$format])): ?>
                <span class="inline-link inline-link-primary"><?= esc_html($cta_labels[$format]); ?></span>
            <?php endif; ?>
        </div>
    </a>
</article>
