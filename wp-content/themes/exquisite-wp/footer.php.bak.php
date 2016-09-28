</div>
<?php if (ot_get_option('footer') != 'no') { ?>
<!-- Start Footer -->
<div class="row">
	<div class="twelve columns">
		<footer id="footer">
		  	<div class="row">
		
		  		<?php if (ot_get_option('footer_columns') == 'fourcolumns') { ?>
			    <div class="three columns">
			    	<?php dynamic_sidebar('footer1'); ?>
			    </div>
			    <div class="three columns">
			    	<?php dynamic_sidebar('footer2'); ?>
			    </div>
			    <div class="three columns">
				    <?php dynamic_sidebar('footer3'); ?>
			    </div>
			    <div class="three columns">
				    <?php dynamic_sidebar('footer4'); ?>
			    </div>
			    <?php } elseif (ot_get_option('footer_columns') == 'threecolumns') { ?>
			    <div class="four columns">
			    	<?php dynamic_sidebar('footer1'); ?>
			    </div>
			    <div class="four columns">
			    	<?php dynamic_sidebar('footer2'); ?>
			    </div>
			    <div class="four columns">
			        <?php dynamic_sidebar('footer3'); ?>
			    </div>
			    <?php } elseif (ot_get_option('footer_columns') == 'twocolumns') { ?>
			    <div class="six columns">
			    	<?php dynamic_sidebar('footer1'); ?>
			    </div>
			    <div class="six columns">
			    	<?php dynamic_sidebar('footer2'); ?>
			    </div>
			    <?php } elseif (ot_get_option('footer_columns') == 'doubleleft') { ?>
			    <div class="six columns">
			    	<?php dynamic_sidebar('footer1'); ?>
			    </div>
			    <div class="three columns">
			    	<?php dynamic_sidebar('footer2'); ?>
			    </div>
			    <div class="three columns">
			        <?php dynamic_sidebar('footer3'); ?>
			    </div>
			    <?php } elseif (ot_get_option('footer_columns') == 'doubleright') { ?>
			    <div class="three columns">
			    	<?php dynamic_sidebar('footer1'); ?>
			    </div>
			    <div class="three columns">
			    	<?php dynamic_sidebar('footer2'); ?>
			    </div>
			    <div class="six columns">
			        <?php dynamic_sidebar('footer3'); ?>
			    </div>
			    <?php } elseif (ot_get_option('footer_columns') == 'sixcolumns') { ?>
			    <div class="two mobile-two columns">
			    	<?php dynamic_sidebar('footer1'); ?>
			    </div>
			    <div class="two mobile-two columns">
			    	<?php dynamic_sidebar('footer2'); ?>
			    </div>
			    <div class="two mobile-two columns">
			    	<?php dynamic_sidebar('footer3'); ?>
			    </div>
			    <div class="two mobile-two columns">
			    	<?php dynamic_sidebar('footer4'); ?>
			    </div>
			    <div class="two mobile-two columns">
			    	<?php dynamic_sidebar('footer5'); ?>
			    </div>
			    <div class="two mobile-two columns">
			    	<?php dynamic_sidebar('footer6'); ?>
			    </div>
			    <?php }?>
		    </div>
		</footer>
	</div>
</div>
<!-- End Footer -->
<?php } ?>
<?php if (ot_get_option('subfooter') != 'no') { ?>
<!-- Start Sub-Footer -->

<div class="row">
	<div class="twelve columns">
		<section id="subfooter">
			<div class="row">
				<div class="four columns">
					<p><?php echo ot_get_option('copyright','Copyrıght 2013 FUEL THEMES. All RIGHTS RESERVED.'); ?> </p>
				</div>
				<div class="eight columns">
					<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'depth' => 1, 'container' => false) ); ?>
				</div>
			</div>
		</section>
	</div>
</div>

<!-- End Sub-Footer -->
<?php } ?>
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
</body>
</html>