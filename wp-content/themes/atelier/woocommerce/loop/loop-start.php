<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
	
global $sf_options, $sf_product_multimasonry;
$product_multi_masonry = $sf_options['product_multi_masonry'];
$product_display_type = $sf_options['product_display_type'];
$product_display_gutters = $sf_options['product_display_gutters'];

// GET VARIABLES
if ( isset($_GET['product_display']) ) {
	$product_display_type = $_GET['product_display'];
}
if ( isset($_GET['product_gutters']) ) {
	$product_display_gutters = $_GET['product_gutters'];
}

$list_class = "";

if ( $product_multi_masonry ) {
	$list_class .= 'multi-masonry-items';
	$sf_product_multimasonry = true;
} else {
	$list_class .= 'product-grid';
	$sf_product_multimasonry = false;
}

$columns = '';
if ( function_exists('wc_get_loop_prop') ) {
	$columns = 'columns-' . wc_get_loop_prop( 'columns' );
}

?>
<?php if (!$product_display_gutters && ($product_display_type == "gallery" || $product_display_type == "gallery-bordered" || $product_multi_masonry)) { ?>
	<ul id="products" class="products <?php echo esc_attr($list_class); ?> no-gutters clearfix <?php echo esc_attr( $columns ); ?>">
<?php } else { ?>
	<ul id="products" class="products <?php echo esc_attr($list_class); ?> gutters row clearfix <?php echo esc_attr( $columns ); ?>">
<?php } ?>

		<?php if ( $product_multi_masonry ) { ?>
    		<div class="clearfix product col-sm-3 grid-sizer"></div>
    	<?php } ?>