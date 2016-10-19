<?php
include_once __DIR__.'/_includes/NH_renderSocialIcon.function.php';
?>

<?php get_header(); ?>

<?php get_template_part('_includes/v18_content_main_start'); ?>

    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    $authID = $curauth->ID;
    ?>

<div id="search-content" class="ibm-background-white-core">   <!-- Dummy div start -->
<!--     <div class="ibm-columns ibm-padding-top-3">
        <div class="ibm-x-col-6-6"> 
            <div class="nh-content-width-control">
                <h1 class="ibm-h1 nh-search-heading ">Search THINK <span>Marketing</span></h1>
            </div>
        </div>
    </div> -->

    <div class="ibm-padding-bottom-1 nh-content-width-control nh-author-heading">
      <div class="nh-author-heading-inner ta-grids">
          <div class="ta-grids">
            <div class="ta-col-12-4 avatar-wrap">
              <div class="nh-author-avatar-wrap">
                <?php if(get_field('author_icon', 'user_' . $authID) != "") { ?>
                  <div><img src="<?php the_field('author_icon', 'user_' . $authID); ?>" class="ibm-circle" alt="user icon" /></div>
                <?php } else { ?>
                  <?php $user_info = get_userdata($authID); echo get_avatar($user_info->user_email, 226); ?>
                <?php } ?>
              </div>
            </div>
            <div class="ta-col-12-8">
              <div class="nh-author-heading-content-wrap ibm-card__content ibm-padding-top-0">
                <div class="author-name-social-wrap">
                  <div class="nh-author-name-title-wrap">
                    <p class="nh-author-title ibm-bold"><?php the_field('job_title', "user_" . $authID); ?></p>
                    <h4 class="nh-author-name ibm-h4 ibm-bold ibm-padding-bottom-0"><?php echo $curauth->display_name; ?></h4>
                  </div>
                  <div class="nh-author-social-wrap">
                    <div class="nh-social-heading">Follow</div>
                    <ul class="nh-author-social ibm-icononly ibm-alternate ibm-textcolor-gray-60">
                    <?php if (get_user_meta($authID,'user_url')): ?>
                      <li class="ibm-ind-link "><a class="ibm-external-link" href="<?php echo get_usermeta($authID,'user_url'); ?>"><?php echo get_usermeta($authID,'user_url'); ?></a></li>
                    <?php endif; ?>
                    <?php if (get_field('ibm_author_social_twitter', 'user_' . $authID)): ?>
                      <li><?php echo NH_renderSocialIcon('twitter', get_field('ibm_author_social_twitter', 'user_' . $authID)); ?></li>
                    <?php endif; ?>
                    <?php if (get_field('ibm_author_social_linkedin', 'user_' . $authID)): ?>
                      <li><?php echo NH_renderSocialIcon('linkedin', get_field('ibm_author_social_linkedin', 'user_' . $authID)); ?></li>
                    <?php endif; ?>
                    <?php if (get_field('ibm_author_social_facebook', 'user_' . $authID)): ?>
                      <li><?php echo NH_renderSocialIcon('facebook', get_field('ibm_author_social_facebook', 'user_' . $authID)); ?></li>
                    <?php endif; ?>
                      </ul>
                  </div>
                </div>
                <p class="nh-author-bio"><?php echo $curauth->description; ?></p>
              </div>
            </div>
          </div>
  
    </div>

    <div id="content">
            <div class="xnh-page-width-control">
                <div class="ibm-padding-bottom-1">
                    <?php if(have_posts()): ?>
                        <div class="nh-author-posts-heading ta-grids">
                          <div class="nh-author-hide-under-799 ta-col-12-4">&nbsp;</div>
                          <div class="ta-col-12-8 nh-search-list-heading-flexer">
                            <h4 class="ibm-h3 ibm-bold">Posts by <?php echo $curauth->display_name; ?></h4>
                            <div class="filter-container">
                                <form class="ibm-row-form" method="post" action="__REPLACE_ME__">
                                    <!--span>
                                        <span>Filter by:</span>
                                        <?php echo facetwp_display( 'facet', 'categories' ); ?>
                                    </span-->
                                    <div style="display:inline-block;">
                                        <?php echo do_shortcode('[facetwp sort="true"]'); ?>    
                                        <?php //facetwp_display('facet', 'sort'); ?>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
                            
                    <?php endif; ?>
                    <div id="story-space-2" class="ta-grids ibm-cards" data-widget="x-masonry" data-items=".post">
                      <div class="ta-col-12-12">
                        <div class="facetwp-template search-listing-display">
                            <?php if (have_posts()): ?>          
                              <?php while (have_posts()): ?>
                                  <?php the_post(); ?>
                                  <?php include('_includes/post_listing_stack2.php'); ?>
                              <?php endwhile; ?>
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





<?php get_template_part('_includes/v18_content_main_end'); ?>
<?php get_footer(); ?>
