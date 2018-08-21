<?php
/**
 * Simple helper function for make menu item objects
 * 
 * @param $title      - menu item title
 * @param $url        - menu item url
 * @param $order      - where the item should appear in the menu
 * @param int $parent - the item's parent item
 * @return \stdClass
 */ 
function _custom_nav_menu_item( $title, $url, $order, $parent = 0 ){
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
	//if( $menu->term_id != 24 ) return $items; // Where 24 is Menu ID, so the code won't affect other menus.
 
	// don't add child categories in administration of menus
	if (is_admin()) {
		return $items;
	}
	$ctr = ($items[sizeof($items)-1]->ID)+1;
	foreach ($items as $index => $i)
	{
		if ("product_cat" !== $i->object) {
			continue;
		}
		$menu_parent = $i->ID;
		$terms = get_terms( array('taxonomy' => 'product_cat', 'parent'  => $i->object_id ) );
		foreach ($terms as $term) {
			$new_item = _custom_nav_menu_item( $term->name, get_term_link($term), $ctr, $menu_parent );
			$items[] = $new_item;
			$new_id = $new_item->ID;
			$ctr++;
			$terms_child = get_terms( array('taxonomy' => 'product_cat', 'parent'  => $term->term_id ) );
			if(!empty($terms_child))
			{
				foreach ($terms_child as $term_child)
				{
					$new_child = _custom_nav_menu_item( $term_child->name, get_term_link($term_child), $ctr, $new_id );
					$items[] = $new_child;
					$ctr++;
				}
			}
		}
	}
 
	return $items;
}, 10, 3);
