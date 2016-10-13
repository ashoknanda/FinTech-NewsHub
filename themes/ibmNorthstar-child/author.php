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

    <div class="ibm-columns ibm-padding-bottom-1">
        <div class="ibm-x-col-6-6"> <!-- ibm-center -->
            <div class="nh-content-width-control" style="border-bottom: 1px solid;">
              <div class="ibm-card__heading ibm-center"><h4 class="ibm-h4 ibm-bold ibm-padding-bottom-0"><?php echo $curauth->display_name; ?></h4></div>
            <div class="ibm-card__image ibm-center">
                      <div class="ibm-blog__post-author-thumb ibm-blog__contributor-thumb">
                        <?php if(get_field('author_icon', 'user_' . $authID) != "") { ?>
                          <div><img src="<?php the_field('author_icon', 'user_' . $authID); ?>" alt="user icon" /></div>
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
                                </span>
                                <div style="display:inline-block; padding-right:20px;">
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
