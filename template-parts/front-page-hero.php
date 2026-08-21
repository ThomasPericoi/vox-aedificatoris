<?php
$post_id = get_queried_object_id();
$hero_media_type = get_field('home_hero_media_type', $post_id);
$hero_image = $hero_media_type === 'image' ? get_field('home_hero_image', $post_id) : false;
$hero_video = $hero_media_type === 'video' ? get_field('home_hero_video', $post_id) : false;
$hero_title = get_field('home_hero_title', $post_id);
$hero_card_title = get_field('home_hero_card_title', $post_id);
$hero_card_text = get_field('home_hero_card_text', $post_id);
$hero_primary_cta = get_field('home_hero_primary_cta', $post_id);
$hero_secondary_cta = get_field('home_hero_secondary_cta', $post_id);
$hero_has_image = $hero_media_type === 'image' && $hero_image;
$hero_has_video = $hero_media_type === 'video' && $hero_video;
$hero_has_primary_cta = !empty($hero_primary_cta['url']) && !empty($hero_primary_cta['title']);
$hero_has_secondary_cta = !empty($hero_secondary_cta['url']) && !empty($hero_secondary_cta['title']);

if (!$hero_has_image && !$hero_has_video && !$hero_title && !$hero_card_title && !$hero_card_text && !$hero_has_primary_cta && !$hero_has_secondary_cta) {
    return;
}
?>

<!-- Front Page Hero -->
<section id="front-page-hero" class="front-page-hero js-alwaysInView"<?= $hero_title ? ' aria-labelledby="front-page-hero-title"' : ''; ?>>
    <?php if ($hero_has_image): ?>
        <figure class="front-page-hero-media">
            <?= wp_get_attachment_image($hero_image, 'full', false, array('alt' => '', 'aria-hidden' => 'true')); ?>
        </figure>
    <?php elseif ($hero_has_video): ?>
        <video class="front-page-hero-media" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
            <source src="<?= esc_url(wp_get_attachment_url($hero_video)); ?>" type="<?= esc_attr(get_post_mime_type($hero_video)); ?>">
        </video>
    <?php endif; ?>

    <div class="front-page-hero-inner container container-lg">
        <?php if ($hero_title): ?>
            <h1 id="front-page-hero-title"><?= wp_kses_post($hero_title); ?></h1>
        <?php endif; ?>

        <?php if ($hero_card_title || $hero_card_text || $hero_has_primary_cta || $hero_has_secondary_cta): ?>
            <div class="front-page-hero-card">
                <?php if ($hero_card_title): ?>
                    <h2 class="h5-size"><?= wp_kses_post($hero_card_title); ?></h2>
                <?php endif; ?>

                <?php if ($hero_card_text): ?>
                    <div class="front-page-hero-card-text formatted">
                        <?= wp_kses_post($hero_card_text); ?>
                    </div>
                <?php endif; ?>

                <?php if ($hero_has_primary_cta || $hero_has_secondary_cta): ?>
                    <div class="front-page-hero-actions btn-wrapper">
                        <?php if ($hero_has_primary_cta): ?>
                            <a class="btn btn-black btn-icon-arrow-right" href="<?= esc_url($hero_primary_cta['url']); ?>"<?= !empty($hero_primary_cta['target']) ? ' target="' . esc_attr($hero_primary_cta['target']) . '"' : ''; ?><?= !empty($hero_primary_cta['target']) && $hero_primary_cta['target'] === '_blank' ? ' rel="noopener noreferrer"' : ''; ?>>
                                <?= esc_html($hero_primary_cta['title']); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($hero_has_secondary_cta): ?>
                            <a class="btn btn-primary" href="<?= esc_url($hero_secondary_cta['url']); ?>"<?= !empty($hero_secondary_cta['target']) ? ' target="' . esc_attr($hero_secondary_cta['target']) . '"' : ''; ?><?= !empty($hero_secondary_cta['target']) && $hero_secondary_cta['target'] === '_blank' ? ' rel="noopener noreferrer"' : ''; ?>>
                                <?= esc_html($hero_secondary_cta['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
