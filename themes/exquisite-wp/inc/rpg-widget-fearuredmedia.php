<?php
class RPG_FeaturedMedia extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_FeaturedMedia',
			'description' => 'RPG - Featured Media'
		);

		$this->WP_Widget('RPG_FeaturedMedia', 'RPG - Featured Media', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Place on any sidebar to display the newest featured media item.</p>';
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
		$thumbType = 'widget';
		if (is_front_page()) {
			$widgetClass .= ' home';
			$thumbType = 'category-home3';
		}

		$args = array(
			'post_type' => 'ibm_media',
			'posts_per_page' => 1,
			'order' => 'DESC',
			'orderby' => 'date',
			'meta_query' => array(
				array(
					'key' => '_ibm_media_featured_locations',
					'value' => 'featured_media',
					'compare' => 'like'
				)
			)
		);
		$the_query = new WP_Query($args);

		if ($the_query->have_posts()) {

			?>

			<div class="widget cf widget_featured_media<?php echo $widgetClass; ?>">

				<h6>Featured Media:</h6>

				<ul>

					<?php
					while ($the_query->have_posts()) {
						$the_query->the_post();
						?>

						<li>

							<a class="wfm_thumb" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_post_thumbnail($post->ID, $thumbType); ?></a>
							
							<a class="wfm_title" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
							
							<span class="wfm_meta"><?php echo get_the_date(); ?></span>

						</li>

						<?php
					}
					?>

				</ul>

			</div>

			<?php
		}

		wp_reset_postdata();

		echo $return;

	}
 
}
 
add_action('widgets_init', 'RPG_FeaturedMedia_register');
function RPG_FeaturedMedia_register() {
	register_widget('RPG_FeaturedMedia');
}
?>