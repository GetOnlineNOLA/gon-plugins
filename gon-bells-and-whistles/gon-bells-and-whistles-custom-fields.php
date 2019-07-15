<?php  

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5cfaba122fdb4',
	'title' => 'JavaScript Pack',
	'fields' => array(
		array(
			'key' => 'field_5d01570542636',
			'label' => 'Note',
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
			'message' => 'Warning: Only use with Get Online NOLA themes! Plugin will be unpredictable otherwise',
			'new_lines' => 'wpautop',
			'esc_html' => 0,
		),
		array(
			'key' => 'field_5cfaba2be8c1c',
			'label' => 'Home Page Animations',
			'name' => 'home_page_animations',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'none',
				'fade-sections' => 'fade in sections',
				'slide-columns' => 'slide in columns',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'none',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_5cfaba74e8c1d',
			'label' => 'Header Slide',
			'name' => 'header_slide',
			'type' => 'true_false',
			'instructions' => 'mark as true to enable a slide-in header activated on scroll',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5cfabac1e8c1e',
			'label' => 'Parallax slide show',
			'name' => 'parallax_slide_show',
			'type' => 'true_false',
			'instructions' => 'mark as true to add a parallax effect to the slide show images',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'adv-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;