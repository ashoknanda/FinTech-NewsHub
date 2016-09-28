<?php
class RPG_Twitter extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_Twitter',
			'description' => 'RPG - Twitter Widget'
		);

		$this->WP_Widget('RPG_Twitter', 'RPG - Twitter', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Place on any sidebar to display Twitter feed.</p>';
	}
	 
	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	 
	//display the widget
	function widget($args, $instance) {

		$return = '';
		$return .= '<div class="widget cf widget_twitter">';
		$return .= '<h6>Twitter:</h6>';
		$return .= '
			<a class="twitter-timeline"  href="https://twitter.com/IBMSecurity" data-widget-id="525651230958157825">Tweets by @IBMSecurity</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		';
		$return .= '</div>';
		echo $return;

	}
 
}
 
add_action('widgets_init', 'RPG_Twitter_register');
function RPG_Twitter_register() {
	register_widget('RPG_Twitter');
}
?>