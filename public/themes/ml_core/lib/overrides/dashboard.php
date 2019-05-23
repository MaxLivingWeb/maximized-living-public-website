<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-09
 */
global $blog_id;

function remove_menu_entries()
{
    // with WP 3.1 and higher
    if (function_exists('remove_menu_page')) {
        remove_menu_page('edit-comments.php');
        remove_menu_page('edit.php');
        remove_menu_page('index.php'); // remove default dashboard
        if (get_current_user_id() != 439) {// Disable Tools page if user is not Arcane Admin
            remove_menu_page('tools.php');
        }
    }

    if (!current_user_can('manage_network')) {
        remove_menu_page('wpseo_dashboard'); // Yoast
        remove_action('admin_bar_menu', 'wpseo_admin_bar_menu', 95);
        remove_menu_page('upload.php'); // Media
        remove_menu_page('themes.php');                 //Appearance
        remove_menu_page('tools.php');                  //Tools
        remove_menu_page('plugins.php');                //Plugin
        hide_menu_acf();
        acf_route_redirect();
    }
    remove_filter('update_footer', 'core_update_footer'); // Remove footer WordPress version
}

add_action('admin_menu', 'remove_menu_entries');//remove options from admin menu

function yoast_remove_meta()
{
    add_action('add_meta_boxes', 'disable_seo_metabox', 100000);
    add_filter('manage_edit-post_columns', 'yoast_remove_columns');
    add_filter('manage_edit-recipe_columns', 'yoast_remove_columns');
    add_filter('manage_edit-article_columns', 'yoast_remove_columns');
    add_filter('manage_edit-event_columns', 'yoast_remove_columns');
}

if (!current_user_can('manage_network')) {
    // Disable WordPress SEO meta box for all roles other than administrator
    add_action('init', 'yoast_remove_meta');
}

function disable_seo_metabox()
{
    remove_meta_box('wpseo_meta', 'post', 'normal');
    remove_meta_box('wpseo_meta', 'page', 'normal');
    remove_meta_box('wpseo_meta', 'recipe', 'normal');
    remove_meta_box('wpseo_meta', 'article', 'normal');
    remove_meta_box('wpseo_meta', 'event', 'normal');
}

function yoast_remove_columns($columns)
{
    // remove the Yoast SEO columns
    unset($columns['wpseo-score']);
    unset($columns['wpseo-title']);
    unset($columns['wpseo-metadesc']);
    unset($columns['wpseo-focuskw']);
    unset($columns['wpseo-links']);
    return $columns;
}

// Move Yoast to bottom
function yoasttobottom()
{
    return 'low';
}

add_filter('wpseo_metabox_prio', 'yoasttobottom');

/**
 * Adding redirects for various admin pages
 */
function this_screen()
{
    global $blog_id;
    global $current_screen;
    $redirect = "admin.php?page=clinic-dashboard";
    if ($blog_id == 1) {
        $redirect = "admin.php?page=admin-dashboard";
    }
    $current_screen = get_current_screen();
    if ($current_screen->id === "dashboard") {
        wp_redirect(admin_url($redirect));
        exit;
    }
    if ($current_screen->id === "edit-comments") {
        wp_redirect(admin_url($redirect));
        exit;

    }
    if ($current_screen->id === "post") {
        wp_redirect(admin_url($redirect));
        exit;
    }
    if ($current_screen->id === "site-new-network") {
        wp_redirect(network_admin_url('admin.php?page=location-create-site'));
        exit;
    }
}

add_action('current_screen', 'this_screen');

function login_redirect()
{
    global $blog_id;
    $redirect = "admin.php?page=clinic-dashboard";
    if ($blog_id == 1) {
        $redirect = "admin.php?page=admin-dashboard";
    }
    return admin_url($redirect);
}

add_filter('login_redirect', 'login_redirect', 10, 3);


/**
 * Remove My Sites Sub-Menu Options: New Post and Manage Comments
 */
function remove_mysites_links()
{
    global $wp_admin_bar;
    foreach ((array)$wp_admin_bar->user->blogs as $blog) {
        $menu_id_n = 'blog-' . $blog->userblog_id . '-n'; /* New Post var */
        $menu_id_c = 'blog-' . $blog->userblog_id . '-c'; /* Manage Comments var */
        $wp_admin_bar->remove_menu($menu_id_n); /*Remove New Post Link */
        $wp_admin_bar->remove_menu($menu_id_c); /*Remove Manage Comments Link */
    }
}

add_action('wp_before_admin_bar_render', 'remove_mysites_links');

/**
 * Hide Admin Bar items
 */
function admin_bar_items($wp_admin_bar)
{
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('customize');
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('updates');
    $wp_admin_bar->remove_menu('wpseo-menu');
    if (current_user_can('clinic_admin')) {
        $wp_admin_bar->add_menu(array(
            'id' => 'return-to-admin-portal',
            'title' => 'Return to Admin Portal',
            'href' => 'https://portal.maxliving.com/'
        ));
    }

    if (current_user_can('manage_network') && get_current_user_id() == 1) {
        $wp_admin_bar->add_menu(array(
            'id' => 'admin-bar-location-site-management',
            'title' => 'Location Management',
            'href' => get_admin_url() . 'network/admin.php?page=location-create-site'
        ));
        if (get_current_blog_id() == 1) {
            $wp_admin_bar->add_menu(array(
                'id' => 'admin-bar-location-site-management-create-site',
                'parent' => 'admin-bar-location-site-management',
                'title' => 'Create Site',
                'href' => get_admin_url() . 'network/admin.php?page=location-details-landing'
            ));
            $wp_admin_bar->add_menu(array(
                'id' => 'admin-bar-location-site-management-create-location',
                'parent' => 'admin-bar-location-site-management',
                'title' => 'Create Location',
                'href' => get_admin_url() . 'network/admin.php?page=network-location-form&action=create_location&form_submission=Create+Location'
            ));
        }
        if (get_current_blog_id() == 1) {
            $wp_admin_bar->add_menu(array(
                'id' => 'admin-bar-location-site-management-update-location',
                'parent' => 'admin-bar-location-site-management',
                'title' => 'Update Locations',
                'href' => get_admin_url() . 'network/admin.php?page=network-view-location&purpose=update'
            ));
            $wp_admin_bar->add_menu(array(
                'id' => 'admin-bar-location-site-management-update-site',
                'parent' => 'admin-bar-location-site-management',
                'title' => 'Update Sites',
                'href' => get_admin_url() . 'network/sites.php'
            ));
        }
        else {
            $wp_admin_bar->add_menu(array(
                'id' => 'admin-bar-location-site-management-update-site',
                'parent' => 'admin-bar-location-site-management',
                'title' => 'Update Site',
                'href' => get_admin_url(1) . 'network/site-info.php?id='.get_current_blog_id()
            ));
        }
    }

    if (current_user_can('manage_network') && get_current_user_id() == 1) {
        $theme = get_option('stylesheet');
        $wp_admin_bar->add_menu(array(
            'id' => 'arcane-debug-bar',
            'title' => 'Debug Tools'
        ));
        $wp_admin_bar->add_menu(array(
            'id' => 'current-site-id-admin-bar',
            'parent' => 'arcane-debug-bar',
            'title' => 'Site ID: ' . get_current_blog_id()
        ));
        $args = array('blog_id' => get_current_blog_id());
        $users = count(get_users($args));
        $wp_admin_bar->add_menu(array(
            'id' => 'users-admin-bar',
            'parent' => 'arcane-debug-bar',
            'title' => 'Site Users: ' . $users,
            'href' => get_admin_url() . 'users.php'

        ));

        $wp_admin_bar->add_menu(array(
            'id' => 'current-site-theme-admin-bar',
            'parent' => 'arcane-debug-bar',
            'title' => 'Theme: ' . $theme,
            'href' => get_admin_url() . 'themes.php'
        ));
	    $wp_admin_bar->add_menu(array(
		    'id' => 'wp-version-admin-bar',
		    'parent' => 'arcane-debug-bar',
		    'title' => 'WordPress '.get_bloginfo('version')
	    ));
    }

    if (current_user_can('manage_network') && get_current_blog_id() != 1) {
        $wp_admin_bar->add_menu(array(
            'id' => 'edit-current-site-location-admin-bar',
            'title' => 'Edit Location',
            'href' => get_admin_url() . 'admin.php?page=location-details'
        ));
    }
}

add_action('admin_bar_menu', 'admin_bar_items', 999);

function remove_footer_admin()
{
    echo null;
}

remove_action('welcome_panel', 'wp_welcome_panel');

add_filter('admin_footer_text', 'remove_footer_admin');

function wp_debranding_remove_wp_logo()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('wp-logo');
    $wp_admin_bar->remove_node('search');
}

add_action('wp_before_admin_bar_render', 'wp_debranding_remove_wp_logo');

function replace_howdy($wp_admin_bar)
{
    $my_account = $wp_admin_bar->get_node('my-account');
    $newtitle = str_replace('Howdy,', '', $my_account->title);
    $wp_admin_bar->add_node(array(
            'id' => 'my-account',
            'title' => $newtitle,
        )
    );
}

add_filter('admin_bar_menu', 'replace_howdy', 25);

function remove_dashboard_widgets()
{
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //Quick Press widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); //Recent Drafts
    remove_meta_box('dashboard_primary', 'dashboard', 'side'); //WordPress.com Blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'side'); //Other WordPress News
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); //Incoming Links
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); //Plugins
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Right Now
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); //Recent Comments
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //Activity
    remove_action('welcome_panel', 'wp_welcome_panel');
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

// Remove the ACF main item from the admin menu.
function hide_menu_acf()
{
    add_filter('acf/settings/show_admin', '__return_false');
}

// If the user tries to access an ACF page directly, redirect them to the Dashboard.
function acf_route_redirect()
{
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'acf-field-group') {
        wp_redirect(admin_url());
        exit;
    }
}

switch (WPENV) {
    case 'local':
    case 'development':
    case 'dev':
    case 'production':
        break;
    default:
        hide_menu_acf();
        acf_route_redirect();
        break;
}
