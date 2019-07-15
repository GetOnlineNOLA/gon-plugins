<?php

//add any necessary custom fields
if( function_exists('acf_add_local_field_group') ):
acf_add_options_sub_page(array(
	'title'      => 'Team Plus Page Settings',
	'parent'     => 'edit.php?post_type=gon_team',
	'capability' => 'manage_options'
));
	
acf_add_local_field_group(array (
	'key' => 'gon_team_grid_extra_fields',
	'title' => 'Meet the Team Options',
	'fields' => array (
		array (
			'key' => 'gon_team_header_text',
			'label' => 'Intro text to diplay above team Grid',
			'name' => 'team-text',
			'type' => 'wysiwyg',
			'instructions' => 'Header Text will be shown on team archive page',
		),
		array (
			'key' => 'gon_team_number_columns',
			'label' => 'Number of Columns',
			'name' => 'team_number_columns',
			'type' => 'select',
			'instructions' => '',
			'choices' => array (
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
			'default_value' => array (
				0 => '4',
			),
		),
		array (
			'key' => 'backtoarchivelink',
			'label' => 'Back to Archive Link',
			'name' => 'archive-link',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-team-plus-page-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

//header-image group
acf_add_local_field_group(array (
	'key' => 'group_team_job_title_extras',
	'title' => 'Team Member Info',
	'fields' => array (
		array (
			'key' => 'field_job_title',
			'label' => 'Job Title',
			'name' => 'job-title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
		),
		array (
			'key' => 'team_member_excerpt',
			'label' => 'Job description excerpt',
			'name' => 'team_excerpt',
			'type' => 'wysiwyg',
			'instructions' => 'Add a brief description to be displayed beneath name and job title on team grid. Leave this field empty to display only name, image, and job title.',
		),
		array (
			'key' => 'field_team_phone',
			'label' => 'Phone Number',
			'name' => 'team-phone',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
		),
		array (
			'key' => 'field_team_email',
			'label' => 'Email Addess',
			'name' => 'team-email',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
		),
		array (
			'key' => 'gon_team_vcard',
			'label' => 'vCard',
			'name' => 'team-vcard',
			'type' => 'file',
			'instructions' => 'Upload vCard',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'library' => 'all',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'gon_team',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

//custom blocks
acf_add_local_field_group(array(
	'key' => 'group_5d23c46d0c002',
	'title' => 'Meet the Team Block',
	'fields' => array(
		array(
			'key' => 'field_5d264a83c0fda',
			'label' => 'Note:',
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
			'message' => 'You can edit or add team members <a href="/wp-admin/edit.php?post_type=gon_team" target="_blank">here</a>',
			'new_lines' => 'wpautop',
			'esc_html' => 0,
		),
		array(
			'key' => 'field_5d23c4876cec2',
			'label' => 'Columns',
			'name' => 'columns',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 3,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 1,
			'max' => 4,
			'step' => '',
		),
		array(
			'key' => 'field_5d2402861f63f',
			'label' => 'Include job title?',
			'name' => 'title',
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
			'default_value' => 1,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5d23c548289c0',
			'label' => 'Team Member Text',
			'name' => 'description',
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
				'none' => 'No text',
				'excerpt' => 'Display bio excerpt',
				'full' => 'Display full bio',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => '',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_5d23c572289c1',
			'label' => 'Link to Team Member Page?',
			'name' => 'link',
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
			'default_value' => 1,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5d23c588289c2',
			'label' => 'Filter by Team Category?',
			'name' => 'category',
			'type' => 'taxonomy',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'teamcategory',
			'field_type' => 'checkbox',
			'add_term' => 1,
			'save_terms' => 0,
			'load_terms' => 0,
			'return_format' => 'id',
			'multiple' => 0,
			'allow_null' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/team-block',
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