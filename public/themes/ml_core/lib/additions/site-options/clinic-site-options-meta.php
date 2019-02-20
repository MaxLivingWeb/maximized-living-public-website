<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5c48ca9769174',
	'title' => 'Site Options',
	'fields' => array(
		array(
			'key' => 'field_5c48caa1b2b72',
			'label' => 'Site Region Selection',
			'name' => 'site_option_region_selection',
			'type' => 'checkbox',
			'instructions' => 'Select the country and region this site belongs to.',
			'required' => 1,
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
			'key' => 'field_5c48cb057ab9f',
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
	'active' => 1,
	'description' => '',
));

endif;
