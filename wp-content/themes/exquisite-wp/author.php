<?php get_header(); ?>
<?php
global $authordata;
$authordata = get_user_by( 'slug', get_query_var( 'author_name' ) );
?>
<div class="row">

	<section class="nine columns">

		<section id="author-page">

			<div class="row">
				<div class="two columns">
					 <?php echo get_avatar( get_the_author_meta( 'ID'), '124'); ?>
				</div>
				<div class="ten columns">
					<strong><?php the_author_posts_link(); ?></strong>
					<p><?php the_author_meta('description'); ?></p>
					<?php if(get_the_author_meta('url') != '') { ?>
						<a href="<?php echo get_the_author_meta('url'); ?>" target="_blank" class="boxed-icon rounded"><i class="fa fa-link icon-1x"></i></a>
					<?php } ?>
					<?php if(get_the_author_meta('twitter') != '') { ?>
						<a href="<?php echo get_the_author_meta('twitter'); ?>" target="_blank" class="boxed-icon rounded twitter"><i class="fa fa-twitter icon-1x"></i></a>
					<?php } ?>
					<?php if(get_the_author_meta('facebook') != '') { ?>
						<a href="<?php echo get_the_author_meta('facebook'); ?>" target="_blank" class="boxed-icon rounded facebook"><i class="fa fa-facebook icon-1x"></i></a>
					<?php } ?>

					<?php if(get_the_author_meta('_ibm_contributor_linkedin') != '') { ?>
						<a href="<?php echo get_the_author_meta('_ibm_contributor_linkedin'); ?>" target="_blank" class="boxed-icon rounded linkedin"><i class="fa fa-linkedin icon-1x"></i></a>
					<?php } ?>

					<?php if(get_the_author_meta('googleplus', $author->ID) != '') { ?>
						<a href="<?php echo get_the_author_meta('googleplus'); ?>" target="_blank" class="boxed-icon rounded google-plus"><i class="fa fa-google-plus icon-1x"></i></a>
					<?php } ?>

					<a href="<?php echo get_author_feed_link( get_the_author_meta( 'ID'), ''); ?>" target="_blank" class="boxed-icon rounded rss" title="<?php echo get_the_author_meta('display_name', $author->ID); ?>'s RSS Feed"><i class="fa fa-rss icon-1x"></i></a>
				</div>
			</div>

		</section>

		<section id="recentnews">

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="post">
						<div class="row">
							<div class="four columns">
								<div class="post-gallery">
									<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('recent'); ?></a>
									<?php if ( 'ibm_news' == get_post_type() ) { ?>
										<a href="<?php the_permalink() ?>" rel="bookmark" class="news-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg-widget-recent-news-white.png"></a>
									<?php } ?>
								</div>
							</div>
							<div class="eight columns">
								<div class="post-title">
									<aside><?php echo thb_DisplaySingleCategory(false); ?></aside>
									<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
								</div>
								<div class="post-content">
									<p><?php echo ShortenText(get_the_excerpt(), 200); ?></p>
									<?php echo thb_DisplayPostMeta(true,true,true,false); ?>
								</div>
							</div>
						</div>
					</article>
				<?php endwhile; ?>
			<?php endif; ?>

			<?php
			// BEGIN CO-AUTHOR SECTION
			$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
			$args = array(
				'posts_per_page' => '99',
				'post_type' => array('post', 'ibm_news', 'ibm_media'),
				'meta_query' => array(
					array(
						'key' => '_ibm_co_contributors',
						'value' => $author->ID,
						'compare' => 'LIKE'
					)
				),
				'tax_query' => array(
					array(
						'taxonomy'  => 'hide_posts',
						'field'     => 'slug',
						'terms'     => 'contributors-page', // exclude items tagged with contributors-page
						'operator'  => 'NOT IN'
					)
				),
			);

			$query = new WP_Query($args);

			if ($query->have_posts()) : ?>

				<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php $_co_contributor_array = get_post_meta(get_the_ID(),'_ibm_co_contributors',true); ?>
				<?php foreach($_co_contributor_array as $_co_contributor_id): ?>
						<?php if($_co_contributor_id == $author->ID): ?>
							<article class="post">
								<div class="row">
									<div class="four columns">
										<div class="post-gallery">
											<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('recent'); ?></a>
											<?php if ( 'ibm_news' == get_post_type() ) { ?>
												<a href="<?php the_permalink() ?>" rel="bookmark" class="news-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg-widget-recent-news-white.png"></a>
											<?php } ?>
										</div>
									</div>
									<div class="eight columns">
										<div class="post-title">
											<aside><?php echo thb_DisplaySingleCategory(false); ?></aside>
											<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
										</div>
										<div class="post-content">
											<p><?php echo ShortenText(get_the_excerpt(), 200); ?></p>
											<?php echo thb_DisplayPostMeta(true,true,true,false); ?>
										</div>
									</div>
								</div>
							</article>
						<?php endif; ?>
				<?php endforeach; ?>

			<?php endwhile; endif; wp_reset_postdata();
			// END CO-AUTHOR SECTION
			?>

		</section>

	</section>

	<?php get_sidebar('author'); ?>

</div>

<?php get_footer(); ?>