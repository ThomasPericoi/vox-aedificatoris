<?php
/* INIT
--------------------------------------------------------------- */

// Set up the theme baseline: translations, supports, and menu locations.
function vox_setup_theme()
{
    load_theme_textdomain('vox-aedificatoris', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
    ));
    add_theme_support(
        'html5',
        array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
            'navigation-widgets',
        )
    );
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-font-sizes');

    register_nav_menus(
        array(
            'header-menu' => __('Header', 'vox-aedificatoris'),
            'menu-footer-1' => __('Footer #1', 'vox-aedificatoris'),
            'menu-footer-2' => __('Footer #2', 'vox-aedificatoris'),
        )
    );
}
add_action('after_setup_theme', 'vox_setup_theme');

// Remove WordPress emoji assets from the front-end and admin.
function vox_disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'vox_disable_emojis');

// Keep comments and pingbacks closed everywhere.
function vox_disable_comments_status()
{
    return false;
}
add_filter('comments_open', 'vox_disable_comments_status', 20, 2);
add_filter('pings_open', 'vox_disable_comments_status', 20, 2);

// Hide existing comments from public queries.
function vox_disable_comments_hide_existing_comments($comments)
{
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'vox_disable_comments_hide_existing_comments', 10, 2);

// Remove the comments screen from the admin menu.
function vox_disable_comments_admin_menu()
{
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'vox_disable_comments_admin_menu');

// Redirect users away from the comments admin screen.
function vox_disable_comments_admin_menu_redirect()
{
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'vox_disable_comments_admin_menu_redirect');

// Remove the comments dashboard widget.
function vox_disable_comments_dashboard()
{
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'vox_disable_comments_dashboard');

// Remove the comments shortcut from the admin bar.
function vox_disable_comments_icon_admin_bar()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'vox_disable_comments_icon_admin_bar');

// Remove comment and trackback support from every post type.
function vox_disable_comments_post_types_support()
{
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'vox_disable_comments_post_types_support');

// Hide the WordPress version generator tag.
function vox_remove_wordpress_version()
{
    return '';
}
add_filter('the_generator', 'vox_remove_wordpress_version');

// Replace detailed login errors with a generic message.
function vox_hide_wordpress_errors()
{
    return __('Une erreur est survenue !', 'vox-aedificatoris');
}
add_filter('login_errors', 'vox_hide_wordpress_errors');

// Disable xmlrpc.php
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// Use the newest CSS file timestamp as the main stylesheet version.
function vox_get_stylesheet_version()
{
    static $version = null;

    if ($version !== null) {
        return $version;
    }

    $version = filemtime(get_stylesheet_directory() . '/style.css');
    $css_directory = new RecursiveDirectoryIterator(get_stylesheet_directory() . '/assets/css', FilesystemIterator::SKIP_DOTS);
    $css_files = new RecursiveIteratorIterator($css_directory);

    foreach ($css_files as $css_file) {
        if ($css_file->getExtension() === 'css') {
            $version = max($version, $css_file->getMTime());
        }
    }

    return $version;
}

// Version individual assets from their file timestamp.
function vox_get_asset_version($relative_path)
{
    $path = get_stylesheet_directory() . '/' . ltrim($relative_path, '/');

    if (file_exists($path)) {
        return filemtime($path);
    }

    return vox_get_stylesheet_version();
}

// Print Google Fonts early so typography starts loading as soon as possible.
function vox_enqueue_google_fonts()
{
    // Preconnect Google Fonts domains
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

    // Load Google Fonts
    echo '<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">' . "\n";
}
add_action('wp_head', 'vox_enqueue_google_fonts', 0);

// Add initial document state classes before the CSS is fully applied.
function vox_print_document_state_script()
{
    ?>
    <script>
        document.documentElement.classList.add('js-enabled');
    </script>
    <?php
}
add_action('wp_head', 'vox_print_document_state_script', 1);

// Register and enqueue theme styles only when they are needed.
function vox_enqueue_theme_stylesheets()
{
    wp_register_style('reset', get_template_directory_uri() . '/assets/css/inc/reset.css', array(), null, 'all');
    wp_register_style('wp-core', get_template_directory_uri() . '/assets/css/inc/wp-core.css', array(), null, 'all');
    wp_register_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css', array(), null, 'all');
    wp_register_style('style', get_stylesheet_uri(), array('reset', 'wp-core'), vox_get_stylesheet_version(), 'all');
    wp_enqueue_style('reset');
    wp_enqueue_style('wp-core');
    if (is_front_page()) {
        wp_enqueue_style('swiper');
    }
    wp_enqueue_style('style');
}
add_action('wp_enqueue_scripts', 'vox_enqueue_theme_stylesheets');

// Register and enqueue theme scripts only when they are needed.
function vox_enqueue_theme_scripts()
{
    wp_register_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array(), null, true);
    wp_register_script('ascii-printer', get_template_directory_uri() . '/assets/js/ascii-printer.min.js', array(), vox_get_asset_version('assets/js/ascii-printer.min.js'), true);
    wp_register_script('script', get_template_directory_uri() . '/assets/js/main.js', array(), vox_get_asset_version('assets/js/main.js'), true);
    if (is_front_page()) {
        wp_enqueue_script('swiper');
    }
    wp_enqueue_script('ascii-printer');
    wp_enqueue_script('script');
}
add_action('wp_enqueue_scripts', 'vox_enqueue_theme_scripts');
