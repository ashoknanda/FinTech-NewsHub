<?php
$featured_params     = array(
    'paged'             => 1,
    'post_type'         => 'Post',
    'posts_per_page'    => 3,
    'orderby'           => 'date'
);

$featured_params['category__and'] =  get_cat_ID('Featured Carousel'); // category_name = featured
if($featured_params['category__and'] !== 0)
{
    $featured_posts      = new WP_Query($featured_params);
    $max        = $featured_posts->max_num_pages;

    ?>
    <div class="ibm-band ibm-background-white-core ibm-padding-top-2">
        <div class="ibm-columns">
            <div class="ibm-col-1-1" data-widget="setsameheight" data-items=".carouselPost">

            <?php
            if ( $featured_posts->have_posts() )
            {
            ?>
                <div data-widget="carousel">
                <?php
                $template_directory = get_template_directory_uri();
                $leadspace_default = $template_directory  . '/default-leadspace-1440x320.jpg';
                while ( $featured_posts->have_posts() )
                {
                    $featured_posts->the_post();
                    $pimages = get_field('leadspace_image');
                    $color = get_field('text_color');
                    $categories = array();
                    $pcategories = get_the_category();
                    foreach($pcategories as $pcategory)
                    {
                        if($pcategory->name !== 'Featured Carousel' && $pcategory->name !== 'Uncategorized')
                        {
                            array_push($categories, $pcategory);
                        }
                    }
                    ?>
                    <div class="ibm-padding-bottom-1">
                    <div class="<?php echo $color; ?> ibm-padding-content" data-post-id-"<?php the_ID(); ?>"
                        <?php
                        if($pimages['url']=="")
                        {
                            echo 'style="background-image: url(\''. $leadspace_default.'\'); background-size: cover; background-position: center center;"';
                        }
                        else
                        {
                            echo 'style="background-image: url(\''. $pimages['url'].'\'); background-size: cover; background-position: center center;"';
                        }
                        ?>>
                        <div class="ibm-columns ibm-padding-content ibm-padding-top-0 ibm-padding-bottom-0">
                        <div class="ibm-col-2-1 ibm-padding-content ibm-padding-top-0 ibm-padding-bottom-0">
                            <div class="carouselPost">
                            <?php if(!empty($categories) && $categories[0]->name != ''): ?>
                            <h4 class="ibm-h4 ibm-small"><a href="<?php echo get_category_link($categories[0]->cat_ID); ?>" target="_self"><span class="<?php echo $color; ?>"><?php echo $categories[0]->name; ?></span></a></h4>
                            <?php endif; ?>

                            <h1 class="ibm-h1 ibm-padding-bottom-2"><?php the_title(); ?></h1>
                            <article class="ibm-padding-bottom-1 <?php echo $color; ?>"><?php the_excerpt(); ?></article>
                            <p class="ibm-light ibm-button-link ibm-padding-bottom-0"><a href="<?php echo the_permalink(); ?>" class="ibm-btn-pri <?php echo $btn_color; ?>"><?php $my_theme = wp_get_theme(); _e('Read More', $my_theme->get( 'Name' )); ?></a></p>
                            </div>
                        </div>
                    </div>
                    </div>
                   </div>
                <?php
                }
                ?>
                </div>
            <?php
            }
            ?>

            </div>
        </div>
    </div>

    <?php wp_reset_postdata();
}
