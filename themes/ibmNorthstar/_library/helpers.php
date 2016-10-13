<?php

// ---------------------------------------------------------------------------

function widont($str = '') {
    $str = rtrim($str);
    $space = strrpos($str, ' ');
    if ($space !== false) {
        $str = substr($str, 0, $space).'&nbsp;'.substr($str, $space + 1);
    }
    return $str;
}


// ---------------------------------------------------------------------------

function get_topic_category($post_categories){
    $pcategory_name = '';
    foreach ($post_categories as $pcategory):
      if ($pcategory->category_parent === get_cat_ID('Topics')){
        $pcategory_name = $pcategory->cat_name;
      }
    endforeach;
    return $pcategory_name;
}

