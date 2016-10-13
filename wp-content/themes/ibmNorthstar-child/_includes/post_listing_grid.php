<?php

/*-----------------------------------------------------
 *  single card
 */

// include_once __DIR__.'/NH_renderArticleSource.function.php';
// include_once __DIR__.'/NH_renderArticleCategories.function.php';
// include_once __DIR__.'/NH_renderArticleTopMeta.function.php';
// include_once __DIR__.'/NH_trim_text.function.php';
// include_once __DIR__.'/NH_renderCard.function.php';
 
// card rendering functions
// include 'renderCardWrap.function.php';


// $postsource = 'THINK Marketing';
// $postauthor = null;
// $authID = $post->post_author;
// $userdata = get_userdata($authID);
// $postauthor =  $userdata->user_nicename; //Setting author to post author set in WP if Newscred nc-author does not exist.
// $custom_fields = get_post_custom($post->ID);
// $nc_source = array();
// $nc_author = array();
// $nc_author = $custom_fields['nc-author']?$custom_fields['nc-author']:"";
// $nc_source = $custom_fields['nc-source']?$custom_fields['nc-source']:"";

// if(is_object($nc_author)){
//   foreach ( $nc_author as $key => $value ) {
//     $postauthor = $value;
//   }
// }

// $postsource = 'THINK Marketing';
// $nc_source_abbrev = 'T';

// if(isset($nc_source)){

//   foreach ( $nc_source as $key => $value ) {
//     $postsource = $value;

//     if(strcasecmp ( $value , "ibm commerce" ) == 0){
//       $postsource = 'THINK Marketing';
//     }
//     // $nc_source_abbrev = abbreviate($postsource, 3);
//     $cleaned_nc_source = str_replace('the', "", $postsource);
//     $nc_source_abbrev = $cleaned_nc_source[0];
//   }

// }else{

//   $postsource = 'THINK Marketing';
//   $nc_source_abbrev = 'T';

// }

//-----------------------------------------------------
//  Editor's pick
// $allTags = wp_get_post_tags($post->ID);
// $is_editor_pick = false;
// $is_regular_post = true;
// $is_video_post = false;
// $is_image_post = false;
// foreach ($allTags as $key => $value) {
//   // print_r($value->name);
//   if($value->name == 'editor_pick'){
//     $is_editor_pick = true;
//   }

//   if($value->name == 'video_post'){
//     $is_video_post = true;
//     $is_regular_post = false;
//   }else if($value->name == 'image_post'){
//     $is_image_post = true;
//     $is_regular_post = false;
//   }

// }

//-----------------------------------------------------
//  set up images
// $pimages = get_field('card_image');

// $imgobjfromnc= wp_get_attachment_image_src( get_post_thumbnail_id(), 'large_size' );

// $background_attributes = '';

// if($imgobjfromnc && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")){
//   $background_attributes = 'background-image: url(' . $imgobjfromnc[0] . ')';
// }else if($pimages && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")){
//   $background_attributes = 'background-image: url(' . $pimages['sizes']['large'] . ')';
// }else{
//   if((get_option('post_listing_image_visibility') == "post_listing_image_visibility_if_available") or (get_option('post_listing_image_visibility') == "post_listing_image_visibility_never")){

//   }
// }

//-----------------------------------------------------
//  set up background color
$bgColor = '#e0e0e0';
if($background_attributes == ''){
  $bgColors = array('#00B4A0', '#4178BE', '#5AA700', '#FF5003', '#00B4A0', '#E59200');
  if(isset($bgColorCount) != true) $bgColorCount = -1;
  $bgColorCount = $bgColorCount + 1;
  if($bgColorCount >= count($bgColors)) $bgColorCount = 0;
  $bgColor = $bgColors[$bgColorCount];
}

//-----------------------------------------------------
//  By ${author} ${date}

// $byAndDate = '';
// if($postauthor != ''){
//   $byAndDate = "By ".$postauthor.', ';
// }
// $byAndDate = $byAndDate.get_the_time(get_option('date_format'), $post->ID);

if(isset($card_count) !== true) $card_count = 0;  $card_count = $card_count +1;

/*
renderCardWrap(
  $post, 
  the_ID(), 
  $card_count, 
  $is_editor_pick, 
  $background_attributes, 
  $nc_source_abbrev, 
  $nc_source, 
  get_the_permalink(), 
  get_the_title(), 
  $byAndDate, 
  get_the_excerpt(), 
  $categories
); 
*/
$email_body = urlencode("\r\n")."You might enjoy reading this article from THINK Marketing: " . rawurlencode($post->post_title) . urlencode("\r\n\r\n") . get_permalink();
  ?>

  <?php NH_renderCard($post, 'card', $post_count, $twitter_hash_tag, wp_get_theme()); ?>

  <?php

  /*-----------------------------------------------------
   *  right rail
   */

  ?>

    <?php if (is_home() && isset($post_count) && $post_count == 2): ?>

<!--    <div class="ibm-col-6-2 post post nh-card-wrap nh-custom_post_list" data-post-id="subscribewidget"> -->
<!--     <div class="ibm-card"> -->

      <!-- Popular Widget & Editors Picks & Twitter widget only to show on Home page.  -->
      <?php if(is_home()): ?>
<!--           <div class="ibm-card__content ibm-link-list nh-custom_post_list nh-twitter-widget-container"> -->
<!--             <div class="rotatingtweets-title"> -->
<!--               <a href="https://twitter.com/IBMforMarketing" target="_blank"><span class="ibm-bold ibm-h4">@IBMforMarketing</span></a> -->
              <img src="<?php //echo get_stylesheet_directory_uri(); ?>/assets/img/Twitter_Social_Icon_Square_Color.png" />

<!--             </div> -->
<!--             <div id="rotatingtweets_widget-2"> -->
              <?php //echo do_shortcode("[rotatingtweets screen_name='IBMforMarketing' timeout='5000' speed='250' rotation_type='scrollHorz' links_in_new_window='1' show_meta_prev_next='1' show_meta_timestamp='0' show_meta_screen_name='0' show_meta_via='0' show_meta_reply_retweet_favorite ='0' prev='<span class=\"ibm-chevron-left-light-link\"></span>' next='<span class=\"ibm-chevron-right-light-link\"></span>' middot='&nbsp;' np_pos='bottom']"); ?>
<!--             </div> -->
<!--           </div> -->
      <?php 

        $editors_args = array(
            // 'category__and' => 'category'
            'tag_slug__and' => array('editor-pick'),
            'showposts' => 5,
            'orderby' => 'date'
        );

         $postslist = get_posts( $editors_args );

         if(!empty($postslist)) { ?>
<!--             <div class="nh-right-rail-lists nh-editors-picks ibm-card__content ibm-link-list nh-custom_post_list"> -->
<!--               <h4 class="nh-right-rail-list-title ibm-icon-nolink ibm-recommended-link"> -->
                <span class="ibm-textcolor-default ibm-bold ibm-h4" ><?php //$my_theme = wp_get_theme(); _e("Editor's picks", $my_theme->get( 'Name' )); ?></span>
<!--               </h4> -->
<!--               <ul class="tagged-list"> -->
                <?php foreach ($postslist as $post) :  setup_postdata($post);  $pimg1 = get_field('card_image');?>
                  <?php
//                     $custom_fields = get_post_custom($post->ID);
//                     // $bckImg = $pimg1['sizes']['large'];
//                     $insidePostURL = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large_size' );
//                     if(!empty($insidePostURL)){
//                       $bckImg = $insidePostURL[0];
//                     }else{

//                       $bgColor = NH_getCardBgColor();
//                     }
//                   ?>
<!--                     <li> -->
<!--                       <div class="custom_post_list_image" style="background-color:<?php //echo($bgColor); ?>; background-image:url(<?php //echo $bckImg; ?>);">
<!--                       </div> -->
<!--                       <div class="custom_post_list_content"> -->
<!--                         <a href="<?php //the_permalink() ?>" class="ibm-textcolor-gray-80 ibm-bold custom_post_label">
                          <div class="nh-right-rail-list-ellipsis"><?php //echo trim_text($post->post_title, 60, true, false); ?></div>
                          
<!--                         </a> -->
 <!--                        <div class="meta ibm-small ibm-textcolor-gray-50 "><?php //echo NH_renderArticleSource($post, 'right-rail'); ?></div>
<!--                       </div> -->
<!--                     </li> -->
                <?php endforeach; ?>
<!--               </ul> -->
<!--             </div> -->
        <?php }
//           wp_reset_query();
//         ?>

<!--         <div class="nh-right-rail-lists nh-trending-list ibm-card__content ibm-link-list nh-custom_post_list"> -->
          <h4 class="nh-right-rail-list-title ibm-bold ibm-h4" style="padding-left:0 !important;">
<!--             <div class="nh-icon-wrap"> -->
<!--               <svg width="14px" height="26px" viewBox="367 301 14 26" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> -->
                  <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
<!--                   <desc>Created with Sketch.</desc> -->
<!--                   <defs></defs> -->
<!--                   <g id="lightening" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(367.000000, 301.000000)"> -->
<!--                       <polygon id="Rectangle-2" fill="#000000" points="6.125 10.3819773 14 10.3819773 3.5 25.9549432"></polygon> -->
<!--                       <polygon id="Rectangle-2-Copy" fill="#000000" points="0 15.5729659 10.5 0 7.875 15.5729659"></polygon> -->
<!--                   </g> -->
<!--               </svg> -->
<!--             </div> -->
<!--             <div class="label ibm-h4"> -->
<!--               Trending -->
<!--             </div> -->
<!--           </h4> -->
          <?php //echo do_shortcode('[do_widget id=wmp_widget-2]') ?>
<!--         </div> -->

      <?php endif ?>
<!--     </div> -->

    <script> 
      (function($){

        /*-----------------------------------------------------
         *  let's start staggered animation
         */
         var
          $el = $('[data-post-id=subscribewidget]'),
          $cardEl = $el.find('.nh-card');

          delay = parseInt($el.attr('data-post-count')) * 100 + 300;
        ;
        setTimeout(function(){
          $el.find('.nh-card')
            .addClass('start-animation')
          ;
        }, delay);

       })(jQuery);
    </script>    
<!--   </div> -->

  <?php endif ?>
  <?php if (!is_search() && isset($post_count) && (($post_count % 10) == 0) || $post_count == 2): ?>
        <!-- Ad management block -->

        <?php
          // $colors1 = array('#17b4a0', '#008571', '#006d5d');
          // $colors2 = array('#db2780', '#a6266e', '#7c1c58');
          // $colors3 = array('#8c7300', '#735f00', '#574a00');
          // $selectedColor = "";
          // if($m3 == 0){
          //   $selectedColor = $colors1[array_rand($colors1,1)];
          //   $m3++;
          // }else if ($m3 == 1){
          //   $selectedColor = $colors2[array_rand($colors2,1)];
          //   $m3++;
          // }else{
          //   $selectedColor = $colors3[array_rand($colors3,1)];
          //   $m3 = 0;
          // }
        ?>
         <!-- <div class="ibm-col-6-4 nh-card-large nh-card-wrap nh-card-wrap-height post <?php echo $post->post_type; ?>" data-post-id="nh_collection_widget-<?php echo $paged.$post_count; ?>">
          <div class="ibm-card nh-card">
            <?php
//                   // $ads_group_ids = '';
//                   $collection_group_id = '';
//                   if(!is_search() && isset($post_count)){
//                       if($post_count == 2){
//                        $collection_group_id = NH_MARKETING;
//                       } elseif($post_count == 8) {
//                         $collection_group_id = NH_DATA_ANALYTICS;
//                       } else {
//                         $collection_group_id = NH_CAMPAIGN;
//                       }
//                   }
//                   if(isset($collection_group_id)){
//                     echo nh_render_ad($collection_group_id);  
//                   }
             ?>
        </div> -->
    <script>
      (function($){

        //-----------------------------------------------------
        //  so that we can get url param to show different behaviors
        function getURLParameter(name) {
          return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [ , "" ])[1] .replace(/\+/g, '%20')) || null;
        };

        /*-----------------------------------------------------
         *  let's start staggered animation
         */
         var
          $el = $('[data-post-id=nh_collection_widget-<?php echo $paged.$post_count; ?>]'),
          $cardEl = $el.find('.nh-card');
          // $cardEl.css({
          //   'transform':'translateY(0px) scale(1.2,1.2) perspective( 2000px ) rotateY('+(Math.random() * 40 + 50)+'deg)'
          // })
          delay = parseInt($el.attr('data-post-count')) * 100 + 300;
        ;
        setTimeout(function(){
          $el.find('.nh-card')
            .addClass('start-animation')
          ;
        }, delay);

        // card click interception is activated only on mouse hover, so that search engine crawlers can follow through the link
        $el.bind('mouseenter', function(e){
          // console.log('mouseenter...');

          var clickThroughTestCase = getURLParameter('transition_option_case');

          clickThroughTestCase = '1';

          if(clickThroughTestCase != null) $el.find('a').click(function(evt) {

                var targetTrue = $el.find('a').attr('target');

                if (targetTrue == '_blank'){
                  return;
                  // var adRedirectWindow;
                  // adRedirectWindow = window.open(
                  //   $el.find('a').attr('href'),
                  //   "showcollection"
                  // );
                } else {

            evt.preventDefault();

            $cardEl.addClass('opened').addClass('bring-to-front');

            var $contentOverlay = $('<div class="nh-content-overlay"></div>');
            $('#ibm-content-body').append($contentOverlay);
            setTimeout(function(){
              $contentOverlay.addClass('show-up');
            },20);

            // var articleData = window.newshub.data.articles[$el.attr('data-post-id')];

            setTimeout(function(){

              if(clickThroughTestCase === '1'){
                  window.location.href = $el.find('a').attr('href');
              }else{
                //-----------------------------------------------------
                //  open an overlay
                // $('#story-space-2').append('<div class="nh-content-overlay"><h2 class="title">'+unescape(articleData.title)+'</h2><div class="content-wrap">'+unescape(articleData.content)+'</div><div class="close-button">close</div></div>');

                // $('#story-space-2').find('.nh-content-overlay > .close-button').click(function(e){
                //   $cardEl.removeClass('opened');
                //   $('#story-space-2').find('.nh-content-overlay > .close-button').unbind('click');
                //   $('#story-space-2').find('.nh-content-overlay').fadeOut(500, function(){
                //     $cardEl.removeClass('bring-to-front');
                //     $('#story-space-2').find('.nh-content-overlay').remove();
                //   });
                // });

                // $('#story-space-2').find('.nh-content-overlay').fadeIn(200);
              }
            }, 200);                  
                }
          });
        });

       })(jQuery);
    </script>           
         </div>
  <?php endif ?>