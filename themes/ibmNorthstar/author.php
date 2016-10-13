<?php get_header(); ?>

<?php get_template_part('_includes/v18_content_main_start'); ?>

    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    $authID = $curauth->ID;
    $leadspace_title_size = get_field('leadspace_title_size', 'user_' . $authID);
    if(!$leadspace_title_size){
      $leadspace_title_size = 'ibm-h1';
    }

    $post_listing_style = get_field('post_listing_style', 'user_' . $authID);
    if($post_listing_style !== 'grid' && $post_listing_style !== 'stack')
    {
      if(esc_attr(get_option( 'post_listing_choice_others', '' )) == "post_listing_choice_others_stack")
      {
          $post_listing_style = 'stack';
      }
      else
      {
          $post_listing_style = 'grid';
      }
    }

    ?>

<?php if(get_field('background_image', 'user_' . $authID) != '') { ?>
  <div id="ibm-leadspace-head" class="ibm-alternate <?php the_field('leadspace_title_color', 'user_' . $authID); ?> "
      data-desktop-lg-retina="<?php echo the_field('background_image', 'user_' . $authID); ?>"
      data-desktop-lg="<?php echo the_field('background_image', 'user_' . $authID); ?>"
      data-desktop-retina="<?php echo the_field('background_image', 'user_' . $authID); ?>"
      data-desktop="<?php echo the_field('background_image', 'user_' . $authID); ?>"
      data-tablet-retina="<?php echo the_field('background_image', 'user_' . $authID); ?>"
      data-tablet="<?php echo the_field('background_image', 'user_' . $authID); ?>"
      data-mobile-retina="<?php echo the_field('background_image', 'user_' . $authID); ?>"
      style="background-image:url('<?php echo the_field('background_image', 'user_' . $authID); ?>');"
      data-mobile="<?php echo the_field('background_image', 'user_' . $authID); ?>">
<?php } else { ?>
  <div id="ibm-leadspace-head" class="ibm-padding-top-2 ibm-padding-bottom-2 <?php echo $alternate; ?> <?php the_field('leadspace_title_color', 'user_' . $authID); ?>"
       style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/default-leadspace-1440x320.jpg);">
<?php } ?>
      <div id="ibm-leadspace-body">
          <div class="ibm-columns ibm-padding-top-3 ibm-padding-bottom-2">
              <div class="ibm-col-1-1"> <!-- ibm-center -->
                <h1 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight', 'user_' . $authID); ?> "><?php echo the_field('author_title_large', 'user_' . $authID); ?></h1>
              </div>
          </div>
      </div>
  </div>
<div class="ibm-columns"><div class="ibm-col-1-1">
 <div class="ibm-columns ibm-padding-top-3 ibm-cards" data-widget="masonry" data-items=".post">

<?php
if($post_listing_style == "stack")
{
  ?><div class="ibm-blog__post-author ibm-col-1-1 post"><?php
}
else
{
  ?><div class="ibm-blog__post-author ibm-col-6-2 post"><?php
}
?>

  <div class="ibm-card">
    <div class="ibm-card__heading ibm-center"><h4 class="ibm-h4 ibm-bold ibm-padding-bottom-0"><?php echo $curauth->display_name; ?></h4></div>
  <div class="ibm-card__image ibm-center">
            <div class="ibm-blog__post-author-thumb ibm-blog__contributor-thumb">
              <?php if(get_field('author_icon', 'user_' . $authID) != "") { ?>
                <div><div style="background-image:url('<?php the_field('author_icon', 'user_' . $authID); ?>'); background-size:cover; background-position:center center;" ></div></div>
              <?php } else { ?>
                <div><?php $user_info = get_userdata($authID); echo get_avatar($user_info->user_email); ?></div>
              <?php } ?>
            </div>
  </div>
    <div class="ibm-card__content ibm-padding-top-0">
    <p class="ibm-center"><?php the_field('job_title', "user_" . $authID); ?></p>
    <p class="ibm-textcolor-gray-60"><?php echo $curauth->description; ?></p>
    <?php if (get_user_meta($authID,'user_url')): ?>
      <p class="ibm-ind-link"><a class="ibm-external-link" href="<?php echo get_usermeta($authID,'user_url'); ?>"><?php echo get_usermeta($authID,'user_url'); ?></a></p>
    <?php endif; ?>
    <p class="ibm-icononly ibm-blog__author-social ibm-center">
    <?php if (get_field('ibm_author_social_twitter', 'user_' . $authID)): ?>
      <a class="ibm-twitter-encircled-link ibm-inlinelink" href="<?php the_field('ibm_author_social_twitter', 'user_' . $authID); ?>"></a>
    <?php endif; ?>
    <?php if (get_field('ibm_author_social_linkedin', 'user_' . $authID)): ?>
      <a class="ibm-linkedin-encircled-link ibm-inlinelink" href="<?php the_field('ibm_author_social_linkedin', 'user_' . $authID); ?>"></a>
    <?php endif; ?>
    <?php if (get_field('ibm_author_social_facebook', 'user_' . $authID)): ?>
      <a class="ibm-facebook-encircled-link ibm-inlinelink" href="<?php the_field('ibm_author_social_facebook', 'user_' . $authID); ?>"></a>
    <?php endif; ?>
      </p>

    </div>
  </div>
  </div>

<?php
if($post_listing_style == "stack")
{
  echo "</div>";
  echo '<div class="ibm-columns">';
}
?>


<!-- The Loop -->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php
    if($post_listing_style == "stack")
    {
      include('_includes/post_listing_stack.php');
    }
    else
    {
      include('_includes/post_listing_grid.php');
    }
    ?>
    <?php endwhile; else: ?>
    <div class="ibm-blog__post-author ibm-col-6-2 post" style="position: absolute; left: 10px; top: 60px;">
  <div class="ibm-card">
    <div class="ibm-card__heading ibm-center"><h4 class="ibm-h4 ibm-bold ibm-padding-bottom-0"><?php $my_theme = wp_get_theme(); _e('Sorry', $my_theme->get( 'Name' )); ?></h4>
    </div>
    <div class="ibm-card__content ibm-center">
      <?php $my_theme = wp_get_theme(); _e('Author has no posts.', $my_theme->get( 'Name' )); ?>
    </div>
  </div>
  </div>
</div>

    <?php endif; ?>

<!-- End Loop -->




  </div>
  <?php
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if (function_exists('custom_pagination')) {
    if(isset($custom_query))
    {
      custom_pagination($custom_query->max_num_pages, "", $paged);
    }
    else
    {
      custom_pagination(false, "", $paged);
    }
    wp_reset_postdata();
}
?>
       </div>

<?php get_template_part('_includes/v18_content_main_end'); ?>
<?php get_footer(); ?>