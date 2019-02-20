<?php

if (get_current_blog_id() == 1) :
    if( function_exists('acf_add_local_field_group')):

        acf_add_local_field_group(array(
            'key' => 'group_5a2089785b3a0',
            'title' => 'Content Distribution',
            'fields' => array(
                array(
                    'key' => 'field_5a257c185a6dc',
                    'label' => 'Content Reach',
                    'name' => 'distribution_reach',
                    'type' => 'radio',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        0 => 'Individual Site',
                        1 => 'Network Wide',
                        2 => 'Region(s)',
                    ),
                    'allow_null' => 1,
                    'other_choice' => 0,
                    'save_other_choice' => 0,
                    'default_value' => '',
                    'layout' => 'vertical',
                    'return_format' => 'value',
                ),
                array(
                    'key' => 'field_5a20898011976',
                    'label' => 'Region(s)',
                    'name' => 'distribution',
                    'type' => 'checkbox',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5a257c185a6dc',
                                'operator' => '==',
                                'value' => '2',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        0 => 'Canada',
                        1 => 'USA',
                    ),
                    'allow_custom' => 0,
                    'save_custom' => 0,
                    'default_value' => array(
                    ),
                    'layout' => 'horizontal',
                    'toggle' => 0,
                    'return_format' => 'value',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'article',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'recipe',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'author',
            ),
            'active' => 1,
            'description' => '',
        ));

    endif;
endif;
