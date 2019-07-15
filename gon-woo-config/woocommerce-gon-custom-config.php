<?php //from https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
add_filter( 'woocommerce_checkout_fields' , 'gon_custom_override_checkout_fields' );
// Our hooked in function - $fields is passed via the filter!
function gon_custom_override_checkout_fields( $fields ) {
	//remove (unset) the billing_company field
    unset($fields['billing']['billing_company']);
    unset($fields['shipping']['shipping_company']);
	// Turning labels into placeholders for the checkout ~ taken from 
	// http://tarikhamilton.com/blog/2016/03/24/create-placeholders-for-woocommerce-fields-from-the-labels-dry/
	// Special Exceptions array
	$exceptions = array(
		'billing_address_1' => 'Street Address',
		'billing_address_2' => 'Apartment, suite, unit etc. (optional)',
		'shipping_address_1' => 'Street Address',
		'shipping_address_2' => 'Apartment, suite, unit etc. (optional)',
		'order_comments' => 'Notes about your order, e.g. special notes for delivery.'
	);
	//automate replacing labels
	foreach ( $fields as &$field_section ) {
		foreach ( $field_section as $field_name => &$field ) { 
			if ( array_key_exists( $field_name, $exceptions ) ) { $field['placeholder'] = $exceptions[$field_name]; } // Check for exceptions
			else { $field['placeholder'] = $field['label']; } //swap placeholder for label
			//unset($field['label']); //instead of unsetting the field labels, we can leave them there for a screen reader's accessibility.
		}
	}
    return $fields;
}
//add_filter( 'woocommerce_product_tabs', 'gon_remove_reviews_count', 98 );


//Removes the "shop" title on the main shop page
add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );
function woo_hide_page_title() {
	return false;
}

//addition of styles to go with these changes
function gon_custom_woocommerce_styles(){
	//register styles
    $parent_style = 'gon-woo-config'; 
	wp_register_style( $parent_style, plugin_dir_url( __FILE__ ) . 'css/gon-woo-config.css' );
    wp_enqueue_style( $parent_style, plugin_dir_url( __FILE__ ) . 'css/gon-woo-config.css');	
	
	//add woo javascript
	wp_enqueue_script( 'woo-js', plugin_dir_url( __FILE__ ) . 'js/gon-woo-js.js', array('jquery','responsive-lightbox-swipebox') );
}

//set to 9 = lower than default priority to load these styles before parent and child 
add_action('wp_enqueue_scripts', "gon_custom_woocommerce_styles", 9); 

function gon_woo_special_styles() {
	wp_register_style( 'woo-special-styles', plugin_dir_url( __FILE__ ) . 'css/gon-woo-special.css', 'parent-style' );
	wp_enqueue_style( 'woo-special-styles', plugin_dir_url( __FILE__ ) . 'css/gon-woo-special.css', 'parent-style' );
}

add_action( 'wp_enqueue_scripts', 'gon_woo_special_styles', 10 );




// change characters on pagination ends
add_filter( 'woocommerce_pagination_args', 	'gon_woo_pagination' );
function gon_woo_pagination( $args ) {
	$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
	$args['next_text'] = '<i class="fa fa-angle-right"></i>';
	return $args;
}

// filter the wc_get_template callback to affect up-sells and cross-sells and related-products
function gon_filter_wc_get_template( $located, $template_name, $args, $template_path, $default_path ) { 
    // make filter magic happen here... 
	//echo $template_name;
	/*if ($template_name == 'single-product/up-sells.php'):
		$located = get_template_directory() . '/gon/gon-woo-config/templates/single-product/up-sells.php';
	endif;*/
	switch ($template_name):
		case 'single-product/up-sells.php':
		  $located = WP_PLUGIN_DIR . '/gon-woo-config/templates/single-product/up-sells.php';
		  break;
		case 'single-product/product-image.php':
		  $located = WP_PLUGIN_DIR . '/gon-woo-config/templates/single-product/product-image.php';
		  break;
		case 'single-product/related.php':
		  $located = WP_PLUGIN_DIR . '/gon-woo-config/templates/single-product/related.php';
		  break;
		case 'single-product/meta.php':
		  $located = WP_PLUGIN_DIR . '/gon-woo-config/templates/single-product/meta.php';
		  break;
		case 'global/quantity-input.php':
		  $located = WP_PLUGIN_DIR . '/gon-woo-config/templates/global/quantity-input.php';
		  break;
		case 'single-product/add-to-cart/simple.php':
		  $located = WP_PLUGIN_DIR . '/gon-woo-config/templates/single-product/add-to-cart/simple.php';
		  break;
		default:
		  $located = $located;
		  break;
	endswitch;
    return $located; 
}; 
         
// add the filter 
add_filter( 'wc_get_template', 'gon_filter_wc_get_template', 10, 5 ); 