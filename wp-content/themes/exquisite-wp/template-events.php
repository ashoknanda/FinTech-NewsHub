<?php
/*
Template Name: Events
*/
?>
<?php get_header(); ?>
<div class="row">

	<?php
	// BEGIN: Featured Event
	$args = array(
		'post_type' => 'ibm_event',
		'posts_per_page' => 1,
		'orderby' => 'meta_value',
		'meta_key' => '_ibm_event_end',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key'     => '_ibm_event_featured_locations',
				'value'   => 'events_hero',
				'compare' => 'LIKE'
			)
		)
	);
	$the_query = new WP_Query($args);

	if ($the_query->have_posts()) : 
		while ($the_query->have_posts()) : $the_query->the_post();
		$timezone = get_post_meta( get_the_ID(), '_ibm_event_time_zone', true );
	?>

	<section class="fullwidth twelve columns" id="featured-event">

		<div class="seven columns">
			<a href="<?php the_permalink() ?>" rel="bookmark">
                <?php the_post_thumbnail('slider'); ?>
            </a>
		</div>

		<article class="five columns feRight">
			<div class="fer_header">
				<div class="ferh_title">Featured Event</div>
				<div class="ferh_date"><?php echo get_event_datetime_timeze_change( get_post_meta( get_the_ID(), '_ibm_event_start', true ), true, $timezone ); ?></div>
			</div>
			<a href="<?php the_permalink(); ?>" rel="bookmark" class="fer_title"><?php echo the_post_title_event_limit(get_the_title()); ?></a>
			<p class="fer_excerpt"><?php echo get_the_excerpt(); ?></p>
			<a href="<?php the_permalink(); ?>" rel="bookmark" class="fer_btn">Register</a>
		</article>

	</section>

	<?php endwhile;
	endif;
	wp_reset_postdata();
	// END: Featured Event
	?>
	<section class="fullwidth twelve columns" id="sort-events">
		<form>
			<ul>
				<li class="se_label"><strong>Show:</strong></li> 
				<li><input type="checkbox" name="show" id="show1" value="webinars" checked> <label for="show1">Upcoming Webinars</label></li>
				<li><input type="checkbox" name="show" id="show2" value="inperson" checked> <label for="show2">Upcoming In-Person</label></li>
				<li><input type="checkbox" name="show" id="show3" value="ondemand" checked> <label for="show3">On-Demand Webinars</label></li>
			</ul>
		</form>
	</section>

	<?php
	// BEGIN: Upcoming Webinars
	$args = array(
		'post_type' => 'ibm_event',
		'posts_per_page' => 16,
		'orderby' => 'meta_value',
		'meta_key' => '_ibm_event_end',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key' => '_ibm_event_end',
				'value' => time(),
				'compare' => '>',
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

	if ($the_query->have_posts()) : 
	?>

	<section class="fullwidth archivepage twelve columns" id="upcoming-webinars">

		<div class="headline"><h2>Upcoming Webinars</h2></div>

		<div class="row">

			<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

	  		<?php
					$attrs = get_timezone_arguments_element();

	  		?>

			<article class="post item three columns eventItem change_timezone_text"<?php echo $attrs; ?> data-timezone-type="7">
				<div class="post-date">
					<div class="calendar">
						<a href="#" title="Add to Calendar" class="addthisevent2">
							Add To Calendar
							<span class="_start"><?php echo date("m-d-y H:i:s", $ibm_event_start); ?></span>
							<span class="_end"><?php echo date("m-d-y H:i:s", $ibm_event_end); ?></span>
							<span class="_zonecode">35</span>
							<span class="_summary"><?php the_title(); ?></span>
							<span class="_description"><?php the_title(); ?></span>
							<span class="_location">Webinar</span>
							<span class="_date_format">MM-DD-YYYY HH:i:s</span>
						</a>
					</div>
					<div class="date"><?php echo date("<b>d</b> M", get_post_meta( get_the_ID(), '_ibm_event_end', true )); ?></div>
					<div class="day"><?php echo date("l", get_post_meta( get_the_ID(), '_ibm_event_end', true )); ?></div>
				</div>
				<div class="post-gallery">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('recent'); ?></a>
					<?php echo thb_DisplayImageTag(get_the_ID()); ?>
				</div>
				<div class="post-title">
					<h4><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo  the_post_title_event_limit(get_the_title()); ?></a></h4>
				</div>
				<div class="clearfix event-type">
				    <span class="left">Webinar</span>
				    <a class="right" href="<?php the_permalink(); ?>">Register</a>
				</div>
			</article>

			<?php endwhile; ?>

		</div>

		<hr class="thick">

	</section>

	<?php endif;
	wp_reset_postdata();
	date_default_timezone_set('America/New_York'); // reset timezone to Eastern
	// END: Upcoming Webinars
	?>

	<?php
	// BEGIN: Upcoming In-Person
	$args = array(
		'post_type' => 'ibm_event',
		'posts_per_page' => 16,
		'orderby' => 'meta_value',
		'meta_key' => '_ibm_event_end',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key' => '_ibm_event_end',
				'value' => time(),
				'compare' => '>',
				'type' => 'NUMERIC'
			),
			array(
				'key'     => '_ibm_event_type',
				'value'   => 'inperson',
				'compare' => '='
			)
		)
	);
	$the_query = new WP_Query($args);

	if ($the_query->have_posts()) : 
	?>

	<section class="fullwidth archivepage twelve columns" id="upcoming-inperson">

		<div class="headline"><h2>Upcoming In-Person</h2></div>

		<div class="row">

			<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

	  		<?php
					$attrs = get_timezone_arguments_element();


	  		?>

			<article class="post item three columns eventItem change_timezone_text"<?php echo $attrs; ?> data-timezone-type="7">
				<div class="post-date">
					<div class="calendar">
						<a href="#" title="Add to Calendar" class="addthisevent2">
							Add To Calendar
							<span class="_start"><?php echo date("m-d-y H:i:s", get_post_meta( get_the_ID(), '_ibm_event_start', true )); ?></span>
							<span class="_end"><?php echo date("m-d-y H:i:s", get_post_meta( get_the_ID(), '_ibm_event_end', true )); ?></span>
							<span class="_zonecode">35</span>
							<span class="_summary"><?php the_title(); ?></span>
							<span class="_description"><?php the_title(); ?></span>
							<span class="_location"><?php echo get_post_meta( get_the_ID(), '_ibm_event_location', true ); ?></span>
							<span class="_date_format">MM-DD-YYYY HH:i:s</span>
						</a>
					</div>
					<div class="date"><?php echo date("<b>d</b> M", get_post_meta( get_the_ID(), '_ibm_event_end', true )); ?></div>
					<div class="day"><?php echo date("l", get_post_meta( get_the_ID(), '_ibm_event_end', true )); ?></div>
				</div>
				<div class="post-gallery">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('recent'); ?></a>
					<?php echo thb_DisplayImageTag(get_the_ID()); ?>
				</div>
				<div class="post-title">
					<h4><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo  the_post_title_event_limit(get_the_title()); ?></a></h4>
				</div>
			</article>

			<?php endwhile; ?>

		</div>

		<hr class="thick">

	</section>

	<?php endif; ?>

	<?php wp_reset_postdata();
	date_default_timezone_set('America/New_York'); // reset timezone to Eastern
	// END: Upcoming In-Person
	?>

	<?php
	// BEGIN: On-Demand Webinars
	$args = array(
		'post_type' => 'ibm_event',
		'posts_per_page' => 16,
		'order' => 'DESC',
		'orderby' => 'meta_value',
		'meta_key' => '_ibm_event_end',
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

	if ($the_query->have_posts()) : 
	?>

	<section class="fullwidth archivepage twelve columns" id="ondemand-webinars">

		<div class="headline"><h2>On-Demand Webinars</h2></div>

		<div class="row">

			<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

	  		<?php			
			$timezone = get_post_meta( get_the_ID(), '_ibm_event_time_zone', true );
	  		?>

			<article class="post item three columns eventItem">
				<div class="post-gallery">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('recent'); ?></a>
					<?php echo thb_DisplayImageTag(get_the_ID()); ?>
				</div>
				<div class="post-title">
					<h4><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo  the_post_title_event_limit(get_the_title()); ?></a></h4>
				</div>
				<div class="clearfix event-type">
				    <span class="left">Webinar</span>
				    <a class="right" href="<?php the_permalink(); ?>">On-Demand</a>
				</div>
			</article>

			<?php endwhile; ?>
			<a id="loadmore" href="#" data-loading="<?php _e( 'Loading ...', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Webinars to Show', THB_THEME_NAME ); ?>" data-count="16" data-action="thb_ajax_webinars"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>

		</div>

	</section>

	<?php endif; ?>

	<?php wp_reset_postdata();
	date_default_timezone_set('America/New_York'); // reset timezone to Eastern
	// END: On-Demand Webinars
	?>
</div>

<script>
jQuery('#show1').change(function() {
	jQuery( "#upcoming-webinars" ).fadeToggle( "fast" );
});
jQuery('#show2').change(function() {
	jQuery( "#upcoming-inperson" ).fadeToggle( "fast" );
});
jQuery('#show3').change(function() {
	jQuery( "#ondemand-webinars" ).fadeToggle( "fast" );
});
</script>

<?php get_footer(); ?>