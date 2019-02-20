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

<section class="contactHeader wave wave-faintGrey" id="content">
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

<section class="contactBody bg-faintGrey wave wave-white">
    <div class="departmentsReachUs container">
            <div class="reachUs">
                <h3>How to Reach Us</h3>
                <?php if (get_field('how_to_reach_us_description', 'contact_options')) { the_field('how_to_reach_us_description', 'contact_options'); } ?>
            </div>

        <?php if (have_rows('departments', 'contact_options')) : ?>
            <div class="departments card card-noBorder card-shadow">

                <h4>Departments</h4>
                <?php while (have_rows('departments', 'contact_options')):
                    the_row(); ?>

                    <span class="departmentName">
                    <?php the_sub_field('department_name', 'contact_options'); ?>
                </span>


                    <?php
                    $phone = get_sub_field('phone', 'contact_options');
                    $phone = preg_replace('/\D+/', '', $phone);
                    $phoneFormatted = '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
                    ?>

                    <div class="departmentItems">
                        <?php if (get_sub_field('phone', 'contact_options')) : ?>
                            <p class="icon-phone iconContact iconContact-small">
                    <span>Tel: <a data-phone
                                  class="phoneNumberAW"
                                href="tel:<?php the_sub_field('phone', 'contact_options'); ?><?php if (get_sub_field('phone_ext', 'contact_options')) {
                                    echo ";";
                                    the_sub_field('phone_ext', 'contact_options');
                                } ?>"
                                class="link-underlineOnHover"
                                title="Call us at <?php echo $phoneFormatted;
                                if (get_sub_field('phone_ext', 'contact_options')) {
                                    echo " x";
                                    the_sub_field('phone_ext', 'contact_options');
                                } ?>"><?php echo $phoneFormatted;
                            if (get_sub_field('phone_ext', 'contact_options')) {
                                echo " x";
                                the_sub_field('phone_ext', 'contact_options');
                            } ?></a>
                    </span>
                            </p>

                        <?php endif;
                        if (get_sub_field('email', 'contact_options')) : ?>
                            <p class="icon-email iconContact iconContact-small">
                    <span>Email: <a href="mailto:<?php the_sub_field('email', 'contact_options'); ?>"
                                    class="link-underlineOnHover"
                                    title="Email us at <?php the_sub_field('email', 'contact_options'); ?>"><?php the_sub_field('email', 'contact_options'); ?></a>
               </span>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php echo do_shortcode('[contact_form]'); ?>

<?php
get_footer();
