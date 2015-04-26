<?php if (!defined('FCPATH')) die('no direct script access allowed!');

function load_menu($slug) {
    $menu_locations = get_nav_menu_locations();

    $items = array();
    if(isset($menu_locations[$slug])) {
        $menu_id = $menu_locations[$slug];
        $menu = wp_get_nav_menu_items($menu_id);

        foreach($menu as &$item) {
            $item->children = array();
            $item->active = false;

            if($item->menu_item_parent == 0) {
                if($item->object_id == get_the_ID()) $item->active = true;

                $items[] = $item;
            } else {
                foreach($items as &$parent) {
                    if($parent->ID == $item->menu_item_parent) {
                        $parent->children[] = $item;

                        if($item->object_id == get_the_ID()) {
                            $item->active = true;
                            $parent->active = true;
                        }
                    }
                }
            }
        }
    }

    return $items;
}