<?php
/* ADMIN
--------------------------------------------------------------- */

// Add the global theme options page for ACF fields.
add_action('acf/init', function () {
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page(array(
        'page_title'      => __('Options du thème', 'vox-aedificatoris'),
        'menu_title'      => __('Options du thème', 'vox-aedificatoris'),
        'menu_slug'       => 'theme-general-settings',
        'capability'      => 'edit_pages',
        'redirect'        => false,
        'position'        => 2,
        'icon_url'        => 'dashicons-admin-settings',
        'update_button'   => __('Mettre à jour', 'vox-aedificatoris'),
        'updated_message' => __('Tout est en ordre', 'vox-aedificatoris'),
    ));
});
