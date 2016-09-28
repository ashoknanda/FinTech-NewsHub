<?php get_header(); ?>
<div class="row">
	<section class="fullwidth archivepage twelve columns mediaPage">
		<div class="row masonry" data-columns="4">
			<?php global $query_string; // required
						$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => '12' ) );
						$query = new WP_Query($args); ?>
			<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
			<article class="item three columns mediaItem">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo get_the_title(); ?>"><?php the_post_thumbnail('recent'); ?></a>
				<h5><a href="<?php echo the_permalink(); ?>" rel="bookmark" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h5>
				<p class="mi_author">By <a href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>" title="<?php echo get_the_author(); ?>"><?php echo get_the_author(); ?></a></p>
				<p class="mi_date"><em><?php echo get_the_date(); ?></em></p>
			</article>
			<?php endwhile; else: ?>
			<article>
				<?php _e( 'Please select tags from your Theme Options Page', THB_THEME_NAME ); ?>
			</article>
			<?php endif; ?>
		</div>
		<?php theme_pagination($query->max_num_pages, 1); ?>
	</section>
</div>
<?php get_footer(); ?>