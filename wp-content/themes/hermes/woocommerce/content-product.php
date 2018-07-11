<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $hermes_opt, $hermes_productsfound;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Extra post classes
$classes = array();
if( $woocommerce_loop['columns'] >= 2 ){
	if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
		$classes[] = 'first';
	}
	if ( 0 == ( $woocommerce_loop['loop'] + 1 ) % $woocommerce_loop['columns'] ) {
		$classes[] = 'last';
	}
}
if($woocommerce_loop['columns'] > 1){
	$hermes_opt['product_per_row'] = $woocommerce_loop['columns'];
	$colwidth = round(12/$woocommerce_loop['columns']);
	$classes[] = ' item-col col-xs-12 col-sm-'.$colwidth;
}
if ( ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) && ( $woocommerce_loop['columns'] >= 2 ) ) {
	if( $hermes_opt['product_per_row'] != 1 ){
		echo '<div class="group">';
	}
} ?>
<div <?php post_class( $classes ); ?>>
	<div class="product-wrapper">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
		<div class="list-col4">
			<div class="product-image">
			
				<?php if ( $product->is_on_sale() ) : ?>
					<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="sale-bg"></span><span class="sale-text">' . esc_html__( 'Sale', 'hermes' ) . '</span></span>', $post, $product ); ?>
				<?php endif; ?>
						
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $product->get_name() ); ?>">
					<?php 
					echo ''.$product->get_image('shop_catalog', array('class'=>'primary_image'));
					
					if(isset($hermes_opt['second_image'])){
						if($hermes_opt['second_image']){
							$attachment_ids = $product->get_gallery_image_ids();
							if ( $attachment_ids ) {
								echo wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), false, array('class'=>'secondary_image') );
							}
						}
					}
					?>
					<span class="shadow"></span>
				</a>
				<?php if(!empty($hermes_opt['enable_quickview'])){ ?>
				<div class="quickviewbtn">
					<a class="detail-link quickview" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'hermes');?></a>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="list-col8">
			<div class="gridview">
				<h2 class="product-name">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<?php hermes_get_rating_html(); ?>
				<div class="price-box"><?php echo ''.$product->get_price_html(); ?></div>
				<div class="actions<?php echo (!empty($hermes_opt['always_visible_acts'])) ? ' always' : ''; ?>">
					<ul class="add-to-links clearfix">
						<li>
							<?php hermes_ajax_add_to_cart_button(); ?>
						</li>

						<li>	
							<?php if ( class_exists( 'YITH_WCWL' ) ) {
								echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
							} ?>
						</li>
						<li>
							<?php if( class_exists( 'YITH_Woocompare' ) ) {
							echo do_shortcode('[yith_compare_button]');
							} ?>
						</li>
					</ul>

				</div>
			
			</div>
		</div>
		<div class="clearfix"></div>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
</div>
<?php if ( ( ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] || $hermes_productsfound == $woocommerce_loop['loop'] ) && $woocommerce_loop['columns'] >= 2 )  ) {
	if( $hermes_opt['product_per_row'] != 1 ){
		echo '</div>';
	}
} ?>
