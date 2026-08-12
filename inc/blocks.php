<?php
/* BLOCKS
--------------------------------------------------------------- */

// Register every ACF block declared in the local blocks directory.
function vox_register_acf_blocks()
{
    $blocks = [];

    foreach ($blocks as $block) {
        $block_directory = __DIR__ . '/blocks/' . $block;

        if (file_exists($block_directory . '/block.json')) {
            register_block_type($block_directory);
        }
    }
}
add_action('init', 'vox_register_acf_blocks');

// Add the theme block category to the editor inserter.
function vox_register_block_category($categories, $post)
{
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'vox-block',
                'title' => __('VOX', 'vox-aedificatoris'),
            ),
        )
    );
}
add_filter('block_categories_all', 'vox_register_block_category', 10, 2);
