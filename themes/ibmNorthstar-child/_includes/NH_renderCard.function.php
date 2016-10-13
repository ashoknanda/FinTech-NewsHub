<?php

/*-----------------------------------------------------
 *  renders a card based on the $post data
 */

include_once __DIR__.'/NH_renderArticleSource.function.php';
include_once __DIR__.'/NH_renderArticleCategories.function.php';
include_once __DIR__.'/NH_renderArticleTopMeta.function.php';
include_once __DIR__.'/NH_trim_text.function.php';
include_once __DIR__.'/NH_getCardBgColor.function.php';
include_once __DIR__.'/NH_renderAuthorDateLine.function.php';

function NH_renderCard($this_post, $context, $card_count, $twitter_hash_tag, $my_theme){ 
  //
  $custom_fields = get_post_custom($this_post->ID);
  $nc_author = array();
  $nc_author = $custom_fields['nc-author'] ? $custom_fields['nc-author'] : "";

  if(is_object($nc_author)){
    foreach ( $nc_author as $key => $value ) {
      $postauthor = $value;
    }
  }

  //-----------------------------------------------------
  //  basic meta
  $permalink = get_permalink($this_post);

  //-----------------------------------------------------
  //  context
  switch($context){

    case 'card-featured':{
      $featuredClass = 'nh-card-featured nh-card-large';
    }

    case 'card':
    default:
  }

  //-----------------------------------------------------
  //  let's see what kind of card this is
  $allTags = wp_get_post_tags($this_post->ID);
  $is_editor_pick = false;
  $is_regular_post = true;
  $is_video_post = false;
  $is_image_post = false;
  foreach ($allTags as $key => $value) {
    // print_r($value->name);
    if($value->name == 'editor_pick'){
      $is_editor_pick = true;
    }

    if($value->name == 'video_post'){
      $is_video_post = true;
      $is_regular_post = false;
    }else if($value->name == 'image_post'){
      $is_image_post = true;
      $is_regular_post = false;
    }

  }

  //-----------------------------------------------------
  //  set up images
  $pimages = get_field('card_image', $this_post->ID);

  $imgobjfromnc= wp_get_attachment_image_src( get_post_thumbnail_id($this_post->ID), 'large_size' );

  $background_attributes = '';

  if($imgobjfromnc && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")){
    $background_attributes = 'background-image: url(' . $imgobjfromnc[0] . ')';
  }else if($pimages && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")){
    $background_attributes = 'background-image: url(' . $pimages['sizes']['large'] . ')';
  }else{
    if((get_option('post_listing_image_visibility') == "post_listing_image_visibility_if_available") or (get_option('post_listing_image_visibility') == "post_listing_image_visibility_never")){

    }
  }

  //-----------------------------------------------------
  //  let's set up color here, so that it is global -> no two adjacent cards will have the same color
  $bgColor = NH_getCardBgColor();

  //-----------------------------------------------------
  //  email sharing
  $email_body = urlencode("\r\n")."You might enjoy reading this article from THINK Marketing: " . rawurlencode($this_post->post_title) . urlencode("\r\n\r\n") . $permalink;

?>
<div 
  class="ibm-col-6-2 post nh-card-wrap nh-card-wrap-height <?php echo $this_post->post_type; ?> <?php echo $featuredClass; ?>" 
  data-post-id="<?php echo $this_post->ID; ?>" 
  data-post-count="<?php echo $card_count; ?>"
>
  <div 
    tabindex="0"
    class="
      ibm-card nh-card 
      <?php if(strlen($this_post->post_title) > 76) echo('nh-card-hide-excerpt'); ?> 
      <?php if($is_editor_pick) { echo 'nh-editors-pick'; };?> 
      <?php if($background_attributes !=''){echo 'nh-background-loaded';}else{echo 'nh-no-background';} ?> 
      <?php echo add_content_type_class($this_post->ID); ?> 
      <?php if($is_video_post == true) echo('nh-video-card'); ?> 
      <?php if($is_image_post == true) echo('nh-image-card'); ?>
    " 
    style="
      <?php echo "background-color:$bgColor;";  ?>
      <?php if($background_attributes != '') echo $background_attributes; ?>
    "
  >
    <?php if($is_image_post): ?>
      <a class="ibm-blog__header-link" style="height:100%;" href= "<?php echo $permalink; ?>">
        <span class=""></span>
      </a>

    <?php else: ?>

    <div class="ibm-card__content">
      <div class="nh-card-content-wrap">

        <div class="nh-card-content">
          <?php if($is_video_post): ?>
            <div class="nh-video-container">
              <a href="<?php echo $permalink; ?>" class="ibm-video-placeholder">
                <span class="ibm-play-link"></span>
              </a>
            </div>          
           <?php endif; ?>         
          <div class="nh-card-top-meta">
            <?php echo NH_renderArticleTopMeta($this_post, $context); ?>
          </div>

          <h3 class="nh-title ibm-h3 ibm-bold ibm-textcolor-white" data-title-content="<?php echo(strlen($this_post->post_title)); ?>"><a class="ibm-blog__header-link nh-transition-triggerer" href= "<?php echo $permalink; ?>"><span class=""><?php echo trim_text($this_post->post_title, 107, true, true); ?></span></a></h3>

          <div class="nh-author ibm-textcolor-white ibm-small"><?php echo NH_renderAuthorDateLine($this_post); ?></div>

          <div class="nh-card-meta-data-rotator"><div class="nh-tags nh-card-meta-color-changer nh-card-meta-data">

            <div class="nh-excerpt ibm-small ibm-light ibm-textcolor-gray-60 "><a class="ibm-blog__header-link nh-transition-triggerer" href= "<?php echo $permalink; ?>"><?php  the_excerpt(); ?></a></div>

            
            <div class="nh-card-categories"><?php echo NH_renderArticleCategories($this_post, $context); ?></div>

            <div class="nh-card-socialrow" style="display:block;height:30px;">
              <div class="ibm-icononly ibm-alternate" style="display:inline-block;">

                <a href="https://twitter.com/intent/tweet?original_referer=<?php echo $permalink;; ?>&amp;text=<?php echo rawurlencode($this_post->post_title); ?>&amp;tw_p=tweetbutton&amp;url=<?php echo $permalink;; ?><?php echo isset($twitter_hash_tag) ? '&amp;hashtags='.$twitter_hash_tag : ''; ?>" target="_blank" class="nh-card-social-icon ibm-twitter-link ibm-small"><?php _e('Twitter', $my_theme->get( 'Name' )); ?></a>
                
                <a href="http://www.facebook.com/sharer.php?u=<?php echo $permalink;;?>&amp;t=<?php echo rawurlencode($this_post->post_title); ?>" target="_blank" class="nh-card-social-icon ibm-facebook-link ibm-small"><?php _e('Facebook', $my_theme->get( 'Name' )); ?></a>
                
                <a class="nh-card-social-icon ibm-linkedin-link ibm-small" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $permalink;; ?>&amp;title=<?php echo rawurlencode($this_post->post_title); ?>&amp;source=<?php bloginfo( 'name' ); ?>" target="_blank"><?php _e('LinkedIn', $my_theme->get( 'Name' )); ?></a>


                <!--
                <a class="nh-card-social-icon nh-social-icon-snapchat">
                  <svg class="nh-icon-snapchat width="19px" height="19px" viewBox="95 0 19 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <desc>Created with Sketch.</desc>
                      <defs></defs>
                      <path d="M109.727394,3.42937698 C109.438189,2.76523865 109.025959,2.16721974 108.502621,1.65198733 C107.97903,1.13680481 107.371714,0.731355573 106.697207,0.44696724 C105.994758,0.150702363 105.252754,0.000199605779 104.491886,0 L104.491075,0 C103.730004,0.000199605779 102.988558,0.150702363 102.287326,0.447366451 C101.614441,0.73195439 101.008648,1.13800245 100.487085,1.65378378 C99.9663332,2.1691659 99.5564867,2.76718481 99.2688538,3.43172235 C98.9699124,4.12250805 98.8177793,4.85271589 98.8168158,5.60203598 C98.8164101,5.97005913 98.8086513,6.32695427 98.793793,6.66887896 L98.4964742,6.60026448 C98.387547,6.57511415 98.2754249,6.56243918 98.1633028,6.56223958 C97.8398172,6.56223958 97.5208956,6.66982709 97.2649571,6.86514135 C96.9979128,7.06903865 96.8107385,7.35931535 96.7378667,7.68267671 C96.5643336,8.45205719 96.9959351,9.22862347 97.7441255,9.50193368 L98.6341547,9.85533571 C98.0448419,11.6352204 96.9581047,11.9763467 96.2265982,12.2061429 C96.0322229,12.2671723 95.8646736,12.3198184 95.7049846,12.3977644 C95.0687134,12.7085007 95,13.2350109 95,13.4468924 C95,13.8527408 95.195136,14.2230595 95.5497075,14.4897328 C95.7261818,14.6224706 95.9448985,14.7320542 96.2182309,14.8246214 C96.5906526,14.9507223 97.0225077,15.030864 97.3733265,15.0949874 C97.3903654,15.2230345 97.4151124,15.3604631 97.4571011,15.4990893 C97.6310399,16.0743033 97.9982892,16.3317947 98.2756277,16.4466179 C98.5388687,16.5556027 98.8108319,16.5682777 98.9924788,16.5682777 C99.1701702,16.5682777 99.3580038,16.5544051 99.5568417,16.5399835 C99.770183,16.5244143 99.9908774,16.5083959 100.20858,16.5083959 C100.545909,16.5083959 100.796878,16.5479678 100.976193,16.6294568 C101.222192,16.7413359 101.4831,16.8920382 101.759424,17.0516729 C102.528406,17.4962948 103.400179,18 104.5,18 C105.59977,18 106.471391,17.4962948 107.240576,17.0516729 C107.5169,16.8920382 107.777808,16.7413359 108.023807,16.6294568 C108.203071,16.5479678 108.454091,16.5083959 108.79142,16.5083959 C109.009123,16.5083959 109.229766,16.5244143 109.442955,16.5399835 C109.641793,16.5544051 109.82983,16.5682777 110.007471,16.5682777 C110.189117,16.5682777 110.461131,16.5556027 110.724169,16.4466179 C111.001711,16.3317947 111.36896,16.0743033 111.542899,15.4990893 C111.584685,15.3604631 111.609635,15.2230345 111.626673,15.0949874 C111.977492,15.030864 112.409347,14.9507223 112.781718,14.8246214 C113.055102,14.7320542 113.273615,14.6224706 113.450293,14.4897328 C113.804661,14.2230595 114,13.8527408 114,13.4468924 C114,13.2350109 113.931236,12.7085007 113.295015,12.3977644 C113.135326,12.3198184 112.967524,12.2671723 112.773402,12.2061429 C112.041692,11.9765463 110.954955,11.63542 110.365642,9.85533571 L111.255672,9.50193368 C112.003862,9.22882307 112.435666,8.45205719 112.262133,7.68267671 C112.189262,7.35931535 112.001884,7.06903865 111.735043,6.86514135 C111.479104,6.66982709 111.15998,6.56223958 110.836697,6.56223958 C110.724778,6.56223958 110.612453,6.57511415 110.503526,6.60026448 L110.206156,6.66887896 C110.191298,6.32695427 110.183387,5.97005913 110.182981,5.60203598" id="Page-1" stroke="none" fill="#FFFFFF" fill-rule="evenodd"></path>
                  </svg>
                </a>
                -->

                <a class="nh-card-social-icon nh-social-icon-email ibm-small" href="mailto:?subject=THINK Marketing: <?php echo rawurlencode($this_post->post_title); ?>&body=<?php echo $email_body; ?>" style=" padding-left: 0;top: 5px;">
                  
                    <svg width="26px" height="17px" viewBox="128 0 26 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
                        <desc>Mail</desc>
                        <defs></defs>
                        <g id="mailIcon" stroke="none" stroke-width="1" fill="white" fill-rule="evenodd" transform="translate(128.000000, 1.000000)" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M24.7618222,15.3326118 L1.02478519,15.3326118 C0.688711111,15.3326118 0.417155556,15.0662588 0.417155556,14.7387294 L0.417155556,1.00131765 C0.417155556,0.673788235 0.688711111,0.407435294 1.02478519,0.407435294 L24.7618222,0.407435294 C25.0978963,0.407435294 25.3694519,0.673788235 25.3694519,1.00131765 L25.3694519,14.7387294 C25.3694519,15.0662588 25.0978963,15.3326118 24.7618222,15.3326118 L24.7618222,15.3326118 Z" id="Stroke-1" stroke="#606060" stroke-width="0.8227"></path>
                            <path d="M0.544651852,0.636517647 L11.901837,10.4878118 C12.4670963,10.9791059 13.3193185,10.9791059 13.8855407,10.4878118 L25.239837,0.636517647" id="Stroke-3" stroke="#000000" stroke-width="0.8227"></path>
                            <path d="M0.544651852,15.0992941 L8.37931852,7.44188235" id="Stroke-5" stroke="#000000" stroke-width="0.8227"></path>
                            <path d="M25.2393556,15.0963765 L17.3883185,7.42296471" id="Stroke-7" stroke="#000000" stroke-width="0.8227"></path>
                        </g>
                    </svg>
                </a>

              </div>
            </div>
                
          </div></div class="nh-card-meta-data-rotator">

        </div class="nh-card-content">
      </div class="nh-card-content-wrap">

    </div class="ibm-card__content">

    


      
    <?php endif; ?> <!-- End if video type or image type or regular type -->
      <a class="nh-card-hover-chevron ibm-chevron-right-light-link ibm-blog__header-link nh-transition-triggerer" href= "<?php echo $permalink; ?>"></a>
    </div class="nh-card">
    <script>
      window.newshub.functions.renderCard(<?php echo $this_post->ID; ?>);
    </script>
  </div>

<?php } ?>