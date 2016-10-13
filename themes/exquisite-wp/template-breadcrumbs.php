<?php if (!is_page_template('template-home.php') && !is_page_template('template-home-style2.php') && !is_page_template('template-home-style3.php') && !is_404() && !is_page(1846) && !is_page(1903) && !is_page(1849) && !is_page(1883)) {  ?>
	<?php if(ot_get_option('breadcrumbs') != 'no') { ?>
	<!-- Start Breadcrumbs -->
	<div class="row hide-for-small">
		<div class="twelve columns">
			<div id="breadcrumbs">				
				<?php thb_breadcrumb(); ?>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
<?php } ?>
<?php } ?>