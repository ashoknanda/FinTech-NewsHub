<?php get_header(); ?>
<div class="row">
	<section class="nine columns">
		<section id="recentnews">
			<?php global $query_string; // required
						$args = array_merge( 
							$wp_query->query_vars, 
							array( 
								'posts_per_page' => '7',
								'tax_query' => array(
									array(
										'taxonomy'  => 'hide_posts',
										'field'     => 'slug',
										'terms'     => 'categories', // exclude items tagged with homepage
										'operator'  => 'NOT IN'
									)
								)
							)
						);
						$query = new WP_Query($args); ?>
			<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
			<article class="post">
				<div class="row">
					<div class="four columns">
						<div class="post-gallery">
							<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('widget'); ?></a>
							<?php echo thb_DisplayImageTag(get_the_ID()); ?>
						</div>
					</div>
					<div class="eight columns">
						<div class="post-title">
							<aside><?php echo thb_DisplaySingleCategory(false,false,false); ?></aside>
							<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						</div>
						<div class="post-content">
							<p><?php echo ShortenText(get_the_excerpt(), 250); ?></p>
							<?php echo thb_DisplayPostMeta(true,true,true,false); ?>
						</div>
					</div>
				</div>
			</article>
			<?php endwhile; else: endif; ?>
			<?php theme_pagination($query->max_num_pages, 1, true); ?>
		</section>
	</section>
	<?php get_sidebar('category'); ?>
</div>
<?php get_footer(); ?>
