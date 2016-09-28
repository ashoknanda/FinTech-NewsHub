<?php
  include_once __DIR__.'/NH_renderArticleCategories.function.php';
  include_once __DIR__.'/NH_renderArticleSource.function.php';
  include_once __DIR__.'/NH_renderArticleTopMeta.function.php';

  $pimages = get_field('card_image');
  $pcategories = get_the_category();
  $nc_source_abbrev = abbreviate('IBM Affiliated Source', 3);

  $categories = array();
  foreach($pcategories as $pcategory)
  {
    if($pcategory->name !== 'Featured Carousel' && $pcategory->name !== 'Uncategorized' && !in_array($pcategory->name, $catNotIn)) {
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


$pimages = get_field('card_image');

$imgobjfromnc= wp_get_attachment_image_src( get_post_thumbnail_id(), 'large_size' );

$background_image = '';

if($imgobjfromnc && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")){
  $background_image = $imgobjfromnc[0];
}else if($pimages && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")){
  $background_image = $pimages['sizes']['large'];
}else{
  if((get_option('post_listing_image_visibility') == "post_listing_image_visibility_if_available") or (get_option('post_listing_image_visibility') == "post_listing_image_visibility_never")){
    $ts = get_template_directory_uri();
    $background_image =  $ts. '/assets/img/default-card-380x190.jpg' ;
  }
}

// print_r($background_image);
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
<div class="nh-search-result-item post <?php echo $post->post_type; ?>" data-post-id="<?php the_ID(); ?>" style="display:flex;">
  
  <div class="nh-image-wrap"><a href="<?php the_permalink() ?>">
        <!-- <div class="custom_post_list_image" style="background-image:url(<?php echo $pimages['sizes']['large']; ?>);min-height:<?php echo $pimages['sizes']['large-height']; ?>px;min-width:<?php echo $pimages['sizes']['large-width']-100; ?>px;"></div> -->
      <?php //var_dump($pimages); ?>
      <img class="ibm-downsize ibm-padding-top-1" src="<?php echo $background_image; ?>" alt="" />
    </a>
  </div>

  <div class="nh-content-wrap ibm-card__content search-card-content">
    <div class="nh-card-content-wrap">
      <div class="nh-card-content search-card-content">
        <?php echo NH_renderArticleTopMeta($post, "search-result"); ?>
      </div>
    </div>
    <div class="nh-content ibm-bold ibm-h4">
      <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </div>
    <div class="nh-card-author">
      <span> <?php if(isset($postauthor) && $postauthor != ""){ echo 'By '.$postauthor.", " ;} ?></span>    
      <!-- <span>By <?php //echo $postauthor ; ?></span> -->
      <span><?php  echo get_the_time('d M Y', $post->ID); ?></span>
      <!--<span><?php echo do_shortcode("[est_time]").' read'; ?></span>-->
    </div>
    <div class="nh-tags nh-card-meta-color-changer nh-card-meta-data">
      <div class="nh-card-categories search-card-content">
        <div class="icon-wrap">
          <svg width="30px" height="24px" viewBox="50 276 30 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
              <desc>Created with Sketch.</desc>
              <defs></defs>
              <g id="tagIcon" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(51.000000, 277.000000)" stroke-linecap="round" stroke-linejoin="round">
                  <polygon id="Stroke-1" stroke="#000000" stroke-width="1.5" points="22.2101939 12.1441692 12.3168606 21.8960923 0.367648485 10.1184769 0.367648485 3.61747692 3.66486061 0.366553846 10.2609818 0.366553846"></polygon>
                  <polyline id="Stroke-3" stroke="#000000" stroke-width="1.5" points="10.260897 0.366384615 15.3297455 0.366384615 27.2789576 12.144 17.3856242 21.8959231 14.8512 19.3972308"></polyline>
                  <path d="M6.94637576,4.71603846 C6.34819394,4.12626923 5.37837576,4.12626923 4.78019394,4.71603846 C4.18201212,5.30580769 4.18201212,6.26111538 4.78019394,6.85173077 C5.37837576,7.44065385 6.34819394,7.44065385 6.94637576,6.85173077 C7.54455758,6.26111538 7.54455758,5.30580769 6.94637576,4.71603846 L6.94637576,4.71603846 Z" id="Stroke-5" stroke="#000000" stroke-width="1.5"></path>
              </g>
          </svg>
        </div>
        <div class="content-wrap">
          <?php foreach ($categories as $key => $value): ?>
            <a class="nh-tag ibm-textcolor-gray-60 ibm-small" href="<?php echo get_category_link($value->cat_ID); ?>"><?php echo($value->name); ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>