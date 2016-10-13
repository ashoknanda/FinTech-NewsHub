<?php
/*
Template Name: Contributors
*/
?>
<?php get_header(); ?>
<div class="row">

	<?php
	// BEGIN: Featured Contributors
	// https://codex.wordpress.org/Class_Reference/WP_User_Query
	$args = array(
		'number' => 20,
		'orderby' => 'name',
		'order' => 'ASC',
		'meta_query' => array(
			0 => array(
				'key' => '_ibm_featured_contributor',
				'value' => 'on',
				'compare' => '='
			),
			1 => array(
				'key' => '_ibm_hidden_user',
				'compare' => 'NOT EXISTS'
			)
		),
	);
	$user_query = new WP_User_Query( $args );

	if ( ! empty( $user_query->results ) ) {
	?>

	<section class="fullwidth archivepage twelve columns contributors" id="featured-contributors">

		<div class="headline"><h2>Featured Contributors</h2></div>

		<div class="row" data-columns="4">

			<?php foreach ( $user_query->results as $user ) { 
				$user_title = get_user_meta( $user->id, '_ibm_contributor_title', true );
				$user_linkedin = get_user_meta( $user->id, '_ibm_contributor_linkedin', true );
				?>

			<article class="item three columns contributorItem">

				<a href="<?php echo get_author_posts_url( $user->id ); ?>" title="<?php echo $user->display_name; ?>"><?php echo get_avatar( $user->id, 70); ?></a>
				
				<h5><a href="<?php echo get_author_posts_url( $user->id ); ?>" title="<?php echo $user->display_name; ?>"><?php echo $user->display_name; ?></a></h5>

				<?php if (!empty($user->twitter)) : ?>
				
				<a href="<?php echo $user->twitter; ?>" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @twitterapi</a>
				
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				
				<?php endif; ?>

				<?php if (!empty($user_title)) : ?><p class="ci_title"><?php echo $user_title; ?></p><?php endif; ?>
				
				<p class="ci_count"><strong><?php echo rpg_count_user_posts( $user->id ); ?></strong> Posts</p>
								
				<?php if (!empty($user->description)) : ?><!--<p class="ci_bio"><?php echo $user->description; ?></p>--><?php endif; ?>
				
				<ul class="ci_social">
					
					<?php if (!empty($user->twitter)) : ?><li class="icon"><a href="<?php echo $user->twitter; ?>" target="_blank" class="twitter" title="<?php echo $user->display_name; ?> on Twitter">&#xf099;</a></li><?php endif; ?>

					<?php if (!empty($user->twitter)) : ?><li class="icon"><a href="<?php echo $user->facebook; ?>" target="_blank" class="facebook" title="<?php echo $user->display_name; ?> on Facebook">&#xf09a;</a></li><?php endif; ?>
					
					<?php if (!empty($user_linkedin)) : ?><li class="icon"><a href="<?php echo $user_linkedin; ?>" target="_blank" class="linkedin" title="<?php echo $user->display_name; ?> on LinkedIn">&#xf0e1;</a></li><?php endif; ?>

					<?php if (!empty($user->googleplus)) : ?><li class="icon"><a href="<?php echo $user->googleplus; ?>" target="_blank" class="googleplus" title="<?php echo $user->display_name; ?> on Google">&#xf0d5;</a></li><?php endif; ?>
					
					<li class="icon"><a href="<?php echo get_author_feed_link($user->id, ''); ?>" target="_blank" class="rss" title="<?php echo $user->display_name; ?>'s RSS Feed">&#xf09e;</a></li>
				
				</ul>
				
			</article>

			<?php } ?>

		</div>


		<hr class="thick">

	</section>

	<?php }
	wp_reset_postdata();
	// END: Featured Contributors
	?>

	<?php
	// BEGIN: All Contributors
	// https://codex.wordpress.org/Class_Reference/WP_User_Query
	$args = array(
		'number' => 12,
		'orderby' => 'name',
		'order' => 'ASC',
		'meta_query' => array(
			0 => array(
				'key' => '_ibm_featured_contributor',
				'compare' => 'NOT EXISTS'
			),
			1 => array(
				'key' => '_ibm_hidden_user',
				'compare' => 'NOT EXISTS'
			)
		),
	);
	$user_query = new WP_User_Query( $args );

	if ( ! empty( $user_query->results ) ) {
	?>

	<section class="fullwidth archivepage twelve columns contributors" id="main-contributors">

		<div class="row">

			<?php foreach ( $user_query->results as $user ) { 
				$user_title = get_user_meta( $user->id, '_ibm_contributor_title', true );
				$user_linkedin = get_user_meta( $user->id, '_ibm_contributor_linkedin', true );
				?>

			<article class="item three columns contributorItem">

				<a href="<?php echo get_author_posts_url( $user->id ); ?>" title="<?php echo $user->display_name; ?>"><?php echo get_avatar( $user->id , 70); ?></a>
				
				<h5><a href="<?php echo get_author_posts_url( $user->id ); ?>" title="<?php echo $user->display_name; ?>"><?php echo $user->display_name; ?></a></h5>
				
				<?php if (!empty($user->twitter)) : ?>
				
				<iframe allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/follow_button.html?screen_name=<?php echo substr(strrchr($user->twitter, "/"), 1); ?>&amp;show_count=false" style="width:160px; height:20px;"></iframe>				
				
				<?php endif; ?>
				
				<?php if (!empty($user_title)) : ?><p class="ci_title"><?php echo $user_title; ?></p><?php endif; ?>
				
				<p class="ci_count"><strong><?php echo count_user_posts( $user->id ); ?></strong> Posts</p>
								
				<?php if (!empty($user->description)) : ?><!--<p class="ci_bio"><?php echo $user->description; ?></p>--><?php endif; ?>
				
				<ul class="ci_social">
					
					<?php if (!empty($user->twitter)) : ?><li class="icon"><a href="<?php echo $user->twitter; ?>" target="_blank" class="twitter" title="<?php echo $user->display_name; ?> on Twitter">&#xf099;</a></li><?php endif; ?>
					
					<?php if (!empty($user_linkedin)) : ?><li class="icon"><a href="<?php echo $user_linkedin; ?>" target="_blank" class="linkedin" title="<?php echo $user->display_name; ?> on LinkedIn">&#xf0e1;</a></li><?php endif; ?>
					
					<li class="icon"><a href="<?php echo get_author_feed_link($user->id, ''); ?>" target="_blank" class="rss" title="<?php echo $user->display_name; ?>'s RSS Feed">&#xf09e;</a></li>
				
				</ul>
				
			</article>
			<?php } ?>

		<a id="loadmore" href="#" data-loading="<?php _e( 'Loading ...', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Contributors to Show', THB_THEME_NAME ); ?>" data-count="8" data-action="thb_ajax_contributors"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>

		</div>

	</section>

	<?php }
	wp_reset_postdata();
	// END: All Contributors
	?>

</div>
<?php get_footer(); ?>