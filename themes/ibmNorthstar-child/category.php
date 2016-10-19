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

  //Creating Ad group id's comman separated list. This will be used for the short code or PHP which is used to insert DataFeedr ads.
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $categories = array();
  array_push($categories, $current_category);
  $allcatids = array_map(create_function('$o', 'return $o->name;'), $categories) ;
  $ads_group_ids = get_ad_group_id($allcatids);
?>

  <div id="content" class="ibm-blog__postgrid">
    <div  class="ibm-columns filter-container">
        <form class="ibm-row-form" method="post" action="__REPLACE_ME__">
            <div class="ibm-bold ibm-h4"><a href="#" id="nh-category-title-name"><?php echo $current_category->name; ?></a></div>
 <!--                <div class="icon-wrap">
                  <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="50 276 30 24" height="24px" width="30px">
                      <desc>Created with Sketch.</desc>
                      <defs/>
                      <g stroke-linejoin="round" stroke-linecap="round" transform="translate(51.000000, 277.000000)" fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="tagIcon">
                          <polygon points="22.2101939 12.1441692 12.3168606 21.8960923 0.367648485 10.1184769 0.367648485 3.61747692 3.66486061 0.366553846 10.2609818 0.366553846" stroke-width="1.5" stroke="#FFFFFF" id="Stroke-1"/>
                          <polyline points="10.260897 0.366384615 15.3297455 0.366384615 27.2789576 12.144 17.3856242 21.8959231 14.8512 19.3972308" stroke-width="1.5" stroke="#FFFFFF" id="Stroke-3"/>
                          <path stroke-width="1.5" stroke="#FFFFFF" id="Stroke-5" d="M6.94637576,4.71603846 C6.34819394,4.12626923 5.37837576,4.12626923 4.78019394,4.71603846 C4.18201212,5.30580769 4.18201212,6.26111538 4.78019394,6.85173077 C5.37837576,7.44065385 6.34819394,7.44065385 6.94637576,6.85173077 C7.54455758,6.26111538 7.54455758,5.30580769 6.94637576,4.71603846 L6.94637576,4.71603846 Z"/>
                      </g>
                  </svg>
                </div>  -->
                <?php 
                    if(strcasecmp($current_category->name,"digital marketing") == 0){
                      echo facetwp_display( 'facet', 'digital' );
                    }else if(strcasecmp($current_category->slug,"data") == 0){
                      echo facetwp_display( 'facet', 'data_analytics' ); 
                    }else if(strcasecmp($current_category->name,"campaign management") == 0){
                      echo facetwp_display( 'facet', 'campaign_management' );
                    }else{
                      echo facetwp_display( 'facet', 'category_level_2' );
                    }

                 echo facetwp_display( 'facet', 'category_level_2' ); 
                ?>
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
