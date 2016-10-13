<?php // X FORCE CATEGORY
get_header(); ?>
<div class="row">
	<?php if (is_category() && category_description()) { ?>
	<div class="row nine columns">
		<div class="two columns">
			<p><img class="x-force-topic-image" src="<?php echo get_template_directory_uri(); ?>/assets/img/XF-Logo.jpg" vspace="5"></p>
		</div>
		<div class="ten columns categoryDesc">
			<?php echo category_description(); ?>
		</div>
	</div>
	<?php } ?>
	<section class="nine columns">
		<?php if(!is_paged()) { ?>
			<div id="slider" class="flex slider flex-start categoryslider" data-bullets="true" data-controls="true">
			<ul class="slides">
				<?php global $query_string; // required
							$args = array_merge( 
								$wp_query->query_vars, 
								array( 
									'posts_per_page' => '5',
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
				<li class="post">
					<div class="post-gallery">
						<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('category-slider'); ?></a>
						<div class="overlay"></div>
					</div>
					<div class="post-title">
						<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<?php echo thb_DisplayPostMeta(true,true,true,true); ?>
					</div>
				</li>
				<?php endwhile; else: endif; ?>
			</ul>
		</div>
		<?php } ?>
		<section id="category">
			<?php
			$catid = get_cat_ID( single_cat_title( '', false ) );
			$args = array(
				'cat' => $catid,
				'posts_per_page' => 7,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'ignore_sticky_posts' => '1',
				'tax_query' => array(
					array(
						'taxonomy'  => 'hide_posts',
						'field'     => 'slug',
						'terms'     => 'categories', // exclude items tagged with homepage
						'operator'  => 'NOT IN'
					)
				)
			);

			$query = new WP_Query( $args );

			if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

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
							<?php echo thb_DisplayPostMeta(true,true,true,true); ?>
						</div>
					</div>
				</div>
			</article>

			<?php endwhile; else: endif; ?>

			<a id="loadmore" href="#" data-loading="<?php _e( 'Loading ...', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Posts to Show', THB_THEME_NAME ); ?>" data-count="7" data-catid="<?php echo get_cat_ID( single_cat_title( '', false ) ); ?>" data-action="thb_ajax_category"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>
		
		</section>
	</section>
	<aside class="sidebar three columns">
		<?php dynamic_sidebar('xforce'); ?>
	</aside>
</div>
<?php get_footer(); ?>
