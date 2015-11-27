<?php
/*
Plugin Name: Temp category exclude
Plugin Description: Wyłącza kategorię "tmp" z listy kategorii
Plugin URI: http://www.b4after.pl
Version: 1.0.1
Author: BEFORE AFTER
Author URI: http://www.b4after.pl
*/

add_filter('get_the_terms', 'hide_categories_terms', 10, 3);
function hide_categories_terms($terms, $post_id, $taxonomy){

    // list of category slug to exclude, 
    $exclude = array('tmp');

    if (!is_admin()) {
        foreach($terms as $key => $term){
            if($term->taxonomy == "category"){
                if(in_array($term->slug, $exclude)) unset($terms[$key]);
            }
        }
    }

    return $terms;
}