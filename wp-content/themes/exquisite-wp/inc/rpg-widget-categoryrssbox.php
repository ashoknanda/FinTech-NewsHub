<?php
class RPG_CatRSSBox extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_CatRSSBox',
			'description' => 'RPG - RSS Box'
		);

		$this->WP_Widget('RPG_CatRSSBox', 'RPG - Category RSS Box', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Subscribe to RSS button for use on Category sidebar <em>only</em>.</p>';
	}
	 
	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	 
	//display the widget
	function widget($args, $instance) {

		if ( is_category() ) {

			$category = get_category( get_query_var('cat') );

			if ( ! empty( $category ) ) {

				$return = '';
				$return .= '<div class="widget cf widget_rss_box">';
				$return .= '
					<div class="wrb_left">
						' . $category->name . '
					</div>
					<a class="wrb_right" href="' . get_category_feed_link( $category->cat_ID ) . '" target="_blank">Subscribe+</a>
					<div class="clear"></div>
				';
				$return .= '</div>';
				echo $return;

			}

		}

	}
 
}
 
add_action('widgets_init', 'RPG_CatRSSBox_register');
function RPG_CatRSSBox_register() {
	register_widget('RPG_CatRSSBox');
}
?>