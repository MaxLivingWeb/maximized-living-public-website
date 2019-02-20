<?php
/* Template Name: Clinic - Thank You Page */
/**
*
* The Clinic Thank You Page template
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package MaxLiving
*/

$socialFacebook = "";
$socialTwitter = "";
$socialGooglePlus = "";

// Check for Corporates social profiles.
switch_to_blog(1);
if (get_field('facebook', 'footer')) {
    $socialFacebook = get_field('facebook', 'footer');
}
if (get_field('twitter', 'footer')) {
    $socialTwitter = get_field('twitter', 'footer');
}
if (get_field('google_plus', 'footer')) {
    $socialGooglePlus = get_field('google_plus', 'footer');
}
restore_current_blog();

//IF Clinic site has own profiles (otherwise keep corporates above)

if (get_field('facebook', 'footer')) :
    $socialFacebook = get_field('facebook', 'footer');
endif;

if (get_field('twitter', 'footer')) :
    $socialTwitter = get_field('twitter', 'footer');
endif;

if (get_field('google_plus', 'footer')) :
    $socialGooglePlus = get_field('google_plus', 'footer');
endif;
get_header(); ?>
<div class="hero hero-thankYou wave wave-multi" style="padding: 12rem 0; background-image:url('<?php echo get_template_directory_uri(); ?>/images/mainHero.jpg');" id="content">
    <div class="heroContent centerAlign">
        <h1 class="heroHeadline">Thanks<?php if(isset($_GET['n']))  {echo ', '.$_GET['n'];} ?>!</h1>
        <span class="icon-lineWave"></span>
        <p class="heroDescription">
            Someone from <?php echo get_bloginfo('name'); ?> will reach out to you soon. In the meantime, learn more about
            how MaxLiving and the 5 Essentials<sup>&trade;</sup> can help you reach your health and wellness goals.
        </p>
        <a href="<?php echo get_home_url();?>/five-essentials"><button class="button button-large"
            title="Discover the 5 essentials">
            Discover the 5 Essentials<sup>&trade;</sup>
        </button></a>
    </div>
</div>
<section class="container centerAlign">
<?php if ($socialFacebook || $socialTwitter || $socialGooglePlus): ?>
    <div class="container centerAlign socialMediaCallout">
        <div class="noDivider"><h2 class="borderText border-brandGrey">Social Media</h2></div>
        <span class="icon iconTwoTone twoTone-megaphone"></span>
        <h3>Connect with us!</h3>
        <p class="connectText">
            Follow us on social media for healthy recipes, wellness tips, and more!
        </p>
        <ul class="social">
            <?php if ($socialFacebook): ?>
                <li>
                    <a href="<?php echo $socialFacebook; ?>" class="socialIcon socialIcon icon-facebook"
                       title="Facebook">
                        <span class="invisible">Facebook</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($socialFacebook): ?>
                <li>
                    <a href="<?php echo $socialTwitter; ?>" class="socialIcon icon-twitter" title="Twitter">
                        <span class="invisible">Twitter</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($socialFacebook): ?>
                <li>
                    <a href="<?php echo $socialGooglePlus; ?>" class="socialIcon icon-googleplus" title="Google Plus">
                        <span class="invisible">Google Plus</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>
<?php
get_footer();
