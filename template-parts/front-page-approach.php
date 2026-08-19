<?php
$post_id = get_queried_object_id();
$approach_eyebrow = get_field('home_approach_eyebrow', $post_id);
$approach_title = get_field('home_approach_title', $post_id);
$approach_introduction = get_field('home_approach_introduction', $post_id);
$approach_steps = get_field('home_approach_steps', $post_id);

if (!$approach_steps) {
    return;
}
?>

<!-- Front Page Approach -->
<section id="front-page-approach" class="front-page-approach" <?= $approach_title ? ' aria-labelledby="front-page-approach-title"' : ''; ?>>
    <div class="container container-lg">
        <?php if ($approach_eyebrow || $approach_title || $approach_introduction): ?>
            <header class="front-page-approach-header">
                <?php if ($approach_eyebrow || $approach_title): ?>
                    <div class="front-page-approach-heading">
                        <?php if ($approach_eyebrow): ?>
                            <p class="eyebrow"><?= esc_html($approach_eyebrow); ?></p>
                        <?php endif; ?>

                        <?php if ($approach_title): ?>
                            <h2 id="front-page-approach-title"><?= wp_kses_post($approach_title); ?></h2>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($approach_introduction): ?>
                    <div class="front-page-approach-introduction formatted">
                        <?= wp_kses_post($approach_introduction); ?>
                    </div>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <?php if ($approach_steps): ?>
            <ol class="front-page-approach-steps">
                <?php foreach ($approach_steps as $approach_step): ?>
                    <li class="front-page-approach-step">
                        <?php if (!empty($approach_step['title'])): ?>
                            <h3><?= wp_kses_post($approach_step['title']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($approach_step['text'])): ?>
                            <div class="front-page-approach-step-text formatted">
                                <?= wp_kses_post($approach_step['text']); ?>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</section>
