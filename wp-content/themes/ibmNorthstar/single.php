<?php get_header(); ?>

    <?php get_template_part('_includes/v18_content_main_start'); ?>

    <?php
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
        ?>

<div class="">

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
                        style="background-image: url(<?php echo $pimages['sizes']['size-1440']; ?>);">
<?php } else { ?>
                <div id="ibm-leadspace-head" class="ibm-padding-top-2 ibm-padding-bottom-2 <?php the_field('text_color'); ?>"
                        style="background-image: url('<?php echo $leadspace_default; ?>');">
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
                                <a class="ibm-twitter-encircled-link" href="http://www.twitter.com/ibm" target="blank"><span>Follow us on Twitter</span></a>
                                <a class="ibm-linkedin-encircled-link" href="http://www.linkedin.com/company/ibm" target="blank"><span>Join us on Linkedin</span></a>
                                <a class="ibm-facebook-encircled-link" href="http://www.facebook.com/ibm" target="blank"><span>Visit our Facebook page</span></a>
                                <a class="ibm-youtube-encircled-link" href="http://www.youtube.com/ibm" target="blank"><span>Watch our YouTube channel</span></a>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
		</div>

    <div class="ibm-columns">
<?php if($fullwidth){ ?>
        <div class="ibm-col-1-1 ibm-blog__article-main ibm-padding-top-2">
<?php } else { ?>
        <div class="ibm-col-6-4 ibm-blog__article-main">
<?php } ?>
            <div class="ibm-blog__article-date"><p class="ibm-date-time ibm-textcolor-gray-40">
            <?php the_date(); if(!$hideauthor){ ?> | <?php $my_theme = wp_get_theme(); _e('Written by:', $my_theme->get( 'Name' )); ?> <?php the_author_posts_link(); } ?> </p>
            <p>
    <?php
        $categoriesDisplayed = 0;
        $categories = get_categories();
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
                $string_temp .= '</a> | ';
            }
        }

        $my_theme = wp_get_theme();
        echo ($categoriesDisplayed > 0 ? __("Categorized: ",$my_theme->get( 'Name' )) : "");
        echo rtrim($string_temp, " |");
         ?>
            </p>
                 </div>

                    <div class="ibm-blog__article-content">

                        <?php the_content(); ?>
                        <?php if($socialshare){ ?>
                            <div class="ibm-sharethispage ibm-padding-top-1 ibm-padding-bottom-1"></div>
                          <?php } ?>
                        <div class="ibm-padding-top-1">
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
                        </div>
                        <div class="ibm-blog__article-tags">
			<p class='ibm-button-link ibm-btn-row'><?php v18_tags( '', ' ', '<br />' ); ?></p>
               </div>


                    <!--- <div class="ibm-blog__article-date">
                        <p class="ibm-date-time ibm-textcolor-gray-40"><?php the_date(); ?></p>
                    </div>

                    <div class="ibm-rule ibm-alternate ibm-gray-30"> </div> -->

                    </div>
                    <?php get_template_part('_includes/post_nextprev'); ?>

                    <?php if($fullwidth){
                        comments_template("/comments-full-width.php");
                         } else {
                        comments_template();
                    } ?>


                </div>


<?php if(!$fullwidth){ ?>
                <div class="ibm-col-6-2 ibm-blog__article-side">
                     <div class="ibm-blog__share">

<!--                         <div class="facebook">
                            <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="200" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>
                        </div> -->
                        <div class="ibm-card ibm-popular-widget">
                        <?php echo do_shortcode('[do_widget id=wmp_widget-2 wrap=div title=h2 ]') ?>
                        </div>
                        <div>
                            <?php echo do_shortcode('[do_widget id=ccre_widget-2]') ?>
                        </div>

			<?php include('_includes/v18_sidebar.php'); ?>
                    </div>
                </div>
<?php } ?>

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

    <?php if ( $posts->have_posts() && get_topic_category( get_the_category() ) !== "Uncategorized") { ?>
        <div class="ibm-article-band ibm-blog__postgrid">
            <div class="ibm-columns">
                <div class="ibm-col-1-1">
                        <h3 class="postgrid-title"><?php $my_theme = wp_get_theme(); _e('More', $my_theme->get( 'Name' )); ?> <?php echo get_topic_category( get_the_category() ); ?> <?php $my_theme = wp_get_theme(); _e('Stories', $my_theme->get( 'Name' )); ?></h3>
                </div>
            </div>
            <div class="ibm-columns" data-widget="setsameheight" data-items=".ibm-blog__postgrid-item-link">
                <?php
                while ( $posts->have_posts() ) : $posts->the_post(); ?>
                    <?php
                          if(esc_attr(get_option( 'post_listing_choice_homepage', '' )) == "post_listing_choice_homepage_stack")
                          {
                              include('_includes/post_listing_stack.php');
                          }
                          else
                          {
                              include('_includes/post_listing_grid.php');
                          }
                endwhile; ?>

            </div> <!-- .ibm-columns -->

        </div>  <!-- .ibm-blog__postgrid -->
    <?php } ?>

    </div>

    <?php get_template_part('_includes/v18_content_main_end'); ?>

<?php get_footer(); ?>
