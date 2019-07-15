<?php get_header(); ?>

<section id="products-archive" class='content-wrapper'>
  <div class='container'>
    <div class='row'>
      <div class="col-sm-9">

        <div class='row'>
          <div class='col-xs-12'>
            <h1 class="entry-title">
              <?php single_term_title(); ?>
            </h1>
          </div>
        </div>


        <?php $i=0;
          $cols = get_field('premiums_products_number_columns','option'); 
          $description = false;    
        ?>


        <div class='row'>
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); $i++; ?>
            <div class="<?php echo $i; ?> col-sm-<?php if($cols == 2): echo '6'; elseif($cols == 3): echo '4'; elseif($cols == 4): echo '3'; endif;?> gon-products">
              <a href="<?php the_permalink();?>"><?php the_post_thumbnail('products-crop', array('class'=>'img-responsive'));?></a>
              <h2 class="entry-title product-title text-center"><?php the_title();?></h2><!-- </a> -->
              <a class="button product-button" href="<?php the_permalink();?>"><span>Details</span></a>
            </div> 
          <?php if($i%$cols==0){ echo '</div><div class="row">'; } ?>
          <?php endwhile; endif; ?>
        </div><!-- end row -->


      </div>

      <div class="col-sm-3">
        <?php dynamic_sidebar('products-premium-sidebar-widget'); ?>
      </div>

    </div>
  </div>
</section>


<?php get_footer(); ?>
