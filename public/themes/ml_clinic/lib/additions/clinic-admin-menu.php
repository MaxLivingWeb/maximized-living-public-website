<?php

function clinic_dashboard_menu()
{
    remove_menu_page('index.php'); // remove default dashboard
    add_menu_page(
        "Dashboard",
        "Dashboard",
        "clinic_admin",
        "clinic-dashboard",
        "clinic_dashboard",
        "dashicons-performance",
        "10"
    );
    function clinic_dashboard()
    {
        get_template_part('template-parts/clinic-admin-dashboard');
    }
}

function clinic_admin_profile_menu()
{
    remove_menu_page('profile.php');
    add_menu_page(
        "Profile",
        "Profile",
        "clinic_admin",
        "profile.php",
        "",
        "dashicons-admin-users",
        "40"
    );

}

function clinic_login_redirect()
{
    return admin_url('admin.php?page=clinic-dashboard');
}

add_filter('login_redirect', 'clinic_login_redirect', 10, 3);
add_action('admin_menu', 'clinic_dashboard_menu');
add_action('admin_menu', 'clinic_admin_profile_menu');

