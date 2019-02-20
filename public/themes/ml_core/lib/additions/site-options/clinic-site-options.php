<?php

/**
 *
 * Combine country and regions to distribution regions for clinic level selection
 *
 * @param $field
 *
 * @return mixed
 */
function acf_site_option_country_choices( $field ) {

    $regionIDOption = 0;
    $field['choices'] = array();    // reset choices

    switch_to_blog(1);    // Switch to corporate to grab countries/regions
    
    // if has regions
    if( have_rows('regions', 'regions') ) {
        while( have_rows('regions', 'regions') ) {

            // instantiate row
            the_row();

            // vars
            $label = get_sub_field('region');

            // append to clinic region choices
            $field['choices'][ $regionIDOption ] = $label;

            ++$regionIDOption;
        }
    }

    restore_current_blog();

    // return the field
    return $field;

}

add_filter('acf/load_field/name=site_option_region_selection', 'acf_site_option_country_choices');
