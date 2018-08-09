<?php
  function plugin_init() {
  }
  add_action('init', 'plugin_init');

    /*
  function pre_post_update($product_id, $data) {
    file_put_contents($product_id . ".output.json", json_encode($data));
  } 
  add_action('pre_post_update', 'pre_post_update', 10, 2);
  add_action('save_post_product', 'mp_sync_on_product_save', 10, 3);
  function mp_sync_on_product_save( $post_id, $post, $update ) {
      $product = wc_get_product( $post_id );
      // do something with this product
  }
     */

  add_filter("woocommerce_rest_pre_insert_product_object", function($product, $request, $creating) {
    $product->set_name($product->id . " asdf");
    return $product;
  }, 10, 3);

?>
