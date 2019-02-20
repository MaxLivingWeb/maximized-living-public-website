<?php
/* Template Name: Corporate - My Future Thank You */
/**
 *
 * The Corporate Thank You Page template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header(); ?>

    <div class="hero hero-thankYou myFuture-thankYou wave wave-multi" style=" background-image:url('<?php echo get_template_directory_uri(); ?>/images/MyFuture_ThankYou_Hero_Cropped.jpg');" id="content">
        <div class="heroContent centerAlign">
            <h1 class="heroHeadline">Thank You!</h1>
            <span class="icon-lineWave"></span>
            <p class="heroDescription">
                Your inquiry has been submitted. A MaxLiving representative will be in touch with you shortly.
            </p>
            <p class="heroDescription">
                In the meantime, browse our website to learn more about MaxLiving!
            </p>
            <a href="<?php echo get_home_url();?>/five-essentials"><button class="button button-large"
                                                                           title="Discover the 5 Essentials">
                    Discover the 5 Essentials&trade;
                </button></a>
        </div>
    </div>

<?php
get_footer();
