<?php
class RPG_OnDemandWebinars extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_OnDemandWebinars',
			'description' => 'RPG - On-Demand Webinars'
		);

		$this->WP_Widget('RPG_OnDemandWebinars', 'RPG - On-Demand Webinars', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Place on any sidebar to display on-demand webinars.</p>';
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

		$args = array(
			'post_type' => 'ibm_event',
			'posts_per_page' => 3,
			'order' => 'DESC',
			'orderby' => 'meta_value',
			'meta_key' => '_ibm_event_end',
			'meta_query' => array(
				array(
					'key' => '_ibm_event_end',
					'value' => time(),
					'compare' => '<',
					'type' => 'NUMERIC'
				),
				array(
					'key'     => '_ibm_event_type',
					'value'   => 'webinar',
					'compare' => '='
				)
			)
		);
		$the_query = new WP_Query($args);

		if ($the_query->have_posts()) {

			$return .= '<div class="widget cf widget_upcoming_webinars">';
			$return .= '<h6>On-Demand Webinars:</h6>';
			$return .= '<ul>';

			while ($the_query->have_posts()) {
				$the_query->the_post();
				$attrs = get_timezone_arguments_element();				
				$return .= '
				<li>
					<a class="wuw_title" href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>
					<span class="wuw_date  change_timezone_text"'. $attrs.' data-timezone-type="9">' . date("F j, Y", get_post_meta( get_the_ID(), '_ibm_event_start', true )) . '</span>
				</li>';
			}

			$return .= '</ul>';
			$return .= '</div>';

		}

		wp_reset_postdata();

		echo $return;

	}
 
}
 
add_action('widgets_init', 'RPG_OnDemandWebinars_register');
function RPG_OnDemandWebinars_register() {
	register_widget('RPG_OnDemandWebinars');
}
?>