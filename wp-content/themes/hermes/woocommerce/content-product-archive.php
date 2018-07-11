<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $hermes_opt, $hermes_shopclass, $hermes_viewmode;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Extra post classes
$classes = array();
$classes[] = 'item-col col-xs-12';
if(!empty($hermes_opt['product_per_row'])){
	$woocommerce_loop['columns'] = $hermes_opt['product_per_row'];
	$colwidth = ($woocommerce_loop['columns'] != 5) ? round(12/$woocommerce_loop['columns']) : 20;
	if ($colwidth == 20 || $colwidth == 3 || $colwidth == 2) {
		$sm = ($colwidth == 20) ? 3 : $colwidth + 1;
		$classes[] = 'col-sm-'. $sm .' col-md-'.$colwidth ;
	} else {
		$classes[] = 'col-sm-'.$colwidth ;
	}
}
?>

<div <?php post_class( $classes ); ?>>
	<div class="product-wrapper">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
		<div class="list-col4 <?php if($hermes_viewmode=='list-view'){ echo ' col-xs-12 col-sm-4';} ?>">
			<div class="product-image">
			
				<?php if ( $product->is_on_sale() ) : ?>
					<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="sale-bg"></span><span class="sale-text">' . esc_html__( 'Sale', 'hermes' ) . '</span></span>', $post, $product ); ?>
				<?php endif; ?>
			
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $product->get_name() ); ?>">
					<?php 
					echo wp_kses($product->get_image('shop_catalog', array('class'=>'primary_image')), array(
						'a'=>array(
							'href'=>array(),
							'title'=>array(),
							'class'=>array(),
						),
						'img'=>array(
							'src'=>array(),
							'height'=>array(),
							'width'=>array(),
							'class'=>array(),
							'alt'=>array(),
						)
					));
					
					if(isset($hermes_opt['second_image'])){
						if($hermes_opt['second_image']){
							$attachment_ids = $product->get_gallery_image_ids();
							if ( $attachment_ids ) {
								echo wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), false, array('class'=>'secondary_image') );
							}
						}
					}
					?>
					<?php if (!empty($hermes_opt['hover_effect'])){ ?>
						<span class="shadow"></span>
					<?php } ?>
				</a>
				<?php if(!empty($hermes_opt['enable_quickview'])){ ?>
				<div class="quickviewbtn">
					<a class="detail-link quickview" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'hermes');?></a>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="list-col8 <?php if($hermes_viewmode=='list-view'){ echo ' col-xs-12 col-sm-8';} ?>">
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
			<div class="listview">
				<h2 class="product-name">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<div class="product-desc"><?php the_excerpt(); ?></div>
				<?php hermes_get_rating_html(); ?>
				<div class="price-box"><?php echo ''.$product->get_price_html(); ?></div>				
				<div class="actions">
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