<?php
/*
Plugin Name: GON Accordion Block
Plugin URI: https://getonlinenola.com/
Description: Adds custom gutenburg block for an accordion Q&A
Version: 1.0
Author: Get Online Nola
*/

//declare custom Gutenberg block
function gon_accordion_register_custom_blocks() {

    // register an address block.
    acf_register_block_type(array(
        'name'              => 'gon-accordion',
        'title'             => __('Q&A Accordion'),
        'description'       => __('A Q&A Accordion.'),
        'render_template'   => plugin_dir_path( __FILE__ ) . 'accordion-block.php',
        'category'          => 'formatting',
        'icon'              => 'admin-comments',
        'keywords'          => array( 'accordion', 'GON' ),
    ));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'gon_accordion_register_custom_blocks');
}


//get custom fields
require_once( plugin_dir_path( __FILE__ ) . 'accordion-custom-fields.php' );



//add jQuery and style to footer
function gon_accordion_enqueue_script() {
?>
<style>.minus{display:none;}</style>
<script type="text/javascript" defer	>


function gonAccordionFunction(){
	if ( undefined !== window.jQuery ) {
		// script dependent on jQuery
		console.log('document ready plugin jquery too');
		//faq needs to add some javascript to the footer
		jQuery(".accordion-pair .accordion-answer").css({"display":"none"});
		jQuery("a .accordion-title").click(function(e){
			e.preventDefault();
			jQuery(this).children('.plus').toggle();
			jQuery(this).children('.minus').toggle();
			jQuery(this).parent().siblings(".accordion-answer").slideToggle(600, 'swing', function(){console.log('i put this here to signal something');});
			jQuery(this).toggleClass("active");
		});
	}
	else{
		console.log('gon waiting function');
		setTimeout(function(){ gonWaitingFunction(); }, 50);
	}
}


gonAccordionFunction();

</script>
<?php	
}
add_action( 'wp_footer', 'gon_accordion_enqueue_script' );

