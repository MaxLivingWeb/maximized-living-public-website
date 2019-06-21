<?php
/* Template Name: Contact */

/**
* Template for Contact Page
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package MaxLiving
*/

get_header();

$heroImage = get_template_directory_uri() . "/images/hero_contact.jpg";
if (has_post_thumbnail()) :
$heroImage = get_the_post_thumbnail_url(get_the_ID(), 'full');
endif;
$mapScripts = true;
?>

    <script>
        var mapCenterLat = 28.4846215;
        var mapCenterLng = -81.4413964;
    </script>

<section class="hero hero-small bg-image centerAlign contactHero wave wave-multi" style="background-image: url('<?php echo $heroImage; ?>');">
    <div class="heroContent">
        <p class="heroLeading">MaxLiving</p>
        <h1 class="heroHeadline heroHeadline-small">Contact Us</h1>
        <p class="heroDescription"></p>
        <span class="icon-lineWave"></span>
    </div>
</section>

<section class="contactHeader wave wave-white" id="content">
    <div class="contactHeaderWrapper">
        <div id="map"></div>
        <div class="contactHeaderDetails container">
            <div class="contactCard card card-noBorder card-shadow card-underline-brandGrey">
                <?php
                $heading = get_field('heading', 'contact_options');
                $fax = $heading['fax'];
                $fax = preg_replace('/\D+/', '', $fax);
                $fax = '(' . substr($fax, 0, 3) . ') ' . substr($fax, 3, 3) . '-' . substr($fax, 6);
                $phone = $heading['phone'];
                $phone =  \MaxLiving\Location\FrontEnd\Functions::unformat_number($phone);
                $phoneFormatted =  \MaxLiving\Location\FrontEnd\Functions::format_telephone($phone);
                ?>
                <h2><span class="bold">max</span>living</h2>
                <?php
                if ($heading['address']['street'] && $heading['address']['city']) : ?>
                    <div class="address">
                        <?php echo $heading['address']['street']; ?><br>
                        <?php echo $heading['address']['city'] . ", " . $heading['address']['state'] . " " . $heading['address']['postal_code']; ?>
                    </div>
                <?php endif;
                if ($heading['phone']) : ?>
                    <p class="iconContact icon-phone"> Tel:
                        <a href="tel:<?php echo $phone; ?><?php if ($heading['phone_ext']) {
                            echo ";";
                            echo $heading['phone_ext'];
                        } ?>" data-phone class="phoneNumberAW">
                            <?php echo $phoneFormatted; ?><?php if ($heading['phone_ext']) {
                                echo " x";
                                echo $heading['phone_ext'];
                            } ?>
                        </a>
                    </p>
                <?php endif;
                if ($heading['fax']) : ?>
                    <p class="iconContact icon-fax"> Fax: <?php echo $fax; ?></p>
                <?php endif;
                if ($heading['email']) : ?>
                    <p class="iconContact icon-email"> Email:
                        <a href="mailto:<?php echo $heading['email']; ?>"
                           title="Email us at <?php echo $heading['email']; ?>">
                            <?php echo $heading['email']; ?>
                        </a>
                    </p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
<section>
<div class="contactFormContainer container">
  <div class="contactFormIntro centerAlign">
                    <h2>Send us a Message</h2>
                    <p></p><p>Are you ready to transform your life and take charge of your health? Contact MaxLiving today to get started.</p>

                </div>
<?php echo do_shortcode('[contact-form-7 id="10310" title="Contact Us"]'); ?>
</div>
</section>
<?php
get_footer();
