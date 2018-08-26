<?php
add_filter( 'woocommerce_rest_prepare_product_object', 'custom_change_product_response', 20, 3 );
add_filter( 'woocommerce_rest_prepare_product_variation_object', 'custom_change_product_response', 20, 3 );

function custom_change_product_response( $response, $object, $request ) {
  $variations    = $response->data['variations'];
  $variations_res   = array();
  $variations_array = array();
  $var              = array();
  if ( ! empty( $variations ) && is_array( $variations ) ) {
    foreach ( $variations as $variation ) {
      $variation_id                    = $variation;
      $variation                       = new WC_Product_Variation( $variation_id );
      $variation_attributes            = $variation->get_variation_attributes();
      $variations_res['variation_id']  = $variation_id;
      $variations_res['on_sale']       = $variation->is_on_sale();
      $variations_res['regular_price'] = (float) $variation->regular_price;
      $variations_res['sale_price']    = (float) $variation->sale_price;
      $variations_res['sku']           = $variation->get_sku();
      $variations_res['quantity']      = $variation->get_stock_quantity();
      if ( $variations_res['quantity'] == null ) {
        $variations_res['quantity'] = '';
      }
      $variations_res['in_stock']        = $variation->is_in_stock();
      foreach ( $variation_attributes as $key => $value ) {
        if ( $key == 'attribute_pa_color' ) {
          $variation_attributes[ $key ] = get_color_code_by_name( $value );
        }
      }
      $variations_res['variation_attributes'] = $variation_attributes;
      $variations_array[$variation->get_sku()]                     = $variations_res;

    }
  }
  $response->data['product_variations'] = $variations_array;
return $response;
}
