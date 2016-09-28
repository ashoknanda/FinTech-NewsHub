<?php

$args = array(
	'post_type' => 'ibm_event',
	'posts_per_page' => 2,
	'order' => 'DESC',
	'orderby' => 'meta_value',
	'meta_key' => '_ibm_event_end',
	'meta_query' => array(
		array(
			'key' => '_ibm_event_end',
			'value' => time(),
			'compare' => '>',
			'type' => 'NUMERIC'
		),
		array(
			'key' => '_ibm_event_banner_featured',
			'value' => 'enabled',
			'compare' => 'like'
		)
	)
);

$the_query = new WP_Query($args);
if ($the_query->have_posts()){
?>

	<div id="header-webinar-banner">

		<?php
		while ($the_query->have_posts()) {

			$the_query->the_post();

			// Set event banner headline as custom field, or default title if custom field is not defined
			$event_banner_headline = get_post_meta( get_the_ID(), '_ibm_event_banner_headline', true );
			if (empty($event_banner_headline)) {
				$event_banner_headline =  get_the_title();
			}

			// Set event banner link as custom field, or default permalink if custom field is not defined
			$event_banner_url = get_post_meta( get_the_ID(), '_ibm_event_banner_url', true );
			if (empty($event_banner_url)) {
				$event_banner_url =  get_the_permalink();
			}

			// Get event timezone and use it if defined
			$timezone = get_post_meta( get_the_ID(), '_ibm_event_time_zone', true );

			// Get event start & end times
			$event_start = get_post_meta( get_the_ID(), '_ibm_event_start', true );
			$event_end = get_post_meta( get_the_ID(), '_ibm_event_end', true );
			$event_location = get_post_meta( get_the_ID(), '_ibm_event_location', true );

			// Get time left until webinar
			$time_now = new DateTime();
			$time_then = new DateTime( date( "r", $event_start ) );
			$time_between = $time_then->diff( $time_now );
			$months_until = $time_between->format( "%m" ) . ( abs( $time_between->format( "%m" ) ) > 1 ? " MONTHS" : " MONTH" );
			$days_until = $time_between->format( "%d" ) . ( abs( $time_between->format( "%d" ) ) > 1 ? " DAYS" : " DAY" );
			$hours_until = $time_between->format( "%h" ) . ( abs( $time_between->format( "%h" ) ) > 1 ? " HRS" : " HR" );
			$minutes_until = $time_between->format( "%i" ) . ( abs( $time_between->format( "%i" ) ) > 1 ? " MINS" : " MIN" );
			if ($months_until > 0) {
				$time_until = $months_until . ", " . $days_until;
			} else {
				$time_until = $days_until . ", " . $hours_until . ", " . $minutes_until;
			}

			// Get event type (webinar or in-person)
			$event_type = get_post_meta( get_the_ID(), '_ibm_event_type', true );
			$event_type_labels = array(
				'webinar' => 'Webinar',
				'inperson' => 'Event',
			);

			$attrs = get_timezone_arguments_element();
	?>

				<div class="row">
					<div class="twelve columns">
						<div class="hwb-upcoming">Upcoming <?php echo $event_type_labels[$event_type]; ?>:</div>
						<div class="hwb-title"><?php echo $event_banner_headline; ?></div>
						<div class="hwb-date">

							<?php if ($event_type == 'webinar') : ?>
								<span class="change_timezone_text"<?php echo $attrs; ?> data-timezone-type="2">
									<?php echo date("F j, gA", $event_start); ?> - <?php echo date("gA T", $event_end); ?> 
								</span>
								<br>
								<span class="change_timezone_text"<?php echo $attrs; ?> data-timezone-type="4">
								Event Starts In: <span><?php echo $time_until; ?></span>
								</span>

							<?php elseif ($event_type == 'inperson') : ?>
								<span class="change_timezone_text"<?php echo $attrs; ?> data-timezone-type="5">
									Beginning <?php echo date("F j, Y", $event_start); ?> 
								</span>
								<br>
								<?php echo $event_location; ?>

							<?php endif; ?>
						</div>
						<div class="hwb-register"><a href="<?php echo $event_banner_url; ?>">Register</a></div>
						<div class="clear"></div>
					</div>
				</div>

	<?php
			date_default_timezone_set('America/New_York'); // reset timezone to Eastern
		}
		?>

	</div>

<?php
}
wp_reset_postdata();
?>
