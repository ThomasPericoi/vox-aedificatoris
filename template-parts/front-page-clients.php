<?php
$post_id = get_queried_object_id();
$clients_eyebrow = get_field('home_clients_eyebrow', $post_id);
$clients_title = get_field('home_clients_title', $post_id);
$clients = get_field('home_clients', $post_id);

if (!$clients) {
    return;
}
?>

<!-- Front Page Clients -->
<section id="front-page-clients" class="front-page-clients"<?= $clients_title ? ' aria-labelledby="front-page-clients-title"' : ''; ?>>
    <?php if ($clients_eyebrow || $clients_title) : ?>
        <header class="front-page-clients-header container">
            <?php if ($clients_eyebrow) : ?>
                <p class="eyebrow"><?= esc_html($clients_eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($clients_title) : ?>
                <h2 id="front-page-clients-title"><?= esc_html($clients_title); ?></h2>
            <?php endif; ?>
        </header>
    <?php endif; ?>

    <?php if ($clients) : ?>
        <div class="front-page-clients-slider swiper container container-lg">
            <div class="swiper-wrapper">
                <?php foreach ($clients as $client) :
                    if (empty($client['logo'])) {
                        continue;
                    }
                    ?>

                    <figure class="front-page-client swiper-slide">
                        <?= wp_get_attachment_image($client['logo'], 'medium', false, array('class' => 'front-page-client-logo')); ?>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
