<?php $postId = $post->ID;
			$post_categories = wp_get_post_categories( $postId);
			$category = thb_GetSingleCategory();
			$categoryname = get_cat_name($category);
			$categorylink = get_category_link($category);
			$color = GetCategoryColor($category);
			$args = wp_parse_args(array(
				'category__in' => $post_categories,
				'ignore_sticky_posts'=> 1,
				'showposts' => 1,
				'post__not_in' => array($postId),
				'orderby' => 'rand',
				'no_found_rows' => true,
				'date_query' => array(
					array(
						'column' => 'post_date_gmt',
						'after'  => '3 months ago',
					),
				),
			));
			$query = new WP_Query($args);
?>
<!-- Start End Page Box -->
<?php if (ot_get_option('disablepageendbox') == 'no') { ?>
		<?php if ($query->have_posts()) : ?>
		<aside id="endpage-box" class="hide-on-print" style="border-color: <?php echo $color ?>;">
			<a href="#" class="close"><i class="fa fa-times"></i></a>
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<aside style="border-color: <?php echo $color ?>;"><a href="<?php echo $categorylink; ?>" style="color: <?php echo $color ?>;"><?php _e( 'MORE IN '.$categoryname, THB_THEME_NAME ); ?></a></aside>
				<h3><?php the_title(); ?></h3>
				<a href="<?php the_permalink(); ?>" class="btn more-link"><?php _e( 'READ MORE', THB_THEME_NAME ); ?></a>
			<?php endwhile; ?>
		</aside>
		<?php endif; ?>
		<?php wp_reset_query(); ?>
<?php } ?>
<!-- End End Page Box -->