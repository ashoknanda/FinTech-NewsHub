<?php
/*
Template Name: News
*/
?>
<?php get_header(); ?>
<div class="row">
	<hr class="space">
	<section class="nine columns">
		<?php if(!is_paged()) { ?>
			<div id="slider" class="flex slider flex-start categoryslider" data-bullets="true" data-controls="true">
			<ul class="slides">
				<?php
				$args = array(
					'post_type' => array('ibm_news'),
			  	  	'posts_per_page' => '5',
			  	  	'ignore_sticky_posts' => '1',
			  	  	'tax_query' => array(
						array(
							'taxonomy'  => 'hide_posts',
							'field'     => 'slug',
							'terms'     => 'news', // exclude items tagged with news
							'operator'  => 'NOT IN'
						)
					)
			  	);
				$query = new WP_Query($args);
				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
				?>
				<li class="post">
					<div class="post-gallery">
						<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('category-slider'); ?></a>
						<div class="overlay"></div>
					</div>
					<div class="post-title">
						<div><img class="news-icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/bg-widget-recent-news-white.png"></div>
						<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<?php echo thb_DisplayPostMeta(true,true,true,true); ?>
					</div>
				</li>
				<?php endwhile; else: endif; wp_reset_postdata(); ?>
			</ul>
		</div>
		<?php } ?>
		<section id="recentnews">
			<?php
				$args = array(
					'post_type' => array('ibm_news'),
			  	  	'posts_per_page' => '5',
			  	  	'ignore_sticky_posts' => '1',
			  	  	'tax_query' => array(
						array(
							'taxonomy'  => 'hide_posts',
							'field'     => 'slug',
							'terms'     => 'news', // exclude items tagged with news
							'operator'  => 'NOT IN'
						)
					)
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
							<a href="<?php the_permalink() ?>" rel="bookmark" class="news-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg-widget-recent-news-white.png"></a>
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
			<a id="loadmore" href="#" data-loading="<?php _e( 'Loading ...', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Posts to Show', THB_THEME_NAME ); ?>" data-count="5" data-action="thb_ajax_news"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>
		</section>
	</section>
	<?php get_sidebar('news'); ?>
</div><?php get_footer(); ?>