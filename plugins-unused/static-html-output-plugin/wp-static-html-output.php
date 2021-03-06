<?php
/*
Plugin Name: WP Static HTML Output
Plugin URI:  http://leonstafford.github.io/wordpress-static-html-output-plugin/
Description: WP Static HTML Output Plugin.
Version:     1.1.1
Author:      Leon Stafford
Author URI:  http://leonstafford.github.io
Text Domain: static-html-output-plugin

Copyright (c) 2016 Leon Stafford
 */

require_once 'library/StaticHtmlOutput/Exception.php';
require_once 'library/StaticHtmlOutput/Options.php';
require_once 'library/StaticHtmlOutput/View.php';
require_once 'library/StaticHtmlOutput/UrlRequest.php';
require_once 'library/StaticHtmlOutput.php';

StaticHtmlOutput::init(__FILE__);

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'pluginActionLinks');

/**
 * Adds link to options page from Plugins list
 * @return array
 */
function pluginActionLinks($links) 
{
	$settings_link = '<a href="tools.php?page=wp-static-html-output-options">' . __('Settings', 'static-html-output-plugin') . '</a>'; 
  	array_unshift( $links, $settings_link ); 
  	return $links; 	
}	

/**
 * Initializes localization 
 * @return void
 */

function myplugin_init() {
  
  load_plugin_textdomain( 'static-html-output-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
add_action('plugins_loaded', 'myplugin_init');
