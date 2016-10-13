<!-- ============================================================ -->
        <!-- START: v18_head -->

        <link rel="icon" href="//www.ibm.com/favicon.ico">

        <meta name="robots" content="index,follow">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="geo.country" content="<?php
        $temp = strtoupper(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1));
        echo ($temp == '' ? "US" : $temp);
        ?>" />
        <meta name="dcterms.date" content="<?php echo the_time('Y-m-d'); ?>" />
        <meta name="dcterms.rights" content="© Copyright IBM Corp. 2016" />


        <?php
        $themeDetails = wp_get_theme();
        $post = get_post_type();
        $isHome = is_home();
        $pageTemplate = get_page_template();
        $templateType = substr($pageTemplate, strrpos($pageTemplate, "/") + 1);
        $specialPages = array("about","archive","categories","contributors");
        if($post == "post" && !$isHome && !in_array("page-".$templateType.".php", $specialPages) && !is_author() && !is_archive() && !is_category() && !is_tag()){
            $type = "CT915";
        }
        else{
            $type = "CT904";
        }


        //Code to add the og tag info.
        $pageTitle = 'IBM '.get_bloginfo('name');
        $pageDesc = get_bloginfo('description');
        $pageImage = "http://www-03.ibm.com/ibm/history/ibm100/images/icp/W141717T18176O09/us__en_us__ibm100__good_design__eye_bee_m__620x350.jpg";
        if(is_category()){
          // $pageTitle = $pageTitle.' - ';
          $catPageTitle = single_cat_title('',false);
          $pageTitle = $catPageTitle.' Articles - '.$pageTitle;
          $pageDesc = category_description();
        }
        elseif(is_single()){
          $pageTitle = $pageTitle.' - ';
          $pageTitle = single_post_title($pageTitle,false); 

          $post_id = get_queried_object_id();
          $post_obj = get_post( $post_id );
          $pageDesc = $post_obj->post_content;
          $pageDesc = strip_tags($pageDesc);
          $pageDesc = substr($pageDesc, 0, 150);
          $postImage = get_field('card_image', $post_id);
          $pageImage = $postImage['sizes']['large'];
        }



        $pageURL = 'http';
        if( isset($_SERVER["HTTPS"]) ) {
          if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
          $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
          $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        $pageCategory = "IBM_MarketingHUB";
        if(is_home()){
          $pageTitle = $pageTitle.' - Thought Leadership & Best Practices';
          $pageCategory = $pageCategory.'_HomePage';
        }else if(is_category()){
          $pageCategory = $pageCategory.'_Topics';
          $ctT = single_cat_title('',false);
          if($ctT == 'Campaign management'){
            $pageCategory = $pageCategory.'_CampaignManagement';
          }else if($ctT == 'Digital marketing'){
            $pageCategory = $pageCategory.'_DigitalMarketing';
          }else if($ctT == 'Data & analytics'){
            $pageCategory = $pageCategory.'_DataAnalytics';
          }
        }else if(strcasecmp($pagename ,'Trending') == 0){
          $pageTitle = 'Trending Articles - '.$pageTitle;
        }

        ?>

        <title><?php echo $pageTitle; ?></title>
        <meta name="description" content="<?php echo $pageDesc; ?>" />

        <script>
            digitalData = {
                page: {
                    category: {
                        primaryCategory: "<?php echo $pageCategory; ?>"
                    },
                    pageInfo: {
                        effectiveDate: '<?php echo the_time('Y-m-d'); ?>',
                        expiryDate: '<?php echo date("Y-m-d",((get_post_time('U', true))+31536000*5));?>',
                        language: '<?php
                        $temp = strtolower(substr(get_option('meta_country'), 0, strpos(get_option('meta_country'), "-"))) . "-" . strtoupper(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1));
                        echo ($temp == '-' ? "en-US" : $temp);
                        ?>',
                        publishDate: '<?php echo the_time('Y-m-d'); ?>',
                        publisher: 'IBM Corporation',
                        version: 'v18',
                         convertro: {
                           enabled: true
                         },
                         hotjar: {
                           enabled: true
                         },                        
                        ibm: {
                            contentDelivery: 'ibm.com/news-hub',
                            contentProducer: '<?php echo $themeDetails->Name . " " . $themeDetails->Version; ?>',
                            country: '<?php
                            $temp = strtoupper(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1));
                            echo ($temp == '' ? "US" : $temp);
                            ?>',
                            industry: 'ZZ',
                            owner: '<?php echo get_option('meta_page_owner'); ?>',
                            siteID: 'IBM_MarketingHUB',
                            subject: 'IBM000',
                            type: '<?php echo $type; ?>',
                            GBTtags: {
                                gbt10_IBM_BU: '<?php echo get_option('meta_page_gbt10_IBM_BU'); ?>',
                                gbt17_Product_Segment: '<?php echo get_option('meta_page_gbt17_Product_Segment'); ?>',
                                gbt20_Primary_Brand: '<?php echo get_option('meta_page_gbt20_Primary_Brand'); ?>',
                                gbt30_Product_Family: '<?php echo get_option('meta_page_gbt30_Product_Family'); ?>'
                            },
                             contactModuleConfiguration: {
                                contactInformationBundleKey: {
                                   focusArea: "Analytics - Watson Analytics",
                                   languageCode: "en",
                                   regionCode: "US"
                                },
                                contactModuleTranslationKey: {
                                   languageCode: "en",
                                   regionCode: "US"
                                }
                             }                            
                          }
                        }
                    }
                };
                               
        </script>


        <!-- IBM: METRICS -->
        <!-- <script src="//1.www.s81c.com/common/stats/ida_stats.js"></script> -->

        <!-- IBM: BASE -->
        <link href="//1.www.s81c.com/common/v18/css/www.css" rel="stylesheet" />
        <script src="//1.www.s81c.com/common/v18/js/www.js"></script>

        <!-- IBM: FORMS -->
        <link href="//1.www.s81c.com/common/v18/css/forms.css" rel="stylesheet" />
        <script src="//1.www.s81c.com/common/v18/js/forms.js"></script>

        <!-- IBM: TABLES -->
        <link href="//1.www.s81c.com/common/v18/css/tables.css" rel="stylesheet" />
        <script src="//1.www.s81c.com/common/v18/js/tables.js"></script>


        <!-- IBM: METRICS -->
        <!-- <script type="text/javascript" src="//www.ibm.com/software/info/js/tactic.js"></script> -->
        <!-- <script type="text/javascript" src="//www.ibm.com/software/info/js/tacticbindlinks.js"></script> -->

        <!-- Newscred: Metrics -->
        <script src="//analytics.newscred.com/analytics_fd28b4bb344e4c9496e4f926e0700b4f.js"></script>

        <script src='//1.www.s81c.com/common/v18/js/masonry.js'></script>

        <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/site.min.js"></script>

        <!--Live Assist --> 
        <!-- <script src="https://www.ibm.com/common/digitaladvisor/js/cm-app.min.js" defer></script> -->


       <?php
       if(get_option('v18_optional_widget_syntaxHighlighter') == "on")
       {
        ?> <!-- IBM: SYNTAX HIGHLIGHTER -->
        <link href="//1.www.s81c.com/common/v18/css/syntaxhighlighter.css" rel="stylesheet">
        <script src="//1.www.s81c.com/common/v18/js/syntaxhighlighter.js"></script>
        <?php
       }
       ?>

       <?php
       if(get_option('v18_optional_widget_dynamicTabs') == "on")
       {
        ?> <!-- IBM: DYNTABS -->
        <script src="//1.www.s81c.com/common/v18/js/dyntabs.js"></script>
        <?php
       }
       ?>

       <?php
       if(get_option('v18_optional_widget_mustache') == "on")
       {
        ?> <!-- IBM: MUSTACHE -->
        <script src="//1.www.s81c.com/common/v18/js/mustache.js"></script>
        <?php
       }
       ?>

        <script>
          function loadmenu(){
              var url = "https://idaas.iam.ibm.com/idaas/mtfim/sps/authsvc?PolicyId=urn:ibm:security:authentication:asf:basicldapuser&Target="+"<?php echo $pageURL ?>";
              var counter=0;
              var milliseconds = new Date().getTime();
              jQuery.ajax({
                url:'https://www.ibm.com/gateway/sec/?cb=777:checkstatus&cc=us&lc=en&format=json&ts='+milliseconds,
                async: false,
                dataType: 'jsonp',
                cache: false,
                contentType: "application/json",
                success: function checkstatus(xhr){
                  ++counter;
                  // console.log("success,counter", counter);
                },
                jsonpCallback: 'checkstatus',
                error: function(xhr){
                  // console.log("Inside error:counter",counter);
                  if(counter>0){
                    return;
                  }
                  IBMCore.common.module.masthead.editProfileMenu({
                    action: "replace",
                    links: [{
                    title: "Sign In",
                        url: url 
                    }]
                  });                        
                }
              });
          }
          window.twttr = null;
        </script>

        <!-- Javascript to highlight the navbars -->
        <script>
        jQuery(document).ready(function($){
          $('.ibm-sitenav-menu-list').find("a").each(function(index, value){
              var urltocompare = $(value).attr("href");
              if(urltocompare == $(location).attr("href")){
                $(value).parents('li').addClass("ibm-highlight");
              }
          })
        });
        </script>


        <?php if(is_home() && $pageURL != ''): ?> 
        
        <script type="text/javascript" src="<?php echo 'wp-content/plugins/rotatingtweets/js/rotating_tweet.min.js'; ?>"></script> 
<!--         <script type="text/javascript" src="<?php //echo 'wp-content/plugins/rotatingtweets/js/jquery.cycle2.renamed.js'; ?>"></script>
        <script type="text/javascript" src="<?php //echo 'wp-content/plugins/rotatingtweets/js/jquery.cycle2.scrollVert.renamed.js'; ?>"></script>
        <script type="text/javascript" src="<?php //echo 'wp-content/plugins/rotatingtweets/js/jquery.cycle2.carousel.renamed.js'; ?>"></script>
        <script type="text/javascript" src="<?php //echo 'wp-content/plugins/rotatingtweets/js/rotatingtweets_v2.js'; ?>"></script> -->
      <?php endif; ?>
