<?php
function hermes_productscategory_shortcode( $atts ) {
	global $hermes_opt;
	
	$atts = shortcode_atts( array(
							'title' => '',
							'widget_style' => '',
							'short_desc' => '',
							'item_layout'=>'box',
							'category' => '',
							'number' => 10,
							'columns'=> '4',
							'rows'=> '1',
							'el_class' => '',
							'style'=>'grid',
							'showon_effect'=>'',
							'desksmall' => '4',
							'tablet_count' => '3',
							'tabletsmall' => '2',
							'mobile_count' => '1',
							'margin' => '30',
							'autoplay' => 'false',
							'playtimeout' => '5000',
							'speed' => '250',
							), $atts, 'productscategory' ); 
	extract($atts);
	switch ($columns) {
		case '6':
			$class_column='col-lg-2 col-md-3 col-sm-4 col-xs-12';
			break;
		case '5':
			$class_column='col-lg-20 col-md-3 col-sm-4 col-xs-12';
			break;
		case '4':
			$class_column='col-lg-3 col-md-4 col-sm-6 col-xs-12';
			break;
		case '3':
			$class_column='col-md-4 col-sm-6 col-xs-12';
			break;
		case '2':
			$class_column='col-md-6 col-sm-6 col-xs-12';
			break;
		default:
			$class_column='col-md-3 col-sm-6 col-xs-12';
			break;
	}
	if($category=='') return;
	$_id = hermes_make_id();
	$loop = hermes_woocommerce_query('',$number, $category);
	$owl_data = '';
	if($style == 'carousel'){
		$owl_data .= 'data-dots="false" data-nav="true" data-owl="slide" data-ow-rtl="false" ';
		$owl_data .= 'data-data-desksmall="'. esc_attr($desksmall) .'" ';
		$owl_data .= 'data-tabletsmall="'. esc_attr($tabletsmall) .'" ';
		$owl_data .= 'data-mobile="'. esc_attr($mobile_count) .'" ';
		$owl_data .= 'data-tablet="'. esc_attr($tablet_count) .'" ';
		$owl_data .= 'data-margin="'. esc_attr($margin) .'" ';
		$owl_data .= 'data-item-slide="'. esc_attr($columns) .'" ';
		$owl_data .= 'data-autoplay="'. esc_attr($autoplay) .'" ';
		$owl_data .= 'data-playtimeout="'. esc_attr($playtimeout) .'" ';
		$owl_data .= 'data-speed="'. esc_attr($speed) .'" ';
	}
	if ( $loop->have_posts() ){ 
		ob_start();
	?>
		<?php $_total = $loop->post_count; ?>
		<div class="woocommerce<?php echo esc_attr($el_class); ?>">
			<?php if($title){ ?><h3 class="vc_widget_title vc_products_title <?php echo esc_attr($widget_style); ?>"><span><?php echo esc_html($title); ?></span></h3><?php } ?>
			<?php if($short_desc){ ?><div class="short_desc"><?php echo wpautop($short_desc) ?></div><?php } ?>
			<div class="inner-content <?php echo esc_attr($widget_style); ?>">
				<?php wc_get_template( 'product-layout/'.$style.'.php', array( 
							'show_rating' => true,
							'showon_effect' => $showon_effect,
							'_id'=>$_id,
							'loop'=>$loop,
							'columns_count'=>$columns,
							'class_column' => $class_column,
							'_total'=>$_total,
							'number'=>$number,
							'rows'=>$rows,
							'itemlayout'=> $item_layout,
							'owl_attrs' => $owl_data,
							 ) ); ?>
			</div>
		</div>
	<?php 
		$content = ob_get_contents();
		ob_end_clean();
		wp_reset_postdata();
		return $content;
	} 
} 
add_shortcode( 'productscategory', 'hermes_productscategory_shortcode' );
?>