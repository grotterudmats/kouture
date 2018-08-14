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

    $edited = get_post_meta($product->id, 'edited', true);

    $edited = empty($edited) ? array() : json_decode($edited);

    $protected_fields = array(
    'description',
    'name',
  );

    foreach ($protected_fields as $field) {
        //Overwrite to old value if it has been manually edited
        if (in_array($field, $edited)) {
            $product->{"set_" . $field}($current->$field);
        }
    }

    return $product;
}, 10, 3);


/*
 * Hook to add our edited fields to the product meta
 */

add_action('save_post_product', function ($product_id, $product, $update) {
    if (!$update || !isset($_POST)) {
        return;
    }

    //Get the product before the newer one
    $old_product = array_shift(wp_get_post_revisions($product_id));

    $edited = get_post_meta($old_product->id, 'edited', true);

    $edited = empty($edited) ? array() : json_decode($edited);
    return;

    foreach (array_keys($product) as $key) {
        if ($old_product->$key != $product->$key) {
            $edited[] = $key;
        }
    }

    $edited = array_unique($edited);

    update_post_meta($product_id, 'edited', json_encode($edited));
}, 10, 3);
