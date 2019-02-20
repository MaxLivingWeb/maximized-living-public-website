<?php
global $blankHeader;
?>
<!-- #site-navigation -->
<nav id="site-navigation" class="navBar headerNavBar fixed">
    <div class="navContainer">
        <a class="logo navLogo" href="<?php echo get_home_url(); ?>" title="MaxLiving">
            <img src="<?php echo get_template_directory_uri(); ?>/images/ML-extended-logo.svg"
                 alt="MaxLiving"/>
        </a>
        <?php if(!$blankHeader) : ?>
            <nav class="navLinks-primary">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'main-nav',
                    'items_wrap' => main_nav_wrap(),
                    'container' => false,
                    'walker' => new mainNav()
                ));
                wp_nav_menu(array(
                    'theme_location' => 'secondary-nav',
                    'menu_class' => 'mobileMenuBottomNavLinks',
                    'container' => false,
                    'walker' => new secondaryMobileNav()
                ));
                ?>
            </nav>
            <nav class="navLinks-secondary">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'secondary-nav',
                    'items_wrap' => sec_nav_wrap(),
                    'container' => false,
                    'walker' => new secondaryNav()
                ));
                ?>
            </nav>
        <?php endif; ?>
    </div>
</nav>
