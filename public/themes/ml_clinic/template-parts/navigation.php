<?php
global $affiliate_id;
get_template_part('template-parts/nav-item-permissions');
?>
<!-- #site-navigation -->
<nav id="site-navigation" class="navBar headerNavBar fixed">
    <div class="navContainer">
        <a class="logo navLogo" href="<?php echo get_home_url(); ?>" title="Maximized Living">
            <img src="<?php echo get_template_directory_uri(); ?>/images/ML-extended-logo.svg"
                 alt="Maximized Living"/>
        </a>
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
                    <a class="navLink" href="#" title="About Us">About Us</a>
                    <div class="navDropdown">
                        <ul>
	                        <?php if ($_SESSION['clinicHasDoctors'] || is_user_logged_in()): ?>
                            <li><a href="<?php echo get_home_url() . '/our-team'; ?>" title="Our Team">Our
                                    Team</a>
                            </li>
                            <?php
                            endif;
                            if ($_SESSION['clinicHasEvents'] || is_user_logged_in()): ?>
                            <li><a href="<?php echo get_home_url() . '/events'; ?>" title="Our Events">Our
                                    Events</a>
                            </li>
                            <?php endif; ?>
                            <li><a href="<?php echo get_home_url() . '/power-of-chiropractic'; ?>"
                                   title="Power of Chiropractic">Power of Chiropractic</a></li>
                            <li><a href="<?php echo get_home_url() . '/success-stories'; ?>"
                                   title="Patient Success Stories">Patient Success Stories</a></li>
                            <li><a href="<?php echo get_home_url() . '/#contact'; ?>"
                                   title="Contact Us">Contact Us</a></li>
                        </ul>
                        <div class="navDropdownShadow"></div>
                    </div>
                    <button class="navDropdownToggle" title="Toggle Submenu"><span
                                class="invisible">Toggle Submenu</span></button>
                </li>
                <li>
                    <a class="navLink" href="#" title="Our Approach">Our Approach</a>
                    <div class="navDropdown">
                        <ul>
                            <li><a href="<?php echo get_home_url() . '/five-essentials'; ?>"
                                   title="5 Essentials">5 Essentials<sup>&trade;</sup></a></li>
                            <li>
                                <a href="<?php echo get_home_url() . '/five-essentials/core-chiropractic'; ?>"
                                   title="Core Chiropractic">Core Chiropractic</a></li>
                            <li><a href="<?php echo get_home_url() . '/five-essentials/nutrition'; ?>"
                                   title="Nutrition">Nutrition</a></li>
                            <li><a href="<?php echo get_home_url() . '/five-essentials/mindset'; ?>"
                                   title="Mindset">Mindset</a>
                            </li>
                            <li>
                                <a href="<?php echo get_home_url() . '/five-essentials/oxygen-and-exercise'; ?>"
                                   title="Oxygen &amp; Exercise">Oxygen &amp; Exercise</a></li>
                            <li><a href="<?php echo get_home_url() . '/five-essentials/minimize-toxins'; ?>"
                                   title="Minimize Toxins">Minimize Toxins</a></li>
                        </ul>
                        <div class="navDropdownShadow"></div>
                    </div>
                    <button class="navDropdownToggle" title="Toggle Submenu"><span
                                class="invisible">Toggle Submenu</span></button>
                </li>
                <li>
                    <a class="navLink" href="#" title="Articles and Recipes">Articles &amp; Recipes</a>
                    <div class="navDropdown">
                        <ul>
                            <li><a href="<?php echo get_home_url() . '/healthy-articles'; ?>"
                                   title="Healthy Articles">Healthy Articles</a></li>
                            <li><a href="<?php echo get_home_url() . '/healthy-recipes'; ?>"
                                   title="Healthy Recipes">Healthy
                                    Recipes</a></li>
                            <?php if ($_SESSION['clinicHasPosts'] || is_user_logged_in()): ?>
                                <li><a href="<?php echo get_home_url() . '/doctors-blog'; ?>"
                                       title="Doctor's Blog">Doctor's
                                        Blog</a></li>
                            <?php endif; ?>
                        </ul>
                        <div class="navDropdownShadow"></div>
                    </div>
                    <button class="navDropdownToggle" title="Toggle Submenu"><span
                                class="invisible">Toggle Submenu</span></button>
                </li>
                <li>
                    <a class="navLink" href="#" title="Patient Resources">Patient Resources</a>
                    <div class="navDropdown">
                        <ul>
                            <li><a href="<?php echo get_home_url() . '/patient-paperwork'; ?>"
                                   title="New Patient Paperwork">Patient Paperwork</a></li>
                            <li><a href="<?php echo get_home_url() . '/home-care-videos'; ?>"
                                   title="Home Care Videos">Home Care Videos</a></li>
                        </ul>
                        <div class="navDropdownShadow"></div>
                    </div>
                    <button class="navDropdownToggle" title="Toggle Submenu"><span
                                class="invisible">Toggle Submenu</span></button>
                </li>
                <li>
                    <span class="divider"></span>
                    <!-- <a class="navLinkWithIcon"
                       href="<?php echo get_home_url(1) . '/store?affiliateId=' . $affiliate_id . utmURL('child'); ?>"
                       rel="nofollow"
                       title="Shop">
                        <span class="icon-cart"></span>
                        <span class="navLinkText">Shop</span>
                    </a> -->
                    <a class="navLinkWithIcon"
                       href="https://store.maxliving.com/?srrf=<?php the_field('affiliate_id', 'clinic_options'); ?>"
                       rel="nofollow"
                       title="Store">
                        <span class="icon-cart"></span>
                        <span class="navLinkText">Store</span>
                    </a>
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
