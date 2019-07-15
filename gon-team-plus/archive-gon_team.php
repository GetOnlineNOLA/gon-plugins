<?php get_header(); ?>


<section id='meet-the-team-archive'>
  <div class='container'>
    <div class='row'>

<div class="col-sm-12">

    <header class="header">
      <h1 class="entry-title">Our Team
        <?php //post_type_archive_title(); ?>
      </h1>
    </header>

    <section id="content" role="main">
      <div class='row'>
        <div class='col-sm-12 team-intro'>
          <?php the_field('team-text','option'); ?>
        </div>
      </div>
      <?php $i = 0;        
        if(get_field('team_number_columns','option')){
          $cols = get_field('team_number_columns','option');
        } else {
          $cols = 4;
        } ?>
      <div class='row'>
        <?php $team_query = new WP_Query( array( 'post_type' => 'gon_team', 'order' => 'menu_order') );
        if ( $team_query->have_posts() ) : while ( $team_query->have_posts() ): $team_query->the_post(); $i++; ?>
        <div class="<?php echo $i; ?> col-sm-<?php if($cols == 2): echo '6'; elseif($cols == 3): echo '4'; elseif($cols == 4): echo '3'; endif;?> gon-team plus">
          <div style='position:relative;'><a href='<?php the_permalink(); ?>'><i class="fa fa-info-circle" aria-hidden="true"></i></a>
      <?php the_post_thumbnail('medium-square-crop', array('class'=>'img-responsive'));?></div>
      <h2 class='team-title'><?php the_title(); ?></h2>
      <h4 class="job-title"><?php the_field('job-title'); ?></h4>
       <?php if( get_field('team_excerpt') ){ ?><p class='team-excerpt'><?php the_field('team_excerpt'); ?></p><?php } ?>
       </div>
      <?php if(($i%$cols)==0){ ?></div><div class='row'><?php } ?>
    <?php endwhile; endif; ?>
    </div><!-- end row -->
  </section>

</div>

    </div>
  </div>
</section>

<?php get_footer(); ?>