<?php

if ( ! isset( $_SESSION['clinicHasPosts'] ) ) {
    $child_site_id = get_current_blog_id();
    switch_to_blog( 1 );
    $posts                      = get_posts( array(
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'post_type'      => array( 'article', 'recipe' ),
        'meta_key'       => 'siteOriginID',
        'meta_value'     => $child_site_id
    ) );
    $_SESSION['clinicHasPosts'] = false;
    if ( $posts ) {
        $_SESSION['clinicHasPosts'] = true;
    }
    restore_current_blog();
}

if ( ! isset( $_SESSION['clinicHasEvents'] ) ) {
    $events                      = get_posts( array(
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'post_type'      => 'event',
    ) );
    $_SESSION['clinicHasEvents'] = false;
    if ( $events ) {
        $_SESSION['clinicHasEvents'] = true;
    }
}

if ( ! isset( $_SESSION['clinicHasDoctors'] ) ) {
    $_SESSION['clinicHasDoctors'] = false;
    if (have_rows('doctors', 'clinic_about_options')) {
        $_SESSION['clinicHasDoctors'] = true;
    }
}
