<?php
/*
Template Name: IBM Commenting Guidelines page Temlate
*/

get_header();
?>
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
          if(is_object($nc_author)){
            foreach ( $nc_author as $key => $value ) {
              $postauthor = $value;
            }    
          }
$postsource = 'THINK Marketing';
$nc_source_abbrev = 'T';

if(is_object($nc_source)){

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
        <div class="ibm-col-6-1"></div>
          <div class="ibm-col-6-4 ibm-padding-top-1">
            <div class="nh-card-article-title">
              <h2 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight'); ?> ibm-bold" itemprop="headline" rel="bookmark">
                  <?php echo widont(get_the_title()); ?></h2>
            </div>
           
            
          </div>
          <div class="ibm-col-6-1"></div>
        </div>
        <div class="ibm-columns">
          <div class="ibm-col-6-1"></div>
          <div class="ibm-col-6-4 nh-card-article-body">
            <?php if(isset($sImg)): ?> 
              <img alt="post_thumb" src="<?php echo $sImg; ?>" class="ibm-resize" /> 
            <?php endif; ?>
            <?php the_content(); ?>
          </div>
          <div class="ibm-col-6-1">
          </div>
        </div>  
      </div> 


    <?php endwhile; ?>
  <?php else : ?>

    <div class="ibm-columns">
    <div class="ibm-col-6-1"></div>
      <div class="ibm-col-6-4">
        <h1 class="ibm-h1"><?php $my_theme = wp_get_theme(); _e('Oops, Post Not Found!', $my_theme->get( 'Name' )); ?></h1>
      </div>
      <div class="ibm-col-6-1"></div>
    </div>

  <?php endif; ?>



    

 

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
