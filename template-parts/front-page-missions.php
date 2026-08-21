<?php
$post_id = get_queried_object_id();
$missions_eyebrow = get_field('home_missions_eyebrow', $post_id);
$missions_title = get_field('home_missions_title', $post_id);
$missions = get_field('home_missions', $post_id);

if (!$missions) {
    return;
}

$mission_icons = array(
    'v' => get_template_directory_uri() . '/assets/medias/icons/v.svg',
    'o' => get_template_directory_uri() . '/assets/medias/icons/o.svg',
    'x' => get_template_directory_uri() . '/assets/medias/icons/x.svg',
);
$mission_colors = array('hippie', 'hippie-80', 'hippie-50', 'hippie-30', 'hippie-16');
?>

<!-- Front Page Missions -->
<section id="front-page-missions" class="front-page-missions" <?= $missions_title ? ' aria-labelledby="front-page-missions-title"' : ''; ?>>
    <?php if ($missions_eyebrow || $missions_title): ?>
        <header class="front-page-missions-header container">
            <?php if ($missions_eyebrow): ?>
                <p class="eyebrow"><?= esc_html($missions_eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($missions_title): ?>
                <h2 id="front-page-missions-title"><?= esc_html($missions_title); ?></h2>
            <?php endif; ?>
        </header>
    <?php endif; ?>

    <?php foreach ($missions as $mission_index => $mission):
        if (empty($mission['title'])) {
            continue;
        }

        $mission_icon_key = !empty($mission['icon']) ? $mission['icon'] : '';
        $mission_color_value = !empty($mission['color']) ? $mission['color'] : '';
        $mission_icon = isset($mission_icons[$mission_icon_key]) ? $mission_icons[$mission_icon_key] : '';
        $mission_color = in_array($mission_color_value, $mission_colors, true) ? $mission_color_value : '';
        $mission_image = !empty($mission['image']) ? $mission['image'] : false;
        $mission_introduction = !empty($mission['introduction']) ? $mission['introduction'] : false;
        $mission_text = !empty($mission['text']) ? $mission['text'] : false;
        $mission_cta = !empty($mission['cta']) ? $mission['cta'] : false;
        $mission_offers = !empty($mission['offers']) ? $mission['offers'] : false;
        $mission_is_opened = $mission_index === 0 && $mission_offers;
        $mission_panel_id = 'front-page-mission-offers-' . $post_id . '-' . $mission_index;
        $mission_cta_target = $mission_cta && !empty($mission_cta['target']) ? $mission_cta['target'] : '';
        $mission_cta_rel = $mission_cta_target === '_blank' ? 'noopener noreferrer' : '';
        ?>

        <article
            class="front-page-mission<?= $mission_color ? ' front-page-mission-' . esc_attr($mission_color) : ''; ?>">
            <div class="front-page-mission-inner container container-lg">
                <h3 class="front-page-mission-title">
                    <?php if ($mission_icon): ?>
                        <img src="<?= esc_url($mission_icon); ?>" alt="" width="41" height="39">
                    <?php endif; ?>

                    <?= esc_html($mission['title']); ?>
                </h3>

                <?php if ($mission_offers): ?>
                    <button class="front-page-mission-icon-toggle" type="button"
                        aria-expanded="<?= $mission_is_opened ? 'true' : 'false'; ?>"
                        aria-controls="<?= esc_attr($mission_panel_id); ?>">
                        <span
                            class="screen-reader-text"><?= esc_html(sprintf(__('Afficher ou masquer l’offre %s', 'vox-aedificatoris'), $mission['title'])); ?></span>
                    </button>
                <?php endif; ?>

                <?php if ($mission_image): ?>
                    <figure class="front-page-mission-media">
                        <?= wp_get_attachment_image($mission_image, 'large'); ?>
                    </figure>
                <?php endif; ?>

                <div class="front-page-mission-content">
                    <?php if ($mission_introduction): ?>
                        <h4 class="h5-size"><?= esc_html($mission_introduction); ?></h4>
                    <?php endif; ?>

                    <?php if ($mission_text): ?>
                        <div class="front-page-mission-text formatted">
                            <?= wp_kses_post($mission_text); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($mission_cta && !empty($mission_cta['url']) && !empty($mission_cta['title'])): ?>
                        <a class="inline-link" href="<?= esc_url($mission_cta['url']); ?>"
                            <?= $mission_cta_target ? ' target="' . esc_attr($mission_cta_target) . '"' : ''; ?>        <?= $mission_cta_rel ? ' rel="' . esc_attr($mission_cta_rel) . '"' : ''; ?>>
                            <?= esc_html($mission_cta['title']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($mission_offers): ?>
                        <button class="btn btn-black front-page-mission-offer-toggle" type="button"
                            aria-expanded="<?= $mission_is_opened ? 'true' : 'false'; ?>"
                            aria-controls="<?= esc_attr($mission_panel_id); ?>">
                            <span><?= esc_html__('Découvrir mon offre', 'vox-aedificatoris'); ?></span>
                            <span class="front-page-mission-offer-toggle-icon" aria-hidden="true"></span>
                        </button>

                        <div id="<?= esc_attr($mission_panel_id); ?>" class="front-page-mission-offers"
                            <?= $mission_is_opened ? '' : ' hidden'; ?>>
                            <p class="front-page-mission-offers-title">
                                <?= esc_html__('Mon offre', 'vox-aedificatoris'); ?></p>

                            <ol>
                                <?php foreach ($mission_offers as $mission_offer):
                                    if (empty($mission_offer['title'])) {
                                        continue;
                                    }
                                    ?>
                                    <li><?= esc_html($mission_offer['title']); ?></li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</section>
