<?php
  include_once __DIR__.'/NH_renderArticleCategories.function.php';
  include_once __DIR__.'/NH_renderArticleSource.function.php';
  include_once __DIR__.'/NH_renderArticleTopMeta.function.php';
  include_once __DIR__.'/NH_renderAuthorDateLine.function.php';

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

  $custom_fields = get_post_custom($post->ID);
  $nc_source = array();
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
      <?php echo NH_renderAuthorDateLine($post); ?>
    </div>
    <div class="nh-tags nh-card-meta-color-changer nh-card-meta-data">
      <div class="nh-card-categories search-card-content">
         <?php echo NH_renderArticleCategories($post, "search-results"); ?>
      </div>
    </div>
  </div>
</div>