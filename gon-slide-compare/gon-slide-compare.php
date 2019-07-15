<?php

/*
Plugin Name: GON Image Comparison Slider
Plugin URI: https://getonlinenola.com/
Description:
Version: 1.0
Author: Get Online Nola
*/


function gon_image_slider_script() {
	wp_register_style( 'gon-portfolio-style', plugin_dir_url( __FILE__ ) . 'portfolio.css' );
	wp_enqueue_style( 'gon-portfolio-style', plugin_dir_url( __FILE__ ) . 'portfolio.css', 'parent-style' );

    wp_register_style( 'gon-slide-compare-style', plugin_dir_url( __FILE__ ) . 'slide-compare.css' );
    wp_enqueue_style( 'gon-slide-compare-style', plugin_dir_url( __FILE__ ) . 'slide-compare.css', 'parent-style' );

	wp_enqueue_script( 'gon-twenty-twenty', plugin_dir_url( __FILE__ ) . 'js/jquery.twentytwenty.js', array('jquery'), null, true );
    wp_enqueue_script( 'gon-mobile-events', plugin_dir_url( __FILE__ ) . 'js/jquery.event.move.js', array('gon-twenty-twenty'), null, true );
    wp_enqueue_script( 'gon-slide-compare', plugin_dir_url( __FILE__ ) . 'slide-compare.js', array('gon-mobile-events'), null, true );

}

add_action( 'wp_enqueue_scripts', 'gon_image_slider_script' );

//custom Gutenberg block
function gon_image_slider_register_custom_blocks() {

    // register an address block.
    acf_register_block_type(array(
        'name'              => 'image-slider-block',
        'title'             => __('Image Comparison Slider'),
        'description'       => __('Select two images for a \'Before / After\' slider.'),
        'render_template'   => plugin_dir_path( __FILE__ ) . 'image-slider-block.php',
        'category'          => 'formatting',
        'icon'              => 'admin-comments',
        'keywords'          => array( 'image-slider', 'GON' ),
    ));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'gon_image_slider_register_custom_blocks');
}


add_shortcode( 'gon-slide-compare', 'gon_image_slider' );
function gon_image_slider($atts){
  
  extract( shortcode_atts( array( 'image1' => '', 'image2' => '', 'width'=>'500px', 'height'=>'500px' ), $atts ) ); 
  $slider = ''; 
  ob_start(); ?>
  <div id="container1" style="width:<?php echo $atts['width']; ?>;height:<?php echo $atts['height']; ?>;">
    <img src="<?php echo $atts['image1'] ?>" style="width:<?php echo $atts['width']; ?>;height:<?php echo $atts['height']; ?>;">
    <img src="<?php echo $atts['image2'] ?>" style="width:<?php echo $atts['width']; ?>;height:<?php echo $atts['height']; ?>;">
  </div>
  <?php $slider = ob_get_clean();
  return $slider;


}



//get custom fields
require_once( plugin_dir_path( __FILE__ ) . 'gon-slide-compare-fields.php' );
