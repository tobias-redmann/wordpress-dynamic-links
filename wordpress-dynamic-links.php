<?php
/*
Plugin Name: WordPress Dynamic Links
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: The Plugin's Version Number, e.g.: 1.0
Author: Name Of The Plugin Author
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/


function get_post_url($atts){
 
  extract( shortcode_atts( array(
		'id' => null,
    'default' => '/'
	), $atts ) );
  
 
  if (!isset($id)) return $default;
  
  $post = get_post($id);
  
  if (isset($post)) {
    
    return get_permalink($id);
    
  } else {
    
    return $default;
    
  }
 
}

function get_category_url($atts) {
  
  extract( shortcode_atts( array(
		'id' => null,
    'default' => '/'
	), $atts ) );
  
  
  $category = get_term($id, 'category');
  
  
  if (isset($category)) {
    
    $link = get_term_link($category, $category->taxonomy);
   
    return $link;
    
  }
  
  return $default;
  
  
}

function get_custom_post_url($atts) {
  
  extract( shortcode_atts( array(
		'id' => null,
    'default' => '/'
	), $atts ) );
  
  return get_permalink($id);
  
}



add_shortcode( 'post_url', 'get_post_url');
add_shortcode( 'cat_url', 'get_category_url');

add_action('init', 'register_custom_types');


function register_custom_types() {

  $post_types = get_post_types(array('_builtin' => false));

  foreach($post_types as $slug => $name) {
    
    add_shortcode($slug. '_url', 'get_custom_post_url');
    
  }

}


?>