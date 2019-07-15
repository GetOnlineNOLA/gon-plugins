<?php
/*
Plugin Name: GON Logo Slider
Plugin URI: https://getonlinenola.com/
Description: Adds [gon-logo-slider-display] shortcode functionality
Version: 1.0
Author: Get Online Nola
*/
function gon_logo_slider_styles(){
	wp_register_style( 'logo-slider-styles', plugin_dir_url( __FILE__ ) . 'logo-sliders.css' );
	wp_enqueue_style( 'logo-slider-styles', plugin_dir_url( __FILE__ ) . 'logo-sliders.css' );
}

add_action('wp_enqueue_scripts','gon_logo_slider_styles');

function gon_logo_slider_script(){
	wp_enqueue_script( 'logo', plugin_dir_url( __FILE__ ) . 'logo.js', array('cycle') );
	wp_enqueue_script( 'carousel', plugin_dir_url( __FILE__ ) . 'carousel.js', array('cycle') );	
}

add_action('wp_enqueue_scripts','gon_logo_slider_script');

//declare custom Gutenberg block
function gon_logo_slider_register_custom_blocks() {

    // register an address block.
    acf_register_block_type(array(
        'name'              => 'gon-logo-slider',
        'title'             => __('Logo Slider'),
        'description'       => __('A carousel of logos.'),
        'render_template'   => plugin_dir_path( __FILE__ ) . 'logo-slider-block.php',
        'category'          => 'formatting',
        'icon'              => 'admin-comments',
        'keywords'          => array( 'logo-slider', 'GON' ),
    ));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'gon_logo_slider_register_custom_blocks');
}


//logo slider shortcode
function gon_add_logo_slider(){
	$team_string = '';
	ob_start(); ?>
	<div class="col-xs-12 text-center">
        <?php wp_reset_postdata(); if( get_field("slider-title","option") ){ ?><h2 style="margin:1em 0 .25em;" class="logo-title"><?php echo get_field("slider-title","option"); ?></h2><?php } ?>
        <div class="slideshow-controls">
            <a href="#" id="foot-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            <a href="#" id="foot-next"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
        </div>
          <div class="logo-slideshow">
            <?php if( have_rows("repeatable-logos","option") ): while ( have_rows("repeatable-logos","option") ) : the_row();?>
            <a href="<?php the_sub_field("logo-link");?>" class="logo-link" target="_blank"><img src="<?php the_sub_field("logo");?>" class="img-responsive" style="height:100px;width:auto;"/></a>
            <?php endwhile; endif;?>
          </div>
      </div><?php
	$team_string = ob_get_clean();
	return $team_string;
}

add_shortcode('gon-logo-slider','gon_add_logo_slider');


/*LOGO SLIDER CUSTOM FIELDS*/
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
			'page_title' 	=> 'Logo Slider',
			'menu_title'	=> 'Logo Slider',
			'menu_slug' 	=> 'logo-slider',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));	
}

//include custom fields
require_once( plugin_dir_path( __FILE__) .'logo-slider-custom-fields.php' );
