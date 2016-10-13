<?php
get_header();
?>

	<?php
get_template_part('_includes/v18_content_main_start');
$leadspace_title_size = get_field('leadspace_title_size');
    if(!$leadspace_title_size){
      $leadspace_title_size = 'ibm-h1';
    }
?>

  <?php
$pimages = get_field('leadspace_image');
?>
<?php if($pimages != ''){ ?>
  <div id="ibm-leadspace-head" class="ibm-alternate <?php the_field('text_color'); ?>"
        style="background-image: url('<?php echo $pimages['url']; ?>')"
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
?>
">
<?php } else { ?>
                <div id="ibm-leadspace-head" class="ibm-padding-top-2 ibm-padding-bottom-2 ibm-alternate <?php the_field('text_color'); ?>"
                        style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/default-leadspace-1440x320.jpg);">
<?php } ?>
      <div id="ibm-leadspace-body">
          <div class="ibm-columns  ibm-padding-top-3 ibm-padding-bottom-3">
              <div class="ibm-col-1-1"> <!-- ibm-center -->
                <h1 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight'); ?>"><?php
echo get_field('display_title');
?></h1>
                <p class="<?php the_field('leadspace_description_size'); ?> <?php the_field('leadspace_description_weight'); ?>"><?php
echo the_field('description');
?></p>
              </div>
          </div>
      </div>
  </div>


	<?php

// ---------------------------------------------------------------------------
// Query

$paged        = (get_query_var('paged')) ? get_query_var('paged') : 1;
$custom_args  = array(
    'paged' => $paged,
    'posts_per_page' => get_field("posts_per_page"),
    'post_type' => 'post',
    'orderby' => 'date',
    'date_query' => array(
        'after' => date('Y-m-d', strtotime('-2 years'))
    )
);
$custom_query = new WP_Query($custom_args);
?>

      <?php
      if(esc_attr(get_option( 'post_listing_choice_others', '' )) == "post_listing_choice_others_stack")
      {
        ?><div class="ibm-padding-top-2 ibm-padding-bottom-3" ><?php
      }
      else
      {
        ?><div class="ibm-columns"><div class="ibm-col-1-1"><div class="ibm-columns ibm-cards ibm-padding-top-2 ibm-padding-bottom-3" data-widget="masonry" data-items=".post"><?php
      }

if ($custom_query->have_posts()):
    while ($custom_query->have_posts()):
        $custom_query->the_post();
?>
      <?php
      if(esc_attr(get_option( 'post_listing_choice_others', '' )) == "post_listing_choice_others_stack")
      {
          include('_includes/post_listing_stack.php');
      }
      else
      {
          include('_includes/post_listing_grid.php');
      }
?>
    <?php
    endwhile;
else:
?>
      <p><?php
    $my_theme = wp_get_theme();
    _e('Sorry, no posts matched your criteria.', $my_theme->get( 'Name' )); ?>;
?></p>
    <?php
endif;
?>

</div> <!-- .ibm-columns -->
<?php
      if(esc_attr(get_option( 'post_listing_choice_others', '' )) !== "post_listing_choice_others_stack")
      {
        ?>
          </div></div>
        <?php
      }
      ?>
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
