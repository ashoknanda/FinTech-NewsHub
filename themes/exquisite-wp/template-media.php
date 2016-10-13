<?php
/*
Template Name: Media
*/
?>
<?php get_header(); ?>
<div class="row">

	<hr class="space test">

	<?php
	$selected_category = '';
	if (isset($_GET['media_topic'])) {
		$selected_category = esc_sql($_GET['media_topic']);
	}
	$taxonomy = 'media_cat';
	$terms = get_terms($taxonomy, array('hide_empty' => true));
	if ( $terms && !is_wp_error( $terms ) ) :
	?>

	<section class="fullwidth twelve columns">

		<form id="mediaTopics">
			<fieldset>
				<select id="media_topic" name="media_topic" method="get">
					<option value="">All Topics</option>
					<?php foreach ( $terms as $term ) { ?>
					<option value="<?php echo $term->slug; ?>"<?php if ($term->slug == $selected_category) { echo ' selected="selected"'; } ?>><?php echo $term->name; ?></option>
					<?php } ?>
				</select>
				<input type="submit" name="media_submit" id="media_submit" value="Filter">
			</fieldset>
		</form>

		<hr class="space">

	</section>

	<?php endif; ?>

	<?php
	if (!empty($selected_category)) {
		$args = array(
			'post_type' => 'ibm_media',
			'posts_per_page' => 12,
			'order' => 'DESC',
			'orderby' => 'date',
			'tax_query' => array(
				array(
					'taxonomy' => 'media_cat',
					'field' => 'slug',
					'terms' => $selected_category
				)
			),
		);
	} else {
		$args = array(
			'post_type' => 'ibm_media',
			'posts_per_page' => 12,
			'order' => 'DESC',
			'orderby' => 'date'
		);
	}
	$the_query = new WP_Query( $args );
	?>

	<?php if ( $the_query->have_posts() ) { ?>

	<section class="fullwidth archivepage twelve columns mediaPage" id="media-page">

		<div class="row">

		<?php while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
			
			<article class="item three columns mediaItem">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo get_the_title(); ?>"><?php the_post_thumbnail('recent'); ?></a>
				<h5><a href="<?php echo the_permalink(); ?>" rel="bookmark" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h5>
				<p class="mi_author">By <a href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>" title="<?php echo get_the_author(); ?>"><?php echo get_the_author(); ?></a></p>
				<p class="mi_date"><em><?php echo get_the_date(); ?></em></p>
			</article>
		
		<?php } ?>

	<?php } ?>

		<a id="loadmore" href="#" data-loading="<?php _e( 'Loading ...', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Media to Show', THB_THEME_NAME ); ?>" data-count="12" data-category="<?php echo $selected_category; ?>" data-action="thb_ajax_media"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>

		</div>

	</section>

	<?php wp_reset_postdata(); ?>

</div>
<?php get_footer(); ?>