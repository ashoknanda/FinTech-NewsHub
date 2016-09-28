<?php
class RPG_TrendingPosts extends WP_Widget {
 
	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_TrendingPosts',
			'description' => 'RPG - Trending Posts Widget'
		);

		$this->WP_Widget('RPG_TrendingPosts', 'RPG - Trending Posts', $option);

	}
 
	//build the widget settings form
	function form($instance) {
		echo '<p>Place any sidebar to display trending posts with images.</p>';
	}
	 
	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	 
	//display the widget
	function widget($args, $instance) {
		?>

		<div class="widget cf widget_trending_posts">

			<h6>Most Popular:</h6>

			<ul>

			<?php
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://q.addthis.com/feeds/1.0/trending.json?pubid=ra-53591bdd1bf9985c&period=month');
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$output = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($output, true);
			$post_ids_array = array();

			foreach ($data as $data_item) {
				// Loop through results, parse them into post ids, then put the post ids into an array
				$replace_array = array('http://securityintelligence.com/');
				$url = substr($data_item['url'], 0, strrpos( $data_item['url'], '/'));
				$url = str_replace($replace_array, '', $url);
				if (url_to_postid($url) !== 0) {
					$post_id = url_to_postid($url);
					if (get_post_type($post_id) == 'post') { // Only show posts (no events, pages, etc)
						array_push($post_ids_array, $post_id);
					}
				}
			}

			$post_ids_array = array_slice($post_ids_array, 0, 4); // make sure we only have 4 items (amount shown) in the array

			// Now take that array and run a wp_query against it
			
			//use a different set of args if not the home page
			//if we are the homepage lets remove posts that should be hidden
			if( is_front_page() ) {
				$args = array(
					'posts_per_page' => 4,
					'order' => 'DESC',
					'orderby' => 'date',
					'post__in' => $post_ids_array,
					'tax_query' => array(
						array(
							'taxonomy'  => 'hide_posts',
							'field'     => 'slug',
							'terms'     => 'homepage', // exclude items tagged with homepage
							'operator'  => 'NOT IN'
						)
					),
				);
			} elseif( is_front_page() ) {
				$args = array(
					'posts_per_page' => 4,
					'order' => 'DESC',
					'orderby' => 'date',
					'post__in' => $post_ids_array,
					'tax_query' => array(
						array(
							'taxonomy'  => 'hide_posts',
							'field'     => 'slug',
							'terms'     => 'topics', // exclude items tagged with topics
							'operator'  => 'NOT IN'
						)
					),
				);
			} elseif( is_front_page() ) {
				$args = array(
					'posts_per_page' => 4,
					'order' => 'DESC',
					'orderby' => 'date',
					'post__in' => $post_ids_array,
					'tax_query' => array(
						array(
							'taxonomy'  => 'hide_posts',
							'field'     => 'slug',
							'terms'     => 'contributors-page', // exclude items tagged with contributors page
							'operator'  => 'NOT IN'
						)
					),
				);
			} else {
				$args = array(
					'posts_per_page' => 4,
					'order' => 'DESC',
					'orderby' => 'date',
					'post__in' => $post_ids_array,
				);
			}
			$the_query = new WP_Query($args);
			
			while ($the_query->have_posts()) {
				$the_query->the_post();
				?>
				<li>
					<a class="wrp_thumb" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_post_thumbnail($post->ID, 'widget'); ?></a>
					<a class="wrp_title" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
					<a class="wrp_author" href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>" title="<?php echo get_the_author(); ?>">By <?php echo get_the_author(); ?></a>
					<!--<span class="wrp_meta"><?php echo get_the_date(); ?></span>-->
				</li>
				<?php
			}

			wp_reset_postdata();
			?>
			</ul>
		</div>

		<?php
	}
 
}
 
add_action('widgets_init', 'RPG_TrendingPosts_register');
function RPG_TrendingPosts_register() {
	register_widget('RPG_TrendingPosts');
}
?>