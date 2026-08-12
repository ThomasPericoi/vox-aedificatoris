<?php
/* POST TYPE(S)
--------------------------------------------------------------- */

// Register custom post types from the post-types directory.
function vox_register_custom_post_types()
{
    $post_types = ['realisation'];

    foreach ($post_types as $post_type) {
        $post_type_file = __DIR__ . '/post-types/' . $post_type . '.php';

        if (file_exists($post_type_file)) {
            include_once $post_type_file;
        }
    }
}
add_action('init', 'vox_register_custom_post_types');

// Flush rewrite rules once when the theme is activated.
function vox_flush_theme_rewrite_rules()
{
    vox_register_custom_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'vox_flush_theme_rewrite_rules');
