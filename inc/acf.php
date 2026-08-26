<?php
/* ACF
--------------------------------------------------------------- */

// Keep the front-end available if the required ACF Pro plugin is disabled.
if (!function_exists('get_field')) {
    function get_field($selector, $post_id = false, $format_value = true)
    {
        return false;
    }
}

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
        'group_vox_realisation' => 'group_vox_realisation',
    );

    if (!empty($post['key']) && !empty($filenames[$post['key']])) {
        return $filenames[$post['key']] . '.json';
    }

    return $filename;
}
add_filter('acf/json/save_file_name', 'vox_name_acf_groups_json', 10, 3);

// Warn admins when the required ACF Pro plugin is missing.
function vox_display_acf_missing_notice()
{
    if ((defined('ACF_PRO') && ACF_PRO) || !current_user_can('activate_plugins')) {
        return;
    }

    echo '<div class="notice notice-error"><p><strong>' . esc_html__('Advanced Custom Fields Pro est requis par le thème VOX.', 'vox-aedificatoris') . '</strong> ' . esc_html__('Activez le plugin pour administrer et afficher les contenus personnalisés.', 'vox-aedificatoris') . '</p></div>';
}
add_action('admin_notices', 'vox_display_acf_missing_notice');
