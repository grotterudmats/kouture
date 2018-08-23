<?php


/*
Plugin Name:  Dynamic Products/Brands in menu
Author: Herosjourney
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function _create_menu_items($title, $url, $order, $parent=0) {
  $item = new stdClass();
  $item->ID = 1000000 + $order + $parent;
  $item->db_id = $item->ID;
  $item->title = $title;
  $item->url = $url;
  $item->menu_order = $order;
  $item->menu_item_parent = $parent;
  $item->type = '';
  $item->object = '';
  $item->object_id = '';
  $item->classes = array();
  $item->target = '';
  $item->attr_title = '';
  $item->description = '';
  $item->xfn = '';
  $item->status = '';
  return $item;
}

add_filter("wp_get_nav_menu_items", function ($items, $menu, $args) {
  if(is_admin() || $menu->name != 'Main Menu') {
    return $items;
  }

  $brands = get_terms('product_brand');
  $categories = get_terms('product_cat');

	$order = ($items[sizeof($items)-1]->ID)+1;
  foreach($items as $index => $item) {
    if($item->title == 'Merker') {
      foreach($brands as $brand) {
        $new = _create_menu_items($brand->name, "/brand/" . $brand->slug, $order, $item->ID);
        $items[] = $new;
        $order++;
      }
    }
    $order++;
  }
  return $items;
}, 10, 3);

?>
