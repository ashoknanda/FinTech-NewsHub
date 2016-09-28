<?php
class RPG_CategoryPosts extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_CategoryPosts',
			'description' => 'RPG - Posts from Category'
		);

		$this->WP_Widget('RPG_CategoryPosts', 'RPG - Posts from Category', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Place on single posts to show other posts in the same category.</p>';
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
		$return .= '<div class="widget cf widget_category_posts">';
		$return .= '<h6>More In This Topic:</h6>';

		$return .= '<ul>';

		$args = array(
			'category__in' => end($category),
			'posts_per_page' => 5,
			'order' => 'DESC',
			'orderby' => 'date'
		);
		$the_query = new WP_Query($args);
		
		while ($the_query->have_posts()) {
			$the_query->the_post();
			$return .= '
			<li>
				<a class="wcp_title" href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>
				<a class="wcp_author" href="' . get_author_posts_url(get_the_author_meta("ID")) . '" title="' . get_the_author() . '">By ' . get_the_author() . '</a>
			</li>';
		}

		wp_reset_postdata();

		$return .= '</ul>';
		$return .= '</div>';
		echo $return;

	}
 
}
 
add_action('widgets_init', 'RPG_CategoryPosts_register');
function RPG_CategoryPosts_register() {
	register_widget('RPG_CategoryPosts');
}
?>