<?php
/*
Plugin Name: GON Galleries
Plugin URI: https://getonlinenola.com/
Description: Use attribute gallery="1" or masonry = "1" to transform the native WP gallery into either a slideshow or masonry grid.
Version: 1.0
Author: Get Online Nola
*/

//create custom thumbnail image size
add_action( 'after_setup_theme', 'blankslate_theme_setup' );
function blankslate_theme_setup() {
  add_image_size( 'gallery-thumb', 435, 999, false); 
  
}

//reconfigure wordpress standard gallery
add_filter('post_gallery', 'my_post_gallery', 10, 2);
function my_post_gallery($output, $attr)
{
    global $post;
    
    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }
    
    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 2,
        'size' => 'gallery-thumb',
        'include' => '',
        'exclude' => ''
    ), $attr));
    
    $id = intval($id);
    if ('RAND' == $order)
        $orderby = 'none';
    
    if (!empty($include)) {
        $include      = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array(
            'include' => $include,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $order,
            'orderby' => $orderby
        ));
        //print_r($_attachments);
        $attachments  = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
            //print_r($_attachments[$key]);$val->post_excerpt;
        }
    }
    
    if (empty($attachments)){ return '';}
	
		$output = '';
		ob_start();
		
		?><div class="row <?php if(isset($attr['masonry'])){echo 'masonry-wrapper';}?>"><?php
		
		if (isset($attr['slideshow'])) {
			//make it a slideshow
			?><div class="cycle-pager text-center"></div>
            <div class="cycle-slideshow"
                data-cycle-timeout="4500" 
                data-cycle-slides="> div"
                data-cycle-auto-height="container"
                data-cycle-fx="scrollHorz"
                data-cycle-pager=".cycle-pager" style="overflow:hidden;"><?php
		}
        foreach ($attachments as $id => $attachment) {
			
            $img = wp_get_attachment_image_src($id, 'thumbnail');
            $img_full = wp_get_attachment_image_src($id, 'large'); 
			
            if ($attachment->post_excerpt) { $caption = $attachment->post_excerpt; } else{ $caption = '';}
			
			if (isset($attr['slideshow'])) {//make it a slideshow
				$slide_html = "<div class=\"col-xs-12 gon-gallery\"><a href=\"{$img_full[0]}\" rel=\"lightbox-gallery-1\" class=\"colorbox\" title='{$caption}' ><img src=\"{$img_full[0]}\" alt=\"\" class=\"img-responsive gallery-standard\" style=\"margin:0 auto;\"/>";
				if($caption!==''){ $slide_html .= "<div class='caption'><p>".$caption."</p></div>"; }
				$slide_html .= "</a></div>\n";
				echo $slide_html;
			}elseif(isset($attr['masonry'])){//make it masonry
				if(isset($attr['cols'])){
					if($attr['cols'] == 2){ $col_class = 'col-sm-6 col-md-6';
					} elseif($attr['cols'] == 3){ $col_class = 'col-sm-6 col-md-4';
					} else { $col_class = 'col-sm-4 col-md-3'; }
				} else { $col_class = 'col-sm-4 col-md-3'; }
				$slide_html = "<div class=\"col-xs-6 " . $col_class . " masonry-target gon-gallery\"><a href=\"{$img_full[0]}\" rel=\"lightbox-gallery-1\" class=\"colorbox\" title='{$caption}' ><img src=\"{$img_full[0]}\" alt=\"\" class=\"img-responsive gallery-standard\" style=\"margin:0 auto;\"/></a>";
				if($caption!==''){ $slide_html .= "<div class='caption'><p>".$caption."</p></div>"; }
				$slide_html .= "</div>\n";
				echo $slide_html;
			}else{//just add the colorbox
				$slide_html = "<div class=\"col-xs-12 col-sm-6 col-md-4 wp-native-gallery \"><a href=\"{$img_full[0]}\" rel=\"lightbox-gallery-1\" class=\"colorbox\" title='{$caption}' ><img src=\"{$img[0]}\" alt=\"\" class=\"img-responsive gallery-standard\"/></a>";
				if($caption!==''){ $slide_html .= "<div class='caption'><p>".$caption."</p></div>"; }
				$slide_html .= "</div>\n";
				echo $slide_html;
			}
        }
		if (isset($attr['slideshow'])) {
			//make it a slideshow
			?></div><!--closes cycle slideshow--><?php 
		}
	echo '</div><!--end row-->';
	$output = ob_get_contents();
	ob_end_clean();
    return $output;
}


//add styling to offset padding of bootstrap, may need adjustment.

//add js for colorbox and masonry - these js files need to be included too
//check that jquery is loaded and then load scripts

//conditionally checking on the function_exists means child theme can write first with same name
if ( ! function_exists( 'gon_galleries_enqueue_styles' ) ) {
    function gon_galleries_enqueue_styles() {
		wp_register_style( 'galleries-css', plugin_dir_url( __FILE__ ) . 'css/gon-galleries.css', array('parent-style'), '1.1' ); 
		wp_enqueue_style( 'galleries-css', plugin_dir_url( __FILE__ ) . 'css/gon-galleries.css', array('parent-style'), '1.1' );
	}
	add_action( 'wp_enqueue_scripts', 'gon_galleries_enqueue_styles' );
}
if ( ! function_exists( 'gon_galleries_load_scripts' ) ) {
	function gon_galleries_load_scripts() {	
		wp_enqueue_script( 'imagesLoaded' );
		wp_enqueue_script( 'masonry' );
		//wp_enqueue_script( 'colorbox', plugin_dir_url( __FILE__ ) . 'js/jquery.colorbox-min.js', array('jquery') );
		wp_enqueue_script( 'galleries-config', plugin_dir_url( __FILE__ ) . 'js/gon-galleries-config.js', array('jquery'), '1.1' );
	}
	add_action('wp_enqueue_scripts', 'gon_galleries_load_scripts');
}
