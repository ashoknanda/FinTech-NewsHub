         <?php
                  $params   = array('name' => 'footer-band', 'post_type' => 'module');
                  $band    = new WP_Query($params);
                  // print_r($leadspace);
                ?>

                <?php if ( $band->have_posts() ) : while ( $band->have_posts() ) : $band->the_post(); ?>
<?php if (get_field('footer_band')){ ?>
   <?php if (get_field('dark_background')){
                     $alternate = 'ibm-btn-white';
                  }
                  else
                  {
                     $alternate = '';
                  }
   ?>
   <?php if ((get_field('parallax_option')) && (get_field('dark_background'))) { ?>
   <div class="ibm-band ibm-alternate-background" data-widget="parallaxscroll" style="background: url(<?php the_field('background_image'); ?>) 0 0 / cover no-repeat;">
   <?php } elseif ((!get_field('parallax_option')) && (get_field('dark_background'))) { ?>
   <div class="ibm-band ibm-alternate-background" style="background: url(<?php the_field('background_image'); ?>) 0 0 / cover no-repeat;">
   <?php } elseif ((get_field('parallax_option')) && (!get_field('dark_background'))) { ?>
      <div class="ibm-band" data-widget="parallaxscroll" style="background: url(<?php the_field('background_image'); ?>) 0 0 / cover no-repeat;">
   <?php } else { ?>
      <div class="ibm-band" style="background: url(<?php the_field('background_image'); ?>) 0 0 / cover no-repeat;">
   <?php } ?>
   	<div class="ibm-columns ibm-padding-top-1">
   		<div class="ibm-col-6-1"></div>
   		<div class="ibm-col-6-4">
   			<h1 class="ibm-h1 ibm-center ibm-padding-bottom-1"><?php the_field('title'); ?></h1>
   			<p class="ibm-h4"><?php the_field('description'); ?></p>
   		</div>
   	</div>
   	<div class="ibm-columns ibm-padding-top-1 ibm-padding-bottom-1">
   	<?php if(get_field('cta_num') == "1_cta") { ?>
   		<div class="ibm-col-1-1 ibm-center">
   			<p class="ibm-btn-link"><a class="ibm-btn-sec <?php echo $alternate ?>" href="<?php the_field('cta_1_url'); ?>"><?php the_field('cta_1_text'); ?></a></p>
   		</div>
   	<?php } ?>
   	<?php if(get_field('cta_num') == "2_cta") { ?>
   		<div class="ibm-col-1-1 ibm-center">
   			<p class="ibm-btn-link ibm-btn-row">
                  <a class="ibm-btn-sec <?php echo $alternate ?>" href="<?php the_field('cta_1_url'); ?>"><?php the_field('cta_1_text'); ?></a>
                  <a class="ibm-btn-sec <?php echo $alternate ?>" href="<?php the_field('cta_2_url'); ?>"><?php the_field('cta_2_text'); ?></a>
            </p>
   		</div>
   	<?php } ?>
   	<?php if(get_field('cta_num') == "3_cta") { ?>
         <div class="ibm-col-1-1 ibm-center">
            <p class="ibm-btn-link ibm-btn-row">
                  <a class="ibm-btn-sec <?php echo $alternate ?>" href="<?php the_field('cta_1_url'); ?>"><?php the_field('cta_1_text'); ?></a>
                  <a class="ibm-btn-sec <?php echo $alternate ?>" href="<?php the_field('cta_2_url'); ?>"><?php the_field('cta_2_text'); ?></a>
                  <a class="ibm-btn-sec <?php echo $alternate ?>" href="<?php the_field('cta_3_url'); ?>"><?php the_field('cta_3_text'); ?></a>
            </p>
         </div>
   	<?php } ?>
   	</div>
  </div>
  <?php } ?>
  <?php endwhile; endif; ?>