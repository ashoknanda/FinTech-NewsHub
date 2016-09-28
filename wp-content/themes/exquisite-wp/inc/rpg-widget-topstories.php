<?php
class RPG_TopStories extends WP_Widget {
 
	// process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_TopStories',
			'description' => 'RPG - Top Stories Widget'
		);

		$this->WP_Widget('RPG_TopStories', 'RPG - Top Stories', $option);

	}
 
	// build the widget settings form
	function form($instance) {
		echo '<p>Place any sidebar to display Top Stories. <br><br>To add a post to this list, use the <em>Options & Settings</em> box on the Edit/Create Post screen.</p>';
	}
	 
	// save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	 
	// display the widget
	function widget($args, $instance) {

		$args = array(
			'posts_per_page' => 3,
			'order' => 'DESC',
			'orderby' => 'date',
			'meta_query' => array(
				array(
					'key' => '_ibm_featured_locations',
					'value' => 'topstories',
					'compare' => 'like'
				)
			)
		);
		$the_query = new WP_Query($args);

		if ($the_query->have_posts()) {
			?>

			<div class="widget cf widget_top_stories">
				<h6>Top Stories:</h6>
				<ul>

			<?php
			while ($the_query->have_posts()) {
				$the_query->the_post();
				$excerpt = wordwrap(get_the_excerpt(), 180);
				$excerpt = explode("\n", $excerpt);
				$excerpt = $excerpt[0] . '...';
				?>

					<li>
						<span class="wts_cat"><?php echo thb_DisplaySingleCategory(false,false,false); ?></span>
						<a class="wts_title" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
						<a class="wts_author" href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>" title="<?php echo get_the_author(); ?>">By <?php echo get_the_author(); ?></a>
						<p class="wts_excerpt"><?php echo $excerpt; ?></p>
						<span class="wts_meta"><?php echo get_the_date(); ?></span>
					</li>


					<?php
				}
				?>

				</ul>

			</div>

			<?php

		}

		wp_reset_postdata(); // they don't think it be like it is, but it do.

		?>

		<?php
	}
 
}
 
add_action('widgets_init', 'RPG_TopStories_register');
function RPG_TopStories_register() {
	register_widget('RPG_TopStories');
}
?>