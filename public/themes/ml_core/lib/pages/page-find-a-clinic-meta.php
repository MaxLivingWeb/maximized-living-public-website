<?php

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5a00868268c38',
        'title' => 'Find a Clinic',
        'fields' => array(
            array(
                'key' => 'field_5a0089bb3b364',
                'label' => 'Clinic Features Area',
                'name' => 'display_clinic_features_area',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => 'This option will display or hide the clinic features section',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Displayed',
                'ui_off_text' => 'Disabled',
            ),
            array(
                'key' => 'field_5a0086885f0b2',
                'label' => 'Title',
                'name' => 'find_a_clinic_title',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'You\'ll Love Our Clinics',
                'placeholder' => 'You\'ll Love Our Clinics',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5a0086c15f0b3',
                'label' => 'Description',
                'name' => 'find_a_clinic_desc',
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
                'maxlength' => '',
                'rows' => '',
                'new_lines' => 'wpautop',
            ),
            array(
                'key' => 'field_5a0086db5f0b4',
                'label' => 'Feature Cards',
                'name' => 'find_a_clinic_feature_cards',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => '',
                'sub_fields' => array(
                    array(
                        'key' => 'field_5a0086f65f0b5',
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'iconTwoTone twoTone-award' => 'Award',
                            'iconTwoTone twoTone-building' => 'Building',
                            'iconTwoTone twoTone-gradHat' => 'Graduation Hat',
                            'iconTwoTone twoTone-list' => 'List',
                            'iconTwoTone twoTone-megaphone' => 'Megaphone',
                            'iconTwoTone twoTone-clock' => 'Clock',
                        ),
                        'default_value' => array(
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'ajax' => 0,
                        'return_format' => 'value',
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_5a00871a5f0b6',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
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
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5a0087245f0b7',
                        'label' => 'Content',
                        'name' => 'content',
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
                        'maxlength' => '',
                        'rows' => '',
                        'new_lines' => 'wpautop',
                    ),
                    array(
                        'key' => 'field_5a15dd3137aa1',
                        'label' => 'CTA Title',
                        'name' => 'cta_title',
                        'type' => 'text',
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
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5a15dd2637aa0',
                        'label' => 'CTA Link',
                        'name' => 'cta_link',
                        'type' => 'url',
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
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'locationSearch.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            1 => 'the_content',
            2 => 'excerpt',
            3 => 'custom_fields',
            4 => 'discussion',
            5 => 'comments',
            6 => 'format',
            7 => 'categories',
            8 => 'tags',
            9 => 'send-trackbacks',
        ),
        'active' => 1,
        'description' => '',
    ));

endif;
