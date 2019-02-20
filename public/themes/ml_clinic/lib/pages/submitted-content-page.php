<?php

add_action( 'admin_menu', 'register_my_custom_submenu_page' );

function register_my_custom_submenu_page() {
    add_submenu_page(
        null,
        'Content Submitted',
        'Content Submitted',
        'clinic_admin',
        'content-submitted',
        'submitted_page_content'
    );
}

function submitted_page_content() {
    get_template_part('template-parts/submitted-page');
}
