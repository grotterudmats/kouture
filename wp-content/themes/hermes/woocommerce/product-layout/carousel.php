<?php
	$_delay = 100;
	global $item_layout;
	$item_layout = $itemlayout;
?>
<div class="products-block shop-products products grid-view">
	<div <?php echo $owl_attrs; ?>  class="owl-carousel owl-theme products-slide">
		<?php $index = 0; while ( $loop->have_posts() ) : $loop->the_post(); global $product; $index ++; ?>
			<?php if($rows > 1){ ?>
				<?php if ( (0 == ( $index - 1 ) % $rows ) || $index == 1) { ?>
					<div class="group">
				<?php } ?>
			<?php } ?>
			<div class="product <?php echo (!empty($showon_effect)) ? 'wow ' . $showon_effect: ''; ?>" data-wow-duration="0.5s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms">
				<?php 
					if(isset($is_deals) && $is_deals){
						wc_get_template_part( 'content', 'product-deals' );
					}else{
						wc_get_template_part( 'content', 'product-inner' );
					}
				?>
			</div>
			<?php if($rows > 1){ ?>
				<?php if ( ( ( 0 == $index % $rows || $_total == $index )) ) { ?>
					</div>
				<?php } ?>
			<?php } ?>
			<?php $_delay+=100; ?>
		<?php endwhile; ?>
	</div>
</div>
