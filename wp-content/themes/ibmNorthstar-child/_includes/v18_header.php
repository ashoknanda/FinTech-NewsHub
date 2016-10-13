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
                        <form id="ibm-search-form"  action="<?php bloginfo('url'); ?>" method="get">
                          <p>
                            <label for="q"></label>
                            <input type="text" maxlength="100" value="" placeholder="Search THINK Marketing" name="s" id="q" aria-label="Search" />
                            <input type="hidden" value="18" name="v" />
                            <input type="hidden" value="utf" name="<?php
                            $temp = strtolower(substr(get_option('meta_country'), 0, strpos(get_option('meta_country'), "-")));
                            echo ($temp == "" ? "en" : $temp); ?>" />
                            <input type="hidden" value="<?php $temp = strtolower(substr(get_option('meta_country'), 0, strpos(get_option('meta_country'), "-"))); echo ($temp == "" ? "en" : $temp); ?>" name="lang" />
                            <input type="hidden" value="<?php $temp = strtolower(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1)); echo ($temp == "" ? "us" : $temp); ?>" name="cc" />
                            <input type="submit" id="ibm-search" class="ibm-btn-search" value="Submit" />
                            </p>
                        </form>
                    </div>
                </div>
            </div> <!-- #ibm-masthead -->
            <script>
              IBMCore.common.util.config.set({
                masthead: {type: "alternate"},
                footer: {
                  type: "alternate",
                  socialLinks: { enabled:false }
                },
                localeselector: {enabled:false}

              });
            </script>


            <header role="banner" aria-labelledby="ibm-pagetitle-h1" style="position:relative;z-index:799">
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

                      </ul>
                  </div>


<!-- Marketing Hub Social bar BEGINS -->
<div id="nh-social-bar-overlay-bg"></div>
<div id="nh-social-bar" class="minimized">
  <div class="nh-positioner">
    <div class=" nh-flexer">
      <div class="subscribe nh-flexer nh-border-setter">
        <div class="nh-icon-wrap">
          <svg width="25px" height="24px" viewBox="34 23 25 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
              <desc>Created with Sketch.</desc>
              <defs></defs>
              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(35.000000, 24.000000)" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M23.2978667,22.3866962 L16.0507556,15.1744269 L23.2978667,8.79546538 L12.7449778,0.669388462 C12.2480889,0.287234615 11.5547556,0.287234615 11.0587556,0.669388462 L0.502311111,8.79546538 L7.73431111,15.1921192 L0.502311111,22.38935" id="Stroke-1" stroke="#000000" stroke-width="0.779399979"></path>
                  <path d="M0.502755556,22.3894385 L9.01653333,13.9165923 C9.33653333,13.5981308 9.76942222,13.4194385 10.2218667,13.4194385 C11.1240889,13.4194385 12.6778667,13.4185538 13.5809778,13.4185538 C14.0334222,13.4185538 14.4663111,13.5972462 14.7872,13.9165923 L23.2983111,22.3867846" id="Stroke-3" stroke="#000000" stroke-width="0.779399979"></path>
                  <path d="M23.2984889,8.79422692 C23.3731556,8.88888077 23.4184889,9.00918846 23.4184889,9.13922692 L23.4184889,22.0501885 C23.4184889,22.3589192 23.1669333,22.6083808 22.8567111,22.6083808 L0.9456,22.6083808 C0.636266667,22.6083808 0.384711111,22.3589192 0.384711111,22.0501885 L0.384711111,9.13922692 C0.384711111,9.01007308 0.429155556,8.89065 0.502933333,8.79599615" id="Stroke-5" stroke="#000000" stroke-width="0.779399979"></path>
                  <path d="M6.72497778,8.79581923 L17.0760889,8.79581923" id="Stroke-7" stroke="#000000" stroke-width="0.779399979"></path>
              </g>
          </svg>
        </div>
        <div class="nh-label ibm-small">Subscribe</div>
      </div class="subscribe">
      <div class="follow-buttons nh-flexer nh-border-setter">
        <div class="instruction ibm-small">Follow #THINKmarketing</div>
        <div class="social-buttons-wrap nh-flexer">
          <a class="ibm-twitter-link social-button" href="https://twitter.com/IBMforMarketing" target="_blank"></a>
          <a class="ibm-linkedin-link social-button" href="https://www.linkedin.com/company/ibm-for-marketing" target="_blank"></a>
          <a class="ibm-facebook-link social-button" href="https://www.facebook.com/Silverpop/" target="_blank"></a>
          <a class="ibm-rss-link social-button" href="feed/rss" target="_blank"></a>
        </div>
      </div>
      <div class="ibm-close-link"></div>
      <div class="minimized-cta ibm-chevron-left-regular-link"></div>
    </div class="nh-flexer">
    <div class="nh-subscribe-form">
      <?php echo do_shortcode('[do_widget id=wpsp_widget-4 category=ALL formtype=1]'); ?>
    </div>
  </div class="nh-positioner">
</div id="nh-social-bar" class="">
<script>
//-----------------------------------------------------
//  once page loads, initialize the subscription bar: the method is defined in /wp-content/themes/ibmNorthstar-child/assets/js/src/NH_subscriptionBar.js
jQuery(function(){
  window.newshub.subscriptionBar.init();
});
</script>
<!-- Marketing Hub Social bar END -->


              </div>


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

                  // console.log("I am here ");
                  // jQuery(document).ready(function($) {
                  //     var x = $("#ibm-signin-minimenu-container li a");
                  //     console.log(x);
                  //     x.on('load', function(ele){
                  //       console.log(ele);
                  //     });
                  // });

                </script>
            </header>

<?php require('abbreviate.function.php'); ?>