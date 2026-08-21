<?php
$post_id = get_queried_object_id();
$contact_eyebrow = get_field('home_contact_eyebrow', $post_id);
$contact_title = get_field('home_contact_title', $post_id);
$contact_text = get_field('home_contact_text', $post_id);
$contact_form_id = get_field('home_contact_form', $post_id);

if (!$contact_form_id || !shortcode_exists('contact-form-7')) {
    return;
}
?>

<!-- Front Page Contact -->
<section id="front-page-contact" class="front-page-contact"<?= $contact_title ? ' aria-labelledby="front-page-contact-title"' : ''; ?>>
    <div class="front-page-contact-inner container container-lg">
        <?php if ($contact_eyebrow || $contact_title || $contact_text): ?>
            <header class="front-page-contact-header">
                <?php if ($contact_eyebrow): ?>
                    <p class="eyebrow"><?= esc_html($contact_eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($contact_title): ?>
                    <h2 id="front-page-contact-title"><?= esc_html($contact_title); ?></h2>
                <?php endif; ?>

                <?php if ($contact_text): ?>
                    <div class="front-page-contact-text formatted">
                        <?= wp_kses_post($contact_text); ?>
                    </div>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <div class="front-page-contact-form">
            <?= do_shortcode('[contact-form-7 id="' . absint($contact_form_id) . '"]'); ?>
        </div>
    </div>
</section>
