<?php
get_header();
?>
<!-- <script src="<?php //echo get_stylesheet_directory_uri().'/assets/js/infinite_load_fw.js'; ?>"></script>  -->
<?php
get_template_part('_includes/v18_content_main_start');
?>

<?php
        $twitter_user = 'IBMforMarketing';
        $twitter_hash_tag = 'NewWaytoEngage';
$current_category = get_category(get_query_var('cat'));
$pimages          = get_field('main_image', $current_category->taxonomy . '_' . $current_category->term_id);
    $leadspace_title_size = get_field('leadspace_title_size', $current_category->taxonomy . '_' . $current_category->term_id);
    if(!$leadspace_title_size){
      $leadspace_title_size = 'ibm-h2';
    }

    $post_listing_style = get_field('post_listing_style', $current_category->taxonomy . '_' . $current_category->term_id);
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

  //Creating Ad group id's comman separated list. This will be used for the short code or PHP which is used to insert DataFeedr ads.
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $categories = array();
  array_push($categories, $current_category);
  $allcatids = array_map(create_function('$o', 'return $o->name;'), $categories) ;
  $ads_group_ids = get_ad_group_id($allcatids);
?>

<?php if($pimages != ''){ ?>
  <div id="ibm-leadspace-head" class="ibm-alternate ibm-alternate-background ibm-background-gray-80 <?php the_field('text_color', $current_category->taxonomy . '_' . $current_category->term_id); ?>"
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
                        class="ibm-alternate ibm-alternate-background ibm-background-gray-80"
                        style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/default-leadspace-1440x320.jpg);">
<?php } ?>
      <div id="ibm-leadspace-body" class="ibm-padding-top-0 ibm-padding-bottom-0">
          <div class="ibm-columns ibm-padding-top-3 ibm-padding-bottom-3">
              <div class="ibm-col-1-1">
                        <h2 class="<?php echo $leadspace_title_size; ?>
 <?php the_field('leadspace_title_weight', $current_category->taxonomy . '_' . $current_category->term_id); ?>"><?php
echo $current_category->name;
?></h2>
                        <p class="<?php the_field('leadspace_description_size'); ?> <?php the_field('leadspace_description_weight'); ?>"><?php
echo $current_category->category_description;
?></p>
              </div>
          </div>
      </div>

      <div id="ibm-leadspace-social">
        <div class="ibm-columns" style="padding: 10px 0 0px;">
          <div class="ibm-col-1-1">
            <div class="ibm-leadspace-social-links">
              <div>
                <p class="ibm-textcolor-white-core">Follow Us</p>
                <p class="ibm-ind-link ibm-alternate">
                    <a class="ibm-twitter-encircled-link" href="https://twitter.com/IBMforMarketing
" target="blank"><span>Follow us on Twitter</span></a>
                    <a class="ibm-linkedin-encircled-link" href="https://www.linkedin.com/company/ibm-for-marketing
" target="blank"><span>Join us on Linkedin</span></a>
                    <a class="ibm-facebook-encircled-link" href="https://www.facebook.com/Silverpop/
" target="blank"><span>Visit our Facebook page</span></a>
                    <a class="ibm-youtube-encircled-link" href="https://www.youtube.com/user/IBMEMMChannel" target="blank"><span>Watch our YouTube channel</span></a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div id="content" class="ibm-blog__postgrid">

    <div  class="ibm-columns filter-container">
        <form class="ibm-row-form" method="post" action="__REPLACE_ME__">
            <div class="ibm-bold ibm-h4"><a href="#" id="nh-category-title-name"><?php echo $current_category->name.': '; ?></a></div>
                <div class="icon-wrap">
                  <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="50 276 30 24" height="24px" width="30px">
                      <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
                      <desc>Created with Sketch.</desc>
                      <defs/>
                      <g stroke-linejoin="round" stroke-linecap="round" transform="translate(51.000000, 277.000000)" fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="tagIcon">
                          <polygon points="22.2101939 12.1441692 12.3168606 21.8960923 0.367648485 10.1184769 0.367648485 3.61747692 3.66486061 0.366553846 10.2609818 0.366553846" stroke-width="1.5" stroke="#FFFFFF" id="Stroke-1"/>
                          <polyline points="10.260897 0.366384615 15.3297455 0.366384615 27.2789576 12.144 17.3856242 21.8959231 14.8512 19.3972308" stroke-width="1.5" stroke="#FFFFFF" id="Stroke-3"/>
                          <path stroke-width="1.5" stroke="#FFFFFF" id="Stroke-5" d="M6.94637576,4.71603846 C6.34819394,4.12626923 5.37837576,4.12626923 4.78019394,4.71603846 C4.18201212,5.30580769 4.18201212,6.26111538 4.78019394,6.85173077 C5.37837576,7.44065385 6.34819394,7.44065385 6.94637576,6.85173077 C7.54455758,6.26111538 7.54455758,5.30580769 6.94637576,4.71603846 L6.94637576,4.71603846 Z"/>
                      </g>
                  </svg>
                </div> 
                <?php echo facetwp_display( 'facet', 'category_level_2' ); ?>
        </form>
    </div>    

      <div id="story-space-2" class="ibm-columns ibm-cards" data-widget="masonry" data-items=".post">
          <div class="facetwp-template">    
              <?php
              $post_count =  ($paged - 1)*10;
              if (have_posts()):
                  while (have_posts()):
                        the_post();
                        $post_count  += 1;
                      include('_includes/post_listing_grid.php');
                  endwhile;
              else:
                  $my_theme = wp_get_theme();
                  echo '<div class="nh-no-post-matched-message">';
                  _e('Sorry, no posts matched your criteria.', $my_theme->get( 'Name' ));
                  echo '</div>';
              endif;
              ?>
          </div>
      </div>
  

</div>  <!-- .ibm-blog__postgrid -->

<script>
jQuery(document).ready(function($){
  $('#nh-category-title-name').click(function(event){
    event.preventDefault();
    FWP.reset();
  });
});
</script>

  <?php
  wp_reset_query();
get_template_part('_includes/v18_content_main_end');
?>

<?php
get_footer();
?>
