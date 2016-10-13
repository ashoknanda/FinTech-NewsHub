<?php
get_header();
?>
<!-- <script src="<?php //echo get_stylesheet_directory_uri().'/assets/js/infinite_load_fw.js'; ?>"></script>  -->
	<?php
get_template_part('_includes/v18_content_main_start');
$leadspace_title_size = get_field('leadspace_title_size');
if(!$leadspace_title_size){
  $leadspace_title_size = 'ibm-h2';
}
?>

<?php
$pimages = get_field('leadspace_image');
$ads_group_ids = -1;
$twitter_user = 'IBMforMarketing';
$twitter_hash_tag = 'NewWaytoEngage';
        
$catNotIn = categoryListNotToShow(); //Gets the full list of categories not be shown on page.         
?>
<?php
// ---------------------------------------------------------------------------
// Query
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<div id="search-content" class="ibm-background-white-core">   <!-- Dummy div start -->
    <div class="ibm-columns ibm-padding-top-3">
        <div class="ibm-x-col-6-6"> 
            <div class="nh-content-width-control">
                <h1 class="ibm-h1 nh-search-heading ">Search THINK <span>Marketing</span></h1>
            </div>
        </div>
    </div>

    <div class="ibm-columns ibm-padding-bottom-1">
        <div class="ibm-x-col-6-6"> <!-- ibm-center -->
            <div class="nh-content-width-control">
                <div id="ibm-search-module" style="float:none;margin-right:20px;" role="search" aria-labelledby="ibm-search-page">
                    <form class="ibm-row-form ibm-row-form--line" id="ibm-search-form" action="<?php bloginfo('url'); ?>" method="get">
                        <label for="search_input"></label>
                        <input type="text" maxlength="100" value="<?php the_search_query(); ?>" placeholder="Search Think Marketing" name="s" id="search_input" aria-label="Search" />
                        <input type="submit" id="ibm-search" class="ibm-btn-search" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>  


    <div id="content" class="ibm-columns">
        <div class="ibm-x-col-6-6">
            <div class="nh-content-width-control">
                <div class="ibm-padding-bottom-1">
                    <?php if(have_posts()): ?>
                        <div class="ibm-columns filter-container" style="padding-left:10px;">
                            <form class="ibm-row-form" method="post" action="__REPLACE_ME__">
                                <span>
                                    <label>Filter by:</label>
                                    <?php echo facetwp_display( 'facet', 'categories' ); ?>
                                    <?php //echo facetwp_display( 'facet', 'topics' ); ?>
                                </span>
                                <div style="display:inline-block; float:left;">
                                    <?php echo do_shortcode('[facetwp counts="true"]'); ?>    
                                </div>
                                <div style="display:inline-block; float:right;padding-right:20px;">
                                    <?php echo do_shortcode('[facetwp sort="true"]'); ?>    
                                    <?php //facetwp_display('facet', 'sort'); ?>
                                </div>
                            </form>
                        </div>    
                    <?php endif; ?>
                    <div id="story-space-2" class="ibm-columns ibm-cards" data-widget="masonry" data-items=".post">
                        <div class="facetwp-template search-listing-display">
                            <?php if (have_posts()): ?>
                                
                                        <?php while (have_posts()): ?>
                                            <?php the_post(); ?>
                                            <?php include('_includes/post_listing_stack2.php'); ?>
                                        <?php endwhile; ?>
                                    
                            <?php else: ?>
                                <?php 
                                    $my_theme = wp_get_theme();
                                    include('_includes/search_no_result.php');    
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <?php
        /*
        <div class="ibm-col-6-2 ibm-padding-top-2 nh-search-page">
            <div class="ibm-col-6-2 ibm-blog__article-side">
                <div class="nh-right-column ibm-blog__share"> 
                <?php include('_includes/v18_sidebar.php'); ?>
                </div>
            </div>
        </div>
        */
        ?>
    </div>
</div><!-- End dummy div -->

<?php if(have_posts()): ?>
    <div class="ibm-band nh-more-ibm-search">
      <div class="ibm-columns">
        <div class="ibm-col-6-1"></div>
        <div class="ibm-col-6-4">
          <h3 class="ibm-h2">Not finding what you’re looking for?</h3>
          <?php
              $temp = array();
              foreach($_GET as $key => $value){
                  if($key === "s"){
                      array_push($temp, "q=".$value);
                  }
                  else {
                      array_push($temp, $key."=".$value);  
                  }
              }
          ?>
          <ul>
              <li>Check your spelling</li>
              <li>Broaden your search terms</li>
              <li>Try out your <a  target="_blank" href="https://www.ibm.com/Search/?<?php echo implode('&', $temp); ?>"  style="color:#4178BE;">search on ibm.com</a></li>
          </ul>
        </div>
        <div class="ibm-col-6-1"></div>
      </div>
    </div>
<?php endif; ?>
<?php
// if (function_exists("custom_pagination")) {
//     custom_pagination($custom_query->max_num_pages, "", $paged);
//     wp_reset_postdata();
// } else {
//     $my_theme = wp_get_theme();
//     _e("<p>Sorry, no posts matched your criteria.</p>", $my_theme->get( 'Name' ));
// }
?>



  <?php
get_template_part('_includes/v18_content_main_end');
?>

  <?php
get_footer();
?>
