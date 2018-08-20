<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
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
 * @version     3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( version_compare( WC_VERSION, '3.3', '>=' )) {
	$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
	if ($total <= 1 ) {
		return;
	}
}

global $sf_options;

$pagination = "standard";
if ( isset( $sf_options['product_display_pagination'] ) ) {
    $pagination = $sf_options['product_display_pagination'];
}
?>

<?php if ( $pagination == "infinite-scroll" ) { ?>
<nav class="woocommerce-pagination pagination-wrap hidden infinite-scroll-enabled">
<?php } else if ( $pagination == "load-more" ) { ?>
<a href="#" class="load-more-btn"><?php _e( 'Load More', 'swiftframework' ); ?></a>
<nav class="woocommerce-pagination pagination-wrap load-more hidden infinite-scroll-enabled">
<?php } else { ?>
<nav class="woocommerce-pagination pagination-wrap">
<?php } ?>
	<?php
		if ( version_compare( WC_VERSION, '3.3', '>=' ) ) {
			$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
			$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
			$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
			$format  = isset( $format ) ? $format : '';

			if ( $total <= 1 ) {
				return;
			}
			$pagination = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
				'base'         => $base,
				'format'       => $format,
				'add_args'     => false,
				'current'      => max( 1, $current ),
				'total'        => $total,
				'prev_text'    => apply_filters( 'sf_pagination_prev_text', __( '&larr;', 'swift-framework' ) ),
				'next_text'    => apply_filters( 'sf_pagination_next_text', __( '&rarr;', 'swift-framework' ) ),
				'type'         => 'list',
				'end_size'     => 3,
				'mid_size'     => 3
			) ) );
			$pagination = str_replace( "<ul class='page-numbers'>", '<ul class="bar-styling pagenavi">', $pagination );
			echo $pagination;
		} else {
			global $wp_query;
			$pagination = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
				'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
				'format'       => '',
				'add_args'     => '',
				'current'      => max( 1, get_query_var( 'paged' ) ),
				'total'        => $wp_query->max_num_pages,
				'prev_text'    => apply_filters( 'sf_pagination_prev_text', __( '&larr;', 'swift-framework' ) ),
				'next_text'    => apply_filters( 'sf_pagination_next_text', __( '&rarr;', 'swift-framework' ) ),
				'type'         => 'list',
				'end_size'     => 3,
				'mid_size'     => 3
			) ) );
			$pagination = str_replace( "<ul class='page-numbers'>", '<ul class="bar-styling pagenavi">', $pagination );
			echo $pagination;
		}
	?>
</nav>
