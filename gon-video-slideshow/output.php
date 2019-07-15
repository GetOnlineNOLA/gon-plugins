<?php


add_shortcode( 'gon-video-slideshow', 'gon_video_slideshow_archive' );

function gon_video_slideshow_archive($atts){
	
	extract( shortcode_atts( array( 'post_id' => '' ), $atts ) );
	
			$args = array(
				'post_type' => 'gon_video_slideshows', 
				'p' => $post_id
			);
	
            $loop = new WP_Query( $args );
                if( $loop->have_posts() ){ while ( $loop-> have_posts() ) { $loop->the_post(); ?>
				
				<!--set up slideshow variables-->	
				<?php
				if( have_rows('slideshow_properties', get_the_ID()) ){
					while( have_rows('slideshow_properties', get_the_ID()) ){

						the_row();

						if( get_sub_field('width', get_the_ID()) ){ 
							$slideshow_width = get_sub_field('width', get_the_ID()); 
						} else { $slideshow_width = '100%'; }
						if( get_sub_field('height', get_the_ID()) ){ 
							$slideshow_height = get_sub_field('height', get_the_ID()); 
						} else { $slideshow_height = '400px'; }

						if( get_sub_field('video_overlay_content', get_the_ID()) ){ 
							$overlay = true;
							$overlay_content = get_sub_field('video_overlay_content', get_the_ID()); 
						} else { $overlay = false; }

						if( have_rows('overlay_background', get_the_ID()) ){
							while ( have_rows('overlay_background', get_the_ID()) ){
								the_row();							
								$overlay_positioning = get_sub_field('overlay_positioning', get_the_ID()); 
								$opacity = get_sub_field('overlay_transparency', get_the_ID()); 
								if( get_sub_field('overlay_shade', get_the_ID()) == 'Black' ){ 
									$shade = '0,0,0,'; }
								else { 
									$shade = '255,255,255,'; 
								}
							}
						}
					}
				}
				?>
																		   
				<div class="swiper-container" 
				id="gon-video-slideshow" 
				style="
       			width:<?php echo $slideshow_width; ?>;
       			height:<?php echo $slideshow_height; ?>;">

					<!--overlay-->
					<?php if($overlay){ ?>
					<div class='video-overlay hidden-mobile <?php echo $overlay_positioning; ?>' style='background:rgba(<?php echo $shade; echo $opacity; ?>);'>
						<div style='position:relative;width: 100%;height:100%;'>
							<div class='video-overlay-inner'>
							<?php echo $overlay_content; ?>
							</div>
						</div>
					</div>
					<?php } ?>
					<!--end overlay-->

       				<div class="swiper-wrapper">
        		

        			<?php //slides
					if(have_rows('slide', get_the_ID())): $i = 0;	   
				    while(have_rows('slide', get_the_ID())):
						the_row();

						if(get_sub_field('slide_type', get_the_ID())=='video'){
							$type = 'video';
							$video_slide = true;
						} else {
							$type = 'image';
							$video_slide = false;
						}

						if($video_slide):
																		   
						$vid_format = get_sub_field('video_format', get_the_ID());
						if( $vid_format == 'youtube' ){
							$youtube_source = get_sub_field('youtube_embed_source', get_the_ID());
							$youtube = true;
						} else { 
							$vid_source = get_sub_field('video_source', get_the_ID());
							$youtube = false; 
						}
							
						$slide_image = get_sub_field('video_screenshot', get_the_ID());

						else://image slide

						$slide_image = get_sub_field('image', get_the_ID());
						$youtube = false;

						endif;


						?>
      					
       					<!--slideshow repeater-->
						<div 
						id="slide_<?php echo $i; ?>" 
						class="swiper-slide <?php echo $type.' '; if($video_slide){ echo $vid_format; if($youtube){ echo ' buffering'; } } if(get_sub_field("panning_effect",get_the_ID())){ echo " kenburns-true"; } ?>" 
						<?php if( $youtube ){ ?> 
						data-source="<?php echo $youtube_source; ?>"
						<?php } ?> 
						>
							
							
						<img src="<?php echo $slide_image['sizes']['tablet-crop']; ?>" 
						class='<?php if($video_slide){ ?>video-poster<?php } else { ?>slider-image <?php } ?>'
						data-mobile="<?php echo $slide_image['sizes']['medium-square-crop']; ?>"
						data-desktop="<?php echo $slide_image['sizes']['slideshow-crop']; ?>">

						<?php if($video_slide){
						if( $youtube ){ ?>

							<div id="video<?php echo $i; ?>" class="slider-video"></div>

							<?php } else { ?>

							<video class="slider-video not-youtube" id="video<?php echo $i; ?>" width="100%" preload="auto" loop autoplay muted style="visibility: visible; width: 100%;" poster="<?php echo $vid_screenshot['url']; ?>">
								<source src="<?php echo $vid_source; ?>" type="video/<?php echo $vid_format; ?>" data-tablet="<?php echo $vid_screenshot['sizes']['tablet-crop']; ?>" data-mobile="<?php echo $vid_screenshot['sizes']['medium-square-crop']; ?>">
							</video>

							<?php } } ?>
						</div>
        	       		<!--end slide-->
         	       	 
          	       	 
          	       	 
          	    <?php $i++; ?>
           	        	
            	<?php endwhile; ?>
				<?php endif;

				// end slides ?>																							
																		
                <?php } } else { echo 'Video Slideshow ID Invalid. Verify the ID of the videoslideshow post you would like to display.'; }

}