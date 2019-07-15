<?php get_header(); ?>
<section id="services-menu-single" class="content-wrapper">
    <div class='container'>
        <div class='row'>

            <?php $navstyle = 'top';
                if(get_field('services-menu-header-text','option')):
                    $toptext = get_field('services-menu-header-text','option'); ?>
                    <div class="col-xs-12 intro-text">
                        <?php echo wpautop($toptext); ?>
                    </div><?php  
                endif; ?>

            <?php $navstyle = 'med';
                if(get_field('navstyle','option')):
                    $navstyle = get_field('navstyle','option');
                endif;
            ?>

            <div class="col-sm-<?php switch($navstyle){
                case 'small':
                    echo "2 services-menu-sidebar";
                    break;
                case 'med':
                    echo "3 services-menu-sidebar";
                    break;
                case 'large':
                    echo "4 services-menu-sidebar";
                    break;
                case 'top':
                    echo "12";
                    break;
            }?>">
                <div class="dropdown-wrap">
                   <button class="visible-xs hidden-sm btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Services <span class="caret"></span></button>  
                   <ul class="dropdown-menu relative" aria-labelledby="dropdownMenuButton">
                    <?php //loop through all titles...
                	$the_query = new WP_Query( array( 'post_type' => 'gon_services_menu', 'orderby' => 'menu_order' ,'order' => 'ASC', 'posts_per_page' => -1 ) );
                	if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ): $the_query->the_post();
                	  $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                	  $link_end = basename($actual_link);
                	  $current_slug = $post->post_name;
                	  ?>

                      <li id='<?php if( $link_end == $current_slug ){ echo "active-item"; } ?>' class='programs-nav-item <?php 
                        if(get_field('button-class')){ the_field('button-class'); } else { echo ''; }
                        switch($navstyle){
                            case 'small':
                            case 'med':
                            case 'large':
                                echo " display-block";
                                break;
                            case 'top':
                                break;
                        }?>'>
                        <a href="<?php the_permalink(); ?>" class="program-type-link button">
                            <?php if(get_field('button-title')): the_field('button-title'); else: the_title(); endif; ?>
                        </a>
                      </li>

                    <?php endwhile; wp_reset_postdata(); endif; ?>

                  </ul>
                </div>

            <?php if( $navstyle!=='top' && get_field('services-menu-cf-shortcode','option') ){ the_field('services-menu-cf-shortcode','option'); } ?>

            </div>

            <div class="col-sm-<?php switch($navstyle){
                case 'small':
                    echo "10";
                    break;
                case 'med':
                    echo "9";
                    break;
                case 'large':
                    echo "8";
                    break;
                case 'top':
                    echo "12";
                    break;
            }?>">
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              <h1 class="entry-title product-title">
                <?php the_title(); ?>
              </h1>
              <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">     
                  <?php the_content(); ?>
                  <?php if( $navstyle=='top' && get_field('services-menu-cf-shortcode','option') ){
            			echo '<div class="clearfix"></div>';
            			echo do_shortcode(get_field('services-menu-cf-shortcode','option'));
            	  } ?>
                </div>
              </article>
                  <?php endwhile; endif; ?>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
