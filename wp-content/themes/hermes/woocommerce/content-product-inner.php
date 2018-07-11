<?php

global $product, $hermes_opt, $item_layout;
?>
	<div class="product-wrapper<?php echo (isset($item_layout) && $item_layout == 'list') ? ' item-list-layout':' item-box-layout'; ?>">
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
					<?php if (!empty($hermes_opt['hover_effect'])){ ?>
						<span class="shadow"></span>
					<?php } ?>
				</a>
				<?php if((isset($item_layout) && $item_layout == 'box') || (!isset($item_layout))){ ?>
					<?php if(!empty($hermes_opt['enable_quickview'])){ ?>
					<div class="quickviewbtn">
						<a class="detail-link quickview" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'hermes');?></a>
					</div>
					<?php } ?>
				<?php } ?>
				<div class="products-info">
					<h2 class="product-name">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<div class="price-box"><?php echo ''.$product->get_price_html(); ?></div>
				</div>				
			</div>
		</div>
		<div class="list-col8">
			<div class="gridview">
				<h2 class="product-name">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<?php hermes_get_rating_html(); ?>
				<div class="price-box"><?php echo ''.$product->get_price_html(); ?></div>
				<?php if((isset($item_layout) && $item_layout == 'box') || (!isset($item_layout))){ ?>
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
				<?php } ?>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
