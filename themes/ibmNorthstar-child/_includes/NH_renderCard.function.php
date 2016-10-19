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
     <?php echo NH_renderArticleCategoriesTitle($this_post, $context); ?> 
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