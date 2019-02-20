<?php

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5b1a8e06837e2',
        'title' => 'start.maxliving.com Listing Description',
        'fields' => array(
            array(
                'key' => 'field_5b1a8e1f72a1f',
                'label' => '',
                'name' => '',
                'type' => 'message',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => 'This section will display on your <a href="https://start.maxliving.com" target="_blank">start.maxliving.com</a> listing.',
                'new_lines' => '',
                'esc_html' => 0,
            ),
            array(
                'key' => 'field_5b1a8ec472a20',
                'label' => '',
                'name' => 'desc',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => 1000,
                'rows' => '',
                'new_lines' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'landing-page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'custom_fields',
            1 => 'discussion',
            2 => 'comments',
            3 => 'page_attributes',
            4 => 'featured_image',
            5 => 'categories',
            6 => 'tags',
            7 => 'send-trackbacks',
        ),
        'active' => 1,
        'description' => '',
    ));

endif;
