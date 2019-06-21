<?php
global $affiliate_id;
?>
<nav>
    <ul>
        <li><a href="<?php echo home_url(); ?>" title="Home">Home</a></li>
        <li><a href="<?php echo home_url().'/sign-up'; ?>" title="Request an Appointment">Request an Appointment</a></li>
        <!-- <li><a href="<?php echo get_home_url(1).'/store?affiliateId='. $affiliate_id . utmURL('child'); ?>" rel="nofollow" title="Shop">Shop</a></li> -->
        <li><a href="https://store.maxliving.com/?srrf=<?php the_field('affiliate_id', 'clinic_options'); ?>" rel="nofollow" title="Store">Store</a></li>
        <li><a href="<?php echo home_url('/sitemap'); ?>" title="Sitemap">Sitemap</a></li>
        <li><a href="<?php echo home_url('/#contact'); ?>" title="Contact Us">Contact Us</a></li>
    </ul>
</nav>
