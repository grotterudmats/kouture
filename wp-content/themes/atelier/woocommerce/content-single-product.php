<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $post, $product, $sf_catalog_mode, $sidebar_config, $sf_options;

$product_layout = sf_get_post_meta($post->ID, 'sf_product_layout', true);
$default_product_product_layout = "standard";
if ( isset( $sf_options['default_product_product_layout'] ) ) {
	$default_product_product_layout = $sf_options['default_product_product_layout'];
}
if ( $product_layout == "" ) {
	$product_layout = $default_product_product_layout;
}
$fw_split_bg_color = sf_get_post_meta($post->ID, 'sf_fw_split_bg_color', true);

$pb_active = sf_get_post_meta($post->ID, '_spb_status', true);
if ($pb_active != "true") {
	$pb_active = sf_get_post_meta($post->ID, '_spb_js_status', true);
	if ($pb_active != "true") {
		$pb_active = false;
	}
}

$product_reviews_pos = "default";
if ( isset( $sf_options['product_reviews_pos'] ) ) {
$product_reviews_pos = $sf_options['product_reviews_pos'];
}

$extra_class = "";

$product_slider_thumbs_pos = "bottom";
if ( isset( $sf_options['product_slider_thumbs_pos'] ) ) {
	$product_slider_thumbs_pos = $sf_options['product_slider_thumbs_pos'];
	$extra_class .= ' woocommerce-thumb-nav--'. $product_slider_thumbs_pos . ' ';
}

if ( class_exists( 'Woocommerce_German_Market' ) ) {
	$extra_class .= "german-market-enabled ";
}

// Product page builder content
if ( $pb_active ) {
	
	$product_pbcontent_pos = "above";		
	if ( isset( $sf_options['product_pbcontent_pos'] ) ) {
		$product_pbcontent_pos = $sf_options['product_pbcontent_pos'];
	}
			
	if ( $product_pbcontent_pos == "above" ) {
		add_action( 'sf_product_before_tabs', 'sf_woo_product_page_builder_content', 10);
	} else {
		add_action( 'sf_product_after_tabs', 'sf_woo_product_page_builder_content', 10);
	}
}
?>

<?php if ( version_compare( WC_VERSION, '3.4', '>=' ) ) { ?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class($extra_class); ?>>
<?php } else { ?>
<div id="product-<?php the_ID(); ?>" <?php post_class($extra_class); ?>>
<?php } ?>

	<div class="entry-title" itemprop="name"><?php the_title(); ?></div>

	<?php if ($sidebar_config == "no-sidebars" && $product_layout != "fw-split") { ?>
	<div class="container product-main">
	<?php } else if ( $product_layout == "fw-split") { ?>
	<div class="product-main clearfix" style="background-color: <?php echo $fw_split_bg_color; ?>;">
	<?php } ?>

		<?php
			/**
			 * Hook: woocommerce_before_single_product.
			 *
			 * @hooked wc_print_notices - 10
			 */
			do_action( 'woocommerce_before_single_product' );

			if ( post_password_required() ) {
				echo get_the_password_form(); // WPCS: XSS ok.
				return;
			}
		?>

		<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="summary entry-summary">

			<div class="summary-top clearfix">

				<?php
					// WooCommerce Breadcrumb
					$breadcrumb_args = array('wrap_before' => '<nav class="woocommerce-breadcrumb">');
					woocommerce_breadcrumb($breadcrumb_args);
				?>
				
				<?php 
					// WooCommerce Title
					woocommerce_template_single_title();
				?>
				
				<?php
					// Navigation
					$has_cat = get_the_terms( $post->ID, 'product_cat' );
					if ($has_cat != 0) { ?>
						<div class="product-navigation">
							<div class="nav-previous"><?php previous_post_link( '%link', '<i class="fa-chevron-right"></i>', true, '', 'product_cat' ); ?></div>
							<div class="nav-next"><?php next_post_link( '%link', '<i class="fa-chevron-left"></i>', true, '', 'product_cat' ); ?></div>
						</div>
				<?php } ?>

			</div>

			<?php
				/**
				* Hook: woocommerce_single_product_summary.
				*
				* @hooked sf_product_price_rating - 10
				* @hooked sf_product_short - 20
				* @hooked woocommerce_template_single_add_to_cart - 30
				* @hooked woocommerce_template_single_meta - 40
				* @hooked sf_product_share - 45
				* @hooked woocommerce_template_single_sharing - 50
				*/

				do_action( 'woocommerce_single_product_summary' );
			?>


		</div><!-- .summary -->

	<?php if (($sidebar_config == "no-sidebars" && $product_layout != "fw-split") || ($product_layout == "fw-split")) { ?>
	</div>
	<?php } ?>

	<?php do_action( 'sf_product_before_tabs'); ?>
	
	<?php
	/**
	 * Product Tabs
	 */
	if ($sidebar_config == "no-sidebars") { ?>
		<div class="container product-after-summary">
	<?php } ?>

		<?php
			/**
			 * Hook: woocommerce_after_single_product_summary.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 *
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>

	<?php if ($sidebar_config == "no-sidebars") { ?>
		</div>
	<?php } ?>
	
	<?php do_action( 'sf_product_after_tabs'); ?>

	<?php
	/**
	 * Product Reviews
	 */
	if ( comments_open() && $product_reviews_pos == "default" ) { ?>
	<div id="product-reviews-wrap">
		<div class="container">
			<?php echo comments_template(); ?>
		</div>
	</div>
	<?php } ?>


	<?php
	/**
	 * Product Related
	 */
	if ($sidebar_config == "no-sidebars") { ?>
	<div class="container product-related-wrap">
	<?php } ?>

		<?php
			/**
			 * Hook: woocommerce_after_single_product_summary.
			 *
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'sf_after_single_product_reviews' );
		?>

	<?php if ($sidebar_config == "no-sidebars") { ?>
	</div>
	<?php } ?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>