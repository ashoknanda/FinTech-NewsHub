
                <?php
                  $params   = array('name' => 'footer-social-icons', 'post_type' => 'module');
                  $footer    = new WP_Query($params);
                  // print_r($footer);
                ?>

                <?php if ( $footer->have_posts() ) : while ( $footer->have_posts() ) : $footer->the_post(); ?>
                    <?php $social_icons = get_field('social_icons'); ?>
                    <?php if($social_icons) {?>
            <div class="ibm-band scene known-footer ibm-background-white-core" id="known-footer">

                <?php 
                    $facebook_link = get_field("facebook_link");
                    $twitter_link = get_field("twitter_link");
                    $linkedin_link = get_field("linkedin_link");
                    $youtube_link = get_field("youtube_link");
                    $googleplus_link = get_field("googleplus_link");
                    $rss_link = get_field("rss_link");

                    if(!empty($facebook_link) || !empty($twitter_link) || !empty($linkedin_link) || !empty($youtube_link) || !empty($googleplus_link) || !empty($rss_link))
                    {
                        ?> 
                        <div class="ibm-columns ibm-padding-top-1 ibm-padding-bottom-2">
                            <div class="ibm-col-1-1">
                                <div class="social-share">
                                    <h4>Connect with us</h4>
                                    <p class="ibm-icononly ibm-padding-top-1">
                                    <?php if(get_field("facebook_link")!=""){ ?>
                                       <a class="ibm-facebook-encircled-link" href="<?php echo the_field("facebook_link") ?>" target="_blank"></a>
                                    <?php } ?>
                                    <?php if(get_field("twitter_link")!=""){ ?>
                                        <a class="ibm-twitter-encircled-link" href="<?php echo the_field("twitter_link") ?>" target="_blank"></a>
                                    <?php } ?>
                                    <?php if(get_field("linkedin_link")!=""){ ?>
                                        <a class="ibm-linkedin-encircled-link" href="<?php echo the_field("linkedin_link") ?>" target="_blank"></a>
                                    <?php } ?>
                                    <?php if(get_field("youtube_link")!=""){ ?>
                                        <a class="ibm-youtube-encircled-link" href="<?php echo the_field("youtube_link") ?>" target="_blank"></a>
                                    <?php } ?>
                                    <?php if(get_field("googleplus_link")!=""){ ?>
                                        <a class="ibm-googleplus-encircled-link" href="<?php echo the_field("googleplus_link") ?>" target="_blank"></a>
                                    <?php } ?>
                                    <?php if(get_field("rss_link")!=""){ ?>
                                        <a class="ibm-rss-link ibm-textcolor-black-core" href="<?php echo the_field("rss_link") ?>" target="_blank"></a>
                                    <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }

                
                } ?>
                <?php endwhile; endif; ?>
</div>

            <!-- IBM: FOOTER_BEGIN -->
            <div id="ibm-footer-module"></div>
            <footer role="contentinfo" aria-label="IBM">
                <div id="ibm-footer">
                    <ul>
                        <li><a href="http://www.ibm.com/contact/us/en/">Contact</a></li>
                        <li><a href="http://www.ibm.com/privacy/us/en/">Privacy</a></li>
                        <li><a href="http://www.ibm.com/legal/us/en/">Terms of use</a></li>
                        <li><a href="http://www.ibm.com/accessibility/us/en/">Accessibility</a></li>
                    </ul>
                </div>
            </footer>
