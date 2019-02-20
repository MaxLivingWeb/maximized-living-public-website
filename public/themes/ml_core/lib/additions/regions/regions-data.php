<?php

/**
 *
 * Combine country and regions to distribution regions
 *
 * @param $field
 *
 * @return mixed
 */
function acf_distribution_choices( $field ) {

    $field['choices'] = array();    // reset choices
    $regionID = 0;

    // if has regions
    if( have_rows('regions', 'regions') ) {
        while( have_rows('regions', 'regions') ) {

            // instantiate row
            the_row();

            // vars
            $label = get_sub_field('region');

            // append to clinic region choices
            $field['choices'][ $regionID ] = $label;

            ++$regionID;
        }
    }

    // return the field
   return $field;

}

add_filter('acf/load_field/name=distribution', 'acf_distribution_choices');
