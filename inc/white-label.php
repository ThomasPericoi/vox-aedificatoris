<?php
/* WHITE LABEL
--------------------------------------------------------------- */

// Replace the WordPress login logo with the project logo.
function vox_change_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-color: #111212;
            background-image: url(<?= esc_url(get_template_directory_uri() . '/assets/medias/images/VOX_white.png'); ?>);
            background-position: center;
            background-repeat: no-repeat;
            background-size: 259px 50px;
            border-radius: 4px;
            box-sizing: border-box;
            height: 100px;
            padding: 25px;
            width: 320px;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'vox_change_login_logo');

// Replace the login logo link and title with the site information.
function vox_change_login_logo_url()
{
    return home_url('/');
}
add_filter('login_headerurl', 'vox_change_login_logo_url');

function vox_change_login_logo_title()
{
    return get_bloginfo('name');
}
add_filter('login_headertext', 'vox_change_login_logo_title');

// Replace the admin bar WordPress icon with the project favicon.
function vox_change_admin_bar_logo()
{
    $favicon_url = esc_url(get_template_directory_uri() . '/assets/medias/images/VOX_mini_black.svg');
    echo '
    <style type="text/css">
        #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
            background-image: url(' . $favicon_url . ') !important;
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            color: rgba(0, 0, 0, 0);
            filter: invert(1);
        }
        #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
            background-position: center;
        }
    </style>
    ';
}
add_action('wp_before_admin_bar_render', 'vox_change_admin_bar_logo');

// Add custom credits to the admin footer.
function vox_change_admin_footer_text()
{
    echo wp_kses_post(__('Propulsé par <a href="https://wordpress.org" target="_blank" rel="noopener noreferrer">WordPress</a> | Thème créé par <a href="https://thomaspericoi.com/" target="_blank" rel="noopener noreferrer">Thomas Pericoi</a>', 'vox-aedificatoris'));
}
add_filter('admin_footer_text', 'vox_change_admin_footer_text');

// Print the dashboard credits widget content.
function vox_custom_dashboard_help()
{
    echo wp_kses_post(__('Ce thème a été créé par <a href="https://thomaspericoi.com/" target="_blank" rel="noopener noreferrer">Thomas Pericoi</a>.', 'vox-aedificatoris'));
}

// Register custom dashboard widgets.
function vox_add_admin_widgets()
{
    wp_add_dashboard_widget('custom_help_widget', __('Crédits', 'vox-aedificatoris'), 'vox_custom_dashboard_help');
}
add_action('wp_dashboard_setup', 'vox_add_admin_widgets');
