</div>

<!-- Start Footer -->
<div class="footer_wrapper">
	<div class="row">
		<div class="twelve columns">
			<footer id="footer">
			  	<div class="row">
			
				    <div class="three columns">
				    	<p><img src="<?php echo get_template_directory_uri(); ?>/assets/img/footer-logo-si.png" alt="Security Intelligence"></p>
				    	<?php dynamic_sidebar('footer1'); ?>
				    	<p><img src="<?php echo get_template_directory_uri(); ?>/assets/img/footer-logo.png" alt="IBM"></p>
				    </div>
				    <div class="three columns">
				    	<h6>Security Intelligence</h6>
				    	<?php dynamic_sidebar('footer2'); ?>
				    </div>
				    <div class="three columns">
				    	<h6>Read More</h6>
					    <?php dynamic_sidebar('footer3'); ?>
				    </div>
				    <div class="three columns">
					    <?php dynamic_sidebar('footer4'); ?>
				    </div>
			    </div>

			    </div>
			</footer>
		</div>
	</div>
</div>

<div id="subfooter">
	<div class="row">
		<div class="twelve columns">
			&copy; <?php echo date("Y"); ?> <span><a href="http://www.ibm.com" class="blue" target="_blank">IBM</a></span> 
			<?php
			$menuParameters = array(
				'theme_location' => 'footer-menu',
				'container' => false,
				'echo' => false,
				'items_wrap' => '%3$s',
				'link_before' => '<span class="sep">|</span><span>',
				'link_after' => '</span>',
				'depth' => 0,
			);
			echo strip_tags( wp_nav_menu( $menuParameters ), '<a><span>' );
			?>
		</div>
	</div>
</div>

</div> <!-- End #wrapper -->
<?php if (ot_get_option('disablescrollbubble') != 'yes') { ?>
	<div id="scrollbubble"></div>
<?php } ?>
<?php echo ot_get_option('ga'); ?>
<?php 
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	 wp_footer(); 
?>
<script type="text/javascript">
setTimeout(function()
{var a=document.createElement("script"); var b=document.getElementsByTagName("script")[0]; a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0032/8411.js?"+Math.floor(new Date().getTime()/3600000); a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}
, 1);
</script>
<script type="text/javascript" language="javascript"> 
var sf14gv = 27609; 
(function()
{ var sf14g = document.createElement('script'); sf14g.type = 'text/javascript'; sf14g.async = true; sf14g.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 't.sf14g.com/sf14g.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sf14g, s); }
)(); 
</script>
</body>
</html>
