        <?php $page_ID = get_the_ID(); 
              $page_type = ucfirst(get_post_type()); ?>
         <?php
                  $params   = array('name' => 'v18_sidebar', 'post_type' => 'module');
                  $sidebar    = new WP_Query($params);
                  // print_r($leadspace);
                ?>

                <?php if ( $sidebar->have_posts() ) : while ( $sidebar->have_posts() ) : $sidebar->the_post(); ?>

<?php 		
		$first_cta_area = get_field('first_cta_area');
		$second_cta_area = get_field('second_cta_area');
    $rss_feed = get_field('rss_feed');
    $add_second_feed = get_field('add_second_feed');
    $page_feed = get_field("page_feed");
?>
		
                  <!--- Right side bar beginning-->
                        <div class="data social-margin"><h1 class="ibm-h3"><?php the_field('main_title'); ?></h1>
                          <?php the_field('twitter_embed_code'); ?>
	   		  <?php if($first_cta_area){ ?>
                           <h4 class="ibm-bold ibm-h4 ibm-padding-top-1"><?php the_field('first_section_title'); ?></h4>
                            <p class="step-2"><?php the_field('first_section_text_area'); ?></p>
                           <div class="ibm-alternate-background ibm-padding-top-1 ibm-padding-bottom-0">
            			<p class="ibm-button-link ibm-padding-bottom-2">
            			<a class="ibm-btn-pri ibm-resize" href="<?php the_field('first_section_cta_url'); ?>" target="_blank">
               				<span class="ibm-textcolor-white-core ibm-bold"><?php the_field('first_section_cta_text'); ?></span>
           			</a>
          			</p>
                           </div>
			  <?php } ?>
			  <?php if($second_cta_area){ ?>
                            <h4 class="ibm-bold ibm-h4">
                                <?php the_field('second_section_title'); ?>
                            </h4>
                            <p class="step-2"><?php the_field('second_section_text_area'); ?></p>
                      <div class="ibm-alternate-background ibm-padding-top-1 ibm-padding-bottom-0">
                      <p class="ibm-button-link ibm-padding-bottom-0">
                      <a class="ibm-btn-pri ibm-resize" href="<?php the_field('second_section_cta_url'); ?>" target="_blank">
                         <span class="ibm-textcolor-white-core ibm-bold"><?php the_field('second_section_cta_text'); ?></span>
                      </a>
                      </p>
                      </div>
			<?php } ?>
      <?php if($rss_feed){ ?>
                            <h4 class="ibm-bold ibm-h4 ibm-padding-top-2">
                                <?php the_field('rss_feed_section_title'); ?>
                            </h4>
                            <ul class="ibm-link-list">
                              <?php if($page_feed){ ?>
                               <li><a href="<?php get_permalink($page_ID); ?>feed/atom" class="ibm-rss-link"><?php echo $page_type; ?> feed</a></li>
                              <?php } else { ?>
                              <li><a href="<?php the_field('rss_feed_1_link'); ?>" class="ibm-rss-link"><?php the_field('rss_feed_1_title'); ?></a></li>
                              <?php } if($add_second_feed){ ?>
                              <li><a href="<?php the_field('rss_feed_2_link'); ?>" class="ibm-rss-link ibm-padding-bottom-1"><?php the_field('rss_feed_2_title'); ?></a></li>
                              <?php } ?>
                            </ul>
                      </div>
      <?php } ?>
                    </div>


  <?php endwhile; endif; ?>

<?php wp_reset_query(); ?>