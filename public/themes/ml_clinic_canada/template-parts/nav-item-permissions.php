<?php

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
