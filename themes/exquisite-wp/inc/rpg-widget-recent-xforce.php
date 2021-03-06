<?php
class RPG_RecentPostsXforce extends WP_Widget {

	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_RecentPostsXforce',
			'description' => 'RPG - Recent X-Force Posts Widget'
		);

		$this->WP_Widget('RPG_RecentPostsXforce', 'RPG - Recent X-Force Posts', $option);

	}

	//build the widget settings form
	function form($instance) {
		echo '<p>Place any sidebar to display recent X-Force posts with images.</p>';
	}

	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}

	//display the widget
	function widget($args, $instance) {

		$return = '';
		$return .= '<div class="widget cf widget_recent_posts">';
		// $return .= '<h6>Recent Posts:</h6>';

		$return .= '<ul>';

		//use a different set of args if not a category page
		//if we are a category lets remove posts that should be hidden
		if( is_category() ) {
			$args = array(
				'posts_per_page' => 1,
				'order' => 'DESC',
				'orderby' => 'date',
				'cat' => '97',
				'tax_query' => array(
					array(
						'taxonomy'  => 'hide_posts',
						'field'     => 'slug',
						'terms'     => 'topics', // exclude items tagged with category
						'operator'  => 'NOT IN'
					)
				),
			);
		} elseif( is_author() ) {
			$args = array(
				'posts_per_page' => 1,
				'order' => 'DESC',
				'orderby' => 'date',
				'cat' => '97',
				'tax_query' => array(
					array(
						'taxonomy'  => 'hide_posts',
						'field'     => 'slug',
						'terms'     => 'contributors-page', // exclude items tagged with contributors-page
						'operator'  => 'NOT IN'
					)
				),
			);
		} elseif( is_front_page() ) {
			$args = array(
				'posts_per_page' => 1,
				'order' => 'DESC',
				'orderby' => 'date',
				'cat' => '97',
				'tax_query' => array(
					array(
						'taxonomy'  => 'hide_posts',
						'field'     => 'slug',
						'terms'     => 'homepage', // exclude items tagged with homepage
						'operator'  => 'NOT IN'
					)
				),
			);
		} else {
			$args = array(
				'posts_per_page' => 1,
				'order' => 'DESC',
				'orderby' => 'date',
				'cat' => '97',
			);
		}
		$the_query = new WP_Query($args);

		while ($the_query->have_posts()) {
			$the_query->the_post();
			$return .= '
			<li>
				<a class="wrp_thumb" href="' . get_permalink() . '" title="' . get_the_title() . '" target="_blank">' . get_the_post_thumbnail($post->ID, 'widget') . '</a>
				<a class="wrp_title" href="' . get_permalink() . '" title="' . get_the_title() . '" target="_blank">' . get_the_title() . '</a>
				<a class="wrp_author" href="' . get_author_posts_url(get_the_author_meta("ID")) . '" title="' . get_the_author() . '" target="_blank">By ' . get_the_author() . '</a>
				<span class="wrp_meta">' . get_the_date() . '</span>
			</li>';
		}

		wp_reset_postdata();

		$return .= '</ul>';
		$return .= '</div>';
		echo $return;

	}

}

add_action('widgets_init', 'RPG_RecentPostsXforce_register');
function RPG_RecentPostsXforce_register() {
	register_widget('RPG_RecentPostsXforce');
}
?>