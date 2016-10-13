<?php
$pimages = get_field('card_image');
$pcategories = get_the_category();

$categories = array();
foreach($pcategories as $pcategory)
{
  if($pcategory->name !== 'Featured Carousel' && $pcategory->name !== 'Uncategorized') {
    array_push($categories, $pcategory);
  }
}

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
  if(isset($nc_source)){
    foreach ( $nc_source as $key => $value ) {
      $postsource = $value;
    }
  }

  //Identify it is editors_pick.
  $allTags = wp_get_post_tags($post->ID);
  $is_editor_pick = false;
  foreach ($allTags as $key => $value) {
    // print_r($value->name);
    if($value->name == 'editor_pick'){
      $is_editor_pick = true;
    }
  }

?>

<div class="ibm-col-6-4 post <?php echo $post->post_type; ?>" data-post-id="<?php the_ID(); ?>" style="display:flex;">
<div class="ibm-card nh-card <?php if($is_editor_pick) { echo 'nh-editors-pick'; } ?>" style="margin-bottom:0;border-top:0;border-right:0; border-left:0;border-bottom: 0;">
<?php
if(get_field('card_image') && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never"))
{
?>
  <div class="ibm-col-6-1 ibm-card__image" style="margin:0;text-align:center;">
    <a href="<?php the_permalink() ?>">
      <div class="custom_post_list_image" style="width:100%;height:100%;background-position:center center; background-size:100%;background-repeat:no-repeat;background-image:url(<?php echo $pimages['sizes']['large']; ?>);"></div>
      <!--img class="ibm-downsize ibm-padding-top-1" src="<?php //echo $pimages['sizes']['large']; ?>" alt="" / -->
    </a>
  </div>
  <div class="ibm-col-6-3" style="margin:0;">

<?php
}
else
{
  ?>
    <div class="ibm-col-6-1 ibm-card__image" style="margin:0;text-align:center;">
      <a href="<?php the_permalink() ?>">
        <div class="custom_post_list_image" style="width:100%;height:100%;background-position:center center; background-size:100%;background-repeat:no-repeat;background-image:url(<?php echo get_template_directory_uri(); ?>/assets/img/default-card-380x190.jpg);"></div>      
        <!--img class="ibm-downsize ibm-padding-top-1" src="<?php //echo get_template_directory_uri(); ?>/assets/img/default-card-380x190.jpg" alt="" / -->
      </a>
    </div>
    <div class="ibm-col-6-3" style="margin:0;">
    <?php
}
?>
  <div class="ibm-card__content">
     <div class="nh-date ibm-textcolor-gray-60 nh-card-meta-color-changer nh-card-meta-data">
          <?php echo get_the_time(get_option('date_format'), $post->ID); ?> <span class="nh-dot-separator">•</span> <?php echo do_shortcode("[est_time]").' read'; ?>
     </div>     

     <h3 class="nh-title ibm-h3 ibm-bold"><a class="ibm-blog__header-link" href= "<?php the_permalink() ?>"><span class="ibm-textcolor-default"><?php the_title(); ?></span></a></h3>
     <div class="nh-author ibm-textcolor-gray-60 ibm-padding-bottom-1 nh-card-meta-data">
                By <?php echo $postauthor ; if(isset($postsource)) { echo ' - '.$postsource; }?>
     </div>
     <div class="nh-tags nh-card-meta-color-changer nh-card-meta-data">
              <?php  if(!empty($categories)): ?>
                <?php $catcountvalue = 0; foreach($categories as $key => $value) { ?>
                  <?php if($value->name != '' && $value->name != 'uncategorized') { ?>
                      <?php if($catcountvalue > 0) { ?>
                        <span>,</span>
                      <?php } ?>          
                      <a style="display:inline-block;" class="nh-tag ibm-textcolor-gray-60" href="<?php echo get_category_link($value->cat_ID); ?>"><?php echo($value->name); ?></a>
                      <?php 
                          $catcountvalue +=1; 
                          if($catcountvalue >= 3){
                            break;
                          }
                        } ?>
                <?php } ?>
              <?php endif; ?>
      </div>
     </div> <!-- End ibm-card__content -->
     <!-- <div class="nh-editors-pick-dogear-outer">
      <div class="nh-editors-pick-dogear-outer-inner">
        <div class="nh-editors-pick-dogear">
          <div class="ibm-star-full-link"></div>
        </div>
      </div></div> -->
    </div>
  </div>
      <!--<script>
      //(function(){
        /*-----------------------------------------------------
         *  let's start editor's pick animation
         */
         //console.log('start animation');
        //  var 
        // $el = jQuery('[data-post-id=<?php //echo(the_ID()); ?>]'),
        //   delay = parseInt($el.attr('data-post-count')) * 100 + 500;
        // ;
        // setTimeout(function(){
        //   $el.find('.nh-card').addClass('start-animation');
        // }, delay);
      // })();
    </script>-->
</div>
<div><h2 /></h2>
</div>


