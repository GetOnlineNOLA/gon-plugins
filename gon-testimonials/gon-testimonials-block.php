<?php 

/**
 * Testimonials Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview False during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Create id attribute allowing for custom "anchor" value.
$id = 'testimonials-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'testimonials-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$image = get_field('include_image') ?: false;


?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">


<?php

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

      if (get_field('review_author', get_the_ID())) {
        $review_author = get_field('review_author', get_the_ID());
      }


      if (have_rows('review_source', get_the_ID())) {
        while( have_rows('review_source', get_the_ID()) ) {
          the_row();
          $review_link = get_sub_field('review_source_link', get_the_ID());
          $review_platform = strtoupper(get_sub_field('review_platform', get_the_ID()));
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
  } ?>

</div>

