<?php get_header(); ?>

<section id="products-single" class='content-wrapper'>
  <div class='container'>
    <div class='row'>

      <div class="col-sm-9">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <h1 class="entry-title product-title">
            <?php the_title(); ?>
          </h1>
          <span class='product-categories'>
                <?php 
                $terms = get_the_terms(get_the_id(), 'product_type');
                    if(is_array($terms)){
                      $last_element = end($terms);
                        foreach($terms as $term){ 
                        $cat_link = get_term_link($term);
                    ?>
                    <a href="<?php echo $cat_link; ?>" class="cat-link"><?php echo $term->name;?></a><?php if($term!==$last_element){echo ', ';}?>
                    <?php }
                  } ?>
          </span>
        <div class="entry-content">
          <?php the_post_thumbnail('full', array('class'=>'img-responsive alignleft'));
          the_content(); ?>
          <a class='button back-to-archive' href='..'>&larr; All <?php 
            $postType = get_post_type_object(get_post_type());
            if ($postType) {
                echo esc_html($postType->labels->singular_name).'s';
            } ?>
          </a>
        </div>
      </article>
      <?php endwhile; endif; ?>
    </div>

    <div class="col-sm-3">
      <?php if( is_active_sidebar('products-premium-sidebar-widget') ){ dynamic_sidebar('products-premium-sidebar-widget'); } else{ get_sidebar(); } ?>
    </div> 
       
  </div>
</div>
</section>


<?php wp_reset_postdata();
//bring in the related projects
$projects_array = get_field('associated-projects');
if(get_field('associated-projects')){
    $number = count($projects_array);
    if($number>0){ ?>

<section id="products-related-posts">
  <div class='container'>
    <div class='row'>
      <div class="col-sm-12 text-center">
        <h2>Related Products</h2>
      </div>
    </div>

    <div class="row associated-row"><!-- ends dynamically dependant on $count -->
      <?php $i = 1;
      foreach($projects_array as $project_id){
        if (($i % 3) !== 0) { ?>
        <div class="col-sm-4 text-center">
          <div class="associated-projects-wrap"><a href="<?php the_permalink($project_id);?>" class="project-image-link">
          <?php echo get_the_post_thumbnail($project_id, 'products-crop', array('class' => 'img-responsive associated-projects-img'));?>
          <div class="associated-projects-text"><?php echo get_the_title($project_id);?></div>
        </a></div>
        </div>
        <?php }
        if (($i % 3) == 0) { ?>
          <div class="col-sm-4 text-center">
            <div class="associated-projects-wrap"><a href="<?php the_permalink($project_id);?>" class="project-image-link">
            <?php echo get_the_post_thumbnail($project_id, 'products-crop', array('class' => 'img-responsive associated-projects-img'));?>
            <div class="associated-projects-text"><?php echo get_the_title($project_id);?></div>
          </a></div>
          </div>
            </div><div class='row  associated-row'> <!--starts new row-->
          <?php }
        $i++; 
      } ?>
    </div><!-- close out final row from related projects -->
  </div>
</section>


  <?php }
} ?>

<?php get_footer(); ?>
