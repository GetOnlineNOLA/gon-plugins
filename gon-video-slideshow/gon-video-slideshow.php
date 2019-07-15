<?php
/**
 * Plugin Name: gon-video-slideshow
 * Plugin URI: http://getonlinenola.com/
 * Description: A video slideshow plugin!
 * Author: Fau-Do
 * Version: 1.0.0
 * Author URI: http://getonlinenola.com/
 * License: Completely restricted to getonlinenola.com, not for use elsewhere.
 */
function create_post_type_gon_video_slideshow() {
  register_post_type( 'gon_video_slideshows',
    array(
      'labels' => array(
        'name' => __( 'Video Slideshows' ),
        'singular_name' => __( 'Video Slideshow' )
      ),
      'public' => true,
      'has_archive' => false,
	  'menu_position' => 5,
	  'capability_type'    => 'post',
	  'rewrite'            => array( 'slug' => 'video-slideshows' ),
	  'supports' => array('title', 'page-attributes')
    )
  );
  
}
add_action( 'init', 'create_post_type_gon_video_slideshow' );

if ( ! function_exists( 'gon_enqueue_video_slideshow_styles' ) ) {
	function gon_enqueue_video_slideshow_styles(){
		wp_register_style('swiper-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.2.5/css/swiper.min.css');
		wp_register_style('gon-video-slideshow-css', plugin_dir_url( __FILE__ ) . 'css/video-style.css');

		wp_enqueue_style('swiper-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.2.5/css/swiper.min.css');
		wp_enqueue_style('gon-video-slideshow-css', plugin_dir_url( __FILE__ ) . 'css/video-style.css');
	}

	add_action('wp_enqueue_scripts', 'gon_enqueue_video_slideshow_styles', 11);
}

if ( ! function_exists( 'gon_enqueue_video_slideshow_scripts' ) ) {
	function gon_enqueue_video_slideshow_scripts(){
		wp_enqueue_script('swiper-js','https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.2.5/js/swiper.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script('video-slideshow-js', plugin_dir_url( __FILE__ ) . 'js/video-slideshow.js', array('jquery'), '1.0', true );
	}

	add_action('wp_enqueue_scripts', 'gon_enqueue_video_slideshow_scripts');
}

//custom Gutenberg block
function gon_video_slideshow_register_custom_blocks() {

    // register an address block.
    acf_register_block_type(array(
        'name'              => 'video-slideshow-block',
        'title'             => __('Video Slideshow'),
        'description'       => __('Select a video slidehow.'),
        'render_template'   => plugin_dir_path( __FILE__ ) . 'video-slideshow-block.php',
        'category'          => 'formatting',
        'icon'              => 'admin-comments',
        'keywords'          => array( 'video-slideshow', 'GON' ),
    ));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'gon_video_slideshow_register_custom_blocks');
}



require_once( plugin_dir_path(__FILE__) . 'gon-video-slideshow-fields.php' );
require_once( plugin_dir_path(__FILE__) . 'output.php' );



?>
