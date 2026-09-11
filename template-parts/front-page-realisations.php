<?php
$post_id = get_queried_object_id();
$realisations_eyebrow = get_field('home_realisations_eyebrow', $post_id);
$realisations_title = get_field('home_realisations_title', $post_id);
$realisations_page = isset($_GET['realisations-page']) ? max(1, absint($_GET['realisations-page'])) : 1;
$realisations_category = isset($_GET['realisation-category']) ? sanitize_title(wp_unslash($_GET['realisation-category'])) : '';
$realisations_per_page = wp_is_mobile() ? 4 : 8;

if ($realisations_category && !term_exists($realisations_category, 'realisation_category')) {
    $realisations_category = '';
}

$realisations_args = [
    'post_type' => 'realisation',
    'post_status' => 'publish',
    'posts_per_page' => $realisations_per_page,
    'paged' => $realisations_page,
    'orderby' => [
        'menu_order' => 'ASC',
        'date' => 'DESC',
    ],
];

if ($realisations_category) {
    $realisations_args['tax_query'] = [
        [
            'taxonomy' => 'realisation_category',
            'field' => 'slug',
            'terms' => $realisations_category,
        ]
    ];
}

$realisations_query = new WP_Query($realisations_args);

if (!$realisations_query->have_posts() && $realisations_page > 1) {
    $realisations_page = 1;
    $realisations_args['paged'] = $realisations_page;
    $realisations_query = new WP_Query($realisations_args);
}

if (!$realisations_query->have_posts()) {
    return;
}

$realisations_categories = get_terms([
    'taxonomy' => 'realisation_category',
    'hide_empty' => true,
]);
?>

<!-- Front Page Realisations -->
<section id="front-page-realisations" class="front-page-realisations" <?= $realisations_title ? ' aria-labelledby="front-page-realisations-title"' : ''; ?>>
    <?php if ($realisations_eyebrow || $realisations_title): ?>
        <header class="front-page-realisations-header container">
            <?php if ($realisations_eyebrow): ?>
                <p class="eyebrow"><?= esc_html($realisations_eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($realisations_title): ?>
                <h2 id="front-page-realisations-title"><?= esc_html($realisations_title); ?></h2>
            <?php endif; ?>
        </header>
    <?php endif; ?>

    <?php if (!is_wp_error($realisations_categories) && $realisations_categories): ?>
        <nav class="front-page-realisations-filters container"
            aria-label="<?= esc_attr__('Filtrer les réalisations', 'vox-aedificatoris'); ?>">
            <a href="<?= esc_url(remove_query_arg(['realisation-category', 'realisations-page']) . '#front-page-realisations'); ?>"
                <?= !$realisations_category ? ' aria-current="true"' : ''; ?>>
                <?= esc_html__('Tout', 'vox-aedificatoris'); ?>
            </a>

            <?php foreach ($realisations_categories as $category):
                $category_url = add_query_arg('realisation-category', $category->slug, remove_query_arg(['realisation-category', 'realisations-page']));
                ?>
                <a href="<?= esc_url($category_url . '#front-page-realisations'); ?>"
                    <?= $realisations_category === $category->slug ? ' aria-current="true"' : ''; ?>>
                    <?= esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>

    <div class="front-page-realisations-grid container">
        <?php while ($realisations_query->have_posts()):
            $realisations_query->the_post(); ?>
            <?php get_template_part('template-parts/item', 'realisation'); ?>
        <?php endwhile; ?>
    </div>

    <?php if ($realisations_query->max_num_pages > 1):
        $pagination_base = add_query_arg('realisations-page', 999999999, remove_query_arg('realisations-page'));
        $pagination_base = str_replace('999999999', '%#%', esc_url($pagination_base));
        $previous_page_url = $realisations_page > 1
            ? add_query_arg('realisations-page', $realisations_page - 1, remove_query_arg('realisations-page')) . '#front-page-realisations'
            : '';
        $next_page_url = $realisations_page < $realisations_query->max_num_pages
            ? add_query_arg('realisations-page', $realisations_page + 1, remove_query_arg('realisations-page')) . '#front-page-realisations'
            : '';
        $pagination_links = paginate_links([
            'base' => $pagination_base . '#front-page-realisations',
            'format' => '',
            'current' => $realisations_page,
            'total' => $realisations_query->max_num_pages,
            'type' => 'array',
            'prev_next' => false,
        ]);
        ?>
        <?php if ($pagination_links): ?>
            <nav class="front-page-realisations-pagination"
                aria-label="<?= esc_attr__('Pagination des réalisations', 'vox-aedificatoris'); ?>">
                <?php if ($previous_page_url): ?>
                    <a class="prev page-numbers" href="<?= esc_url($previous_page_url); ?>">
                        <span class="screen-reader-text"><?= esc_html__('Page précédente', 'vox-aedificatoris'); ?></span>
                    </a>
                <?php endif; ?>

                <?php foreach ($pagination_links as $pagination_link): ?>
                    <?= wp_kses_post($pagination_link); ?>
                <?php endforeach; ?>

                <?php if ($next_page_url): ?>
                    <a class="next page-numbers" href="<?= esc_url($next_page_url); ?>">
                        <span class="screen-reader-text"><?= esc_html__('Page suivante', 'vox-aedificatoris'); ?></span>
                    </a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</section>

<?php wp_reset_postdata(); ?>
