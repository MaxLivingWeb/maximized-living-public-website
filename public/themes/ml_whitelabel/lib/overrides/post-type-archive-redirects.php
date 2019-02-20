<?php

if (!is_admin()) {
    add_action('pre_get_posts','archive_redirect');
}

function archive_redirect() {
    if (is_post_type_archive('recipe') || is_post_type_archive('article')) {
        wp_redirect(get_home_url().'/doctors-blog');
    }
}
