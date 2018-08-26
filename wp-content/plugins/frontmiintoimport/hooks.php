<?php

function plugin_init()
{
}
add_action('init', 'plugin_init');

/*
 * Hook to make sure certain user edited fields are not overwritten when syncing
 */

add_filter('woocommerce_rest_pre_insert_product_object', function ($product, $request, $creating) {

  //If we are creating a product do nothing
  if ($creating) {
    return $product;
  }

  //Let's check the meta what protected fields have been manually edited and set them to the current value

  $current = wc_get_product($product->id);

  $edited = json_decode(get_post_meta($product->id, '_front_miinto_edited_fields', true));

  $protected_fields = array(
    'description',
  );

  foreach ($protected_fields as $field) {
    //Overwrite to old value if it has been manually edited
    if (in_array($field, $edited['edited_fields'])) {
      $product->{"set_" . $field}($current->{"_get" . $field}());
    }
  }

  return $product;
}, 10, 3);


/*
 * Hook to add our edited fields to the product meta
 */

add_action('save_post_product', function ($post_id, $product, $update) {

  //$_POST Won't be set if we're not coming from wp-admin 
  if (!isset($_POST)) {
    return;
  }

  $product = wc_get_product($post_id);
  if (!$update) {
    //We need
    $edited = array('edited_fields' => array(), 'current' => $product->get_data());
    update_post_meta($post_id, '_front_miinto_edited_fields', json_encode($edited));
    return;
  }
  $edited = json_decode(get_post_meta($post_id, '_front_miinto_edited_fields', true));
  foreach ($product->get_data_keys() as $field) {
    if ($edited['current'][$field] != $product->{"get_" . $field}()) {
      $edited['edited_fields'][] = $key;
    }
  }

  // Make sure we have no duplicates
  $edited['edited_fields'] = array_unique($edited['edited_fields']);

  //Update current
  $edited['current'] = $product->get_data();

  update_post_meta($post_id, '_front_miinto_edited_fields', json_encode($edited));

}, 10, 3);
