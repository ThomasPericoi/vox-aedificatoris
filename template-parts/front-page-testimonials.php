<?php
$post_id = get_queried_object_id();
$testimonials_eyebrow = get_field('home_testimonials_eyebrow', $post_id);
$testimonials_title = get_field('home_testimonials_title', $post_id);
$testimonials = get_field('home_testimonials', $post_id);

if (!$testimonials) {
    return;
}
?>

<!-- Front Page Testimonials -->
<section id="front-page-testimonials" class="front-page-testimonials"<?= $testimonials_title ? ' aria-labelledby="front-page-testimonials-title"' : ''; ?>>
    <?php if ($testimonials_eyebrow || $testimonials_title): ?>
        <header class="front-page-testimonials-header container">
            <?php if ($testimonials_eyebrow): ?>
                <p class="eyebrow"><?= esc_html($testimonials_eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($testimonials_title): ?>
                <h2 id="front-page-testimonials-title"><?= esc_html($testimonials_title); ?></h2>
            <?php endif; ?>
        </header>
    <?php endif; ?>

    <div class="front-page-testimonials-slider swiper container">
        <div class="swiper-wrapper">
            <?php foreach ($testimonials as $testimonial): ?>
                <blockquote class="front-page-testimonial swiper-slide">
                    <?php if (!empty($testimonial['title'])): ?>
                        <h3 class="h5-size"><?= esc_html($testimonial['title']); ?></h3>
                    <?php endif; ?>

                    <?php if (!empty($testimonial['text'])): ?>
                        <div class="front-page-testimonial-text formatted">
                            <?= wp_kses_post($testimonial['text']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($testimonial['photo']) || !empty($testimonial['name']) || !empty($testimonial['position']) || !empty($testimonial['logo'])): ?>
                        <footer class="front-page-testimonial-author<?= !empty($testimonial['photo']) ? ' has-photo' : ''; ?>">
                            <?php if (!empty($testimonial['photo'])): ?>
                                <?= wp_get_attachment_image($testimonial['photo'], 'thumbnail', false, array('class' => 'front-page-testimonial-photo', 'alt' => '')); ?>
                            <?php endif; ?>

                            <div class="front-page-testimonial-author-content">
                                <?php if (!empty($testimonial['name'])): ?>
                                    <cite><?= esc_html($testimonial['name']); ?></cite>
                                <?php endif; ?>

                                <?php if (!empty($testimonial['position'])): ?>
                                    <p><?= esc_html($testimonial['position']); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($testimonial['logo'])): ?>
                                    <?= wp_get_attachment_image($testimonial['logo'], 'medium', false, array('class' => 'front-page-testimonial-logo')); ?>
                                <?php endif; ?>
                            </div>
                        </footer>
                    <?php endif; ?>
                </blockquote>
            <?php endforeach; ?>
        </div>
    </div>
</section>
