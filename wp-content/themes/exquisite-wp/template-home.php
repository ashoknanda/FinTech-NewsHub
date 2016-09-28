<?php
/*
Template Name: Home Page - Style 1
*/
?>
<?php get_header(); ?>
<div class="row">
	<?php
	$menu_name = 'home-slide1';
	$post_types_array = array( 'post', 'ibm_event', 'ibm_media' );
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		$post_ids = array();
		foreach ( (array) $menu_items as $key => $menu_item ) {
			if (is_numeric($menu_item->object_id) && in_array($menu_item->object, $post_types_array)) {
				array_push($post_ids, $menu_item->object_id);
			}
		}
		?>
		<section class="fullwidth twelve columns">
			<div id="featured" class="carousel owl row" data-columns="4" data-navigation="true" data-autoplay="false">
				<?php
				$i = 1;
				$args = array(
					'orderby' => 'post__in',
					'order' => 'ASC',
					'posts_per_page' => '10',
					'post__in' => $post_ids,
                    'post_status' => array('publish'),
					'tax_query' => array(
						array(
							'taxonomy'  => 'hide_posts',
							'field'     => 'slug',
							'terms'     => 'homepage', // exclude items tagged with homepage
							'operator'  => 'NOT IN'
						)
					),
				);
				?>
				<?php $query = new WP_Query($args); ?>
				<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
					<?php $category = thb_GetSingleCategory();
								$color = GetCategoryColor($category); ?>
				<article>
					<?php the_post_thumbnail('featured', array('class' => 'hidden')); ?>
					<div class="post front">
						<div class="post-gallery">
							<?php the_post_thumbnail('featured'); ?>
							<div class="overlay cat-on-bottom"></div>
						</div>
						<div class="post-title cat-on-bottom">
							<!--<aside><?php echo thb_DisplaySingleCategory(); ?></aside>-->
							<h2><a href="<?php the_permalink() ?>" rel="bookmark" onClick="_gaq.push(['_trackEvent', 'Homepage', 'Click', 'Homepage Hero Slider <?php echo $i; ?>']);"><?php echo ShortenText(get_the_title(), 70); ?></a></h2>
							<?php echo thb_DisplayPostMeta(true,false,true, false); ?>
						</div>
						<div class="post-category"><?php echo thb_DisplaySingleCategory(false, false, false); ?></div>
					</div>
				</article>
				<?php $i++; endwhile; else: endif; ?>
			</div>
		</section>
		<?php
	}
	?> 
	<section class="seven columns">
		<?php
		$menu_name = 'home-slide2';
		$post_types_array = array( 'post', 'ibm_event', 'ibm_media' );
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			$menu_items = wp_get_nav_menu_items($menu->term_id);
			$post_ids = array();
			foreach ( (array) $menu_items as $key => $menu_item ) {
				if (is_numeric($menu_item->object_id) && in_array($menu_item->object, $post_types_array)) {
					array_push($post_ids, $menu_item->object_id);
				}
			}
			?>
			<div id="slider" class="flex slider flex-start" data-bullets="true" data-controls="true">
				<ul class="slides">
					<?php
					$i = 1;
					$args = array(
						'orderby' => 'post__in',
						'order' => 'ASC',
						'posts_per_page' => '5',
						'post__in' => $post_ids,
                        'post_status' => array('publish'),
						'tax_query' => array(
							array(
								'taxonomy'  => 'hide_posts',
								'field'     => 'slug',
								'terms'     => 'homepage', // exclude items tagged with homepage
								'operator'  => 'NOT IN'
							)
						),
					);
					?>
					<?php $query = new WP_Query($args); ?>
					<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
					<li class="post">
						<div class="post-gallery">
							<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('slider'); ?></a>
							<div class="overlay"></div>
						</div>
						<div class="post-title">
							<!--<aside><?php echo thb_DisplaySingleCategory(); ?></aside>-->
							<h2><a href="<?php the_permalink() ?>" rel="bookmark" onClick="_gaq.push(['_trackEvent', 'Homepage', 'Click', 'Homepage Hero Slideshow <?php echo $i; ?>']);"><?php the_title(); ?></a></h2>
							<?php echo thb_DisplayPostMeta(true,true,true,true); ?>
							<div class="post-category"><?php echo thb_DisplaySingleCategory(false, false, false); ?></div>
						</div>
					</li>
					<?php $i++; endwhile; else: ?>
					<li>
						<?php _e( 'Please select tags from your Theme Options Page', THB_THEME_NAME ); ?>
					</li>
					<?php endif; ?>
				</ul>
			</div>
			<?php
		}
		?> 
		<section id="recentnews">
			<div class="headline"><h2><?php _e( 'Recent Articles', THB_THEME_NAME ); ?></h2></div>
			<?php 
				$args = array(
			  	   'posts_per_page' => '5',
			  	   'ignore_sticky_posts' => '1',
                    'post_status' => array('publish'),
					'tax_query' => array(
						array(
							'taxonomy'  => 'hide_posts',
							'field'     => 'slug',
							'terms'     => 'homepage', // exclude items tagged with homepage
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
			<a id="loadmore" href="#" data-loading="<?php _e( 'Loading ...', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Posts to Show', THB_THEME_NAME ); ?>" data-count="5" data-action="thb_ajax_home"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>
		</section>
	</section>
	<?php get_sidebar('left'); ?>
	<?php get_sidebar('right'); ?>
	<section class="five columns">
		<?php dynamic_sidebar('2col'); ?>
	</section>
</div>
<?php get_footer(); ?>