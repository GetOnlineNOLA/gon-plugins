<?php

/*
Plugin Name: Page Builder
Description: A robust and flexible page builder.
Version: 1.0
Author: Leo Skovron
*/

//enqueue styles
function gon_page_builder_enqueue_styles() {
	//register styles
	wp_register_style( 'gon-page-builder-styles', plugin_dir_url( __FILE__ ) . 'page-builder-styles.css' );
	wp_enqueue_style( 'gon-page-builder-styles', plugin_dir_url( __FILE__ ) . 'page-builder-styles.css', array('meyer-reset') );

	wp_enqueue_script( 'gon-page-builder-js', plugin_dir_url( __FILE__ ) . 'page-builder.js', array('jquery'), null, true );

}
add_action( 'wp_enqueue_scripts', 'gon_page_builder_enqueue_styles' );

add_action( 'after_setup_theme', 'page_builder_image_sizes' );
function page_builder_image_sizes() {
    add_image_size( 'medium-square-crop', 300, 300, array('center', 'center') );
}


//////////////////////
//////////////////////
//ACF CUSTOMIZATIONS//
//////////////////////
//////////////////////

//load fields
require_once('page-builder-acf-import.php');


//ACF custom layout section title
function my_acf_flexible_content_layout_title( $title, $field, $layout, $i ) {
	$title = '<strong>'.$title.'</strong>';
	if( $text = get_sub_field('section_title') ) {
		$title = $text.' - '.$title;	
	} else {
		$title = 'New Section (add a title) - '.$title;
	}
	if( $combine = get_sub_field('combine_with_next') ){
		$title .= ' --- <span style="font-weight:bold;font-size:.85em;">COMBINED WITH NEXT SECTION</span>';
	}
	return $title;
}
add_filter('acf/fields/flexible_content/layout_title/name=gon_page_builder', 'my_acf_flexible_content_layout_title', 10, 4);



///////////////////////
///////////////////////
///ADD PAGE TEMPLATE///
///////////////////////
///////////////////////


//add page template
class PageTemplater {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;

	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	/**
	 * Returns an instance of this class. 
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new PageTemplater();
		} 

		return self::$instance;

	} 

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {

		$this->templates = array();


		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {

			// 4.6 and older
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' )
			);

		} else {

			// Add a filter to the wp 4.7 version attributes metabox
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
			);

		}

		// Add a filter to the save post to inject out template into the page cache
		add_filter(
			'wp_insert_post_data', 
			array( $this, 'register_project_templates' ) 
		);


		// Add a filter to the template include to determine if the page has our 
		// template assigned and return it's path
		add_filter(
			'template_include', 
			array( $this, 'view_project_template') 
		);


		// Add your templates to this array.
		$this->templates = array(
			'page-builder-template.php' => 'GON Page Builder',
		);
			
	} 

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 */
	public function register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list. 
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		} 

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	} 

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_project_template( $template ) {
		
		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[get_post_meta( 
			$post->ID, '_wp_page_template', true 
		)] ) ) {
			return $template;
		} 

		$file = plugin_dir_path( __FILE__ ). get_post_meta( 
			$post->ID, '_wp_page_template', true
		);

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		// Return template
		return $template;

	}

} 
add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );



////////////////////////////
////////////////////////////
/////OUTPUT FUNCTIONS///////
////////////////////////////
////////////////////////////

require_once( 'output.php' );

add_action('gon_custom_page_builder','gon_page_builder_function');
//use correct layout function
function gon_page_builder_function(){
	if( have_rows('gon_page_builder') ):
		while ( have_rows('gon_page_builder') ) : the_row();
			$layout = get_row_layout();
			switch ($layout) {
				case 'one_column_section':
					one_column_section_function();
					break;
				case 'two_column_section':
					two_column_section_function();
					break;
				case 'three_column_section':
					three_column_section_function();
					break;
				case 'four_column_section':
					four_column_section_function();
					break;
				case 'meet_the_team_module':
					meet_the_team_module_function();
					break;
				case 'two_column_section_with_grid':
					two_column_section_with_grid_function();
					break;
				case 'accordion_section':
					repeatable_qa_function();
					break;
			}
		endwhile;
	endif;
}




?>