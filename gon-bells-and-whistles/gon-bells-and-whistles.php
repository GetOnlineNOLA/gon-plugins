<?php
/**
 * Plugin Name: gon-bells-and-whistle
 * Plugin URI: http://getonlinenola.com/
 * Description: A collection of javascript features!
 * Author: Fau-Do
 * Version: 1.0.0
 * Author URI: http://getonlinenola.com/
 * License: Completely restricted to getonlinenola.com, not for use elsewhere.
 */


if ( ! function_exists( 'gon_enqueue_javascript_styles' ) ) {
	function gon_enqueue_javascript_styles(){
		wp_register_style('features-css', plugin_dir_url( __FILE__ ) . 'css/features.css');
		wp_enqueue_style('features-css', plugin_dir_url( __FILE__ ) . 'css/features.css');
	}

	add_action('wp_enqueue_scripts', 'gon_enqueue_javascript_styles', 11);
}

if ( ! function_exists( 'gon_enqueue_javascript_scripts' ) ) {
	function gon_enqueue_javascript_scripts(){
		wp_enqueue_script('js-features', plugin_dir_url( __FILE__ ) . 'js/features.js', array('jquery'), '1.0', true );
	}

	add_action('wp_enqueue_scripts', 'gon_enqueue_javascript_scripts');
}

require_once( plugin_dir_path( __FILE__ ) . 'gon-bells-and-whistles-custom-fields.php' );

?>