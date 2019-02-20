<?php

function dashboard_menu()
{
    add_menu_page(
        "Dashboard",
        "Dashboard",
        "editor",
        "admin-dashboard",
        "dashboard",
        "dashicons-performance",
        "1"
    );
    function dashboard()
    {
        get_template_part('template-parts/admin-dashboard');
    }
}
add_action('admin_menu', 'dashboard_menu');

//Admin Menu Item Order
add_filter('custom_menu_order', '__return_true');
add_filter('menu_order', 'custom_menu_order');
function custom_menu_order($menu_ord) {
    return array(
        'admin-dashboard',
        'edit.php?post_type=recipe',
        'edit.php?post_type=event',
        'edit.php?post_type=article',
        'edit.php?post_type=press',
        'location-details',
        'edit.php?post_type=page',
        'home-page-options',
        'contact-page-options',
        'edit.php?post_type=essential',
        'footer-options',
        'clinic-site-options',
        'upload.php',
        'themes.php',
        'options-general.php',
        'users.php',
        'tools.php',
    );
}
