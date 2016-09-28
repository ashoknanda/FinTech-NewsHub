<?php
class RPG_RSSBoxNews extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_RSSBoxNews',
			'description' => 'RPG - News RSS Box'
		);

		$this->WP_Widget('RPG_RSSBoxNews', 'RPG - News RSS Box', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Subscribe to News-only RSS button for use on sidebars.</p>';
	}

	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	 
	//display the widget
	function widget($args, $instance) {

		global $post;
		$category = get_the_category($post->ID);

		$return = '';
		$return .= '<div class="widget cf widget_rss_box">';
		$return .= '
			<div class="wrb_left">
				News Stream RSS Feed
			</div>
			<a class="wrb_right" href="http://feeds.feedburner.com/securityintelligence/feed/news" target="_blank">Subscribe+</a>
			<div class="clear"></div>
		';
		$return .= '</div>';
		echo $return;

	}
 
}
 
add_action('widgets_init', 'RPG_RSSBoxNews_register');
function RPG_RSSBoxNews_register() {
	register_widget('RPG_RSSBoxNews');
}
?>