<?php
class RPG_AddToCalendar extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_AddToCalendar',
			'description' => 'RPG - Add To Calendar'
		);

		$this->WP_Widget('RPG_AddToCalendar', 'RPG - Add To Calendar', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Add to Calendar button. Should <em>only</em> be used on the "Event Sidebar."</p>';
	}
	 
	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	 
	//display the widget
	function widget($args, $instance) {

		global $post;
		$category = get_the_category($post->ID);
		$event_start = get_post_meta( get_the_ID(), '_ibm_event_start', true );
		$event_end = get_post_meta( get_the_ID(), '_ibm_event_end', true );
		$timezone = get_post_meta( get_the_ID(), '_ibm_event_time_zone', true );

		if (is_numeric($event_end) && $event_end > time()) {

			if (!empty($timezone)) {
				date_default_timezone_set($timezone);
			}

			$attrs = get_timezone_arguments_element();


		?>

		<div class="widget cf widget_add_to_calendar change_timezone_text"<?php echo $attrs; ?> data-timezone-type="8">
			<div class="calendar">
				<a href="#" title="Add to Calendar" class="addthisevent">
					Add To Calendar
					<span class="_start"><?php echo date("m-d-y H:i:s", $event_start); ?></span>
					<span class="_end"><?php echo date("m-d-y H:i:s", $event_end); ?></span>
					<span class="_zonecode">35</span>
					<span class="_summary"><?php the_title(); ?></span>
					<span class="_description"><?php the_title(); ?></span>
					<span class="_location">Webinar</span>
					<span class="_date_format">MM/DD/YYYY</span>
				</a>
			</div>
		</div>

		<?php
		date_default_timezone_set('America/New_York'); // reset timezone to Eastern
		}
	}
 
}
 
add_action('widgets_init', 'RPG_AddToCalendar_register');
function RPG_AddToCalendar_register() {
	register_widget('RPG_AddToCalendar');
}
?>