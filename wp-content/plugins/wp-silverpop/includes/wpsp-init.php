<?php
function wpsp_admin_menue(){
  $iconUrl= WPSP_BASE_URL . '/images/logo.jpg';
	add_object_page('WP Silverpop', 'WP Silverpop', 8, __FILE__, 'wpsp_admin_option',$iconUrl);
	add_submenu_page( __FILE__, 'Silverpop setting','Silverpop setting', 8, __FILE__,'wpsp_admin_option' );  
  add_submenu_page(__FILE__, 'Popup setting', 'Popup setting', 8, 'wpsp-popup-setting', 'wpsp_popup_setting');  
}

function wpsp_install(){}
function wpsp_uninstall(){}

add_action('admin_menu', 'wpsp_admin_menue');
add_action( 'widgets_init', create_function( '', 'register_widget( "wpsp_widget" );' ) );
?>