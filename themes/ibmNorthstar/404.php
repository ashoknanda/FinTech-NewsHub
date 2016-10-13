<?php get_header(); ?>

	<?php get_template_part('_includes/v18_content_main_start'); ?>

		<div class="ibm-columns ibm-padding-top-3 ibm-padding-bottom-3 ibm-center">
			<div class="ibm-col-1-1">
        <h1 class="ibm-h1"><?php $my_theme = wp_get_theme(); _e("Page Not Found", $my_theme->get( 'Name' )); ?></h1>
        <p><?php $my_theme = wp_get_theme(); _e("The page you were looking for was not found.", $my_theme->get( 'Name' )); ?></p>
        <p class="ibm-btn-row igf-ibm-btn-row"><a href="<?php echo get_home_url(); ?>" class="ibm-back-link ibm-inlinelink"><?php $my_theme = wp_get_theme(); _e("Back", $my_theme->get( 'Name' )); ?></a></p>
      </div>
		</div>

	<?php get_template_part('_includes/v18_content_main_end'); ?>

<?php get_footer(); ?>
