<?php
class RPG_FeaturedEvent extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_FeaturedEvent',
			'description' => 'RPG - Featured Event'
		);

		$this->WP_Widget('RPG_FeaturedEvent', 'RPG - Featured Event', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Place on any sidebar to display an upcoming featured event.</p>';
	}
	 
	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	 
	//display the widget
	function widget($args, $instance) {

		global $post;
		$category = get_the_category($post->ID);

		$widgetClass = '';
		if (is_front_page()) {
			$widgetClass .= ' home';
		}

		$args = array(
			'post_type' => 'ibm_event',
			'posts_per_page' => 1,
			'order' => 'DESC',
			'orderby' => 'meta_value',
			'meta_key' => '_ibm_event_end',
			'meta_query' => array(
				array(
					'key' => '_ibm_event_end',
					'value' => time(),
					'compare' => '>',
					'type' => 'NUMERIC'
				),
				// array(
				// 	'key'     => '_ibm_event_type',
				// 	'value'   => 'webinar',
				// 	'compare' => '='
				// ),
				array(
					'key' => '_ibm_event_featured_locations',
					'value' => 'featured_event',
					'compare' => 'like'
				)
			)
		);
		$the_query = new WP_Query($args);

		if ($the_query->have_posts()) {

			?>

			<div class="widget cf widget_featured_event<?php echo $widgetClass; ?>">

				<div class="wfe_wrapper">

					<?php
					while ($the_query->have_posts()) {
						$the_query->the_post();
						$timezone = get_post_meta( get_the_ID(), '_ibm_event_time_zone', true );
						if (!empty($timezone)) {
							date_default_timezone_set($timezone);
						}
						?>

						<div class="wfe_header">

							<a class="wfeh_link" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"></a>

							<div class="wfeh_title">Featured Event</div>

							<div class="wfeh_date"><?php echo date("F j, Y", get_post_meta( get_the_ID(), '_ibm_event_start', true )); ?></div>

						</div>

						<a class="wfe_title" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>

						<p class="wfe_excerpt"><?php echo get_the_excerpt(); ?></p>

						<a class="wfe_button" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">Register</a>

						<?php
						date_default_timezone_set('America/New_York'); // reset timezone to Eastern
					}
					?>

				</div>

			</div>

			<?php
		}

		wp_reset_postdata();

		echo $return;

	}
 
}
 
add_action('widgets_init', 'RPG_FeaturedEvent_register');
function RPG_FeaturedEvent_register() {
	register_widget('RPG_FeaturedEvent');
}
?>