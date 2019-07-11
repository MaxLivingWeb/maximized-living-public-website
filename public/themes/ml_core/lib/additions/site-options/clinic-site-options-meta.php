<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5d2769b58eaed',
	'title' => 'Site Options',
	'fields' => array(
		array(
			'key' => 'field_5d2769c9e21e8',
			'label' => 'Site Region Selection',
			'name' => 'site_option_region_selection',
			'type' => 'checkbox',
			'instructions' => 'Select the country and region this site belongs to.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
			),
			'allow_custom' => 0,
			'default_value' => array(
			),
			'layout' => 'vertical',
			'toggle' => 0,
			'return_format' => 'value',
			'save_custom' => 0,
		),
		array(
			'key' => 'field_5d276b8600847',
			'label' => 'Facebook Pixel',
			'name' => 'fb_pixel',
			'type' => 'textarea',
			'instructions' => 'Entering your own Facebook Pixel will overwrite the default MaxLiving pixel.',
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
			'new_lines' => '',
		),
		array(
			'key' => 'field_5d276c0e00849',
			'label' => 'Google Tag Manager (head)',
			'name' => 'gtm_head',
			'type' => 'textarea',
			'instructions' => 'This code will be inserted in between the head tags.',
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
			'new_lines' => '',
		),
		array(
			'key' => 'field_5d276c250084a',
			'label' => 'Google Tag Manager (body)',
			'name' => 'gtm_body',
			'type' => 'textarea',
			'instructions' => 'This code will be inserted in between the body tags.',
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
			'new_lines' => '',
		),
		array(
			'key' => 'field_5d276a0f9b0a2',
			'label' => 'Shopify Affiliate ID',
			'name' => 'affiliate_id',
			'type' => 'text',
			'instructions' => 'Type in the Shopify Affiliate ID below for this clinic. To find out what the affiliate ID is, please visit <a href="https://store.maxliving.com/admin" target="_blank">https://store.maxliving.com/admin</a><br><br>Note: Make sure you only enter affiliate ID after the equal sign - https://store.maxliving.com/?srrf=<strong>AFFILIATEID</strong>',
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
			'key' => 'field_5d276a839b0a3',
			'label' => 'Homecare Certification',
			'name' => 'homecare_cert',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5d276aa19b0a4',
			'label' => 'Homecare Certification Level 1',
			'name' => 'homecare_cert_lvl1',
			'type' => 'true_false',
			'instructions' => '<strong>Requires:</strong> Homecare Certification',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5d276a839b0a3',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5d276afa9b0a5',
			'label' => 'Homecare Certification Level 2',
			'name' => 'homecare_cert_lvl2',
			'type' => 'true_false',
			'instructions' => '<strong>Requires:</strong> Homecare Certification Level 1',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5d276aa19b0a4',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5d276b0f9b0a6',
			'label' => 'Nutrition Certification',
			'name' => 'nutrition_cert',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5d276b319b0a7',
			'label' => 'Nutrition Certification Level 1',
			'name' => 'nutrition_cert_lvl1',
			'type' => 'true_false',
			'instructions' => '<strong>Requires:</strong> Nutrition Certification',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5d276b0f9b0a6',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5d276b479b0a8',
			'label' => 'Nutrition Certification Level 2',
			'name' => 'nutrition_cert_lvl2',
			'type' => 'true_false',
			'instructions' => '<strong>Requires:</strong> Nutrition Certification Level 1',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5d276b319b0a7',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'clinic-site-options',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'permalink',
		1 => 'the_content',
		2 => 'excerpt',
		3 => 'discussion',
		4 => 'comments',
		5 => 'revisions',
		6 => 'slug',
		7 => 'author',
		8 => 'format',
		9 => 'page_attributes',
		10 => 'featured_image',
		11 => 'categories',
		12 => 'tags',
		13 => 'send-trackbacks',
	),
	'active' => true,
	'description' => '',
));

endif;
