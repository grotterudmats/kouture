<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $sf_options;
$original_slider = false;
if ( isset( $sf_options['original_product_slider'] ) ) {
	$original_slider  = $sf_options['original_product_slider'];				
}

if ( version_compare( WC_VERSION, '3.3.3', '>=' ) && !$original_slider ) { 

	global $post, $product, $sf_options;
	$post_thumbnail_id = $product->get_image_id();
	$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
	$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
	$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
	$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
	$product_slider_thumbs_pos = "bottom";
	if ( isset( $sf_options['product_slider_thumbs_pos'] ) ) {
			$product_slider_thumbs_pos = $sf_options['product_slider_thumbs_pos'];
	}
	$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	) );
	$image_caption = "";
	$image_meta = sf_get_attachment_meta( $post_thumbnail_id );
	if ( isset($image_meta) ) {
	    $image_caption      = esc_attr( $image_meta['caption'] );
	}
	
	$disable_product_slider = false;
	if ( isset( $sf_options['disable_product_slider'] ) ) {
		$disable_product_slider = $sf_options['disable_product_slider'];
	}
	
	if ( $disable_product_slider ) {
		$wrapper_classes[] = 'woocommerce-product-gallery--disabled';
	}

	?>
	<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
		<figure class="woocommerce-product-gallery__wrapper">
			<?php
			$attributes = array(
				'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
				'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
				'data-src'                => $full_size_image[0],
				'data-large_image'        => $full_size_image[0],
				'data-large_image_width'  => $full_size_image[1],
				'data-large_image_height' => $full_size_image[2],
			);
			
			if ( has_post_thumbnail() && $image_caption != '' ) {
				$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
				$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
				$html .= '</a>';
				if ( $image_caption != "" ) {
				    $html .= '<div class="img-caption">' . $image_caption . '</div>';
				}
				$html .= '</div>';
			} else if ( has_post_thumbnail() ) {
				$html  = wc_get_gallery_image_html( $post_thumbnail_id, true );
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'swiftframework' ) );
				$html .= '</div>';
			}
	
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post_thumbnail_id ) );
	
			do_action( 'woocommerce_product_thumbnails' );
			?>
		</figure>
	</div>

<?php } else if ( version_compare( WC_VERSION, '2.7', '>=' ) && !$original_slider ) { 

	global $post, $product, $sf_options;
	$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
	$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
	$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
	$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
	$product_slider_thumbs_pos = "bottom";
	if ( isset( $sf_options['product_slider_thumbs_pos'] ) ) {
			$product_slider_thumbs_pos = $sf_options['product_slider_thumbs_pos'];
	}
	$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . $placeholder,
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	) );
	$image_caption = "";
	$image_meta = sf_get_attachment_meta( $post_thumbnail_id );
	if ( isset($image_meta) ) {
	    $image_caption      = esc_attr( $image_meta['caption'] );
	}
	
	$disable_product_slider = false;
	if ( isset( $sf_options['disable_product_slider'] ) ) {
		$disable_product_slider = $sf_options['disable_product_slider'];
	}
	
	if ( $disable_product_slider ) {
		$wrapper_classes[] = 'woocommerce-product-gallery--disabled';
	}

	?>
	<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
		<figure class="woocommerce-product-gallery__wrapper">
			<?php
			$attributes = array(
				'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
				'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
				'data-src'                => $full_size_image[0],
				'data-large_image'        => $full_size_image[0],
				'data-large_image_width'  => $full_size_image[1],
				'data-large_image_height' => $full_size_image[2],
			);
			
			if ( has_post_thumbnail() ) {
				$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
				$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
				$html .= '</a>';
				if ( $image_caption != "" ) {
				    $html .= '<div class="img-caption">' . $image_caption . '</div>';
				}
				$html .= '</div>';
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'swiftframework' ) );
				$html .= '</div>';
			}
	
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
	
			do_action( 'woocommerce_product_thumbnails' );
			?>
		</figure>
	</div>
	
<?php } else {

	global $post, $woocommerce, $product, $sf_options;
	
	$attachment_ids = array();
	$product_layout = sf_get_post_meta($post->ID, 'sf_product_layout', true);
	$product_image_width = apply_filters('sf_product_image_width', 700);
	
	$default_product_product_layout = "standard";
	if ( isset( $sf_options['default_product_product_layout'] ) ) {
		$default_product_product_layout = $sf_options['default_product_product_layout'];
	}
	if ( $product_layout == "" ) {
		$product_layout = $default_product_product_layout;
	}
	
	if ($product_layout == "fw-split") {
	$product_image_width = apply_filters('sf_product_fw_image_width', 1200);
	}
	$disable_product_slider = false;
	if ( isset( $sf_options['disable_product_slider'] ) ) {
		$disable_product_slider = $sf_options['disable_product_slider'];
	}
	
	if ( !$disable_product_slider ) {
		wp_enqueue_script( 'flexslider' );
	}
	
	wp_enqueue_script( 'jquery-ui' );
	
	?>
	<div class="images">
		
		<?php if ( $disable_product_slider ) { ?>
	
		<div id="product-img-noslider" class="product-img-area">
			
		<?php } else { ?>
			
		<div id="product-img-slider" class="product-img-area flexslider">
			
		<?php } ?>
		
			<?php if ( $disable_product_slider == "2" ) { ?>
				
				<?php sf_woo_product_badge(); ?>
			
				<ul class="main-image">	
					<?php
						if ( has_post_thumbnail() ) {
				
							$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
							$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
							$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
							$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
								'title'	=> $image_title,
								'alt'	=> $image_title,
								'class' => 'product-slider-image'
								) );
							
							$attachment_count = 0;
							if ( version_compare( WC_VERSION, '2.7', '>=' ) ) {
							$attachment_count = count( $product->get_gallery_image_ids() );
							} else {
							$attachment_count = count( $product->get_gallery_attachment_ids() );
							}
							if ( $attachment_count > 0 ) {
								$gallery = '[product-gallery]';
							} else {
								$gallery = '';
							}
				
							echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );
										
						} else {
				
							echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'swiftframework' ) ), $post->ID );
				
						}
					?>
				</ul>
				
				<ul class="thumbnails">
					<?php do_action( 'woocommerce_product_thumbnails' ); ?>
				</ul>
				
			<?php } else { ?>
	
				<?php sf_woo_product_badge(); ?>
	
				<ul class="slides">
					<?php
						if ( has_post_thumbnail() ) {
							
							$image_caption = $image_alt = $image_title = $caption_html = "";
							$image_id			= get_post_thumbnail_id();
							$image_meta 		= sf_get_attachment_meta( $image_id );
							
							if ( isset($image_meta) ) {
								$image_caption 		= esc_attr( $image_meta['caption'] );
								$image_title 		= esc_attr( $image_meta['title'] );
								$image_alt 			= esc_attr( $image_meta['alt'] );
							}
							$image_link  		= wp_get_attachment_url( $image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
							$image         		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
								'title'	=> $image_title,
								'alt'	=> $image_title,
								'class' => 'product-slider-image',
								'data-zoom-image' => $image_link
							) );							
		
							if ( $image_caption != "" ) {
								$caption_html = '<div class="img-caption">' . $image_caption . '</div>';
							}
							
							echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-data-rel="ilightbox[product]">%s</a>', $image_link, $image_caption, $image ), $post->ID );
		
						}
		
						$loop = 0;
						$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
						
						$attachment_ids = '';
						if ( version_compare( WC_VERSION, '2.7', '>=' ) ) {
						$attachment_ids = $product->get_gallery_image_ids();
						} else {
						$attachment_ids = $product->get_gallery_attachment_ids();
						}
						
						if ( $attachment_ids ) {
		
							foreach ( $attachment_ids as $attachment_id ) {
		
								$classes = array( 'zoom' );
		
								if ( $loop == 0 || $loop % $columns == 0 )
									$classes[] = 'first';
		
								if ( ( $loop + 1 ) % $columns == 0 )
									$classes[] = 'last';
		
								$image_link  		= wp_get_attachment_url( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
		
								if ( ! $image_link )
									continue;
								
								$image_caption = $image_alt = $image_title = $caption_html = "";
								$image_id = $attachment_id;
								$image_meta = sf_get_attachment_meta( $image_id );
								
								if ( isset($image_meta) ) {
									$image_caption 		= esc_attr( $image_meta['caption'] );
									$image_title 		= esc_attr( $image_meta['title'] );
									$image_alt 			= esc_attr( $image_meta['alt'] );
								}
								
								$thumb_image = wp_get_attachment_url( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
								$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), false, array(
									'title'	=> $image_title,
									'alt'	=> $image_title,
									'class' => 'product-slider-image',
									'data-zoom-image' => $image_link
								) );
								$image_class = esc_attr( implode( ' ', $classes ) );						
			
								if ( $image_caption != "" ) {
									$caption_html = '<div class="img-caption">' . $image_caption . '</div>';
								}
			
								echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li data-thumb="%s">%s%s<a href="%s" class="%s lightbox" data-rel="ilightbox[product]" data-caption="%s" title="%s" alt="%s"><i class="fa-search-plus"></i></a></li>', $thumb_image, $caption_html, $image, $image_link, $image_class, $image_caption, $image_title, $image_alt ), $attachment_id, $post->ID, $image_class );
		
								$loop++;
							}
		
						}
					?>
				</ul>
			
			<?php } ?>
			
		</div>
	
	</div>

<?php } ?>
	