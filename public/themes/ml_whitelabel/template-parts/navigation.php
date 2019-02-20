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

if ( ! isset( $_SESSION['clinicHasDoctors'] ) ) {
    $_SESSION['clinicHasDoctors'] = false;
    if (have_rows('doctors', 'clinic_about_options')) {
        $_SESSION['clinicHasDoctors'] = true;
    }
}
?>
<!-- #site-navigation -->
<nav id="site-navigation" class="navBar headerNavBar fixed">
    <div class="navContainer">
        <nav class="navLinks-primary">
            <ul class="navLinks">
                <li class="appointment">
                    <a class="navLinkWithIcon" href="<?php echo get_home_url() . '/sign-up'; ?>"
                       title="Make An Appointment">
                        <span class="icon-outlinedPin"></span>
                        <span class="navLinkText">Make An Appointment</span>
                    </a>
                </li>
                <li>
                    <a class="navLink" href="<?php echo get_home_url() ?>" title="Home">Home</a>
                </li>
	            <?php if ($_SESSION['clinicHasDoctors'] || is_user_logged_in()): ?>
                <li>
                    <a class="navLink" href="<?php echo get_home_url() . '/our-team'; ?>"
                       title="Our Team">Team</a>
                </li>
                <?php endif;
                if ($_SESSION['clinicHasPosts'] || is_user_logged_in()): ?>
                    <li>
                        <a class="navLink" href="<?php echo get_home_url() . '/doctors-blog'; ?>"
                           title="Blog">Blog</a>
                    </li>
                <?php endif; ?>
                <li>
                    <a class="navLink" href="<?php echo get_home_url() . '/patient-paperwork'; ?>"
                       title="Patient Paperwork">Patient Paperwork</a>
                </li>
            </ul>
        </nav>
        <nav class="navLinks-secondary">
            <ul class="navLinks">
                <a class="button button-tertiary" href="<?php echo home_url() . '/sign-up'; ?>"
                   title="Request Appointment At <?php echo get_bloginfo('name'); ?>">Request
                    Appointment</a>
                <li class="mobileMenuButtonContainer">
                    <button class="mobileMenuButton" title="Menu">
                        <span class="line-1"></span>
                        <span class="line-2"></span>
                        <span class="line-3"></span>
                        <span class="invisible">Menu</span>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
</nav>
