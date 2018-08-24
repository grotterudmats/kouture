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
  $shoes = end(array_filter($categories, function($cat) {
    return strtolower($cat->name) == 'sko';
  }));
  $accessories = end(array_filter($categories, function($cat) {
    return strtolower($cat->name) == 'accessories';
  }));
  $categories = array_filter($categories, function($cat) {
    return strtolower($cat->name) != 'accessories' &&
      strtolower($cat->name) != 'sko';
  });

	$order = ($items[sizeof($items)-1]->ID)+1;
  foreach($items as $index => $item) {
    if($item->title == 'Produkter') {
      $subs = array_filter($categories, function($cat) {
        return $cat->parent == 0;
      });
      foreach($subs as $sub) {
        $new = _create_menu_items($sub->name, get_term_link($sub), $order, $item->ID);
        $items[] = $new;
        $order++;
			  $children = get_terms( array('taxonomy' => 'product_cat', 'parent'  => $sub->term_id ) );
        $parent_id = $new->ID;
        if(!empty($children)) {
          foreach($children as $child) {
            $new = _create_menu_items($child->name, get_term_link($child), $order, $parent_id);
            $items[] = $new;
            $order++;
          }
        }
      }
    }
    if($item->title == 'Sko') {
		  $subs = get_terms( array('taxonomy' => 'product_cat', 'parent'  => $shoes->term_id ) );
      foreach($subs as $sub) {
        $new = _create_menu_items($sub->name, get_term_link($sub), $order, $item->ID);
        $items[] = $new;
        $order++;
			  $children = get_terms( array('taxonomy' => 'product_cat', 'parent'  => $sub->term_id ) );
        if(!empty($children)) {
          foreach($children as $child) {
            $new = _create_menu_items($child->name, get_term_link($child), $order, $new->ID);
            $items[] = $new;
            $order++;
          }
        }
      }
    }
    if($item->title == 'Tilbehør') {
		  $subs = get_terms( array('taxonomy' => 'product_cat', 'parent'  => $accessories->term_id ) );
      foreach($subs as $sub) {
        $new = _create_menu_items($sub->name, get_term_link($sub), $order, $item->ID);
        $items[] = $new;
        $order++;
			  $children = get_terms( array('taxonomy' => 'product_cat', 'parent'  => $sub->term_id ) );
        if(!empty($children)) {
          foreach($children as $child) {
            $new = _create_menu_items($child->name, get_term_link($child), $order, $new->ID);
            $items[] = $new;
            $order++;
          }
        }
      }
    }
    if($item->title == 'Merker') {
      foreach($brands as $brand) {
        $new = _create_menu_items($brand->name, get_term_link($brand), $order, $item->ID);
        $items[] = $new;
        $order++;
      }
    }
    $order++;
  }
  return $items;
}, 10, 3);

?>
