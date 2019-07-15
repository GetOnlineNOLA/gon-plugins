<?php
/*
Plugin Name: GON FAQs
Plugin URI: https://getonlinenola.com/
Description: Adds FAQ post type and [gon-faq-display] shortcode functionality
Version: 1.0
Author: Get Online Nola
*/

//cusom post type for faqs
function create_post_type_gon_cpt_faq() {
  register_post_type( 'gon_cpt_faq',
    array(
      'labels' => array(
        'name' => __( 'FAQs' ),
        'singular_name' => __( 'FAQ' )
      ),
      'public' => true,
      'has_archive' => false,
	  'menu_position' => 5,
	  'capability_type'    => 'post',
	  'rewrite_slug'	    => 'faq',
	  'supports' => array('title', 'editor','page-attributes')
    )
  );
  
}
add_action( 'init', 'create_post_type_gon_cpt_faq' );

//add a shortcode to do the dirty work
add_shortcode( 'gon-faq-display', 'gon_faq_display_function' );

function gon_faq_display_function($atts, $content = null){
	extract(shortcode_atts(array(), $atts));
	$args = array(
		'post_type' => 'gon_cpt_faq',
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'post_status' => 'publish'
	);

	$faq_string = '';
	ob_start();
	$query = new WP_Query( $args );
	if( $query->have_posts() ){
		while( $query->have_posts() ){
			$query->the_post();?>
            <div class="gon-faq faq-pair">
			<a style="text-decoration:none;" href="#">
                <h2 class="entry-title faq-title faq-question">
                <span class="plus">+</span><span class="minus">-</span> <?php the_title();?></h2>
			</a>
			<div class="faq-answer"><?php echo wpautop(get_the_content());?></div>
			</div>
		<?php }
	}
	wp_reset_postdata();
	$faq_string = ob_get_contents();
	ob_end_clean();
	return $faq_string;
}

//add init to footer
function gon_faq_enqueue_script() {
?>
<style>.minus{display:none;}</style>
<script type="text/javascript" defer	>

function gonWaitingFunction(){
	if ( undefined !== window.jQuery ) {
		// script dependent on jQuery
		console.log('document ready plugin jquery too');
		//faq needs to add some javascript to the footer
		jQuery(".faq-pair .faq-answer").css({"display":"none"});
		jQuery("a .faq-title").click(function(e){
			e.preventDefault();
			jQuery(this).children('.plus').toggle();
			jQuery(this).children('.minus').toggle();
			jQuery(this).parent().siblings(".faq-answer").slideToggle(600, 'swing', function(){console.log('i put this here to signal something');});
			jQuery(this).toggleClass("active");
		});
	}
	else{
		console.log('gon waiting function');
		setTimeout(function(){ gonWaitingFunction(); }, 50);
	}
}
gonWaitingFunction();
</script>
<?php	
}
add_action( 'wp_footer', 'gon_faq_enqueue_script' );
