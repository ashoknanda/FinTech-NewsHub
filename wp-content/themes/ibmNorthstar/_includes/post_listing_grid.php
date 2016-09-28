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
?>

  <?php if($post_count == 4): ?>
    <div class="ibm-col-6-2 post post" data-post-id-"subscribewidget">
      <div class="ibm-card">
        <div class="nh-wpsp-widget-container" style="padding:10px;">
        <?php echo do_shortcode('[do_widget id=wpsp_widget-2 category=Industry,Cloud formtype=3]') ?>
        </div>
      </div>
    </div>
  <?php endif ?>


  <?php if($post_count == 2): ?>
  <div class="ibm-col-6-4 post <?php echo $post->post_type; ?>" data-post-id-"<?php the_ID(); ?>">
    <?php else: ?>
 <div class="ibm-col-6-2 post <?php echo $post->post_type; ?>" data-post-id-"<?php the_ID(); ?>">
    <?php endif ?>
    <div class="ibm-card">
    <?php if(!empty($categories) && $categories[0]->name != ''): ?>
    <div class="ibm-card__heading"><p><a href="<?php echo get_category_link($categories[0]->cat_ID); ?>"><?php echo $categories[0]->name; ?></a></p></div>
    <?php endif; ?>
	<?php
  if(get_field('card_image') && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never"))
  {
  ?>
    <div class="ibm-card__image"><a href="<?php the_permalink() ?>"><img class="ibm-resize" src="<?php echo $pimages['sizes']['large']; ?>" alt="" /></a></div>
  <?php
  }
  else
  {
    if((get_option('post_listing_image_visibility') == "post_listing_image_visibility_if_available") or (get_option('post_listing_image_visibility') == "post_listing_image_visibility_never"))
    {

    }
    //default choice when the blog is new - post_listing_image_visibility_if_available
    else if(get_option('post_listing_image_visibility') == "")
    {

    }
    else
    {
      ?>
        <div class="ibm-card__image"><a href="<?php the_permalink() ?>"><img class="ibm-resize" src="<?php echo get_template_directory_uri(); ?>/assets/img/default-card-380x190.jpg" alt="" /></a></div>
      <?php
    }
  }
  ?>
    <div class="ibm-card__content">
    <h3 class="ibm-h3"><a class="ibm-blog__header-link" href= "<?php the_permalink() ?>"><span class="ibm-textcolor-default"><?php the_title(); ?></span></a></h3>
    <p><?php the_excerpt(); ?></p>
    </div>
    <div class="ibm-card__bottom ibm-padding-bottom-0 ibm-padding-top-0"  onmouseleave="socialCardHide(<?php the_ID(); ?>)">
    <p style="max-width: calc(100% - 36px);"><a class="ibm-forward-link ibm-inlinelink ibm-fleft" href="<?php the_permalink() ?>"><?php $my_theme = wp_get_theme(); _e("Continue reading", $my_theme->get( 'Name' )); ?></a></p>
    <p class="ibm-icon-nolink ibm-icononly ibm-inlinelink ibm-fright ibm-share-encircled-link" onmouseenter="socialCardDisplay(<?php the_ID(); ?>)"></p>
  <div id='<?php the_ID(); ?>_social' style="display: none;">
    <p class="ibm-icononly"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="_blank" class="ibm-facebook-encircled-link"><?php $my_theme = wp_get_theme(); _e('Facebook', $my_theme->get( 'Name' )); ?></a>
    <a href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?><?php echo isset( $twitter_user ) ? '&amp;via='.$twitter_user : ''; ?>" target="_blank" class="ibm-twitter-encircled-link"><?php $my_theme = wp_get_theme(); _e('Twitter', $my_theme->get( 'Name' )); ?></a>
    <a class="ibm-linkedin-encircled-link" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source=<?php bloginfo( 'name' ); ?>" target="_blank"><?php $my_theme = wp_get_theme(); _e('LinkedIn', $my_theme->get( 'Name' )); ?></a>
    <a class="ibm-googleplus-encircled-link" href="https://plusone.google.com/_/+1/confirm?hl=en-US&amp;url=<?php the_permalink(); ?>" target="_blank"><?php $my_theme = wp_get_theme(); _e('LinkedIn', $my_theme->get( 'Name' )); ?></a></p>
    <?php if (function_exists('wpfp_link')) { wpfp_link(); } ?>
</div>
    </div>
    </div>
  </div>
