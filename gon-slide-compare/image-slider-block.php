<?php 

/**
 * Image Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview False during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Create id attribute allowing for custom "anchor" value.
$id = 'image-slider-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'image-slider-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$img_one = get_field('image_one') ?: false;
$img_two = get_field('image_two') ?: false;
$width = get_field('width').'px' ?: '400px';
$height = get_field('height').'px' ?: '400px';


?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">

  <div id="container1" style="width:<?php echo $width; ?>;height:<?php echo $height; ?>;">
    <img src="<?php echo $img_one; ?>" style="width:<?php echo $width; ?>;height:<?php echo $height; ?>;">
    <img src="<?php echo $img_two; ?>" style="width:<?php echo $width; ?>;height:<?php echo $height; ?>;">
  </div>

</div>


