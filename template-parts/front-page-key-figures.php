<?php
$post_id = get_queried_object_id();
$key_figures = get_field('home_key_figures', $post_id);

if (!$key_figures) {
    return;
}
?>

<!-- Front Page Key Figures -->
<section id="front-page-key-figures" class="key-figures" aria-label="<?= esc_attr__('Chiffres clés', 'vox-aedificatoris'); ?>">
    <div class="container container-lg">
        <ul class="key-figures-list">
            <?php foreach ($key_figures as $key_figure) : ?>
                <li class="key-figure">
                    <?php if (!empty($key_figure['value'])) : ?>
                        <strong class="key-figure-value"><?= esc_html($key_figure['value']); ?></strong>
                    <?php endif; ?>

                    <?php if (!empty($key_figure['label'])) : ?>
                        <span class="key-figure-label"><?= esc_html($key_figure['label']); ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
