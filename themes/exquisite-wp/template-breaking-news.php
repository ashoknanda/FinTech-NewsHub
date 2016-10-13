<?php if (!is_404() && !is_page(1846) && !is_page(1903)) {  ?>
<!-- Start Breaking News -->
<div class="row" id="breakingcontainer">
	<div class="twelve columns">
		<div id="breaking" <?php if (is_page_template('template-home-style2.php') || is_page_template('template-home-style3.php')) { ?>class="margin"<?php } ?>>
			<div class="row">
					<div class="marquee-img"></div>
					<div class="marquee-wrapper">
						<div class="marquee" id="marquee">
							<?php echo rpgHeaderTweets(); ?>
						</div>
					</div>
					<!--<a class="close" href="#" onclick="jQuery('#breaking').animate({ height: 0}); return false;"><i class="fa fa-times-circle"></i></a>-->
			</div>
		</div>
	</div>
</div>
<!-- End Breaking News -->
<?php } ?>