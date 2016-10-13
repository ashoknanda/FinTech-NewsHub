<?php
get_header();
?>

  <?php
get_template_part('_includes/v18_content_main_start');
?>

  <?php
$cattag_obj = $wp_query->get_queried_object();
$pimages    = get_field('main_image', $cattag_obj->taxonomy . '_' . $cattag_obj->term_id);
    $leadspace_title_size = get_field('leadspace_title_size', $cattag_obj->taxonomy . '_' . $cattag_obj->term_id);
    if(!$leadspace_title_size){
      $leadspace_title_size = 'ibm-h1';
    }

    $post_listing_style = get_field('post_listing_style', $cattag_obj->taxonomy . '_' . $cattag_obj->term_id);
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

<?php if($pimages != ''){ ?>

  <div id="ibm-leadspace-head" class="ibm-alternate <?php the_field('text_color', $cattag_obj->taxonomy . '_' . $cattag_obj->term_id); ?>"
        data-desktop-lg-retina="<?php
echo $pimages['sizes']['size-2880'];
?>"
        data-desktop-lg="<?php
echo $pimages['sizes']['size-1440'];
?>"
        data-desktop-retina="<?php
echo $pimages['sizes']['size-2400'];
?>"
        data-desktop="<?php
echo $pimages['sizes']['size-1200'];
?>"
        data-tablet-retina="<?php
echo $pimages['sizes']['size-1200'];
?>"
        data-tablet="<?php
echo $pimages['sizes']['size-780'];
?>"
        data-mobile-retina="<?php
echo $pimages['sizes']['size-780'];
?>"
        data-mobile="<?php
echo $pimages['sizes']['size-380'];
?>"
style="background-image: url('<?php echo $pimages['sizes']['size-1440']; ?>');">
<?php } else { ?>
                <div id="ibm-leadspace-head"
                        style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/default-leadspace-1440x320.jpg);">
<?php } ?>
      <div id="ibm-leadspace-body">
          <div class="ibm-columns ibm-padding-top-3 ibm-padding-bottom-3">
              <div class="ibm-col-1-1"> <!-- ibm-center -->
                        <h1 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight', $cattag_obj->taxonomy . '_' . $cattag_obj->term_id); ?>">
                        <?php
echo $cattag_obj->name;
?></h1>
                        <p class="<?php the_field('leadspace_description_size'); ?> <?php the_field('leadspace_description_weight'); ?>"><?php
echo $cattag_obj->description;
?></p>
              </div>
          </div>
      </div>
  </div>

  <div class="ibm-blog__postgrid">


      <?php
      if($post_listing_style == "stack")
      {
        ?><div id="content"><?php
      }
      else
      {
        ?><div class="ibm-columns"><div class="ibm-col-1-1"><div id="content" class="ibm-columns" data-widget="masonry" data-items=".post"><?php
      }
set_query_var('current_category', $current_category);
?>
      <?php

// ---------------------------------------------------------------------------
// Query

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$custom_args = array(
    'paged' => $paged,
    'post_type' => 'post',
    'posts_per_page' => get_field("posts_per_page"),
    'orderby' => 'date',
    'category__not_in'  => get_cat_ID('Featured Topic'),
    'tag' => $cattag_obj->slug
);

$custom_query = new WP_Query($custom_args);

?>

      			<?php
if ($custom_query->have_posts()):
    while ($custom_query->have_posts()):
        $custom_query->the_post();

          if($post_listing_style == "stack")
          {
              include('_includes/post_listing_stack.php');
          }
          else
          {
              include('_includes/post_listing_grid.php');
          }

    endwhile;
else:
?>
      <p><?php
      $my_theme = wp_get_theme();
      _e('Sorry, no posts matched your criteria.', $my_theme->get( 'Name' ));
?></p>
      <?php
endif;
?>

  </div> <!-- .ibm-columns -->

  <?php
  if($post_listing_style !== "stack")
  {
    ?></div></div><?php
  }
  ?>
  </div> <!-- #content -->

  <!-- pagination here -->
  <?php
if (function_exists('custom_pagination')) {
    custom_pagination($custom_query->max_num_pages, "", $paged);
    wp_reset_postdata();
} else {
     $my_theme = wp_get_theme();
     _e("<p>Sorry, no posts matched your criteria.</p>", $my_theme->get( 'Name' ));
}
?>


  <?php
get_template_part('_includes/v18_content_main_end');
?>

<?php
get_footer();
?>
