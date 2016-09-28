            <div id="ibm-masthead" role="banner" aria-label="IBM">
                <div id="ibm-mast-options">
                    <ul role="toolbar" aria-labelledby="ibm-masthead">
                        <li id="ibm-geo" role="presentation"><a href="http://www.ibm.com/planetwide/select/selector.html" role="button" aria-label="United states selected - Choose a country">United States</a> </li>
                    </ul>
                </div>
                <div id="ibm-universal-nav">
                    <nav role="navigation" aria-label="IBM">

                        <div id="ibm-home"><a href="http://www.ibm.com/<?php
                        $temp = strtolower(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1));
                        echo ($temp == "" ? "us" : $temp);
                        ?>/<?php
                        $temp = strtolower(substr(get_option('meta_country'), 0, strpos(get_option('meta_country'), "-")));
                        echo ($temp == "" ? "en" : $temp); ?>/">IBM®</a></div>
                        <ul id="ibm-menu-links" role="toolbar" aria-label="Site map">
                            <li><a href="http://www.ibm.com/sitemap/<?php
                            $temp = strtolower(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1));
                            echo ($temp == "" ? "us" : $temp); ?>/<?php $temp = strtolower(substr(get_option('meta_country'), 0, strpos(get_option('meta_country'), "-"))); echo ($temp == "" ? "en" : $temp); ?>/">Site map</a></li>
                        </ul>
                    </nav>
                    <div id="ibm-search-module" role="search" aria-labelledby="ibm-masthead">
                        <form id="ibm-search-form" action="http://www.ibm.com/Search/" method="get">
                            <label for="q"></label>
                            <input type="text" maxlength="100" value="" placeholder="Search" name="q" id="q" aria-label="Search" />
                            <input type="hidden" value="18" name="v" />
                            <input type="hidden" value="utf" name="<?php
                            $temp = strtolower(substr(get_option('meta_country'), 0, strpos(get_option('meta_country'), "-")));
                            echo ($temp == "" ? "en" : $temp); ?>" />
                            <input type="hidden" value="<?php $temp = strtolower(substr(get_option('meta_country'), 0, strpos(get_option('meta_country'), "-"))); echo ($temp == "" ? "en" : $temp); ?>" name="lang" />
                            <input type="hidden" value="<?php $temp = strtolower(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1)); echo ($temp == "" ? "us" : $temp); ?>" name="cc" />
                            <input type="submit" id="ibm-search" class="ibm-btn-search" value="Submit" />
                        </form>
                    </div>
                </div>
            </div> <!-- #ibm-masthead -->
            <script>
              IBMCore.common.util.config.set({
                masthead: {type: "alternate"}
              });
            </script>


            <header role="banner" aria-labelledby="ibm-pagetitle-h1">
              <div class="ibm-sitenav-menu-container">
<!-- The code below is where you edit the blog title that appears in menu navigation -->
                 <div class="ibm-sitenav-menu-name"><a class="ibm-bold" href="<?php echo get_bloginfo('url'); ?>"><?php echo get_bloginfo('name'); ?></a></div>
                  <div class="ibm-sitenav-menu-list">

                      <ul role="menubar">

                          <?php

                            $menu = wp_get_nav_menu_object ('v18_header_nav');
                            $menu_items = wp_get_nav_menu_items($menu->term_id);

                            if($menu_items)
                            {
                                foreach ($menu_items as $menu_item)
                                {
                                  $has_children = false;
                                  $children = array();

                                  // get children
                                  foreach ($menu_items as $mitem) :
                                    if ($menu_item->ID === (int)$mitem->menu_item_parent) {
                                      $has_children = true;
                                      array_push($children, $mitem);
                                    }
                                  endforeach;

                                  if ($has_children) {
                              ?>
                                    <li role="presentation" class="ibm-haschildlist"><span role="menuitem"><?php echo $menu_item->title; ?></span>
                                      <ul role="menu">

                              <?php foreach ($children as $child) { ?>
                                        <li><a href="<?php echo $child->url; ?>"><?php echo $child->title; ?></a></li>
                              <?php } ?>
                                      </ul>
                                    </li>
                              <?php
                                  } else {
                                    if ((int)$menu_item->menu_item_parent === 0) {
                              ?>
                                      <li role="presentation"><a role="menuitem" href="<?php echo $menu_item->url; ?>"><?php echo $menu_item->title; ?></a></li>
                              <?php
                                    }
                                  }
                                }
                              }
                              ?>

                              <li role="presentation" class="custom-head-button custom-button-container">
                                <p>
                                  <button style="margin-top:6px;margin-left:20px;margin-right:20px" class="ibm-btn-sec ibm-btn-blue-50 ibm-btn-small" data-tooltip-id="test-tt-1">Subscribe</button>
                                </p>
                                  <div id="test-tt-1" class="custom-tooltip-content">
                                      <?php echo do_shortcode('[do_widget id=wpsp_widget-3 category=All formtype=1]') ?>
                                  </div>
                              </li>

                      </ul>
                  </div>
              </div>
              <?php if (is_front_page() && ('posts' == get_option( 'show_on_front' )) or is_home()) { ?>

                <?php
                  $params   = array('name' => 'home-leadspace', 'post_type' => 'module');
                  $leadspace    = new WP_Query($params);
                  // print_r($leadspace);
                ?>

                <?php if ( $leadspace->have_posts() ) : while ( $leadspace->have_posts() ) : $leadspace->the_post(); ?>
                  <?php $limage = get_field('main_image');
                        $directory = get_template_directory_uri();
                        $leadspace_title_size = get_field('leadspace_title_size');
                        $leadspace_subtitle_size = get_field('leadspace_subtitle_size');
                        if(!$leadspace_title_size){
                          $leadspace_title_size = 'ibm-h2';
                        }
                        if(!$leadspace_subtitle_size){
                          $leadspace_subtitle_size = 'ibm-h4';
                        }
                      if($limage != '') { ?>
                  <div id="ibm-leadspace-head" class="ibm-alternate ibm-padding-top-2 ibm-padding-bottom-2 <?php the_field('text_color'); ?>"
                        data-desktop-lg-retina="<?php echo $limage['sizes']['size-2880']; ?>"
                        data-desktop-lg="<?php echo $limage['sizes']['size-1440']; ?>"
                        data-desktop-retina="<?php echo $limage['sizes']['size-2400']; ?>"
                        data-desktop="<?php echo $limage['sizes']['size-1200']; ?>"
                        data-tablet-retina="<?php echo $limage['sizes']['size-1200']; ?>"
                        data-tablet="<?php echo $limage['sizes']['size-780']; ?>"
                        data-mobile-retina="<?php echo $limage['sizes']['size-780']; ?>"
                        data-mobile="<?php echo $limage['sizes']['size-380']; ?>"
			style="background-image: url(<?php echo $limage['sizes']['size-1440']; ?>);">
                <?php } else { ?>
                <div id="ibm-leadspace-head" class="ibm-padding-top-2 ibm-padding-bottom-2 <?php the_field('text_color'); ?>"
                        style="background-image: url('<?php echo $directory; ?>/assets/img/default-leadspace-1440x320.jpg');">
                <?php } ?>
                      <div id="ibm-leadspace-body" class="ibm-padding-top-0 ibm-padding-bottom-0">
                          <div class="ibm-columns">
                          <?php if(get_field('text_align') == "center"){ ?>
                              <div class="ibm-col-1-1 ibm-center">
                              <?php } else { ?>
                              <div class="ibm-col-1-1">
                              <?php } ?>
                                    <h2 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight'); ?>"><?php the_field('main_title'); ?></h2>
                                    <h4 class="<?php echo $leadspace_subtitle_size; ?> <?php the_field('leadspace_subtitle_weight'); ?>"><?php the_field('sub_title'); ?></h4>
                                    <!-- <h4 class="<?php the_field('leadspace_description_size'); ?> <?php the_field('leadspace_description_weight'); ?>"><?php the_field('credit'); ?></h4> -->
                                  </div>
                          </div>

                      </div>
                      <?php if (0){ ?>
                      <div id="ibm-leadspace-social">
                          <div class="ibm-columns">
                              <div class="ibm-col-1-1">
                                  <div class="ibm-leadspace-social-links">
                                      <div class="ibm-sharethispage"></div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <?php } else { ?>

                        <div id="ibm-leadspace-social">
              						<div class="ibm-columns" style="padding: 10px 0 0px;">
              							<div class="ibm-col-1-1">
              								<div class="ibm-leadspace-social-links">
              									<div>
              										<p class="ibm-textcolor-white-core">Follow Us</p>
              										<p class="ibm-ind-link ibm-alternate">
              											<a class="ibm-twitter-encircled-link" href="http://www.twitter.com/ibm" target="blank"><span>Follow us on Twitter</span></a>
              											<a class="ibm-linkedin-encircled-link" href="http://www.linkedin.com/company/ibm" target="blank"><span>Join us on Linkedin</span></a>
              											<a class="ibm-facebook-encircled-link" href="http://www.facebook.com/ibm" target="blank"><span>Visit our Facebook page</span></a>
              											<a class="ibm-youtube-encircled-link" href="http://www.youtube.com/ibm" target="blank"><span>Watch our YouTube channel</span></a>
              										</p>
              									</div>
              								</div>
              							</div>
              						</div>
              					</div>
                      <?php } ?>

                <?php endwhile; endif; ?>

              <?php } ?>


                <nav role="navigation" aria-labelledby="ibm-pagetitle-h1">

                </nav>
                <!-- CONTENT_NAV_END -->
                  <script>
                  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                  ga('create', 'UA-79125772-1', 'auto');
                  <?php
                  $google_analytics_UA = get_option('google_analytics_UA');
                  if(!empty($google_analytics_UA) && $google_analytics_UA !== "UA-79125772-1")
                  {
                    ?>ga('create', '<?php echo get_option('google_analytics_UA'); ?>', 'auto', {'name': 'blogTracker'});
                  ga('blogTracker.send', 'pageview');
                  <?php
                  }
                  ?>ga('send', 'pageview');

                  console.log("I am here ");
                  jQuery(document).ready(function($) {
                      var x = $("#ibm-signin-minimenu-container li a");
                      console.log(x);
                      x.on('load', function(ele){
                        console.log(ele);
                      });
                  });

                </script>
            </header>
