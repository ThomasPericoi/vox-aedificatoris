<?php
/* ACF
--------------------------------------------------------------- */

// Save ACF local JSON inside the theme.
function vox_save_acf_groups_json($path)
{
    return get_stylesheet_directory() . '/inc/acf-json';
}
add_filter('acf/settings/save_json', 'vox_save_acf_groups_json');

// Load ACF local JSON from the theme.
function vox_load_acf_groups_json($paths)
{
    $paths[] = get_stylesheet_directory() . '/inc/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'vox_load_acf_groups_json');

// Keep exported ACF JSON filenames readable and stable.
function vox_name_acf_groups_json($filename, $post, $load_path)
{
    $filenames = array(
        'group_page_front_page' => 'group_page_front_page',
        'group_theme_options_footer' => 'group_theme_options_footer',
    );

    if (!empty($post['key']) && !empty($filenames[$post['key']])) {
        return $filenames[$post['key']] . '.json';
    }

    return $filename;
}
add_filter('acf/json/save_file_name', 'vox_name_acf_groups_json', 10, 3);

// Warn admins when the required ACF plugin is missing.
function vox_display_acf_missing_notice()
{
    if (class_exists('ACF') || !current_user_can('activate_plugins')) {
        return;
    }

    echo '<div class="notice notice-warning"><p>' . esc_html__('Advanced Custom Fields Pro est recommandé pour administrer les contenus personnalisés de ce thème.', 'vox-aedificatoris') . '</p></div>';
}
add_action('admin_notices', 'vox_display_acf_missing_notice');
