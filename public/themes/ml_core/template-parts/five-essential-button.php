<?php
global $fiveEssentialButton;
$fiveEssentialButton = '<a class="button" href="'.get_home_url().'/locations" title="Find a clinic near you">Find a Clinic</a>';
if (get_current_blog_id() != 1) {
    $fiveEssentialButton = '<a class="button" href="' . get_home_url(get_current_blog_id()) . '/sign-up" title="Request an Appointment">Request an Appointment</a>';
}
