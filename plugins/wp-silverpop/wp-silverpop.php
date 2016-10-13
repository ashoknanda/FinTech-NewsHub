<?php
/*
Plugin Name: WP Silverpop Subscription
Plugin URI: http://www.solvercircle.com
Description: WP Silverpop plugin is a wordpress plugin which is used to Intrigate Silverpop with wordpress.User Can easily intigreate Silverpop subscription at widget area or popup.
Version: 1.1
Author: SolverCircle
Author URI: http://www.solvercircle.com
*/

define("WPSP_BASE_URL", WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)));

// add_action('init', 'set_wpsp_cookie');
function set_wpsp_cookie() {
    // yes, this is a PHP 5.3 closure, deal with it
    if (!isset($_COOKIE['wpsp_cookie'])) {        
        if(get_option('wpsp_popup_cookie')==0){
          setcookie("wpsp_cookie",1, time()+15);
        }else{
          setcookie("wpsp_cookie",1, time()+24*3600*get_option('wpsp_popup_cookie'));
        }
    }
}

include ('includes/wpsp-admin.php');
include ('includes/wpsp-popup-setting.php');
include ('includes/wpsp-popup-view.php');
include ('includes/wpsp-widget.php');
include ('includes/wpsp-email.php');
include ('includes/wpsp-init.php');

function wpsp_css(){
  $cssurl = WPSP_BASE_URL.'/css/wpsp-popup.css';
  // echo "<link rel='stylesheet' type='text/css' href='$cssurl' />\n";
}
add_action('wp_head', 'wpsp_css');

function wpsp_js(){        
  wp_enqueue_script('jquery');
  if(is_admin()){
    wp_enqueue_script( 'wpsp-jscolor', plugins_url( '/js/colorpicker/jscolor.js', __FILE__ ));  
  }
  // wp_enqueue_script( 'wpsp-popup', plugins_url( '/js/wpsp_popup.js', __FILE__ ));  
}
add_action('init','wpsp_js');
register_activation_hook( __FILE__, 'wpsp_install');
register_deactivation_hook( __FILE__, 'wpsp_uninstall');
?>