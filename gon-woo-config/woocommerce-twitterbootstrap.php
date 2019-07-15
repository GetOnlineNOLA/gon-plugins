<?php
/*
Plugin Name: GON Custom WooCommerce Twitter Bootstrap
Depends: WooCommerce
Plugin URI: 
Description: Adds Customized Twitter Bootstrap Grid to WooCommerce for AJ's Produce. based on the WooCommerce Twitter Bootstrap plugin by Bass Jobsen - http://bassjobsen.weblogs.fm/
Version: 1.1
Author: Faudo
Author URI: http://faudo.com
License: GPLv2

/*  Copyright 2013 Bass Jobsen (email : bass@w3masters.nl)
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA*/

/* Check if WooCommerce is active*/
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
// Put your plugin code here
die('install Woocommerce First');//
}

//first, some config for this version of gon_wootb
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
/////////////////////config follows//////////////////////
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////

//include our custom config file
include( WP_PLUGIN_DIR . '/gon-woo-config/woocommerce-gon-custom-config.php');

//custom image thumbnail size
add_image_size( 'large-square', 500, 500, array( 'center', 'center' ) );
add_image_size( 'bootstrap-list-product', 500, 250, false );//300 is max-height to scale to

//remove the built in woo commerce wrapping html structure
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

//shop wrapper functions have been removed above.. then declare new ones based on BS
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
//functions are referenced below according to settings

//thefollowing hides the notice about woocommerce support in this theme
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
//remove woocommerce styles
add_filter( 'woocommerce_enqueue_styles', 'gon_dequeue_styles' );
function gon_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}

//and enqueue new version that won't be overwritten
function wp_enqueue_woocommerce_style(){
	//wp_register_style( 'mytheme-woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );
	//wp_register_style( 'mytheme-woocommerce', get_template_directory_uri() . '/css/woocommerce-layout.css' );
	//wp_register_style( 'mytheme-woocommerce', get_template_directory_uri() . '/css/woocommerce-smallscreen.css' );
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'mytheme-woocommerce' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );


/*add_action('woocommerce_before_cart', 'gon_woocommerce_before_cart_bs');
function gon_woocommerce_before_cart_bs(){echo'<div class="col-md-2 hidden-sm">&nbsp;</div><div class="col-xs-12 col-md-8 solid-white-bg cart-page text-center"><div class="entry-content"><h1>Cart</h1></div>';}
add_action('woocommerce_after_cart', 'gon_woocommerce_after_cart_bs');
function gon_woocommerce_after_cart_bs(){echo'</div><div class="col-md-2 hidden-sm">&nbsp;</div>';}*/

function gon_alter_woo_hooks(){
	// Remove the product rating display on product loops
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	// remove the add to cart button on product archive loop
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
	//remove related products
	add_filter('woocommerce_related_products_args','gon_remove_related_products', 10);
}
add_action('plugins_loaded','gon_alter_woo_hooks');


function gon_remove_related_products( $args ) {
	return array();
}

/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
//////config is done, the main Class follows/////////////
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////

if(!class_exists('WooCommerce_Twitter_Bootstrap')) {
	class WooCommerce_Twitter_Bootstrap{	
		/*Construct the plugin object*/ 
		public function __construct() { 
			load_plugin_textdomain( 'wootb', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
			// register actions 
			add_action('admin_init', array(&$this, 'admin_init')); 
			add_action('admin_menu', array(&$this, 'add_menu')); 
			add_filter( 'init', array(&$this, 'init' ) );
			
			$plugin = plugin_basename(__FILE__); 
			add_filter("plugin_action_links_$plugin", array( $this,'plugin_settings_link')); 
		} 
		// END public 
		
		function init(){
			remove_shortcode( 'sale_products' );//
			add_shortcode( 'sale_products_bs', array(&$this, 'sale_products' ));
			remove_shortcode( 'featured_products' );//
			add_shortcode( 'featured_products_bs', array(&$this, 'featured_products' ));
			remove_shortcode( 'recent_products' );
			add_shortcode( 'recent_products_bs', array(&$this, 'recent_products' ));
			/*add_action( 'wp_enqueue_scripts', array(&$this, 'woocommerce_twitterbootstrap_setstylesheets'), 99 );*/
			add_action( 'shop_loop', array($this, 'bs_shop_loop'), 99 );
			add_action( 'woocommerce_before_single_product_summary', array(&$this, 'woocommerce_before_single_product_summary_bs'), 1 );
			add_action( 'woocommerce_before_single_product_summary', array(&$this, 'woocommerce_before_single_product_summary_bs_end'), 100 );
			add_action( 'woocommerce_after_single_product_summary', array(&$this, 'woocommerce_after_single_product_summary_bs'), 1 );
			/* thumbnails*/
			add_action('bs_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',10);
			//add_action( 'woocommerce_before_single_product_summary', array(&$this, 'bs_get_product_thumbnail'), 1 );
			//added the below to remove the image from the loop - it's getting called and treaed in functions further down the page,
			//so no need for duplicates, especially since they weren't img-responsive
			//image gallery shown by below
			//remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			add_action('bs_before_shop_loop_item_title',array(&$this, 'bs_get_product_thumbnail'),10,3);
			add_action('woocommerce_after_shop_loop',array(&$this, 'endsetupgrid'),1);
			add_action('woocommerce_before_shop_loop',array(&$this, 'setupgrid'),999);
			/* the grid display*/
			/*
			|  	columns		| mobile 	| tablet 	| desktop	|per page 	|
			----------------------------------------------------|-----------|
			|		1		|	1		|	1		|	1		| 	10		|
			|---------------------------------------------------|-----------|
			|		2		|	1		|	2		|	2		|	10		|
			|---------------------------------------------------|-----------|
			|		3		|	1		|	1		|	3		|	 9		|
			|---------------------------------------------------|-----------|
			|		3(1)	|	1		|	2		|	3		|	12		|
			|---------------------------------------------------|-----------|
			|		4		|	1		|	2		|	4		|	12		|
			|---------------------------------------------------|-----------|
			|		5		|	n/a		|	n/a		|	n/a		|	n/a	    |
			|---------------------------------------------------|-----------|
			|		6		|	2		|	4		|	6		|	12		|
			|---------------------------------------------------|-----------|
			|		>=6		|	n/a		|	n/a		|	n/a		|	n/a		|
			|---------------------------------------------------------------|*/
			// Store column count for displaying the grid
			global $woocommerce_loop;
			if ( empty( $woocommerce_loop['columns'] ) )
			{
			$woocommerce_loop['columns'] = get_option('number_of_columns', 4 );	
			}
			if($woocommerce_loop['columns']==3)
			{
				add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 10 );
			}	
			elseif($woocommerce_loop['columns']>2)
			{
				add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 10 );
			}
			define('WooCommerce_Twitter_Bootstrap_grid_classes', $this->get_grid_classes($woocommerce_loop));
			
			//based on the options page, settings for woocommerce default setups:
			$breadcrumbs = get_option('breadcrumbs');
			if( empty($breadcrumbs) || ($breadcrumbs !== 'breadcrumbs')){
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			}
			$resultcount = get_option('resultcount');
			if( empty($resultcount) || ($resultcount !== 'resultcount')){
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}
			$catalogordering = get_option('catalogordering');
			if( empty($catalogordering) || ($catalogordering !== 'catalogordering')){ //remove catalog ordering
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}
			$sidebar = get_option('optradio');
			if( empty($sidebar) || ($sidebar !== 'optradio')){ //set sidebar position
				if(!function_exists('my_theme_wrapper_start')){
					function my_theme_wrapper_start(){
						$col_count = 9; //default size - assuming sidebar required
						$pull = 'pull-right'; // assuming default position should be sidebar left, hence content pulled right
						if(get_option('optradio') == 'left_sidebar'){}
						if(get_option('optradio') == 'right_sidebar'){$pull = 'pull-left';}
						if(get_option('optradio') == 'no_sidebar'){$col_count = 12;$pull = '';}
						echo '<div class="container"><div clas="row"><div class="col-sm-'.$col_count.' '.$pull.'"><div class="gon-shop"><section id="main" class="entry-content" >';
					}
				}
				
				if(!function_exists('my_theme_wrapper_end')){
					function my_theme_wrapper_end(){
						echo '</section></div></div>';	
						if(get_option('optradio') !== 'no_sidebar'){
							//set an alternative to default sidebar
							$sidebar_content = '';
							ob_start();
							?><div class="col-sm-3 <?php if(get_option('optradio') == 'right_sidebar'){echo 'pull-right';}?>"><?php
							echo wc_get_template( 'global/sidebar.php' );
							echo '</div></div></div>';
							$sidebar_content = ob_get_contents();
						} else {
							echo '</div></div>';
						}
					}
				}
				
			}
			$tabs_description = get_option('tabs_description');
			if( empty($tabs_description) || ($tabs_description !== 'tabs_description')){ //editing the product details informaiton, removal of reviews
				function woo_remove_product_tabs_description( $tabs ) { 
					unset( $tabs['description'] );//Remove the description tab
					return $tabs;
				}
				add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs_description', 98 );
			}
			$tabs_reviews = get_option('tabs_reviews');
			if( empty($tabs_reviews) || ($tabs_reviews !== 'tabs_reviews')){ //editing the product details informaiton, removal of reviews
				function woo_remove_product_tabs_reviews( $tabs ) { 
					unset( $tabs['reviews'] ); 			// Remove the reviews tab
					return $tabs;
				}
				add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs_reviews', 98 );
			}
			$tabs_additional_information = get_option('tabs_additional_information');
			if( empty($tabs_additional_information) || ($tabs_additional_information !== 'tabs_additional_information')){ //editing the product details informaiton, removal of reviews
				function woo_remove_product_tabs_additional_information( $tabs ) { 
					unset( $tabs['additional_information'] );  	 //Remove the additional information tab
					return $tabs;
				}
				add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs_additional_information', 98 );
			}
		}
		
		/* Activate the plugin*/ 
		public static function activate(){
			// Do nothing 
		} 
		// END public static function activate 
		/* Deactivate the plugin **/ 
		public static function deactivate() { 
			// Do nothing 
		} 
		// END public static function deactivate 
		/* hook into WP's admin_init action hook*/ 
		public function admin_init(){
			// Set up the settings for this plugin 
			$this->init_settings(); 
			// Possibly do additional admin_init tasks 
		} 
		// END public static function activate - See more at: http://www.yaconiello.com/blog/how-to-write-wordpress-plugin/#sthash.mhyfhl3r.JacOJxrL.dpuf
		
		/* Initialize some custom settings*/ 
		public function init_settings() {
			// register the settings for this plugin 
			register_setting('woocommerce-twitterbootstrap-group', 'number_of_columns'); 
			register_setting('woocommerce-twitterbootstrap-group', 'breadcrumbs'); 
			register_setting('woocommerce-twitterbootstrap-group', 'resultcount'); 
			register_setting('woocommerce-twitterbootstrap-group', 'catalogordering'); 
			register_setting('woocommerce-twitterbootstrap-group', 'tabs_description'); 
			register_setting('woocommerce-twitterbootstrap-group', 'tabs_reviews'); 
			register_setting('woocommerce-twitterbootstrap-group', 'tabs_additional_information'); 
			register_setting('woocommerce-twitterbootstrap-group', 'optradio');
			register_setting('woocommerce-twitterbootstrap-group', 'wootb_size'); 
			register_setting('woocommerce-twitterbootstrap-group', 'wootb_size_special'); 
		} // END public function init_custom_settings()
		
		/* add a menu*/ 
		public function add_menu() {
			 add_options_page('GON Woo Config', 'WooCommerce Bootstrap', 'manage_options', 'woocommerce-twitterbootstrap', array(&$this, 'plugin_settings_page'));
		} // END public function add_menu() 
		
		/* Menu Callback*/ 
		public function plugin_settings_page() { 
			if(!current_user_can('manage_options')) 
			{
				wp_die(__('You do not have sufficient permissions to access this page.'));
			} // Render the settings template 
			//include(sprintf("%s/templates/settings.php", dirname(__FILE__))); 
			$this->showform();
		} // END public function plugin_settings_page() 
		
		function showform(){
			?><div class="wrap"> 
			<h2>GON Woo Config<?php echo __('Settings','wootb');?></h2> 
			<form method="post" action="options.php"> 
			<?php settings_fields('woocommerce-twitterbootstrap-group'); ?> 
			<table class="form-table"> 
			<tr valign="top"> 
			<th scope="row">
			<label for="setting_a"><?php echo __('Number of columns per row','wootb');?></label></th> 
			<td>
				<select name="number_of_columns" id="number_of_columns">
				<?php $numberofcolumns = (get_option('number_of_columns'))?get_option('number_of_columns'):4;
				foreach(array(1,2,3,4,6) as $number)
				{
					?><option value="<?php echo $number ?>" <?php echo ($numberofcolumns==$number)?' selected="selected"':''?>><?php echo $number ?></option><?php
				}	
				?>
				</select>
			</td> 
			</tr>
			<tr valign="top"> 
			<th scope="row">
			<label for="breadcrumbs"><?php echo __('Include Breadcrumbs?','wootb');?></label></th> 
			<td>
				<?php
				$breadcrumbs = (get_option('breadcrumbs'))?get_option('breadcrumbs'):'';
				?>
				<input type="checkbox" value="breadcrumbs" name="breadcrumbs" <?php echo ($breadcrumbs)?' checked="checked"':''?>><!--Checked = Include Breadcrumbs--><br>
			</td> 
			</tr>
			<tr valign="top"> 
			<th scope="row">
			<label for="resultcount"><?php echo __('Include Result Count?','wootb');?></label></th> 
			<td>
				<?php
				$resultcount = (get_option('resultcount'))?get_option('resultcount'):'';
				?>
				<input type="checkbox" value="resultcount" name="resultcount" <?php echo ($resultcount)?' checked="checked"':''?>><!--Checked = Include Result Count--><br>
			</td> 
			</tr>
			<tr valign="top"> 
			<th scope="row">
			<label for="catalogordering"><?php echo __('Include Catalog Ordering?','wootb');?></label></th> 
			<td>
				<?php
				$catalogordering = (get_option('catalogordering'))?get_option('catalogordering'):'';
				?>
				<input type="checkbox" value="catalogordering" name="catalogordering" <?php echo ($catalogordering)?' checked="checked"':''?>><!--Checked = Include Result Count--><br>
			</td> 
			</tr>
			<tr valign="top"> 
			<th scope="row">
			<label for="tabs_description"><?php echo __('Include Description Tab?','wootb');?></label></th> 
			<td>
				<?php
				$tabs_description = (get_option('tabs_description'))?get_option('tabs_description'):'';
				?>
				<input type="checkbox" value="tabs_description" name="tabs_description" <?php echo ($tabs_description)?' checked="checked"':''?>><!--Checked = Include Result Count--><br>
			</td> 
			</tr>
			<tr valign="top"> 
			<th scope="row">
			<label for="tabs_reviews"><?php echo __('Include Review Tab?','wootb');?></label></th> 
			<td>
				<?php
				$tabs_reviews = (get_option('tabs_reviews'))?get_option('tabs_reviews'):'';
				?>
				<input type="checkbox" value="tabs_reviews" name="tabs_reviews" <?php echo ($tabs_reviews)?' checked="checked"':''?>><!--Checked = Include Result Count--><br>
			</td> 
			</tr>
			<tr valign="top"> 
			<th scope="row">
			<label for="tabs_additional_information"><?php echo __('Include Additional Information Tab?','wootb');?></label></th> 
			<td>
				<?php
				$tabs_additional_information = (get_option('tabs_additional_information'))?get_option('tabs_additional_information'):'';
				?>
				<input type="checkbox" value="tabs_additional_information" name="tabs_additional_information" <?php echo ($tabs_additional_information)?' checked="checked"':''?>><!--Checked = Include Result Count--><br>
			</td> 
			</tr>
			<tr valign="top"> 
			<th scope="row">
			<label for="tabs_additional_information"><?php echo __('Include Additional Information Tab?','wootb');?></label></th> 
			<td>
				<?php
				$tabs_additional_information = (get_option('tabs_additional_information'))?get_option('tabs_additional_information'):'';
				?>
				<input type="checkbox" value="tabs_additional_information" name="tabs_additional_information" <?php echo ($tabs_additional_information)?' checked="checked"':''?>><!--Checked = Include Result Count--><br>
			</td> 
			</tr>
             <tr>
                 <td style="width:30%;">
                     <div class="radio">
						<?php $optradio = (get_option('optradio'))?get_option('optradio'):'no_sidebar'; ?>
                         <label><input type="radio" id='no_sidebar' value='no_sidebar' name="optradio"<?php echo ($optradio=='no_sidebar')?' checked="checked"':''?>>No Sidebar</label>
                    </div>
                 </td>
                 <td style="width:30%;">
                     <div class="radio">
                         <label><input type="radio" id='left_sidebar' value='left_sidebar' name="optradio"<?php echo ($optradio=='left_sidebar')?' checked="checked"':''?>>Left Sidebar</label>
                     </div>
                 </td>
                 <td style="width:30%;">
                     <div class="radio">
                         <label><input type="radio" id='right_sidebar' value='right_sidebar' name="optradio"<?php echo ($optradio=='right_sidebar')?' checked="checked"':''?>>Right Sidebar</label>
                     </div>
                 </td>
             </tr>
			<tr valign="top"> 
			<th scope="row">
			<label for="wootb_size">!! --- This section is not yet reliable on front end --- !! <br>
<?php echo __('Shop Loop Image Size','wootb');?></label></th> 
			<td>
			<p><?php echo __('Either a string keyword (thumbnail, medium, large or full & check functions file for additional custom names/sizes) or a 2-item array representing width and height in pixels, e.g. array(32,32).','wootb');?></p>	
				<?php $wootb_size = (get_option('wootb_size'))?get_option('wootb_size'):'medium';?>
				<input type="text" value="<?php echo $wootb_size; ?>" name="wootb_size" id="wootb_size">
			</td> 
			</tr> 
			<tr valign="top"> 
			<th scope="row">
			<label for="wootb_size"><?php echo __('Single Page Image Size','wootb_special');?></label></th> 
			<td><p><?php echo __('<strong>Front page image size</strong> Either a string keyword (thumbnail, medium, large or full & check functions file for additional custom names/sizes) or a 2-item array representing width and height in pixels, e.g. array(32,32).','wootb_special');?></p>	
				<?php $wootb_size_special = (get_option('wootb_size_special'))?get_option('wootb_size_special'):'medium';?>
				<input type="text" value="<?php echo $wootb_size_special; ?>" name="wootb_size_special" id="wootb_size_special">
			</td> 
			</tr> 
			</table> 
			<?php submit_button(); ?> </form> 
			</div>
			<?php
		}
		
		/* Output featured products *
		 * @access public
		 * @param array $atts
		 * @return string*/
		function featured_products( $atts ) {
			extract(shortcode_atts(array(
				'per_page' => 12,
				'columns' => 4,
				'orderby' => 'date',
				'order' => 'desc',
				'content_product_template' => 'bs-content-product'
				), $atts));
		
			$args = array(
				'post_type'=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'=> 1,
				'posts_per_page' => $per_page,
				'orderby' => $orderby,
				'order' => $order,
				'meta_query' => array(
					array(
					'key' => '_visibility',
					'value' => array('catalog', 'visible'),
					'compare' => 'IN'
					),
					array(
					'key' => '_featured',
					'value' => 'yes'
					)
				)
			);
			return $this->showproductspeciallist($args,$content_product_template,$columns);
		}
		/* On Sale Products shortcode *
		 * @access public
		 * @param array $atts
		 * @return string*/
		public function sale_products( $atts ){
			extract( shortcode_atts( array(
					'per_page'      => '12',
					'columns'       => '4',
					'orderby'       => 'title',
					'order'         => 'asc',
					'content_product_template' => 'bs-content-product'
					), $atts ) );
			// Get products on sale
			$product_ids_on_sale = woocommerce_get_product_ids_on_sale();
			$meta_query = array();
			$args = array(
				'posts_per_page'=> $per_page,
				'orderby' 		=> $orderby,
				'order' 		=> $order,
				'no_found_rows' => 1,
				'post_status' 	=> 'publish',
				'post_type' 	=> 'product',
				'orderby' 		=> 'date',
				'order' 		=> 'ASC',
				'meta_query' 	=> $meta_query,
				'post__in'		=> $product_ids_on_sale
			);	
			return $this->showproductspeciallist($args,$content_product_template,$columns);
		}
		/* Recent Products shortcode *
		 * @access public
		 * @param array $atts
		 * @return string*/
		public function recent_products( $atts ){
			global $woocommerce;
			
			extract(shortcode_atts(array(
			'per_page' => '12',
			'columns' => '4',
			'orderby' => 'date',
			'order' => 'desc',
			'content_product_template' => 'bs-content-product'
			), $atts));
			
			$meta_query = $woocommerce->query->get_meta_query();
			
			$args = array(
			'post_type'=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'=> 1,
			'posts_per_page' => $per_page,
			'orderby' => $orderby,
			'order' => $order,
			'meta_query' => $meta_query
			);	
			
			return $this->showproductspeciallist($args,$content_product_template,$columns);
		}
		
		function showproductspeciallist($args,$content_product_template,$columns=null)
		{
				
			global $woocommerce_loop;	
			ob_start();
			
			$products= new WP_Query( $args );
			
			$woocommerce_loop['columns'] = ($columns)?$columns:get_option( 'number_of_columns', 4 );
			
			if ( $products->have_posts() ) 
			{
			$this->bs_shop_loop($products,$content_product_template,$columns);	
			}
			
			wp_reset_postdata();
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';
		}
		
		/*function woocommerce_twitterbootstrap_setstylesheets()
		{
			wp_register_style ( 'woocommerce-twitterbootstrap', plugins_url( 'css/woocommerce-twitterboostrap.css' , __FILE__ ), 'woocommerce' );
			wp_enqueue_style ( 'woocommerce-twitterbootstrap');
		}*/
		function get_grid_classes($woocommerce_loop){
		/* the grid display*/
		/*
		|  	columns		| mobile 	| tablet 	| desktop	|per page 	|
		----------------------------------------------------|-----------|
		|		1		|	1		|	1		|	1		| 	10		|
		|---------------------------------------------------|-----------|
		|		2		|	1		|	2		|	2		|	10		|
		|---------------------------------------------------|-----------|
		|		3		|	1		|	1		|	3		|	9		|
		|---------------------------------------------------|-----------|
		|		4		|	1		|	2		|	4		|	12		|
		|---------------------------------------------------|-----------|
		|		5		|	n/a		|	n/a		|	n/a		|	n/a	    |
		|---------------------------------------------------|-----------|
		|		6		|	2		|	4		|	6		|	12		|
		|---------------------------------------------------|-----------|
		|		>=6		|	n/a		|	n/a		|	n/a		|	n/a		|
		|---------------------------------------------------------------|
		**/
		
		/* the grid display Twitter's Bootstrap 2.x*/
		/*
		|  	columns		| mobile / tablet| desktop	|per page |
		------------------------------------------------------|
		|		1		|	1		     |	1		| 	10	  |
		|-----------------------------------------------------|
		|		2		|	1		     |	2	    |	10	  |
		|-----------------------------------------------------|
		|		3		|	1			 |	3		|	9     |
		|-----------------------------------------------------|
		|		4		|	1		     |	4	    |   12	  |
		|-----------------------------------------------------|
		|		5		|	n/a		     |	n/a		|	n/a	  |	
		|-----------------------------------------------------|
		|		6		|	2		     |	4		|	12	  |
		|-----------------------------------------------------|
		|		>=6		|	n/a		     |	n/a		|	n/a	  |	
		|-----------------------------------------------------|
		**/
			switch($woocommerce_loop['columns'])
			{
				case 6: $classes = 'col-xs-6 col-sm-3 col-md-2 gon'; break;
				case 4: $classes = 'col-xs-12 col-sm-6 col-md-3 gon'; break;
				case 3: $classes = 'col-xs-12 col-sm-12 col-md-4 gon'; break;
				case 31: $classes = 'col-xs-12 col-sm-6 col-md-4 gon'; break;
				case 2: $classes = 'col-xs-12 col-sm-6 col-md-6 gon'; break;
				default: $classes = 'col-xs-12 col-sm-12 col-md-12 gon';
			}
			return $classes;
		}
		
		function bs_product_loop(&$woocommerce_loop,$classes,$template='bs-content-product')
		{	
			$template = get_template_directory_uri() . '/gon/gon-custom-woocommerce-twitterbootstrap-master/templates/'.$template.'.php';
			$filename = $template;
			$file_headers = @get_headers($filename);
			
			/*if($file_headers[0] == 'HTTP/1.0 404 Not Found'){
				  echo "The file $filename does not exist";
			} else if ($file_headers[0] == 'HTTP/1.0 302 Found' && $file_headers[7] == 'HTTP/1.0 404 Not Found'){
				echo "The file $filename does not exist, and I got redirected to a custom 404 page..";
			} else {
				echo "The file $filename exists";
			}*/
			
			if(!file_exists( $template ))
			{
				 //$template = WP_PLUGIN_DIR.'/'.str_replace( basename( __FILE__), "", plugin_basename(__FILE__) ).'templates/bs-content-product.php';
				 //from: http://wordpress.stackexchange.com/questions/119064/what-should-i-use-instead-of-wp-content-dir-and-wp-plugin-dir
				 $template = plugin_dir_path( __FILE__ ). 'templates/bs-content-product.php';
			}
			include($template);
			if($woocommerce_loop['columns'] == 6) 
			{
				if(0 == ($woocommerce_loop['loop'] % 6)){?><div class="clearfix visible-md visible-lg"></div><?php }
				if(0 == ($woocommerce_loop['loop'] % 4)){?><div class="clearfix visible-sm"></div><?php }
				if(0 == ($woocommerce_loop['loop'] % 2)){?><div class="clearfix visible-xs"></div><?php }
			}	
			elseif($woocommerce_loop['columns'] == 4) 
			{
				if(0 == ($woocommerce_loop['loop'] % 4)){?><div class="clearfix visible-md visible-lg"></div><?php }
				if(0 == ($woocommerce_loop['loop'] % 2)){?><div class="clearfix visible-sm"></div><?php }
			}
			elseif($woocommerce_loop['columns'] == 3) 
			{
				if(0 == ($woocommerce_loop['loop'] % 3)){?><div class="clearfix visible-md visible-lg"></div><?php }
			}
			elseif($woocommerce_loop['columns'] == 31) 
			{
				if(0 == ($woocommerce_loop['loop'] % 3)){?><div class="clearfix visible-md visible-lg"></div><?php }
				if(0 == ($woocommerce_loop['loop'] % 2)){?><div class="clearfix visible-sm"></div><?php }
			}
			elseif($woocommerce_loop['columns'] == 2) 
			{
				if(0 == ($woocommerce_loop['loop'] % 2)){?><div class="clearfix invisible-xs"></div><?php }
			}
			$woocommerce_loop['loop']++;
		}
		
		function bs_shop_loop($product=null,$template='bs-content-product',$columns=null){
			$woocommerce_loop = array('loop'=>0,'columns' => ($columns)?$columns:get_option( 'number_of_columns', 4 ));	
			/* double check*/
			if($woocommerce_loop['columns']!=31 && ( $woocommerce_loop['columns']>6 || in_array($woocommerce_loop['columns'],array(5,7)))) { return; }
			// Increase loop count
			$woocommerce_loop['loop']++;
			ob_start();
			woocommerce_product_subcategories(array('before'=>'<div class="clearfix"></div><div class="subcategories"><div class="row">','after'=>'</div></div>')); 
			$subcategories = ob_get_contents();
			ob_end_clean();
			$classes = $this->get_grid_classes($woocommerce_loop);
			echo preg_replace(array('/<li[^>]*>/','/<\/li>/'),array('<div class="'.$classes.'">','</div>'),$subcategories);
			if($product)//not sure what qualifies an entry as a product
			{
				?><div class="clearfix"></div><div class="products"><div class="row"><?php
				while ( $product->have_posts()) : $product->the_post(); 
				$this->bs_product_loop($woocommerce_loop,$classes,$template);
				endwhile;
			}	
			else //this seems to be default...
			{
				?><!--<div class="clearfix"></div>-->
                <div class="products">
                    <div class="row"><?php
				while ( have_posts() ) : the_post(); 
				$this->bs_product_loop($woocommerce_loop,$classes);
				endwhile;
			}				
			if($woocommerce_loop['columns']==31)$woocommerce_loop['columns']=3;
			if ( 0 != ($woocommerce_loop['loop']-1) % $woocommerce_loop['columns'] )
			{
			?><div class="<?php echo $classes?>"></div><?php		
				while ( 0 != $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
				{
					$woocommerce_loop['loop']++;
					?><div class="<?php echo $classes?>"></div><?php
				}
			}		
			?>		  </div><!-- closes .row-->
              	  </div><!-- closes .products--><?php
		}
		
		/* Output the start of the page wrapper. *
		 * @access public
		 * @return void*/
		function woocommerce_output_content_wrapper_bs() {
			//woocommerce_get_template( 'shop/wrapper-start.php' );
		}
		
		/* Output the end of the page wrapper. *
		 * @access public
		 * @return void*/
		function woocommerce_output_content_wrapper_end_bs() {
			//woocommerce_get_template( 'shop/wrapper-end.php' );
		}
		
		//single product page markup adjustments governed by the below
		
		function woocommerce_before_single_product_summary_bs() {	
			echo '<div class="row"><div class="col-sm-6 bssingleproduct">'; 
		}
		
		function woocommerce_before_single_product_summary_bs_end(){
			echo '</div><div class="col-sm-6 bssingleproduct">'; 
		}
		
		function woocommerce_after_single_product_summary_bs(){ 
			echo '</div>	</div>'; 
			remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);
			//set an alternative sidebar in wrapped functions at top of page ^^
		}
		
		function bs_get_product_thumbnail(){
			global $post;
			$wootb_size = get_option( 'wootb_size', 'medium');
			$wootb_size_special = get_option( 'wootb_size_special', 'medium');
			
			if(preg_match('/array\(.+\);?/',$wootb_size))
				{
					eval('$wootb_size='.str_replace(';','',$wootb_size).';');
				}
			if(preg_match('/array\(.+\);?/',$wootb_size_special))
				{
					eval('$wootb_size_special='.str_replace(';','',$wootb_size_special).';');
				}
			//set thumbnail size to either woo tb size field, or to woo tb size special field, for front page only
			if(is_front_page()){$thumbnail = get_the_post_thumbnail($post->ID,$wootb_size_special );}
			else{$thumbnail = get_the_post_thumbnail($post->ID,$wootb_size );}
			
			if(empty($thumbnail))
				{
					if(!file_exists( $template = get_stylesheet_directory() . '/woocommerce-twitterbootstrap/placeholder.php' ))
					{
						 //$template = WP_PLUGIN_DIR.'/'.str_replace( basename( __FILE__), "", plugin_basename(__FILE__) ).'templates/placeholder.php';
						 $template = plugin_dir_path( __FILE__ ). 'templates/placeholder.php';
					}	
					include($template);
					return;
				}
				
			$doc = new DOMDocument();
			$doc->loadHTML('<?xml encoding="'.DB_CHARSET.'">' . $thumbnail );
			$images = $doc->getElementsByTagName('img');
			foreach ($images as $image) {
			$image->setAttribute('class',$image->getAttribute('class').' img-responsive');
			$image->removeAttribute('height');
			$image->setAttribute('width', '100%');//set the image in the loop to have width:100%
			//$image->removeAttribute('width');
			//see: http://stackoverflow.com/questions/6321481/printing-out-html-content-from-domelement-using-nodevalue
			echo $doc->saveXML($image); break;
		}
		
		}	
					
		function setupgrid(){
			ob_start();
		}

		function endsetupgrid(){
			ob_end_clean();
			$this->bs_shop_loop();
			remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);
		}
		
		function plugin_settings_link($links) { 
			$settings_link = '<a href="options-general.php?page=woocommerce-twitterbootstrap">Settings</a>';
			array_unshift($links, $settings_link); 
			return $links; 
		} 
	} // END class
}

if(class_exists('WooCommerce_Twitter_Bootstrap')) 
{ // Installation and uninstallation hooks 
	register_activation_hook(__FILE__, array('WooCommerce_Twitter_Bootstrap', 'activate')); 
	register_deactivation_hook(__FILE__, array('WooCommerce_Twitter_Bootstrap', 'deactivate')); 
	
	new WooCommerce_Twitter_Bootstrap();
}


