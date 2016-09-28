<?php
class RPG_RecentNews extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_RecentNews',
			'description' => 'RPG - Recent News Widget'
		);

		$this->WP_Widget('RPG_RecentNews', 'RPG - Recent News', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Place any sidebar to display recent news with images.</p>';
	}
	 
	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	 
	//display the widget
	function widget($args, $instance) {

		$return = '';
		$return .= '<div class="widget cf widget_recent_news">';
		$return .= '<h6>News Stream:</h6>';

		$return .= '<ul>';

		//use a different set of args if not the home page
		//if we are the homepage lets remove news items that should be hidden
		if( is_front_page() ) {
			$args = array(
				'post_type' => 'ibm_news',
				'posts_per_page' => 7,
				'order' => 'DESC',
				'orderby' => 'date',
				'tax_query' => array(
					array(
						'taxonomy'  => 'hide_posts',
						'field'     => 'slug',
						'terms'     => array('homepage', 'news'), // exclude items tagged with homepage
						'operator'  => 'NOT IN'
					)
				),
			);
		} elseif( is_category() ) {
			$args = array(
				'post_type' => 'ibm_news',
				'posts_per_page' => 7,
				'order' => 'DESC',
				'orderby' => 'date',
				'tax_query' => array(
					array(
						'taxonomy'  => 'hide_posts',
						'field'     => 'slug',
						'terms'     => array('topics', 'news'), // exclude items tagged with topics
						'operator'  => 'NOT IN'
					)
				),
			);
		} elseif( is_author() ) {
			$args = array(
				'post_type' => 'ibm_news',
				'posts_per_page' => 7,
				'order' => 'DESC',
				'orderby' => 'date',
				'tax_query' => array(
					array(
						'taxonomy'  => 'hide_posts',
						'field'     => 'slug',
						'terms'     => array('contributors-page', 'news'), // exclude items tagged with contributors-page
						'operator'  => 'NOT IN'
					)
				),
			);
		} else {
			$args = array(
				'post_type' => 'ibm_news',
				'posts_per_page' => 7,
				'order' => 'DESC',
				'orderby' => 'date',
				'tax_query' => array(
					array(
						'taxonomy'  => 'hide_posts',
						'field'     => 'slug',
						'terms'     => 'news', // exclude items tagged with news
						'operator'  => 'NOT IN'
					)
				)
			);
		}
		$the_query = new WP_Query($args);
		
		while ($the_query->have_posts()) {
			$the_query->the_post();
			$return .= '
			<li>
				<a class="wrp_title" href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>
				<a class="wrp_author" href="' . get_author_posts_url(get_the_author_meta("ID")) . '" title="' . get_the_author() . '">By ' . get_the_author() . '</a>
				<span class="wrp_meta">' . get_the_date() . '</span>
			</li>';
		}

		wp_reset_postdata();

		$return .= '</ul>';
		$return .= '</div>';
		echo $return;

	}
 
}
 
add_action('widgets_init', 'RPG_RecentNews_register');
function RPG_RecentNews_register() {
	register_widget('RPG_RecentNews');
}
?>