<?php

/* Template Name: Location Search */
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header();

$showNewsletter = false;
$mapScripts = true;
?>


<section class="searchHeader bg-faintGrey centerAlign<?php
if (get_field('display_clinic_features_area')) : ?> wave wave-white<?php endif; ?>" <?php
if (!get_field('display_clinic_features_area')) : ?> style="margin-bottom: -3rem;"<?php endif; ?> id="content">
    <div class="container">
        <h1>Find a Clinic</h1>
        <p>Get connected with a chiropractic doctor in your area. To begin, enter your city or zip/postal code below.</p>
        <form class="locationSearch" id="locationSearchForm">
            <label class="inputField" for="locationSearch">
                <input class="locationInput" id="locationSearch" type="text" name="location" placeholder=""
                       required/>
                <span class="locationSearchLabel">City or Zip/Postal Code</span>
                <span class="locationSearchIcon"></span>
            </label>
        </form>
    </div>
</section>
<?php
if (get_field('display_clinic_features_area')) :
    if (get_field('find_a_clinic_title') && get_field('find_a_clinic_desc')) : ?>

        <section class="searchDetails flexible-fullWidthCards centerAlign container">
            <div class="flexible-fullWidth centerAlign">
                <h2 class="title"><?php the_field('find_a_clinic_title'); ?></h2>
                <div class="description"><?php the_field('find_a_clinic_desc'); ?></div>
            </div>

        <?php if (have_rows('find_a_clinic_feature_cards')) :?>
            <div class="cardContainer">

                <?php
                $count = 0;
                $cardNumbers = '';
                while (have_rows('find_a_clinic_feature_cards')) {
                    the_row();
                    $count++;
                }
                if($count == 2){
                    $cardNumbers = 'card-half';
                }
                if($count >= 3){
                    $cardNumbers = 'card-third';
                }
                ?>

            <?php
            while (have_rows('find_a_clinic_feature_cards')): the_row(); ?>
                <div class="card card-shadow centerAlign <?php echo $cardNumbers; ?>">

                    <?php if(get_sub_field('icon')) :?>
                        <span class="image bg-image <?php the_sub_field('icon'); ?>"></span>
                    <?php endif; ?>
                    <?php if(get_sub_field('title')) :?>
                        <h3><?php the_sub_field('title'); ?></h3>
                    <?php endif; ?>
                    <?php if(get_sub_field('content')) :?>
                        <div><?php the_sub_field('content'); ?></div>
                    <?php endif; ?>
                    <?php if(get_sub_field('cta_link')) : ?>
                        <a class="button button-secondary" href="<?php the_sub_field('cta_link'); ?>" title="<?php the_sub_field('cta_title'); ?>"><?php the_sub_field('cta_title'); ?></a>
                    <?php endif; ?>
                </div>

            <?php endwhile; ?>
            </div>
            <?php
        endif;
    endif; ?>

        </section>

        <?php
    endif;
    get_footer();
