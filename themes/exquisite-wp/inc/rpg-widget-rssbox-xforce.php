<?php
class RPG_RSSBoxXForce extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_RSSBoxXForce',
			'description' => 'RPG - X-Force RSS Box'
		);

		$this->WP_Widget('RPG_RSSBoxXForce', 'RPG - X-Force RSS Box', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Subscribe to X-Force-only RSS button for use on sidebars.</p>';
	}

	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	 
	//display the widget
	function widget($args, $instance) {
		$return = '';
		$return .= '<div class="widget cf widget_rss_box">';
		$return .= '
			<div class="wrb_left">
				Threat Center
			</div>
			<a class="wrb_right" href="/feed/?post_type%5B0%5D=ibm_malware&post_type%5B1%5D=ibm_vulnerabilities&post_type%5B2%5D=ibm_general_advisory" target="_blank">Subscribe+</a>
			<div class="clear"></div>
		';
		$return .= '</div>';
		echo $return;

	}
 
}
 
add_action('widgets_init', 'RPG_RSSBoxXForce_register');
function RPG_RSSBoxXForce_register() {
	register_widget('RPG_RSSBoxXForce');
}
?>