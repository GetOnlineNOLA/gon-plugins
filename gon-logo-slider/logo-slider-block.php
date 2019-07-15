<?php 

/**
 * Logo Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview False during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Create id attribute allowing for custom "anchor" value.
$id = 'logo-slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'logo-slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$carousel = get_field('logo_carousel') ?: false;

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">

	<div class="slideshow-controls">
        <a href="#" id="foot-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
        <a href="#" id="foot-next"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
    </div>
	<div class="logo-slideshow">
	<?php foreach ($carousel as $row) { ?>
        <a href="<?php echo $row['link']; ?>" class="logo-link" target="_blank"><img src="<?php echo $row['upload_image']['url']; ?>" class="img-responsive" style="height:100px;width:auto;"/></a>
    <?php } ?>
  	</div>


</div>


