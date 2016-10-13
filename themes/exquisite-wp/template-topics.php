<?php
/*
Template Name: Topics
*/
?>
<?php get_header(); ?>
<div class="row">
	<hr class="space">
	<section class="nine columns">
		<section id="recentnews">
			<?php 
				$args = array(
			  	   'posts_per_page' => '5',
			  	   'ignore_sticky_posts' => '1',
			  	   'tax_query' => array(
						array(
							'taxonomy'  => 'hide_posts',
							'field'     => 'slug',
							'terms'     => 'topics', // exclude items tagged with homepage
							'operator'  => 'NOT IN'
						)
					),
				);
			?>
			<?php $query = new WP_Query($args); ?>
			<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
			<article class="post">
				<div class="row">
					<div class="five columns">
						<div class="post-gallery">
							<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('recent'); ?></a>
							<?php echo thb_DisplayImageTag(get_the_ID()); ?>
						</div>
					</div>
					<div class="seven columns">
						<div class="post-title">
							<aside><?php echo thb_DisplaySingleCategory(false,false,false); ?></aside>
							<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						</div>
						<div class="post-content">
							<p><?php echo ShortenText(get_the_excerpt(), 150); ?></p>
							<?php echo thb_DisplayPostMeta(true,true,true,true); ?>
						</div>
					</div>
				</div>
			</article>
			<?php endwhile; else: ?>
			<article>
				<?php _e( 'Please select tags from your Theme Options Page', THB_THEME_NAME ); ?>
			</article>
			<?php endif; ?>
			<a id="loadmore" href="#" data-loading="<?php _e( 'Loading ...', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Posts to Show', THB_THEME_NAME ); ?>" data-count="5" data-action="thb_ajax_topics"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>
		</section>
	</section>
	<?php get_sidebar('topics'); ?>
</div><?php get_footer(); ?>