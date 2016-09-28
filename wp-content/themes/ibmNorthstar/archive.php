<?php
/*
Template Name: Archives
*/
get_header(); ?>

<?php get_template_part('_includes/v18_content_main_start'); ?>

 <div class="ibm-columns">
        <div class="ibm-col-6-4 ibm-blog__article-main">


		<?php the_post(); ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php get_search_form(); ?>

		<h2><?php $my_theme = wp_get_theme(); _e('Archives by Month:', $my_theme->get( 'Name' )); ?></h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>

		<h2><?php $my_theme = wp_get_theme(); _e('Archives by Subject:', $my_theme->get( 'Name' )); ?></h2>
		<ul>
			 <?php wp_list_categories(); ?>
		</ul>

	</div><!-- #ibm-col-6-4 ibm-blog__article-main -->
</div><!-- #ibm-columns -->



<?php get_footer(); ?>
