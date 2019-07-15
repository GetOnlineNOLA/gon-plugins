<?php

/*
Plugin Name: GON Services-Menu
Plugin URI: https://getonlinenola.com/
Description: Create 'Services Menu' post type. Configure settings in Services Menu > Services Menu Settings
Version: 1.0
Author: Get Online Nola
*/

//add services_menu grid to site - 
//start with the services_menu post type
function create_post_type_gon_services_menu() {
  register_post_type( 'gon_services_menu',
    array(
      'labels' => array(
        'name' => __( 'Products' ),
        'singular_name' => __( 'Product' )
      ),
      'public' => true,
	'menu_icon' => 'dashicons-list-view',
      'has_archive' => false,
	  'menu_position' => 5,
	  'capability_type'    => 'post',
	  'supports' => array('title', 'editor','page-attributes','thumbnail'),
	  'rewrite' => array( 'slug' => 'products' )
    )
  );
  
}
add_action( 'init', 'create_post_type_gon_services_menu' );
//instead of a shortcode to note the details, a custom option menu - next to the CPT will capture all the info using ACF.

//addition of custom fields
if( function_exists('acf_add_local_field_group') ):

acf_add_options_sub_page(array(
	'title'      => 'Services Menu Settings',
	'parent'     => 'edit.php?post_type=gon_services_menu',
	'capability' => 'manage_options'
));
	
acf_add_local_field_group(array (
	'key' => 'group_services_menus_extra_fields',
	'title' => 'Services Menus',
	'fields' => array (
		array (
			'key' => 'field_services_menu_header_text',
			'label' => 'Common Header Text',
			'name' => 'services-menu-header-text',
			'type' => 'wysiwyg',
			'instructions' => 'Header Text will be shown above each single content',
		),
		array (
			'key' => 'field_services_menu_nav_style',
			'label' => 'navstyle',
			'name' => 'navstyle',
			'type' => 'select',
			'instructions' => 'Choose top nav or side and what size it should be (side only)',
			'choices' => array (
				'top' => 'top',
				'small' => 'small',
				'med' => 'med',
				'large' => 'large',
			),
			'default_value' => array (
				0 => 'top',
			),
		),
		array (
			'key'  => 'field_optional_services_menu_contactform',
			'label'=> 'Below nav content',
			'name' => 'services-menu-cf-shortcode',
			'type' => 'wysiwyg',
			'instructions' => 'Content will display below services menu. Shortcode friendly ;)',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-services-menu-settings',
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
acf_add_local_field_group(array (
	'key' => 'group_gon_services_menu_additional',
	'title' => 'Button Title',
	'fields' => array (
		array (
			'key' => 'field_gon_services_menu_button_text',
			'name' => 'button-title',
			'type' => 'text',
			'instructions' => 'Text to show on the button',
		),
		array (
			'key' => 'button-class-services-menu',
			'label' => 'Button Class',
			'name' => 'button-class',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'gon_services_menu',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));
endif;


//add custom single page
function services_get_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'gon_services_menu') {
          $single_template = dirname( __FILE__ ) . '/single-gon_services_menu.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'services_get_custom_post_type_template' );


//conditionally checking on the function_exists means child theme can write first with same name
if ( ! function_exists( 'gon_services_menu_enqueue_styles' ) ) {
    function gon_services_menu_enqueue_styles() {
		wp_register_style( 'services-menu-css', plugin_dir_url( __FILE__ ) . 'services-menu-styles.css' ); 
		wp_enqueue_style( 'services-menu-css', plugin_dir_url( __FILE__ ) . 'services-menu-styles.css' );
	}
	add_action( 'wp_enqueue_scripts', 'gon_services_menu_enqueue_styles' );
}

if ( ! function_exists( 'gon_services_menu_enqueue_scripts' ) ) {
    function gon_services_menu_enqueue_scripts() {
		wp_enqueue_script('services-menu-script', plugin_dir_url( __FILE__ ) . 'services-menu.js', array('jquery'), 1.0, true);
	}
	
	add_action( 'wp_enqueue_scripts', 'gon_services_menu_enqueue_scripts' );
}
