<?php 

/**
 * Meet the Team Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview False during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Create id attribute allowing for custom "anchor" value.
$id = 'mtt-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'mtt-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$cols = get_field('columns') ?: 3;
$description = get_field('description') ?: 'none';
$link = get_field('link') ?: false;
$teamcategory = get_field('category') ?: false;
$title = get_field('title') ?: false;


?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">

<?php
if(!!$teamcategory):
$args = array(
	'post_type' => 'gon_team',
	'order' => 'ASC',
	'orderby' => 'menu_order',
	'post_status' => 'publish',
	'tax_query' => array(
		array(
			'taxonomy' => 'teamcategory',
			'field'    => 'id',
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
// ob_start();
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
		
		<?php if($title){?>
			<h4 class="job-title"><?php the_field('job-title',get_the_ID()); ?></h4>
		<?php } ?>
		
		<?php if($description == 'excerpt'){ wpautop(the_field('team_excerpt',get_the_ID())); }
		if($description == 'full'){ wpautop(the_content()); }
		if($cols == '1'){?></div></div><?php }
		if($cols == '1'){?><hr><?php }
		?></div><?php
		if($i % $cols == 0){?></div><!-- ends row modulus '.$cols.' --><div class="row"><?php }
		$i++;
	}
	if($i % $cols !== 0){?></div><!-- ends row modulus !'.$cols.' --><?php }/**/
}
// return ob_get_clean();

?>
</div>


