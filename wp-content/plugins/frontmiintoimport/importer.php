<?php
require_once("./settings.php");
$GLOBALS["_SERVER"] = ["DOCUMENT_ROOT" => "."];
require_once($WORDPRESS_PATH . "wp-load.php");

define('WP_DEBUG', true);
require_once("./woocommerce.php");
require_once("./functions.php");
require_once("./front.php");

/*
$front_token = LOGIN("front-kouture@herosjourney.io", "@Kouture123!");


$front_filter = array(
  'includeEmptyGTINs' => false,
  'includeStockQuantity' => true,
  'pageSize' => 0,
  'pageSkip' => 0,
);

$front_products = json_decode(POST("${BASE_URL}Product", $front_filter, $front_token));

//Only import products with GTIN
$front_products = array_filter($front_products, function($p) {
  return !empty($p->productSizes[0]->gtin);
});
 */



/*
global $wpdb;
if(!empty($product_ids)) {
  $result = $wpdb->get_results("DELETE FROM $wpdb->posts WHERE id IN (" . join(',', $product_ids) . ")");
  print_r($result);
}
 */




$wcapi = new WooCommerceRestApi($WOOCOMMERCE_API_URL, $WOOCOMMERCE_API_CREDENTIALS);
$frontapi = new FrontSystemsApi('front-kouture@herosjourney.io', '@Kouture123!');

$wcapi->clear();

$miinto_products = json_decode(GET($MIINTO_URL));

$gtin_array = array();
foreach($miinto_products as $mp) {
  $gtin_array[(string)$mp->Gtin] = $mp;
}

$categories = array();
$brands = array();
foreach($frontapi->products as $p) {
  foreach($p->productSizes as $size) {
    $gtin = (string)$size->gtin;
    if(array_key_exists($gtin, $gtin_array))
      break;
  }
  if(array_key_exists($gtin, $gtin_array)) {

    //Categories

    $cat = $p->groupName;
    $sub = $p->subgroupName;
    $brands[] = $p->brand;

    if(!array_key_exists($cat, $categories)) {
      $categories[$cat] = array($sub);
    } else if (!in_array($sub, $categories[$cat])) {
      array_push($categories[$cat], $sub);
    }
  }
}

$brands = array_map(function($brand) {
  return array('name' => $brand);
}, array_unique($brands, SORT_STRING));
$wcapi->post('products/brands/batch', array('create' => $brands));

$brands = array();
foreach($wcapi->get('products/brands') as $brand) {
  $brands[$brand->name] = $brand->id;
};

foreach($categories as $cat => $subs) {
  $data = $wcapi->post('products/categories', array('name' => $cat));
  $parent_id = $data->id;
  $subs = array_map(function($sub) use ($parent_id) {
    return array('name' => $sub, 'parent' => $parent_id);
  }, $subs);
  $wcapi->post('products/categories/batch', array('create' => $subs));
}

$categories = array();
foreach($wcapi->get('products/categories') as $cat) {
  $categories[$cat->name] = $cat->id;
};

foreach($frontapi->products as $p) {

  $sizes = $p->productSizes;
  foreach($sizes as $size) {
    $gtin = (string)$size->gtin;
    if(array_key_exists($gtin, $gtin_array))
      break;
  }

  if(array_key_exists($gtin, $gtin_array)) {

    $cat = $p->groupName;
    $sub = $p->subgroupName;

    $cats = array();
    foreach(array($cat, $sub) as $key) {
      if(array_key_exists($key, $categories)) { 
        $id = $categories[$key];
        $cats[] = array('id' => $id);
      }
    }

    $miinto_data = $gtin_array[$gtin];

    $images = array_merge(array($miinto_data->ImageUrl), explode(',', $miinto_data->AdditionalImages));
    $images = array_map(function($url, $index) {
      return array('src' => $url, 'position' => $index, 'name' => end(explode('/', $url)));
    }, $images, array_keys($images));

    $images = array_filter($images, function($image) {
      return !empty($image['src']);
    });


    $size_options = array_map(function($size) {
      return (string)$size->label;
    }, $sizes);

    natsort($size_options);

    $product_data = array(
      'name' => $p->name,
      'sku' => (string)$p->productid,
      'description' => $miinto_data->Description,
      'images' => $images,
      'attributes' => array(
        array('variation' => true, 'id' => 1, 'name' => 'Størrelse', 'visible' => true, 'options' => $size_options),
      ),
      'regular_price' => (string)$miinto_data->OriginalPrice,
      'sale_price' => (string)$miinto_data->SalePrice,
      'categories' => $cats,
      'brands' => array($brands[$p->brand]),
      'type' => 'variable',
      'sizes' => $sizes,
    );

    $parent = $wcapi->post('products', $product_data);
    if(!$parent) {
      continue;
    }
    $variations = array();

    foreach($sizes as $size) {
      $variation = array(
        'sku' => $size->gtin,
        'regular_price' => (string)$miinto_data->OriginalPrice,
        'sale_price' => (string)$miinto_data->SalePrice,
        'stock_quantity' => $size->stockQty[0]->qty,
        'manage_stock' => true,
        'attributes' => array(
          array('id' => 1, 'option' => (string)$size->label),
        ),
      );
      $variations[] = $variation;
    }
    $result = $wcapi->post("products/" . $parent->id . "/variations/batch", array('create' => $variations));
  }
}


?>
