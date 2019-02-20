<?php
/* Template Name: Search */
/**
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package MaxLiving
 */

get_header(); ?>

    <section>
        <h1>Find a Clinic</h1>
    </section>
<?php
if (get_field('display_clinic_features_area')) :
    if (get_field('find_a_clinic_title') && get_field('find_a_clinic_desc')) : ?>
        <section>
        <h2><?php the_field('find_a_clinic_title'); ?></h2>
        <p><?php the_field('find_a_clinic_desc'); ?></p>
        <?php if (have_rows('find_a_clinic_feature_cards')) :
            while (have_rows('find_a_clinic_feature_cards')): the_row(); ?>

                <div>
                    <img src="<?php the_sub_field('icon'); ?>" alt="">
                    <h3><?php the_sub_field('title'); ?></h3>
                    <p><?php the_sub_field('desc'); ?></p>
                </div>

            <?php endwhile;
        endif;
    endif; ?>
    </section>
    <?php
endif;
get_footer();
