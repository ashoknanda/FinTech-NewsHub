<?php
get_header();
?>

  <?php
get_template_part('_includes/v18_content_main_start');
?>

  <?php
$cattag_obj = $wp_query->get_queried_object();
?>
  <div id="content" class="ibm-blog__postgrid">

    <div  class="ibm-columns filter-container">
        <form class="ibm-row-form" method="post" action="__REPLACE_ME__">
            <div class="ibm-bold ibm-h4"><a href="#" id="nh-category-title-name"><?php echo $cattag_obj->name.': '; ?></a></div> 
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

                // echo facetwp_display( 'facet', 'category_level_2' ); 
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

  <?php
  wp_reset_query();
get_template_part('_includes/v18_content_main_end');
?>

<?php
get_footer();
?>
