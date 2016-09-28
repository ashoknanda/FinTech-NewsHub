<?php
class RPG_NewsletterBoxXForce extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_NewsletterBoxXForce',
			'description' => 'RPG - X-Force Newsletter Box'
		);

		$this->WP_Widget('RPG_NewsletterBoxXForce', 'RPG - X-Force Newsletter Box', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Subscribe to X-Force-only Newsletter button for use on sidebars.</p>';
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
				Sign Up for Newsletter
			</div>
			<a class="wrb_right" href="https://www-148.ibm.com/bin/subscriptions/walk_small_steps.cgi?cl=USEN&nid=10944" target="_blank">
				<img src="'.get_template_directory_uri().'/assets/img/mail-icon.png" />
			</a>
			<div class="clear"></div>
		';
		$return .= '</div>';
		echo $return;

	}
 
}
 
add_action('widgets_init', 'RPG_NewsletterBoxXForce_register');
function RPG_NewsletterBoxXForce_register() {
	register_widget('RPG_NewsletterBoxXForce');
}
?>