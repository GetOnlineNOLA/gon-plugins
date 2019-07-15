<?php 

/**
 * Accordion Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview False during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Create id attribute allowing for custom "anchor" value.
$id = 'accordion-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'accordion';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$accordion = get_field('accordion') ?: false;

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">

<?php foreach ($accordion as $row) { ?>

	<div class="gon-accordion accordion-pair">
		<a style="text-decoration:none;" href="#">
		    <h2 class="entry-title accordion-title accordion-question">
		    <span class="plus">+</span><span class="minus">-</span> <?php echo $row['question']; ?></h2>
		</a>
		<div class="accordion-answer"><?php echo $row['answer']; ?></div>
	</div>

<?php } ?>

</div>


