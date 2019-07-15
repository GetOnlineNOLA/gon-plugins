<?php
/*
Plugin Name: GON Meet the Team +
Plugin URI: https://getonlinenola.com/
Description: A Meet the Team grid with added functionality
Version: 1.0
Author: Get Online Nola
*/
//add team grid to site - 

//with the team post type

function create_post_type_gon_team() {
  register_post_type( 'gon_team',
    array(
      'labels' => array(
        'name' => __( 'Meet the Team' ),
        'singular_name' => __( 'Team Member' )
      ),
      'public' => true,
      'has_archive' => true,
	'menu_icon' => 'dashicons-groups',
	  'menu_position' => 5,
	  'capability_type'    => 'post',
	  'supports' => array('title', 'editor','page-attributes','thumbnail'),
	  'rewrite' => array( 'slug' => 'meet-the-team' )
    )
  );
  
	//add product-type tax
	
	register_taxonomy(
		'teamcategory',
		'gon_team',
		array(
			'label' => __( 'Team Category' ),
			'rewrite' => array( 'slug' => 'team-category' ),
			'hierarchical' => true,
		)
	);
}
add_action( 'init', 'create_post_type_gon_team' );

//register style
function gon_team_plus_style() {
	wp_register_style( 'gon-team-plus-style', plugin_dir_url( __FILE__ ) . 'team.css' );
	wp_enqueue_style( 'gon-team-plus-style', plugin_dir_url( __FILE__ ) . 'team.css' );
}
add_action( 'wp_enqueue_scripts', 'gon_team_plus_style' );


//custom Gutenberg block
function gon_team_register_custom_blocks() {

    // register an address block.
    acf_register_block_type(array(
        'name'              => 'team-block',
        'title'             => __('Team Grid'),
        'description'       => __('A grid of team members.'),
        'render_template'   => plugin_dir_path( __FILE__ ) . 'team-block.php',
        'category'          => 'formatting',
        'icon'              => 'admin-comments',
        'keywords'          => array( 'meet-the-team', 'GON' ),
    ));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'gon_team_register_custom_blocks');
}

//load custom fields
require_once( plugin_dir_path( __FILE__ ) . 'team-custom-fields.php' );

//add a shortcode to do the dirty work
add_shortcode( 'gon-team-display', 'gon_team_display_function' );
function gon_team_display_function($atts, $content = null){
	extract(shortcode_atts(array('cols' => '4', 'description' => true, 'link' => true, 'teamcategory' => false), $atts));
	if(!!$teamcategory):
	$args = array(
		'post_type' => 'gon_team',
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'teamcategory',
				'field'    => 'slug',
				'terms'    => $teamcategory,
			),
		),
	);
	else:
	$args = array(
		'post_type' => 'gon_team',
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'post_status' => 'publish',
	);
	endif;

	$team_string = '';
	$i = 1;
	ob_start();
	$query = new WP_Query( $args );
	if( $query->have_posts() ){
		?><div class="row <?php echo $cols;?>">
		<?php while( $query->have_posts() ){
			
			$query->the_post();
			
			?><div class="col-sm-<?php if($cols == '1'){echo '12';}elseif($cols == '2'){echo '6';}elseif($cols == '3'){echo '4';}elseif($cols == '4'){echo '3';} ?> gon-team text-center plus <?php echo $i;?>">
			
			<?php if($cols == '1'){ ?><div class="row"><div class="col-md-3"><?php } ?>
			
			<div style='position:relative;'>
   		
    		<?php if($link){ ?><a href='<?php the_permalink(); ?>'><i class="fa fa-info-circle" aria-hidden="true"></i></a><?php } ?>
     		
      		<?php the_post_thumbnail('medium-square-crop', array('class'=>'img-responsive'));?>
      		
      		</div>
			
			<?php if($cols == '1'){?></div><div class="col-md-9"><?php } ?>
			
			<h2 class="team-title"><?php the_title();?></h3>
			
			<?php if(get_field('job-title')){?>
				<h4 class="job-title"><?php the_field('job-title'); ?></h4>
			<?php } ?>
			
			<?php if($description == 1){ wpautop(the_field('team_excerpt'));}
			if($cols == '1'){?></div></div><?php }
			if($cols == '1'){?><hr><?php }
			?></div><?php
			if($i % $cols == 0){?></div><!-- ends row modulus '.$cols.' --><div class="row"><?php }
			$i++;
		}
		if($i % $cols !== 0){?></div><!-- ends row modulus !'.$cols.' --><?php }/**/
	}
	$team_string = ob_get_clean();
	wp_reset_postdata();
	return $team_string;
}

// Allow .vcf files to upload to the media library
add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ){
	$existing_mimes['vcf'] = 'text/x-vcard'; return $existing_mimes;
}




//add custom single page
function gon_team_custom_post_type_template($single_template) {
     global $post;
     if ($post->post_type == 'gon_team') {
          $single_template = dirname( __FILE__ ) . '/single-gon_team.php';
     }
     return $single_template;
}
// add custom archive page
function gon_team_product_archive_template($archive_template) {
     global $post;
     if ($post->post_type == 'gon_team') {
          $archive_template = dirname( __FILE__ ) . '/archive-gon_team.php';
     }
     return $archive_template;
}
// // UNCOMMENT FOR PRODUCTS PREMIUM
// //add custom taxonomy page
// // function gon_team_custom_post_type_taxonomy_template($taxonomy_template) {
// //      global $post;
// //      if ($post->post_type == 'gon_team') {
// //           $taxonomy_template = dirname( __FILE__ ) . '/taxonomy-team-category.php';
// //      }
// //      return $taxonomy_template;
// // }
add_filter( 'single_template', 'gon_team_custom_post_type_template' );
add_filter( 'archive_template', 'gon_team_product_archive_template' );
// add_filter( 'taxonomy_template', 'gon_team_custom_post_type_taxonomy_template' );






