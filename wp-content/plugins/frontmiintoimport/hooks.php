<?php
  function plugin_init() {
  }
  add_action('init', 'plugin_init');


  /*
   * Hook to make sure certain user edited fields are not overwritten when syncing
   */

  add_filter("woocommerce_rest_pre_insert_product_object", function($product, $request, $creating) {

    //If we are creating a product do nothing
    if($creating)
      return $product;

    //Let's check the meta what protected fields have been manually edited and set them to the current value

    $current = wc_get_product($product->id);

    $protected_fields = array(
      'description',
      'name',
    );

    foreach($protected_fields as $field) {
      $product->{"set_" . $field}($current->$field); //Overwrite to old value
    }

    return $product;
  }, 10, 3);

?>
