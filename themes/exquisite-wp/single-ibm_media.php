<?php get_header(); ?>
<div class="row relative">
<?php //get_template_part( 'inc/postformats/post-sharebox' ); ?>
<section class="nine columns">
  <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
  	<article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
  		
		  <?php
		    // The following determines what the post format is and shows the correct file accordingly
		    $format = get_post_format();
		    if ($format) {
		    get_template_part( 'inc/postformats/'.$format );
		    } else {
		    get_template_part( 'inc/postformats/standard' );
		    }
		  ?>
		  <div class="post-title">
		  	<!--<aside><?php echo thb_DisplaySingleCategory(true); ?></aside>-->
		  	<h1><?php the_title(); ?></h1>
		  </div>
		  <aside class="post-meta single">
		  	<ul>
		  		<li class="pm-author"><a href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>" title="<?php echo get_the_author(); ?>">By <?php echo get_the_author(); ?></a></li>
		  		<li>&bull;  &nbsp; <?php echo get_the_date('F j, Y'); ?></li>
		  	</ul>
	  		<?php 
	  		// display media categories ("media_cat" taxonomy) if available
	  		$media_categories = wp_get_post_terms( $post->ID, 'media_cat', array( 'fields' => 'all', 'public' => true ) );
	  		if ( !empty( $media_categories ) && !is_wp_error( $media_categories ) ) {
	  			$mc_count = count($media_categories);
		  		$i = 1;
	  			?>
			  	<p class="pm-topics">

			  		Topics: 

				  	<?php foreach ( $media_categories as $cat ) {

				  		$cat = sanitize_term( $cat, 'media_cat' );
				  		$term_link = get_term_link( $cat, 'media_cat' );

				  		if ($i < $mc_count) {
					  		echo '<a href="' . esc_url( $term_link ) . '">' . $cat->name . '</a>, ';
				  		} else {
					  		echo '<a href="' . esc_url( $term_link ) . '">' . $cat->name . '</a>';
				  		}

				  		$i++;

				  	} ?>

			  	</p>
	  			<?php
	  		}
	  		?>
		  </aside>
		  <div class="post-content">
		  	<?php get_template_part('template-addthis-horizontal'); ?>
			<hr class="space">
		  	<?php
		  	if ( get_post_meta( get_the_ID(), '_ibm_media_embed', true ) ) {
			  	echo get_post_meta( get_the_ID(), '_ibm_media_embed', true );
			}
		  	?>
		  	<?php //get_template_part( 'inc/postformats/post-meta' ); ?>
		  	<?php the_content(); ?>
		  	<?php if ( is_single()) { wp_link_pages(); } ?>
		  </div>
			  
  	</article>
  <?php endwhile; ?>
  	<?php get_template_part( 'inc/postformats/post-review' ); ?>
  <?php else : ?>
    <p><?php _e( 'Please add posts from your WordPress admin page.', THB_THEME_NAME ); ?></p>
  <?php endif; ?>
  	<?php get_template_part( 'inc/postformats/post-prevnext' ); ?>
  	<?php get_template_part( 'inc/postformats/post-related' ); ?>
  	<?php get_template_part( 'inc/postformats/post-endbox' ); ?>
  	<!-- Start #comments -->
  	<section id="comments" class="cf">
  	  <?php // comments_template('', true ); ?>
  	</section>
  	<!-- End #comments -->
</section>
  <?php get_sidebar('media'); ?>
</div>
<?php get_footer(); ?>