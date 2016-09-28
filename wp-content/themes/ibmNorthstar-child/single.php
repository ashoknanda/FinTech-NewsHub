<?php

include_once __DIR__.'/_includes/NH_renderArticleTopMeta.function.php';
include_once __DIR__.'/_includes/NH_renderArticleCategories.function.php';
?>

<?php get_header(); ?>

    <?php get_template_part('_includes/v18_content_main_start'); ?>

    <?php

          $postsource = null;
          $postauthor = null;
          $authID = $post->post_author;
          $userdata = get_userdata($authID);
          $postauthor =  $userdata->user_nicename; //Setting author to post author set in WP if Newscred nc-author does not exist. 
          $custom_fields = get_post_custom($post->ID);
          $nc_source = array();
          $nc_author = array();
          $nc_author = $custom_fields['nc-author']?$custom_fields['nc-author']:"";
          $nc_source = $custom_fields['nc-source']?$custom_fields['nc-source']:"";
          if(isset($nc_author)){
            foreach ( $nc_author as $key => $value ) {
              $postauthor = $value;
            }    
          }
$postsource = 'THINK Marketing';
$nc_source_abbrev = 'T';

if(isset($nc_source)){

  foreach ( $nc_source as $key => $value ) {
    $postsource = $value;

    if(strcasecmp ( $value , "ibm commerce" ) == 0){
      $postsource = 'THINK Marketing';
    }
    // $nc_source_abbrev = abbreviate($postsource, 3);
    $cleaned_nc_source = str_replace('the', "", $postsource);
    $nc_source_abbrev = $cleaned_nc_source[0];
  }

}else{

  $postsource = 'THINK Marketing';
  $nc_source_abbrev = 'T';

}

          //Identify it is editors_pick.
          $allTags = wp_get_post_tags($post->ID);
          $is_editor_pick = false;
          $is_events_post = false;
          $is_watson_tshirt = false;
          foreach ($allTags as $key => $value) {
            // print_r($value->name);
            if($value->name == 'editor_pick'){
              $is_editor_pick = true;
            }
            else if($value->name == 'events_post') {
                $is_events_post = true;
            }
            else if($value->name == 'watson_tshirt') {
                $is_watson_tshirt = true;
            }
          }





        //calculates the facebook counts and linkedin counts and sets it to a variable to reuse.
        $urltogetcount = get_permalink(); 
        $fbCount=0; $lnCount = 0;
        $fbCount = do_shortcode("[facebook-share url='".$urltogetcount."']");
        $lnCount = do_shortcode("[linkedin-share url='".$urltogetcount."']"); 


        // size helper -- Single Post Template modified by Ryan Sebade
        function formatSizeUnits($bytes) {
            if ($bytes >= 1073741824) {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576) {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024) {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1) {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1) {
                $bytes = $bytes . ' byte';
            }
            else {
                $bytes = '0 bytes';
            }

            return $bytes;
        }

        // get csv data
        $csv_data = get_field('csv_data');
        $fullwidth_choice = get_field('full_width');
        $socialshare_choice = get_field('social_share');
        if($socialshare_choice == 'Yes'){
            $socialshare = true;
        }
        elseif($socialshare_choice == 'No'){
            $socialshare = false;
        }
        else{
            if(esc_attr(get_option( 'force_all_posts_to_social_share', '' )) == "on"){
                $socialshare = true;
            }
            else{
                $socialshare = false;
            }
        }

        if($socialshare_choice == ''){
            if(esc_attr(get_option( 'force_all_posts_to_social_share', '' )) == "on"){
                $socialshare = true;
            }
            else{
                $socialshare = false;
            }
        }
        if($fullwidth_choice == 'Yes'){
            $socialshare = true;
        }
        elseif($fullwidth_choice == 'No'){
            $socialshare = false;
        }
        else{
            if(esc_attr(get_option( 'force_all_posts_to_full_width', '' )) == "on"){
                $fullwidth = true;
            }
            else{
                $fullwidth = false;
            }
        }

        if($fullwidth_choice == ''){
            if(esc_attr(get_option( 'force_all_posts_to_full_width', '' )) == "on"){
                $fullwidth = true;
            }
            else{
                $fullwidth = false;
            }
        }

        if(esc_attr(get_option( 'hide_author_from_posts', '' )) == "on"){
                $hideauthor = true;
            }
            else{
                $hideauthor = false;
            }



    ?>

<!-- The Loop -->
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <?php
        $pimages = get_field('leadspace_image');


        if ($post->post_type === 'abstract') {
            $aimages = get_field('abstract_image');
        }
        $categories = array();
        $pcategories = get_the_category();
        $catNotIn = categoryListNotToShow(); //Gets the full list of categories not be shown on page. 
        foreach($pcategories as $pcategory)
        {
          if($pcategory->name !== 'Featured Carousel' && $pcategory->name !== 'Uncategorized' && !in_array($pcategory->name, $catNotIn)) {
            array_push($categories, $pcategory);
          }
        }

        $template_directory = get_template_directory_uri();
        $leadspace_default = $template_directory  . '/default-leadspace-1440x320.jpg';
        $leadspace_title_size = get_field('leadspace_title_size');
        if(!$leadspace_title_size){
          $leadspace_title_size = 'ibm-h2';
        }

        // SIdebar Links to Collections through Ads
        $allcatids = array_map(create_function('$o', 'return $o->name;'), $categories) ;
        $ads_group_ids = get_ad_group_id($allcatids);

        $imgobjfromnc= wp_get_attachment_image_src( get_post_thumbnail_id(), 'large_size' );
        //Required for Events page to show watson generated image. 
        if($is_events_post && $is_watson_tshirt){
            $sImg1 = wp_get_attachment_image_src('33697','size-780');
            if($sImg1){
                $sImg = $sImg1[0];
            }
        
            if (isset($_GET['watson_proposed'])) {
                $imgName = filter_input( INPUT_GET, 'watson_proposed', FILTER_SANITIZE_URL );
                $imgName = htmlspecialchars($imgName, ENT_QUOTES);
                if($imgName != ''){
                    $sImg1 = wp_get_attachment_image_src($imgName,'size-780');
                    if($sImg1){
                        $sImg = $sImg1[0];    
                    }
                } 
            }  
        }else if(!empty($imgobjfromnc)){
          $sImg = $imgobjfromnc[0];
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


        $loginurl = "https://idaas.iam.ibm.com/idaas/mtfim/sps/authsvc?PolicyId=urn:ibm:security:authentication:asf:basicldapuser&Target=".$pageURL;

        $email_body = urlencode("\r\n")."You might enjoy reading this article from THINK Marketing: " . rawurlencode($post->post_title) . urlencode("\r\n\r\n") . get_permalink();
      ?>
      <div class="ibm-band nh-card-article-container">
        <div class="ibm-columns">
          <div class="ibm-col-6-4 ibm-padding-top-1">
            <?php echo NH_renderArticleTopMeta($post, "content-page"); ?>
            <div class="nh-card-article-title">
              <h2 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight'); ?> ibm-bold" itemprop="headline" rel="bookmark">
                  <?php echo widont(get_the_title()); ?></h2>
            </div>
            <div class="nh-card-author">
              <span> <?php if(isset($postauthor) && $postauthor != ""){ echo 'By '.$postauthor ; }?></span>, 
              <span><?php  echo get_the_time(get_option('date_format'), $post->ID); ?></span>
              <!-- <span><?php //echo do_shortcode("[est_time]").' read'; ?></span> -->
            </div>
            <div class="nh-tags nh-card-meta-color-changer nh-card-meta-data">
              <?php echo NH_renderArticleCategories($post, 'content-page'); ?>
            </div>
            <div class="nh-social-wrapper ibm-padding-top-1">
              <div id='<?php the_ID(); ?>_social' >
                <div class="nh-social-share-icon-count">
                    <a href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php  echo widont(get_the_title()); ?>&amp;hashtags=THINKmarketing&amp;url=<?php the_permalink(); ?>" target="_blank" class="ibm-twitter-link ibm-small ibm-inlinelink nh-social-icon">&nbsp;</a>                
                    <a class="ibm-facebook-link ibm-small ibm-inlinelink nh-social-icon" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="_blank">
                        <span class="ibm-textcolor-gray-40"><?php echo $fbCount; ?>&nbsp;</span>
                    </a>
                    <a class="ibm-linkedin-link ibm-small ibm-inlinelink nh-social-icon" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source=<?php bloginfo( 'name' ); ?>" target="_blank">
                        <span class="ibm-textcolor-gray-40"><?php echo $lnCount; ?>&nbsp;</span>
                    </a>
                    <a class="nh-card-social-icon nh-social-icon-email ibm-small" href="mailto:?subject=THINK Marketing: <?php echo rawurlencode($post->post_title); ?>&body=<?php echo $email_body; ?>" style=" padding-left: 0;position:relative;top: 4px;">

                      <svg width="26px" height="17px" viewBox="128 0 26 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
                          <desc>Created with Sketch.</desc>
                          <defs></defs>
                          <g id="mailIcon" stroke="none" stroke-width="1" fill="#000000" fill-rule="evenodd" transform="translate(128.000000, 1.000000)" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M24.7618222,15.3326118 L1.02478519,15.3326118 C0.688711111,15.3326118 0.417155556,15.0662588 0.417155556,14.7387294 L0.417155556,1.00131765 C0.417155556,0.673788235 0.688711111,0.407435294 1.02478519,0.407435294 L24.7618222,0.407435294 C25.0978963,0.407435294 25.3694519,0.673788235 25.3694519,1.00131765 L25.3694519,14.7387294 C25.3694519,15.0662588 25.0978963,15.3326118 24.7618222,15.3326118 L24.7618222,15.3326118 Z" id="Stroke-1" stroke="#FFFFFF" stroke-width="0.8227"></path>
                              <path d="M0.544651852,0.636517647 L11.901837,10.4878118 C12.4670963,10.9791059 13.3193185,10.9791059 13.8855407,10.4878118 L25.239837,0.636517647" id="Stroke-3" stroke="#FFFFFF" stroke-width="0.8227"></path>
                              <path d="M0.544651852,15.0992941 L8.37931852,7.44188235" id="Stroke-5" stroke="#FFFFFF" stroke-width="0.8227"></path>
                              <path d="M25.2393556,15.0963765 L17.3883185,7.42296471" id="Stroke-7" stroke="#FFFFFF" stroke-width="0.8227"></path>
                          </g>
                      </svg>
                    </a>                                              
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="ibm-columns">
          <div class="ibm-col-6-4 nh-card-article-body">
            <?php if(isset($sImg)): ?> 
              <img alt="post_thumb" src="<?php echo $sImg; ?>" class="ibm-resize" /> 
            <?php endif; ?>
            <?php the_content(); ?>
            <div class="nh-social-wrapper ibm-padding-bottom-1">
              <div id='<?php the_ID(); ?>_social' >
                <div class="nh-social-share-icon-count">
                    <a href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php  echo widont(get_the_title()); ?>&amp;hashtags=NewWaytoEngage&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?><?php echo isset( $twitter_user ) ? '&amp;via='.$twitter_user : '&amp;via=IBMforMarketing'; ?>" target="_blank" class="ibm-twitter-link ibm-small ibm-inlinelink nh-social-icon">&nbsp;</a>                
                    <a class="ibm-facebook-link ibm-small ibm-inlinelink nh-social-icon" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="_blank">
                        <span class="ibm-textcolor-gray-40"><?php echo $fbCount; ?>&nbsp;</span>
                    </a>
                    <a class="ibm-linkedin-link ibm-small ibm-inlinelink nh-social-icon" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source=<?php bloginfo( 'name' ); ?>" target="_blank">
                        <span class="ibm-textcolor-gray-40"><?php echo $lnCount; ?>&nbsp;</span>
                    </a>
                    <a class="nh-card-social-icon nh-social-icon-email ibm-small" href="mailto:?subject=THINK Marketing: <?php echo rawurlencode($post->post_title); ?>&body=<?php echo $email_body; ?>" style=" padding-left: 0;position:relative;top: 4px;">

                      <svg width="26px" height="17px" viewBox="128 0 26 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
                          <desc>Created with Sketch.</desc>
                          <defs></defs>
                          <g id="mailIcon" stroke="none" stroke-width="1" fill="#000000" fill-rule="evenodd" transform="translate(128.000000, 1.000000)" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M24.7618222,15.3326118 L1.02478519,15.3326118 C0.688711111,15.3326118 0.417155556,15.0662588 0.417155556,14.7387294 L0.417155556,1.00131765 C0.417155556,0.673788235 0.688711111,0.407435294 1.02478519,0.407435294 L24.7618222,0.407435294 C25.0978963,0.407435294 25.3694519,0.673788235 25.3694519,1.00131765 L25.3694519,14.7387294 C25.3694519,15.0662588 25.0978963,15.3326118 24.7618222,15.3326118 L24.7618222,15.3326118 Z" id="Stroke-1" stroke="#FFFFFF" stroke-width="0.8227"></path>
                              <path d="M0.544651852,0.636517647 L11.901837,10.4878118 C12.4670963,10.9791059 13.3193185,10.9791059 13.8855407,10.4878118 L25.239837,0.636517647" id="Stroke-3" stroke="#FFFFFF" stroke-width="0.8227"></path>
                              <path d="M0.544651852,15.0992941 L8.37931852,7.44188235" id="Stroke-5" stroke="#FFFFFF" stroke-width="0.8227"></path>
                              <path d="M25.2393556,15.0963765 L17.3883185,7.42296471" id="Stroke-7" stroke="#FFFFFF" stroke-width="0.8227"></path>
                          </g>
                      </svg>
                    </a>                                                  
                </div>
              </div>
            </div>
             <?php 
             $ip_address = get_client_ip();
             $demand_base_url = "http://api.demandbase.com/api/v2/ip.json?key=de6a29fa50b1ab298d4e4132e91315d83e5fd375&query=".$ip_address;

             $result = file_get_contents($demand_base_url, false, $context);
             $json_2 = json_decode($result, true);

             if(isset($json_2) && $json_2['registry_country_code'] != 'AT'){
               
?>
              <div class="ibm-col-6-4">
                <p class="ibm-textcolor-gray-40 ibm-bold ibm-padding-top-30 ibm-padding-bottom-30">
              Please note that DISQUS operates this forum. By commenting, you are accepting the 
              <a class="nh-link-color-restore" href="/think/marketing/ibm-commenting-guidelines" target="_blank">IBM commenting guidelines</a> and the 
              <a class="nh-link-color-restore" href="https://help.disqus.com/customer/portal/articles/466260-terms-of-service" target="_blank">DISQUS terms of service</a>.
              </p>
            </div>
             <?php if(!is_user_logged_in()): ?>
              <div>
              <p class="ibm-regular ibm-padding-bottom-30"><a href='<?php echo $loginurl ?>' style="color:#fff;" class="ibm-btn-pri ibm-btn-blue-50">Sign in to comment</a></p>
              </div>
            <?php endif; ?> 
            <?php 
                comments_template(); 
              }
            ?>
          </div>
          <div class="ibm-col-6-2">
            <?php include('_includes/v18_sidebar.php'); ?> 
          </div>
        </div>  
      </div> 


    <?php endwhile; ?>
  <?php else : ?>

    <div class="ibm-columns">
      <div class="ibm-col-6-4">
        <h1 class="ibm-h1"><?php $my_theme = wp_get_theme(); _e('Oops, Post Not Found!', $my_theme->get( 'Name' )); ?></h1>
      </div>
      <div class="ibm-col-6-2"></div>
    </div>

  <?php endif; ?>


    <?php



        // ---------------------------------------------------------------------------
        // Query

        $params     = array(
            'paged'             => 1,
            'post_type'         => $post->post_type,
            'posts_per_page'    => 3, // get_field('number_of_posts'),
            'orderby'           => 'rand',
            'post__not_in'      => array($post->ID)
            );

        // get by category
        $categories = get_the_category();
        if (!empty( $categories)) {
            $category = $categories[0];
            $params['category_name'] = $category->slug;
        }

        $posts      = new WP_Query($params);
        $post_spot = 0;
        $grid_with_highlights = false;
    ?>

    
        <div class="nh-single-related-wrap ibm-blog__postgrid">
        <?php if ( $posts->have_posts() && get_topic_category( get_the_category() ) !== "Uncategorized") { ?>
            <div class="ibm-columns">
                <div class="ibm-col-1-1">
                        <!-- <h3 class="postgrid-title"><?php $my_theme = wp_get_theme(); _e('More', $my_theme->get( 'Name' )); ?> <?php echo get_topic_category( get_the_category() ); ?> <?php $my_theme = wp_get_theme(); _e('Stories', $my_theme->get( 'Name' )); ?></h3> -->
                        <h3 class="postgrid-title ibm-bold ibm-h3"><?php $my_theme = wp_get_theme(); _e('You may also like', $my_theme->get( 'Name' )); ?> </h3>                        
                </div>
            </div>

            <div class="ibm-columns" data-widget="setsameheight" data-items=".ibm-blog__postgrid-item-link" tabindex="-1">
                <?php
                while ( $posts->have_posts() ) : $posts->the_post(); ?>
                    <?php
                          if(esc_attr(get_option( 'post_listing_choice_homepage', '' )) == "post_listing_choice_homepage_stack")
                          {
                              include('_includes/post_listing_stack.php');
                          }
                          else
                          {
                              include('_includes/post_listing_grid.php');
                          }
                endwhile; ?>

            </div> <!-- .ibm-columns -->
        <?php } ?>               
        </div>  <!-- .ibm-blog__postgrid -->
    

    </div>

    <div class="ibm-common-overlay ibm-overlay-alt-three nh-card-large nh-card-wrap nh-card-wrap-height" data-widget="overlay" id="overlayExampleXl">
            <?php
                  $params_single_post = 'groups=-1&limit=1&orderby=random&order=DESC&container_class=nh-promo-card-holder';
                  echo dfads($params_single_post);   
             ?>
    </div>
    <script>
        function showOverlayAd(){
            IBMCore.common.widget.overlay.show('overlayExampleXl');
        }
        jQuery(document).ready(function($){
            // setTimeout(showOverlayAd, 5000);
        });
    </script>

    <?php get_template_part('_includes/v18_content_main_end'); ?>

<?php get_footer(); ?>
