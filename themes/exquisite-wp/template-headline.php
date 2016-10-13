<?php if (is_page_template('template-events.php') || !is_page_template('template-home.php') && !is_page_template('template-home-style2.php') && !is_page_template('template-home-style3.php') && !is_author() && !is_single() && !is_404() && !is_page(1846) && !is_page(1903) /*&& is_archive() || is_search() */) {  ?>
<!-- Start Headline -->
<div class="row">
	<div class="twelve columns">
		<div class="archiveheadline">
			<?php
			if (is_page_template('template-events.php')) {
				echo "<h1>Events &amp; Webinars</h1>";
			} else if (is_archive() || is_search()) {
				echo archive_title();
			} else if (is_page('news')) {
				echo '<h1>'.get_the_title($wp_query->get_queried_object_id()).' <span class="news-title">Today\'s Leading Information Security Stories</span></h1>';
			} else {
				echo '<h1>'.get_the_title($wp_query->get_queried_object_id()).'</h1>';
			}?>
		</div>
	</div>
</div>
<!-- End Headline -->
<?php } ?>