<?php

/*
Plugin Name: GON Products Premium
Plugin URI: https://getonlinenola.com/
Description: Products grid with additional features
Version: 1.0
Author: Get Online Nola
*/

//add products grid to site - 
//start with the products post type
function create_post_type_gon_products_premium() {
  register_post_type( 'gon_products_premium',
    array(
      'labels' => array(
        'name' => __( 'Products' ),
        'singular_name' => __( 'Product' )
      ),
      'public' => true,
      'has_archive' => true,
	  'menu_position' => 10,
	  'capability_type'    => 'post',
	  'supports' => array('title', 'editor','page-attributes','thumbnail'),
	  'rewrite' => array( 'slug' => 'products' )
    )
  );
  
  	//add product-type tax
  
	register_taxonomy(
		'featured_product_type',
		'gon_products_premium',
		array(
			'label' => __( 'Product Categories' ),
			'rewrite' => array( 'slug' => 'product-type' ),
			'hierarchical' => true,
		)
	);
}
add_action( 'init', 'create_post_type_gon_products_premium' );

//function gon_add_product_crop(){
//	if (function_exists('add_image_size')) {
//		add_image_size('products-crop', 400, 300, array('center', 'center'));//4:3
//	}
//}
//
//add_action('after_setup_theme','gon_add_product_crop');

function gon_products_premium_style() {
	wp_register_style( 'gon-products-premium-style', plugin_dir_url( __FILE__ ) . 'products.css' );
	wp_enqueue_style( 'gon-products-premium-style', plugin_dir_url( __FILE__ ) . 'products.css', 'parent-style' );
}
add_action( 'wp_enqueue_scripts', 'gon_products_premium_style' );


//if premium, uncomment to register custom sidebar
function gon_products_sidebar_init(){
	register_sidebar(array(
        'name' => __('Products Sidebar Widget', 'gon_carrollton'),
        'id' => 'products-premium-sidebar-widget',
        'description' => 'Sidebar will appear on products pages',
        'before_widget' => '<aside id="sidebar"><div id="%1$s" class="widget-container %2$s">',
        'after_widget' => "</div></aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
}

add_action('widgets_init','gon_products_sidebar_init');



//addition of custom fields
if( function_exists('acf_add_local_field_group') ):

acf_add_options_sub_page(array(
	'title'      => 'Premium Products Settings',
	'parent'     => 'edit.php?post_type=gon_products_premium',
	'capability' => 'manage_options'
));
	
acf_add_local_field_group(array (
	'key' => 'premiums_products_grid_extra_fields',
	'title' => 'Products Premium Grid',
	'fields' => array (
		array (
			'key' => 'premiums_products_menu_header_text',
			'label' => 'Intro text to diplay above Premium Products Grid',
			'name' => 'premium-text',
			'type' => 'wysiwyg',
			'instructions' => 'Header Text will be shown on premium products archive page',
		),
		array (
			'key' => 'premiums_products_number_columns',
			'label' => 'Number of Columns',
			'name' => 'number_columns_premiums_products',
			'type' => 'select',
			'instructions' => '',
			'choices' => array (
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
			'default_value' => array (
				0 => '2',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-premium-products-settings',
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
endif;


//addition of previously exported custom fields
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array (
	'key' => 'group_57dc3f5212e71',
	'title' => 'Additional Information',
	'fields' => array (
		/*array (
			'key' => 'field_57c9895fdd5df1',
			'label' => 'Space Icon',
			'name' => 'Spaces-icon',
			'type' => 'image',
			'instructions' => 'Suggested image size 65px x 65px as transparent .png',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),*/
		array (
			'key' => 'field_57dc3f5f23d71',
			'label' => 'Associated Projects',
			'name' => 'associated-projects',
			'type' => 'relationship',
			'instructions' => 'Choose 3 examples to display',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'gon_products_premium',
			),
			'taxonomy' => array (
			),
			'filters' => array (
				0 => 'search',
				1 => 'post_type',
				2 => 'taxonomy',
			),
			'elements' => array (
				0 => 'featured_image',
			),
			'min' => 0,
			'max' => 3,
			'return_format' => 'id',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'gon_products_premium',
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
endif;


//alter query
function alter_post_per_page( $query ) {
    if ( $query->is_tax('featured_product_type') || $query->is_post_type_archive('gon_products_premium') ) {
        $query->set( 'posts_per_page', '-1' );
    }
}
add_action( 'pre_get_posts', 'alter_post_per_page' );


//add custom single page
function get_products_premium_template($single_template) {
     global $post;

     if ($post->post_type == 'gon_products_premium') {
          $single_template = dirname( __FILE__ ) . '/single-gon_products_premium.php';
     }
     return $single_template;
}

// UNCOMMENT FOR PRODUCTS PREMIUM
// add custom taxonomy page
function get_product_premium_taxonomy_template($taxonomy_template) {
     global $post;

     if ($post->post_type == 'gon_products_premium') {
          $taxonomy_template = dirname( __FILE__ ) . '/taxonomy-product_type.php';
     }
     return $taxonomy_template;
}
// add custom archive page
function get_product_premium_archive_template($archive_template) {
     global $post;

     if ($post->post_type == 'gon_products_premium') {
          $archive_template = dirname( __FILE__ ) . '/archive-gon_products_premium.php';
     }
     return $archive_template;
}


add_filter( 'single_template', 'get_products_premium_template' );
add_filter( 'archive_template', 'get_product_premium_archive_template' );

// UNCOMMENT FOR PRODUCTS PREMIUM
add_filter( 'taxonomy_template', 'get_product_premium_taxonomy_template' );



