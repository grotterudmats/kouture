<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
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
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$product_id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;
$product_type = method_exists( $product, 'get_type' ) ? $product->get_type() : $product->product_type;
$tooltip_text = "";
?>

<?php if ( ! $product->is_in_stock() ) : ?>
	<div class="add-to-cart-wrap" data-toggle="tooltip" data-placement="top" title="<?php _e("Sold out", "swiftframework"); ?>">
		<a href="<?php echo apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product_id ) ); ?>" class="product_type_soldout"><i class="sf-icon-soldout"></i><span><?php echo apply_filters( 'out_of_stock_add_to_cart_text', __( 'Out of stock', 'swiftframework' ) ); ?></span></a>
	</div>
	<?php echo sf_wishlist_button(); ?>

<?php else : ?>

	<?php
		$link = array(
			'url'   => '',
			'label' => '',
			'class' => '',
			'icon' => '',
			'icon_class' => '',
		);

		$handler = apply_filters( 'woocommerce_add_to_cart_handler', $product_type, $product );

		switch ( $handler ) {
			case "variable" :
				$link['url'] 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product_id ) );
				$link['icon_class'] = 'sf-icon-variable-options';
				$link['label'] 	= '<i class="sf-icon-variable-options"></i><span>' . apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'swiftframework' ) ) . '</span>';
				$tooltip_text = __("Select Options", "swiftframework");
			break;
			case "grouped" :
				$link['url'] 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product_id ) );
				$link['icon_class'] = 'sf-icon-variable-options';
				$link['label'] 	= '<i class="sf-icon-variable-options"></i><span>' . apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'swiftframework' ) ) . '</span>';
				$tooltip_text = __("View Options", "swiftframework");
			break;
			case "external" :
				$link['url'] 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product_id ) );
				$link['icon_class'] = 'fa-info';
				$link['label'] 	= '<i class="fa-info"></i><span>' . apply_filters( 'external_add_to_cart_text', __( 'Read More', 'swiftframework' ) ) . '</span>';
				$tooltip_text = __("Read More", "swiftframework");
			break;
			default :
				if ( $product->is_purchasable() && $product_type != "booking" ) {
					$link['url'] 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
					$link['icon_class'] = 'sf-icon-add-to-cart';
					$link['label'] 	= apply_filters( 'add_to_cart_icon', '<i class="sf-icon-add-to-cart"></i>' ) . '<span>' . apply_filters( 'add_to_cart_text', __( 'Add to cart', 'swiftframework' ) ) . '</span>';
					$link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button ajax_add_to_cart' );
					$tooltip_text = __("Add to cart", "swiftframework");
				} else {
					$link['url'] 	= apply_filters( 'not_purchasable_url', get_permalink( $product_id ) );
					$link['icon_class'] = 'sf-icon-soldout';
					$link['label'] 	= '<i class="sf-icon-soldout"></i><span>' . apply_filters( 'not_purchasable_text', __( 'Read More', 'swiftframework' ) ) . '</span>';
					$tooltip_text = __("Read More", "swiftframework");
				}
			break;
		}

		$loading_text = __( 'Adding...', 'swiftframework' );
		$added_text = __( 'Item added', 'swiftframework' );
		$added_text_short = __( 'Added', 'swiftframework' );
		$added_tooltip_text = __( 'Added to cart', 'swiftframework' );

		// Add to Cart
		echo '<div class="add-to-cart-wrap" data-toggle="tooltip" data-placement="top" title="'.$tooltip_text.'" data-tooltip-added-text="'.$added_tooltip_text.'">';
		echo apply_filters( 'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
			sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s" data-default_icon="%s" data-loading_text="%s" data-added_text="%s" data-added_short="%s" %s>%s</a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $product_id ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
				esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
				esc_attr( $product_type ),
				esc_attr( $link['icon_class'] ),
				esc_attr( $loading_text ),
				esc_attr( $added_text ),
					esc_attr( $added_text_short ),
				isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
				$link['label']
			),
		$product, $args );

		echo '</div>';


		// Wishlist Button
		echo sf_wishlist_button();

	?>

<?php endif; ?>
