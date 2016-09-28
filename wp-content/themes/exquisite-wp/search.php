<?php 

$count_results = 0;
global $wpdb;
$search_param = ( isset($_GET["s"]) ) ? get_search_query() : '' ;
$search_param = strtolower($search_param);

$post_ids = array();
$posts_query = "SELECT distinct p.ID 
								FROM ibm_posts AS p
								LEFT JOIN ibm_users AS u ON u.ID = p.post_author
								where LCASE(p.post_content) like '%" . $search_param . "%' OR LCASE(p.post_title) like '%" . $search_param . "%' OR
										LCASE(p.post_excerpt) like '%" . $search_param . "%' OR LCASE(p.post_name) like '%" . $search_param . "%' OR 
								        LCASE(p.guid) like '%" . $search_param . "%' OR 
								        LCASE(u.user_login) like '%" . $search_param . "%' OR LCASE(u.user_nicename) like '%" . $search_param . "%' OR
										LCASE(u.user_email) like '%" . $search_param . "%' OR LCASE(u.display_name) like '%" . $search_param . "%';";

$results = $wpdb->get_results( $posts_query, OBJECT );
foreach($results as $post){
	$post_ids[] = $post->ID;
}

			global $query_string; // required

			if (empty($search_param) || empty($post_ids)) {
				$args = array_merge( $wp_query->query_vars, 
										array( 'posts_per_page' => '8', 'post_type' => array( 'post', 'ibm_news'  ) ) );
			}else{
				$args = array_merge( $wp_query->query_vars, 
								array('include' => $post_ids, 'posts_per_page' => '8', 
												'post_type' => array( 'post', 'ibm_news'  ) ));
			}
			$query = new WP_Query($args); 
	$count_results += $query->found_posts;


	$paged_user = ( isset($_GET["pu"])) ? sanitize_text_field($_GET["pu"]) : 1;	
	global $paged2;
	$paged2 = $paged_user;

	$args = array(
		'offset' => ($paged_user - 1) * 8,		
		'number' => 8,
		'orderby' => 'name',
		'order' => 'ASC',
		'meta_query' => array(
			0 => array(
				'key' => '_ibm_hidden_user',
				'compare' => 'NOT EXISTS'
			)
		),
	);
	$user_query = new WP_User_Query();
	$user_query->prepare_query($args);
	$users_where = " AND (LCASE(ibm_users.user_login) like '%" . $search_param . "%' OR LCASE(ibm_users.user_nicename) like '%" . $search_param . "%' OR
									LCASE(ibm_users.user_email) like '%" . $search_param . "%' OR LCASE(ibm_users.display_name) like '%" . $search_param . "%' OR
									LCASE(ibm_usermeta.meta_value) like '%" . $search_param . "%')";

	$user_query->query_where .= $users_where;
	$user_query->query();

		$total_users = $user_query->total_users;
		$total_pages = round($total_users / 8);			
		if (($total_pages * 8) < $total_users){
			$total_pages++;
		}
		$count_results += $user_query->total_users;


	if ($count_results > 0) {
		$page_id = 'SEARCH: SUCCESSFUL';
	} else {
		$page_id = 'SEARCH: UNSUCCESSFUL';
	}

	global $coremetric_options;
	$coremetric_options = array(
							'page' => array(
								'pageInfo' => array(
									'ibm' => array(
										'siteID' => 'securityintelligence',
									),
								),
								'category' => array(
									'primaryCategory' => $coremetric_primary_category,
								),
							),
						);
	$coremetric_options['page']['pageInfo']['pageID'] = $page_id;
	$coremetric_options['page']['pageInfo']['onsiteSearchResults'] = $count_results;
	$coremetric_options['page']['pageInfo']['onsiteSearchResult'] = $count_results;



get_header(); 
?>
<div class="row">
	<section class="fullwidth archivepage twelve columns">
			<?php if ($query->have_posts()) { ?>
		<div class="row masonry" data-columns="4">
				<?php while ($query->have_posts()) : $query->the_post(); ?>
			<article class="post item three columns">
				<div class="post-gallery">
					<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('recent'); ?></a>
					<?php echo thb_DisplayImageTag(get_the_ID()); ?>
				</div>
				<div class="post-title">
					<h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
				</div>
				<div class="post-content">
					<p><?php echo ShortenText(get_the_excerpt(), 70); ?></p>
					<?php echo thb_DisplayPostMeta(true,true,true,false); ?>
				</div>
			</article>
				<?php endwhile; ?>
		</div>
			<?php }else{ ?>
			<br />
			No posts found for: <?php echo $search_param; ?>
			<br />
			<?php } ?>
		<?php 
		theme_pagination($query->max_num_pages, 1); 
		?>
	</section>
</div>
<div class="row">

	<?php

	if ( isset($user_query) && ! empty( $user_query->results ) ) {
	?>

	<section class="fullwidth archivepage twelve columns contributors" id="featured-contributors">
		<div class="archiveheadline">
			<h1>Contributors search results for: <?php echo $search_param; ?></h1>		
		</div>

		<div class="row masonry" data-columns="4">

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
					
					<?php if (!empty($user_linkedin)) : ?><li class="icon"><a href="<?php echo $user_linkedin; ?>" target="_blank" class="linkedin" title="<?php echo $user->display_name; ?> on LinkedIn">&#xf0e1;</a></li><?php endif; ?>
					
					<li class="icon"><a href="<?php echo get_author_feed_link($user->id, ''); ?>" target="_blank" class="rss" title="<?php echo $user->display_name; ?>'s RSS Feed">&#xf09e;</a></li>
				
				</ul>
				
			</article>

			<?php } ?>

		</div>
		<?php theme_pagination2($total_pages, 1); ?>
	</section>
	<?php }else{
		?>
	<section class="fullwidth archivepage twelve columns contributors" id="featured-contributors">
		<div class="archiveheadline">
			<h1>Contributors search results for: <?php echo $search_param; ?></h1>		
		</div>
		<br />
		No contributors found for: <?php echo $search_param; ?>
		<br />
	</section>		
		<?php
	}
	wp_reset_postdata();
	// END: All Contributors


	?>

</div>
<script>
	$(document).ready(function(){
		ga('send', 'pageview', '/search_results.php?q=<?php echo $search_param; ?>');
	});
</script>
<?php get_footer(); ?>
