<?php get_header(); ?>

    <?php get_template_part('_includes/v18_content_main_start'); ?>

    <?php

          $postsource = null;
          $postauthor = null;
          $authID = $post->post_author;
          $userdata = get_userdata($authID);
          $postauthor =  $userdata->user_nicename; //Setting author to post author set in WP if Newscred nc-author does not exist. 
          $custom_fields = get_post_custom($post->ID);
          $nc_source = array();
          $nc_author = array();
          $nc_author = $custom_fields['nc-author']?$custom_fields['nc-author']:"";
          $nc_source = $custom_fields['nc-source']?$custom_fields['nc-source']:"";
          if(is_object($nc_author)){
            foreach ( $nc_author as $key => $value ) {
              $postauthor = $value;
            }    
          }
          if(is_object($nc_source)){
            foreach ( $nc_source as $key => $value ) {
              $postsource = $value;
            }
          }

          //Identify it is editors_pick.
          $allTags = wp_get_post_tags($post->ID);
          $is_editor_pick = false;
          foreach ($allTags as $key => $value) {
            // print_r($value->name);
            if($value->name == 'editor_pick'){
              $is_editor_pick = true;
            }
          }

        //calculates the facebook counts and linkedin counts and sets it to a variable to reuse.
        $urltogetcount = get_permalink(); 
        $fbCount=0; $lnCount = 0;
        $fbCount = do_shortcode("[facebook-share url='".$urltogetcount."']");
        $lnCount = do_shortcode("[linkedin-share url='".$urltogetcount."']"); 


        // size helper -- Single Post Template modified by Ryan Sebade
        function formatSizeUnits($bytes) {
            if ($bytes >= 1073741824) {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576) {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024) {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1) {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1) {
                $bytes = $bytes . ' byte';
            }
            else {
                $bytes = '0 bytes';
            }

            return $bytes;
        }

        // get csv data
        $csv_data = get_field('csv_data');
        $fullwidth_choice = get_field('full_width');
        $socialshare_choice = get_field('social_share');
        if($socialshare_choice == 'Yes'){
            $socialshare = true;
        }
        elseif($socialshare_choice == 'No'){
            $socialshare = false;
        }
        else{
            if(esc_attr(get_option( 'force_all_posts_to_social_share', '' )) == "on"){
                $socialshare = true;
            }
            else{
                $socialshare = false;
            }
        }

        if($socialshare_choice == ''){
            if(esc_attr(get_option( 'force_all_posts_to_social_share', '' )) == "on"){
                $socialshare = true;
            }
            else{
                $socialshare = false;
            }
        }
        if($fullwidth_choice == 'Yes'){
            $socialshare = true;
        }
        elseif($fullwidth_choice == 'No'){
            $socialshare = false;
        }
        else{
            if(esc_attr(get_option( 'force_all_posts_to_full_width', '' )) == "on"){
                $fullwidth = true;
            }
            else{
                $fullwidth = false;
            }
        }

        if($fullwidth_choice == ''){
            if(esc_attr(get_option( 'force_all_posts_to_full_width', '' )) == "on"){
                $fullwidth = true;
            }
            else{
                $fullwidth = false;
            }
        }

        if(esc_attr(get_option( 'hide_author_from_posts', '' )) == "on"){
                $hideauthor = true;
            }
            else{
                $hideauthor = false;
            }



    ?>

<!-- The Loop -->
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php
            $pimages = get_field('leadspace_image');

            if ($post->post_type === 'abstract') {
                $aimages = get_field('abstract_image');
            }
            $categories = array();
            $pcategories = get_the_category();
            foreach($pcategories as $pcategory)
            {
              if($pcategory->name !== 'Featured Carousel' && $pcategory->name !== 'Uncategorized') {
                array_push($categories, $pcategory);
              }
            }

            $template_directory = get_template_directory_uri();
            $leadspace_default = $template_directory  . '/default-leadspace-1440x320.jpg';
            $leadspace_title_size = get_field('leadspace_title_size');
            if(!$leadspace_title_size){
              $leadspace_title_size = 'ibm-h2';
            }

            // SIdebar Links to Collections through Ads
            $allcatids = array_map(create_function('$o', 'return $o->name;'), $categories) ;
            $ads_group_ids = get_ad_group_id($allcatids);
        ?>

<div class="" style="background: #fff;">

        <div class="ibm-blog__article ibm-padding-bottom-0" data-post-id-"<?php the_ID(); ?>">

 <?php if($pimages != ''){ ?>
                <div id="ibm-leadspace-head" class="ibm-padding-top-2 ibm-padding-bottom-2 <?php the_field('text_color'); ?>"
                        data-desktop-lg-retina="<?php echo $pimages['sizes']['size-2880']; ?>"
                        data-desktop-lg="<?php echo $pimages['sizes']['size-1440']; ?>"
                        data-desktop-retina="<?php echo $pimages['sizes']['size-2400']; ?>"
                        data-desktop="<?php echo $pimages['sizes']['size-1200']; ?>"
                        data-tablet-retina="<?php echo $pimages['sizes']['size-1200']; ?>"
                        data-tablet="<?php echo $pimages['sizes']['size-780']; ?>"
                        data-mobile-retina="<?php echo $pimages['sizes']['size-780']; ?>"
                        data-mobile="<?php echo $pimages['sizes']['size-380']; ?>"
                        style="display:block;background-image: url(<?php echo $pimages['sizes']['size-1440']; ?>);">
<?php } else { ?>
                <div id="ibm-leadspace-head" class="ibm-padding-top-2 ibm-padding-bottom-2 <?php the_field('text_color'); ?>"
                        style="display:block;background-image: url('<?php echo $leadspace_default; ?>');">
<?php } ?>
                    <div id="ibm-leadspace-body" class="">
                        <div class="ibm-columns">
                            <div class="ibm-col-2-1">
                                <?php if(!get_field('alternate_background')){ ?>
                                <a href="<?php echo get_category_link($categories[0]->cat_ID); ?>"><h4 class="ibm-blog__category <?php the_field('text_color'); ?>"><?php echo $categories[0]->name; ?></h4></a>
                                <?php } else { ?>
                                <a href="<?php echo get_category_link($categories[0]->cat_ID); ?>"><h4 class="ibm-blog__category <?php the_field('text_color'); ?>"><?php echo $categories[0]->name; ?></h4></a>
                                <?php } ?>
                            <h2 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight'); ?>" itemprop="headline" rel="bookmark">
                            <?php echo widont(get_the_title()); ?></h2>
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
                                <a class="ibm-linkedin-encircled-link" href="https://www.linkedin.com/company/silverpop/
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



    <div class="ibm-columns">
        <div class="ibm-col-1-1 ibm-blog__article-main ibm-padding-top-2">
            <div class="ibm-blog__article-date">
                <p>
                    <?php
                        $categoriesDisplayed = 0;
                        $categories = get_the_category();
                        $string_temp = "";
                        $isUncategorized = false;
                        foreach ( $categories as $category )
                        {
                            if($category->name !== "Featured Carousel" && $category->name !== "Uncategorized")
                            {
                                $categoriesDisplayed++;
                                $cat_url = get_category_link(get_cat_ID($category->name));
                                $string_temp .= '<a href="';
                                $string_temp .= $cat_url;
                                $string_temp .= '">';
                                $string_temp .= $category->name;
                                $string_temp .= '</a> , ';
                            }
                        }


                  // $categories = array();
                  // array_push($categories, $current_category);
                  $allcatids = array_map(create_function('$o', 'return $o->name;'), $categories) ;
                  $ads_group_ids = get_ad_group_id($allcatids);

                        $my_theme = wp_get_theme();
                        // echo ($categoriesDisplayed > 0 ? __("Categorized: ",$my_theme->get( 'Name' )) : "");
                        echo rtrim($string_temp, " ,");
                         ?>
                </p>
                <p class="ibm-date-time ibm-small ibm-textcolor-gray-30 <?php if($is_editor_pick) { echo 'nh-single-page nh-editors-picks'; }?>">
                    <?php if($is_editor_pick) { ?>
                    <span class="ibm-icon-nolink ibm-star-full-link ibm-textcolor-gray-30">
                        <span style="padding-right: 10px;"><?php $my_theme = wp_get_theme(); _e("Editors' Pick", $my_theme->get( 'Name' )); ?></span>
                    </span>
                    <span class="nh-dot-separator"style="padding-right:10px;">•</span>
                    <?php } ?>
                    <span class="ibm-textcolor-gray-30" style="padding-right:10px;"><?php the_date(); ?> </span>
                </p>            
            </div>

            <h2 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight'); ?>" itemprop="headline" rel="bookmark">
            <?php echo widont(get_the_title()); ?></h2>

            <div class="ibm-blog__article-date">
                <p class="ibm-date-time ibm-small ibm-textcolor-gray-40 ibm-padding-bottom-0">
                    <?php if(!$hideauthor){ $my_theme = wp_get_theme(); _e('by', $postauthor); ?> <span class="ibm-bold ibm-textcolor-blue-60"><?php echo $postauthor; } ?> </span>
                </p>
                <p class="ibm-date-time ibm-small ibm-textcolor-gray-40 ibm-padding-bottom-0">
                    <?php echo $postsource; ?>
                </p>                
            </div>
            <div id='<?php the_ID(); ?>_social' >
                <div class="nh-social-share-icon-count">
                    <a href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php  echo widont(get_the_title()); ?>&amp;hashtags=NewWaytoEngage&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?><?php echo isset( $twitter_user ) ? '&amp;via='.$twitter_user : '&amp;via=IBMforMarketing'; ?>" target="_blank" class="ibm-twitter-link ibm-small ibm-inlinelink nh-social-icon">&nbsp;</a>                
                    <a class="ibm-facebook-link ibm-small ibm-inlinelink nh-social-icon" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="_blank">
                        <span class="ibm-textcolor-gray-40">
                        <?php 
                            echo $fbCount; 
                        ?>   
                        &nbsp;                     
                        </span>
                    </a>
                    <a class="ibm-linkedin-link ibm-small ibm-inlinelink nh-social-icon" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source=<?php bloginfo( 'name' ); ?>" target="_blank">
                        <span class="ibm-textcolor-gray-40">
                        <?php 
                            echo $lnCount; 
                        ?>    
                        &nbsp;                    
                        </span>
                    </a>                                                   
                </div>
            </div>


            <div class="ibm-blog__article-content">
                <?php the_content(); ?>
                <div id='<?php the_ID(); ?>_social' >
                    <?php 
                        $urltogetcount = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];  
                    ?>
                    <div class="nh-social-share-icon-count">
                        <a href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php  echo widont(get_the_title()); ?>&amp;hashtag=NewWaytoEngage&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?><?php echo isset( $twitter_user ) ? '&amp;via='.$twitter_user : '&amp;via=IBMforMarketing'; ?>" target="_blank" class="ibm-twitter-link ibm-small ibm-inlinelink nh-social-icon">&nbsp;</a>                
                        <a class="ibm-facebook-link ibm-small ibm-inlinelink nh-social-icon" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="_blank">
                            <span class="ibm-textcolor-gray-40">
                            <?php 
                                echo $fbCount; 
                            ?>                        
                            </span>
                        </a>
                        <a class="ibm-linkedin-link ibm-small ibm-inlinelink nh-social-icon" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source=<?php bloginfo( 'name' ); ?>" target="_blank">
                            <span class="ibm-textcolor-gray-40">
                            <?php 
                                echo $lnCount;
                            ?>                        
                            </span>
                        </a>                                                     
                    </div>
                </div>                        
                        <!-- <?php if($socialshare){ ?> -->
<!--                             <div class="ibm-sharethispage ibm-padding-top-1 ibm-padding-bottom-1">



                            </div> -->
<!--                             <h4 class="ibm-bold">Share this page</h4>
                           <p class="ibm-icononly">
                                <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="_blank" class="ibm-facebook-encircled-link"><?php $my_theme = wp_get_theme(); _e('Facebook', $my_theme->get( 'Name' )); ?></a>
                                <a href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php  echo widont(get_the_title()); ?>&amp;hashtag=NewWaytoEngage&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?><?php echo isset( $twitter_user ) ? '&amp;via='.$twitter_user : '&amp;via=IBMforMarketing'; ?>" target="_blank" class="ibm-twitter-encircled-link"><?php $my_theme = wp_get_theme(); _e('Twitter', $my_theme->get( 'Name' )); ?></a>
                                <a class="ibm-linkedin-encircled-link" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source=<?php bloginfo( 'name' ); ?>" target="_blank"><?php $my_theme = wp_get_theme(); _e('LinkedIn', $my_theme->get( 'Name' )); ?></a>
                                <a class="ibm-googleplus-encircled-link" href="https://plusone.google.com/_/+1/confirm?hl=en-US&amp;url=<?php the_permalink(); ?>" target="_blank"><?php $my_theme = wp_get_theme(); _e('LinkedIn', $my_theme->get( 'Name' )); ?></a>
                            </p>                            
                          <?php } ?> -->
<!--                         <div class="ibm-padding-top-1">
                            <?php if(!$hideauthor) { ?>
                            <div class="ibm-blog__post-author">
                                <div class="first">
                                        <div class="ibm-blog__post-author-thumb ibm-blog__contributor-thumb">
                                            <?php $user_info = get_userdata(get_the_author_meta('ID'));
                                            if(get_field('author_icon', 'user_' . get_the_author_meta('ID')) != "") { ?>
                                           <div><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta( 'user_nicename' ))); ?>"><img src="<?php the_field('author_icon', 'user_' . get_the_author_meta('ID')); ?>" alt="user icon" /></a></div>
                                           <?php } else { ?>
                                           <div><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta( 'user_nicename' ))); ?>"><?php echo get_avatar($user_info->user_email); ?></a></div>
                                           <?php } ?>
                                        </div>
                                    <div class="ibm-center">
                                       <h4 class="ibm-h4 ibm-bold ibm-padding-bottom-0"><?php the_author_posts_link() ?></h4>
                                       <p class="ibm-textcolor-gray-40"><?php the_field('job_title', 'user_' . get_the_author_meta('ID')); ?></p>
                                    </div>
                                </div>
                            <?php if(get_field('guest_author')){ ?>
                                    <div class="second">
                                            <?php if(get_field('guest_author_website_link')){ ?>
                                            <div class="ibm-blog__post-author-thumb ibm-blog__contributor-thumb">
                                               <div><a href="<?php echo get_field('guest_author_website_link') ?>"><img src="<?php the_field('guest_author_image') ?>"></a></div>
                                            </div>
                                                                                            <div class="ibm-center">
                                                   <a href="<?php echo get_field('guest_author_website_link') ?>"><h4 class="ibm-h4 ibm-bold ibm-padding-bottom-0"><?php the_field('guest_author_name'); ?></h4></a>
                                                   <p class="ibm-textcolor-gray-40"><?php the_field('guest_author_description'); ?></p>
                                                </div>
                                            <?php } else { ?>
                                            <div class="ibm-blog__post-author-thumb ibm-blog__contributor-thumb">
                                                <div><img src="<?php the_field('guest_author_image') ?>"></div>
                                            </div>
                                        <div class="ibm-center">
                                           <h4 class="ibm-h4 ibm-bold ibm-padding-bottom-0"><?php the_field('guest_author_name'); ?></h4>
                                           <p class="ibm-textcolor-gray-40"><?php the_field('guest_author_description'); ?></p>
                                        </div>
                                        <?php } ?>
                                    </div>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        </div> -->
<!--                         <div class="ibm-blog__article-tags">
			<p class='ibm-button-link ibm-btn-row'><?php v18_tags( '', ' ', '<br />' ); ?></p>
               </div> -->


                    <!--- <div class="ibm-blog__article-date">
                        <p class="ibm-date-time ibm-textcolor-gray-40"><?php the_date(); ?></p>
                    </div>

                    <div class="ibm-rule ibm-alternate ibm-gray-30"> </div> -->

                </div>



            </div>

        </div>


    <?php endwhile; ?>
    <?php else : ?>

        <div class="ibm-columns">
            <div class="ibm-col-6-4">
                <h1 class="ibm-h1"><?php $my_theme = wp_get_theme(); _e('Oops, Post Not Found!', $my_theme->get( 'Name' )); ?></h1>
            </div>
            <div class="ibm-col-6-2"></div>
        </div>

    <?php endif; ?>


    <?php



        // ---------------------------------------------------------------------------
        // Query

        $params     = array(
            'paged'             => 1,
            'post_type'         => $post->post_type,
            'posts_per_page'    => 3, // get_field('number_of_posts'),
            'orderby'           => 'rand',
            'post__not_in'      => array($post->ID)
            );

        // get by category
        $categories = get_the_category();
        if (!empty( $categories)) {
            $category = $categories[0];
            $params['category_name'] = $category->slug;
        }

        $posts      = new WP_Query($params);
        $post_spot = 0;
        $grid_with_highlights = false;
    ?>

    
        <div class="ibm-columns">
        <div class="nh-single-related-wrap ibm-article-band ibm-blog__postgrid">
        <?php if ( $posts->have_posts() && get_topic_category( get_the_category() ) !== "Uncategorized") { ?>


                    <?php 
                        comments_template();
                     ?>
                    

          
        <?php } ?>               
        </div>  <!-- .ibm-blog__postgrid -->
        </div>
    

    </div>

    <?php get_template_part('_includes/v18_content_main_end'); ?>

<?php get_footer(); ?>
