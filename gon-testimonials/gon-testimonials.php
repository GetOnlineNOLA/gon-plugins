<?php

/*
Plugin Name: GON Testimonials
Plugin URI: https://getonlinenola.com/
Description: Create custom tesimonials posts and display them on a page using [testimonials-shortcode].
Version: 1.0
Author: Get Online Nola
*/


function create_post_type_gon_testimonials() {
  register_post_type( 'gon_testimonials',
    array(
      'labels' => array(
        'name' => __( 'Testimonials' ),
        'singular_name' => __( 'Testimonial' )
      ),
      'public' => true,
      'has_archive' => false,
	  'menu_position' => 5,
	  'capability_type'    => 'post',
	  'supports' => array('title', 'editor','page-attributes','thumbnail'),
	  'rewrite' => array( 'slug' => 'testimonials' )
    )
  );
  
}
add_action( 'init', 'create_post_type_gon_testimonials' );

function gon_testimonials_style() {
	wp_register_style( 'gon-testimonials-style', plugin_dir_url( __FILE__ ) . 'testimonials.css' );
	wp_enqueue_style( 'gon-testimonials-style', plugin_dir_url( __FILE__ ) . 'testimonials.css', 'parent-style' );
}
add_action( 'wp_enqueue_scripts', 'gon_testimonials_style' );

//custom Gutenberg block
function gon_testimonials_register_custom_blocks() {

    // register an address block.
    acf_register_block_type(array(
        'name'              => 'testimonials-block',
        'title'             => __('Testimonials Grid'),
        'description'       => __('A list of reviews.'),
        'render_template'   => plugin_dir_path( __FILE__ ) . 'gon-testimonials-block.php',
        'category'          => 'formatting',
        'icon'              => 'admin-comments',
        'keywords'          => array( 'testimonials', 'GON' ),
    ));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'gon_testimonials_register_custom_blocks');
}

require_once( plugin_dir_path( __FILE__ ) . 'gon-testimonials-fields.php' );



//make a shortcode 
function gon_testimonials_function( $atts ) {
  extract(shortcode_atts(array('image' => false), $atts));
  
  //query for the testimonials CPT
  $testimonials_args = array(
    'posts_per_page'   => -1,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'gon_testimonials',
    'post_status'      => 'publish',
    'meta_query'       => '_thumbnail_id',
    'suppress_filters' => true 
  );
  $query = new WP_Query( $testimonials_args );
  if( $query->have_posts() ){
    while( $query->have_posts() ){
      $query->the_post();

      if (get_field('review_author')) {
        $review_author = get_field('review_author');
      }


      if (have_rows('review_source')) {
        while( have_rows('review_source') ) {
          the_row();
          $review_link = get_sub_field('review_source_link');
          $review_platform = strtoupper(get_sub_field('review_platform'));
          switch ($review_platform) {
            case 'FACEBOOK':
              $review_icon = '<i class="fa fa-facebook" aria-hidden="true"></i>';
              break;
            case 'YELP':
              $review_icon = '<i class="fa fa-yelp" aria-hidden="true"></i>';
              break;
            case 'TRIP ADVISOR':
              $review_icon = '<i class="fa fa-tripadvisor" aria-hidden="true"></i>';
              break;
            case 'TRIPADVISOR':
              $review_icon = '<i class="fa fa-tripadvisor" aria-hidden="true"></i>';
              break;
            case 'GOOGLE +':
              $review_icon = '<i class="fa fa-google-plus" aria-hidden="true"></i>';
              break;
            case 'GOOGLE PLUS':
              $review_icon = '<i class="fa fa-google-plus" aria-hidden="true"></i>';
              break;
            case 'GOOGLEPLUS':
              $review_icon = '<i class="fa fa-google-plus" aria-hidden="true"></i>';
              break;
            case 'GOOGLE+':
              $review_icon = '<i class="fa fa-google-plus" aria-hidden="true"></i>';
              break;
            case 'HOUZZ':
              $review_icon = '<i class="fa fa-houzz" aria-hidden="true"></i>';
              break;
            case 'LINKEDIN':
              $review_icon = '<i class="fa fa-linkedin" aria-hidden="true"></i>';
              break;
            default:
              $review_icon = ucwords(strtolower($review_platform));
              break;
          }
       }
     }

      

      ?>
      <div class='row'>
        <div class='col-sm-12 review'>
          <?php if($image&&has_post_thumbnail()){ the_post_thumbnail('thumbnail',array('class'=>'pull-left testimonial-image')); } ?>
          <?php the_content(); ?>
          <div class='review-meta'>
            <?php if($review_author){?><span class='review-author'><?php echo $review_author; ?></span><?php } ?>
            <?php if($review_icon) {?><span class='review-link'><a href='<?php echo $review_link; ?>' target='_blank'><?php echo $review_icon; ?></a></span><?php }?>
          </div>
        </div>
      </div>
      <?php

      $review_author = '';
      $review_source = ''; 
      $review_link = '';

      wp_reset_postdata();
    }
  }
}

add_shortcode( 'testimonials-shortcode', 'gon_testimonials_function' );

?>
