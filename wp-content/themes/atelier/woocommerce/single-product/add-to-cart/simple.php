<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $woocommerce, $product, $sf_options;

$loading_text = __( 'Adding...', 'swiftframework' );
$added_text = __( 'Item added', 'swiftframework' );
$button_class = "add_to_cart_button";
$ajax_enabled = true;
$minimum_allowed_quantity = 1;
$product_id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;

if ( isset($sf_options['product_addtocart_ajax']) ) {
	$ajax_enabled = $sf_options['product_addtocart_ajax'];
}

if ( !$ajax_enabled || ( defined('DOING_AJAX') && DOING_AJAX ) ) {
	$button_class = "single_add_to_cart_button";
}

if ( ! $product->is_purchasable() ) return;

// Availability
echo wc_get_stock_html( $product ); // WPCS: XSS ok.

// WooCommerce Min/Max Quanties Plugin
if ( class_exists( 'WC_Min_Max_Quantities_Addons' ) ) {
	$custom_min_qty = sf_get_post_meta( get_the_ID(), 'minimum_allowed_quantity', true );
	if ( $custom_min_qty != "" ) {
		$minimum_allowed_quantity = $custom_min_qty;
	}
}
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	 	<?php
			do_action( 'woocommerce_before_add_to_cart_quantity' );

			woocommerce_quantity_input( array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			) );

			do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>
		
	 	<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" data-product_id="<?php echo esc_attr($product_id); ?>" data-quantity="<?php echo esc_attr( $minimum_allowed_quantity ); ?>" data-default_text="<?php echo esc_attr($product->single_add_to_cart_text()); ?>" data-default_icon="sf-icon-add-to-cart" data-loading_text="<?php echo esc_attr($loading_text); ?>" data-added_text="<?php echo esc_attr($added_text); ?>" class="<?php echo $button_class; ?> ajax_add_to_cart product_type_simple button alt"><?php echo apply_filters('sf_add_to_cart_icon', '<i class="sf-icon-add-to-cart"></i>'); ?><span><?php echo esc_html($product->single_add_to_cart_text()); ?></span></button>
	 	
		<?php echo sf_wishlist_button(); ?>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php else : ?>

<?php echo sf_wishlist_button('oos'); ?>

<?php endif; ?>