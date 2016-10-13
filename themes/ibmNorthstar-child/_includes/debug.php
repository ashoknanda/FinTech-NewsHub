<?php
// Exit if accessed directly
defined('ABSPATH') or die("Nope!");
define('PRINT_R_ALL_PROCESSES', true);
define('SAVEQUERIES', true);
// define('WP_DEBUG_LOG', true );
// define('WP_DEBUG_DISPLAY', true);


/*
Make sure the following lines are in the wp-config.php

define('PRINT_R_ALL_PROCESSES', true);

if(defined('PRINT_R_ALL_PROCESSES') === PRINT_R_ALL_PROCESSES)
	define('SAVEQUERIES', true);
*/

// Call print_r_view function to print in footer of page.

add_action('wp_footer','print_r_calling');
add_action('admin_footer', 'remove_footer_admin');
add_action('print_r_view', 'print_num_queries');
add_action('print_r_view', 'print_get_current_user');
add_action('print_r_view', 'print_wpdb_queries');
add_action('print_r_view', 'print_get_post');
add_action('print_r_view', 'print_scripts');
add_action('print_r_view', 'print_styles');
add_action('print_r_view', 'print_included_files');
add_action('print_r_view', 'print_all_available_functions');
// add_action('print_r_view', 'print_member_template');

	/**
	 * prints views of debug on footer hook
	 */
	function print_r_calling(){
		do_action('print_r_view');
	}

	function remove_footer_admin () {
		do_action('print_r_view');
	}

	function print_num_queries (){
		global $wpdb;
		display_in_div_wrapper($wpdb->num_queries . ' queries in ' . timer_stop(0) . ' seconds');
	}

	function print_get_current_user (){
		$user_display = wp_get_current_user();


		display_in_pre_wrapper(print_r( $user_display, true) ,'wp_get_current_user', '#FDD9A0');
	}

	function print_wpdb_queries (){
		global $wpdb;
		display_in_pre_wrapper(print_r($wpdb->queries, true) ,'$wpdb queries', '#CDFFCD');
	}

	function print_get_post (){
		// $wp = new WP();
		// display_in_pre_wrapper(print_r($wp , true) ,'WP', '#bbccdd');
		$wp_post = get_post();
		display_in_pre_wrapper(print_r($wp_post , true) ,'get_post', '#bbccdd');
	}

	function print_scripts (){
		global $wp_scripts;
		display_in_pre_wrapper(print_r($wp_scripts,true), '$wp_scripts',"#FFCDCD");
	}

	function print_styles (){
		global $wp_styles;
		display_in_pre_wrapper(print_r($wp_styles,true), '$wp_styles',"#FFCDCD");
	}

	function print_included_files (){
		$included_files = get_included_files();
		display_in_pre_wrapper(print_r($included_files, true),'get_included_files');
	}

	function print_all_available_functions (){
		// global $think_db;
		// $BP_XProfile_Group = new BP_XProfile_Group(0);
		$vars_list = get_defined_vars();
		$function_list = get_defined_functions();
		$class_list = get_declared_classes();
		$constants_list = get_defined_constants();

		display_in_pre_wrapper(print_r($function_list["internal"] , true) ,'get_defined_functions ["internal"]');
		display_in_pre_wrapper(print_r($function_list["user"] , true) ,'get_defined_functions ["user"]');
		display_in_pre_wrapper(print_r($class_list , true) ,'get_declared_classes');
		display_in_pre_wrapper(print_r($constants_list , true) ,'get_defined_constants');
		// display_in_pre_wrapper(print_r($BP_XProfile_Group , true) ,'BP_XProfile_Group');
		// display_in_pre_wrapper(print_r($think_db , true) ,'$think_db');
	}

	// function print_member_template (){
	// 	global $members_template;
	// 	display_in_pre_wrapper(print_r($members_template, true),'$members_template');
	// }

/*
*
*
*
* --------------------------   OUTPUT ONLY PLUGIN AND THEME FILES  -------------------------
*
*
*
*/

class filter_included_files {
	private $main;
	private $theme;

	public function setup($template) {
		$this->plugin = wp_normalize_path( WP_PLUGIN_DIR );
		$this->theme = wp_normalize_path(get_theme_root()); // theme folder
		$this->main = wp_normalize_path($template); // main template

		return $template;
	}

	public function grab() {
		return array_filter(get_included_files(), array($this, 'filter') );
	}

	private function filter($file) {
		$norm =  wp_normalize_path($file);
		return ( strpos($norm, $this->theme) === 0 || strpos($norm, $this->plugin) === 0 ); // true if file is in theme dir
	}
}

$grabber = new filter_included_files;
add_action('print_r_view', array($grabber, 'setup'));
add_action('print_r_view', function() use($grabber) {
  display_in_pre_wrapper(print_r($grabber->grab(), true),'plugin files only', "#dcdcdc");
});

function wpa54064_inspect_scripts() {
	global $wp_scripts;
	$list_of_scripts = '';
	foreach( $wp_scripts->queue as $handle ) :
		$list_of_scripts .= $handle . '<br/>';
	endforeach;

	global $wp_styles;
	$list_of_styles = '';
	foreach( $wp_styles->queue as $s_handle ) :
		$list_of_styles .= $s_handle . '<br/>';
	endforeach;

	display_in_pre_wrapper($list_of_scripts,'enqued scripts');
	display_in_pre_wrapper($list_of_styles,'enqued styles');


}
// add_action( 'wp_footer', 'wpa54064_inspect_scripts' );

/*
*
*
*
* --------------------------   OUTPUT FORMATTING  ----------------------------------------
*
*
*
*/
add_action('think_r', 10, 1 );
	function think_r($results) {

		if ($results === NULL) {
		  $results = "Field is Null";
		}

		if ($results === '') {
		  $results = "Field is Empty";
		}

		display_in_pre_wrapper($results, $results[0]);
	}

function display_in_pre_wrapper($results, $fieldset='', $hex = NULL) {
	// trace_r($results);
	if ($hex === NULL)
		 $hex = display_rand_color();

	if ($results === NULL) {
	  $results = "Field is Null";
	  $fieldset = "No data";
	}

	if ($results === '') {
	  $results = "Field is Empty";
	  $fieldset = "Field is not set";
	}

	$pre_results = '<fieldset style="position:relative;margin:40px 20px 20px;border:2px solid #000;"><legend style="position: absolute;top: -25px;left: -2px;font-size: 12px;background-color: #000; color: #fff;padding: 5px 10px;line-height: 15px;display: block;">Displaying '.$fieldset.'</legend><pre style="background-color:'.$hex.';overflow:auto;white-space:pre-wrap;text-align:left;font-size:12px;font-family:monospace;margin:0;"><code style="background:none;display: block;margin:5px; max-height:300px;overflow:auto;word-break: break-all;">' . $results . "</code></pre></fieldset>";
	display_in_div_wrapper($pre_results);
}

function display_in_div_wrapper($results) {
	// trace_r($results);
	if (is_admin())
		echo '<div style=" margin: 20px 0 20px 160px; text-align:center;position:relative;">' . $results . '</div>';
	else
		echo '<div style=" margin: 20px auto 20px; text-align:center;position:relative;">' . $results . '</div>';
}

function display_rand_color() {
	return '#' . dechex(mt_rand(0xAA, 0xFF)) . dechex(mt_rand(0xAA, 0xFF)). dechex(mt_rand(0xAA, 0xFF));
}
