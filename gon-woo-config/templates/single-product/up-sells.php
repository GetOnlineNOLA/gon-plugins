<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

<section class="up-sells upsells products">
    <div class="row"><div class="col-xs-12"><h2>
      <?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ) ?>
    </h2></div></div>
    <?php //woocommerce_product_loop_start(); ?>
    <?php $i = 1; ?>
    <div class="row"> <!--opening row for loop-->
    <?php foreach ( $upsells as $upsell ) : ?>
    <?php
	$post_object = get_post( $upsell->get_id() );
	setup_postdata( $GLOBALS['post'] =& $post_object );
	$product = wc_get_product( get_the_ID() );
	$cols = get_option('number_of_columns', 4 );
	// Output product information here	
	$cols = get_option('number_of_columns', 4 );
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'small-square-crop' );?>
    <div class="col-sm-<?php if($cols == 1){echo'12';}elseif($cols == 2){echo'6';}elseif($cols == 3){echo'4';}elseif($cols == 4){echo'3';}?> upsell-product-wrapper"><a class="related-product" href="<?php echo get_the_permalink(get_the_ID());?>"><img src="<?php  echo $image[0]; ?>" data-id="<?php echo get_the_ID(); ?>" class="related-product-image">
    <div class="related-product-text">
      <?php the_title();?>
      <br>
      <?php if($product->get_sale_price()){echo '$'.$product->get_sale_price().' -';}?>
      <?php echo '$'.$product->get_regular_price();?></div>
    </a></div>
    <?php //the above replaces ~ wc_get_template_part( 'content', 'product' ); ?>
	<?php if($i%$cols==0){echo '</div><div class="row">';}?>
	<?php $i ++; // increment $i if row modulus required ?>
    <?php endforeach; ?>
    <?php if(($i>0)&&($i%$cols!=0)){echo '</div>';} ?>
    <?php //woocommerce_product_loop_end(); ?>
</section>
<?php endif;

wp_reset_postdata();

