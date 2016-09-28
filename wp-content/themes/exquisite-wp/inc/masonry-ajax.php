<?php
function load_more_posts() {
	$count = $_POST['count'];
	$page = $_POST['page']; 
	
	$offset = (($page - 1) * $count) + 5;

	$args = array(
		'offset' => $offset,
		'posts_per_page' => $count,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'ignore_sticky_posts' => '1',
	    'post_status' => array('publish'),
	    'tax_query' => array(
			array(
				'taxonomy'  => 'hide_posts',
				'field'     => 'slug',
				'terms'     => 'categories', // exclude items tagged with homepage
				'operator'  => 'NOT IN'
			)
		),
	);

	$query = new WP_Query( $args );
	
	if ( $query->have_posts() ) {
	    while ( $query->have_posts() ) { $query->the_post(); ?>
	       <article class="post">
	       	<div class="row">
	       		<div class="five columns">
	       			<div class="post-gallery">
	       				<?php the_post_thumbnail('recent'); ?>
	       				<?php echo thb_DisplayImageTag(get_the_ID()); ?>
	       			</div>
	       		</div>
	       		<div class="seven columns">
	       			<div class="post-title">
	       				<aside><?php echo thb_DisplaySingleCategory(false); ?></aside>
	       				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	       			</div>
	       			<div class="post-content">
	       				<p><?php echo ShortenText(get_the_excerpt(), 150); ?></p>
	       				<?php echo thb_DisplayPostMeta(true,true,true,true); ?>
	       			</div>
	       		</div>
	       	</div>
	       </article>
	    <?php
	    }
	}
	
	die();
}

function load_more_posts_home() {
	$count = $_POST['count'];
	$page = $_POST['page']; 
	
	$offset = (($page - 1) * $count) + 5;

	$args = array(
		'offset' => $offset,
		'posts_per_page' => $count,
		'orderby' => 'post_date',
		'order' => 'DESC',
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

	$query = new WP_Query( $args );
	
	if ( $query->have_posts() ) {
	    while ( $query->have_posts() ) { $query->the_post(); ?>
	       <article class="post">
	       	<div class="row">
	       		<div class="five columns">
	       			<div class="post-gallery">
	       				<?php the_post_thumbnail('recent'); ?>
	       				<?php echo thb_DisplayImageTag(get_the_ID()); ?>
	       			</div>
	       		</div>
	       		<div class="seven columns">
	       			<div class="post-title">
	       				<aside><?php echo thb_DisplaySingleCategory(false); ?></aside>
	       				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	       			</div>
	       			<div class="post-content">
	       				<p><?php echo ShortenText(get_the_excerpt(), 150); ?></p>
	       				<?php echo thb_DisplayPostMeta(true,true,true,true); ?>
	       			</div>
	       		</div>
	       	</div>
	       </article>
	    <?php
	    }
	}
	
	die();
}

function load_more_posts_type2() {
	$count = $_POST['count'];
	$page = $_POST['page']; 

	$offset = (($page - 1) * $count) + 14;
	
	$args = array(
        'offset' => $offset,
        'posts_per_page' => $count,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'ignore_sticky_posts' => '1',
        'post_status' => array('publish')
	);

	$query = new WP_Query( $args );
	
	if ( $query->have_posts() ) {
	    while ( $query->have_posts() ) { $query->the_post(); ?>
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
	       				<aside><?php echo thb_DisplaySingleCategory(false); ?></aside>
	       				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	       			</div>
	       			<div class="post-content">
	       				<p><?php echo ShortenText(get_the_excerpt(), 250); ?></p>
	       				<?php echo thb_DisplayPostMeta(true,true,true,false); ?>
	       			</div>
	       		</div>
	       	</div>
	       </article>
	    <?php
	    }
	}
	
	die();
}
function load_more_contributors() {
	$count = $_POST['count'];
	$page = $_POST['page']; 

	$offset = (($page - 1) * $count) + 12;
	
	$args = array(
		'offset' => $offset,
		'number' => $count,
		'orderby' => 'name',
		'order' => 'ASC',
        'post_status' => array('publish'),
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
				
				<p class="ci_count"><strong><?php echo rpg_count_user_posts( $user->id ); ?></strong> Posts</p>
								
				<?php if (!empty($user->description)) : ?><!--<p class="ci_bio"><?php echo $user->description; ?></p>--><?php endif; ?>
				
				<ul class="ci_social">
					
					<?php if (!empty($user->twitter)) : ?><li class="icon"><a href="<?php echo $user->twitter; ?>" target="_blank" class="twitter" title="<?php echo $user->display_name; ?> on Twitter">&#xf099;</a></li><?php endif; ?>
					
					<?php if (!empty($user_linkedin)) : ?><li class="icon"><a href="<?php echo $user_linkedin; ?>" target="_blank" class="linkedin" title="<?php echo $user->display_name; ?> on LinkedIn">&#xf0e1;</a></li><?php endif; ?>
					
					<li class="icon"><a href="<?php echo get_author_feed_link($user->id, ''); ?>" target="_blank" class="rss" title="<?php echo $user->display_name; ?>'s RSS Feed">&#xf09e;</a></li>
				
				</ul>
				
			</article>

			<?php } ?>

	<?php }
	wp_reset_postdata();
	
	die();
}
function load_more_webinars() {
	$count = $_POST['count'];
	$page = $_POST['page'];

	$offset = (($page - 1) * $count) + 16;

	$args = array(
		'offset' => $offset,
		'posts_per_page' => $count,
		'post_type' => 'ibm_event',
		'order' => 'DESC',
		'orderby' => 'meta_value',
		'meta_key' => '_ibm_event_end',
        'post_status' => array('publish'),
		'meta_query' => array(
			array(
				'key' => '_ibm_event_end',
				'value' => time(),
				'compare' => '<',
				'type' => 'NUMERIC'
			),
			array(
				'key'     => '_ibm_event_type',
				'value'   => 'webinar',
				'compare' => '='
			)
		)
	);

	$the_query = new WP_Query($args);
	if ($the_query->have_posts()) {
	?>

		<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

			<?php
			$timezone = get_post_meta( get_the_ID(), '_ibm_event_time_zone', true );
			if (!empty($timezone)) {
				date_default_timezone_set($timezone);
			}
			?>

			<article class="post item three columns eventItem">
				<div class="post-gallery">
					<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('recent'); ?></a>
					<?php echo thb_DisplayImageTag(get_the_ID()); ?>
				</div>
				<div class="post-title">
					<h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
				</div>
				<div class="clearfix event-type">
					<span class="left">Webinar</span>
					<a class="right" href="<?php the_permalink() ?>">On-Demand</a>
				</div>
			</article>

		<?php endwhile; ?>

	<?php }
	wp_reset_postdata();

	die();
}
function load_more_media() {
	$count = $_POST['count'];
	$page = $_POST['page'];
	$category = $_POST['category'];

	$offset = (($page - 1) * $count) + 12;

	if (!empty($category)) {
		$args = array(
			'offset' => $offset,
			'posts_per_page' => $count,
			'post_type' => 'ibm_media',
			'order' => 'DESC',
			'orderby' => 'date',
            'post_status' => array('publish'),
			'tax_query' => array(
				array(
					'taxonomy' => 'media_cat',
					'field' => 'slug',
					'terms' => $category
				)
			),
		);
	} else {
		$args = array(
			'offset' => $offset,
			'posts_per_page' => $count,
			'post_type' => 'ibm_media',
			'order' => 'DESC',
			'orderby' => 'date'
		);
	}
	
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
	?>

			<?php while ( $the_query->have_posts() ) { $the_query->the_post(); ?>

			<article class="item three columns mediaItem">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo get_the_title(); ?>"><?php the_post_thumbnail('recent'); ?></a>
				<h5><a href="<?php echo the_permalink(); ?>" rel="bookmark" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h5>
				<p class="mi_author">By <a href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>" title="<?php echo get_the_author(); ?>"><?php echo get_the_author(); ?></a></p>
				<p class="mi_date"><em><?php echo get_the_date(); ?></em></p>
			</article>

			<?php } ?>

	<?php }
	wp_reset_postdata();
	
	die();
}
function load_more_category() {

	$count = $_POST['count'];
	$page = $_POST['page']; 
	if (is_numeric($_POST['catid'])) {
		$catid = $_POST['catid']; // only allow this to be a number for obvious reasons
	} else {
		die();
	}

	$offset = (($page - 1) * $count) + 7;

	$args = array(
		'cat' => $catid,
		'offset' => $offset,
		'posts_per_page' => $count,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'ignore_sticky_posts' => '1',
        'post_status' => array('publish'),
	    'tax_query' => array(
			array(
				'taxonomy'  => 'hide_posts',
				'field'     => 'slug',
				'terms'     => 'categories', // exclude items tagged with homepage
				'operator'  => 'NOT IN'
			)
		),
	);

	$query = new WP_Query( $args );
	
	if ( $query->have_posts() ) {
	    while ( $query->have_posts() ) { $query->the_post(); ?>
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
							<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() . $catid; ?></a></h2>
						</div>
						<div class="post-content">
							<p><?php echo ShortenText(get_the_excerpt(), 250); ?></p>
							<?php echo thb_DisplayPostMeta(true,true,true,true); ?>
						</div>
					</div>
				</div>
			</article>

	    <?php
	    }
	}
	
	die();
}
function load_more_news() {
	$count = $_POST['count'];
	$page = $_POST['page']; 
	
	$offset = (($page - 1) * $count) + 5;

	$args = array(
		'post_type' => array('ibm_news'),
		'offset' => $offset,
		'posts_per_page' => $count,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'ignore_sticky_posts' => '1',
        'post_status' => array('publish'),
        'tax_query' => array(
			array(
				'taxonomy'  => 'hide_posts',
				'field'     => 'slug',
				'terms'     => 'news', // exclude items tagged with news
				'operator'  => 'NOT IN'
			)
		)
	);

	$query = new WP_Query( $args );
	
	if ( $query->have_posts() ) {
	    while ( $query->have_posts() ) { $query->the_post(); ?>
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

		<?php
	    }
	}
	
	die();
}
?>