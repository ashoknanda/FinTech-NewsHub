<?php

$featured_params     = array(
    'paged'             => 1,
    'post_type'         => 'Post',
    'posts_per_page'    => 3,
    'orderby'           => 'date',
);

$featured_params['category__and'] =  get_cat_ID('Featured Carousel'); // category_name = featured


$featured_posts      = new WP_Query($featured_params);
$max        = $featured_posts->max_num_pages;

?>
<div class="ibm-band ibm-background-white-core">
<div class="ibm-columns">
<div class="ibm-col-1-1" data-widget="setsameheight" data-items=".ibm-band">
<div data-widget="carousel" data-arrows="true" data-autoplay="true" class="ibm-carousel__controls--dark">
<?php if ( $featured_posts->have_posts() ) : while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>

    <?php
        $pimages = get_field('leadspace_image');

        $btn_color = '';
        $alternate = '';
        $color = get_field('text_color');

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
    ?>


    <div class="ibm-columns ibm-padding-top-2 <?php echo $alternate; ?>">
    <div class="ibm-col-1-1 ibm-blog__postgrid-item ibm-blog__featured" data-post-id-"<?php the_ID(); ?>">

        <div class="ibm-band ibm-blog__featured-article">
		<div class="ibm-blog__featured-area">
      <?php if($pimages['url']==""){ ?>
                      <div class="ibm-home-featured-top ibm-no-mobile"
    style="background-image: url('<?php echo $leadspace_default; ?>');"></div>
      <?php } else { ?>
                <div class="ibm-home-featured-top ibm-no-mobile"
		style="background-image: url('<?php echo $pimages['url']; ?>');"></div>
      <?php } ?>
                <div class="ibm-home-featured-content <?php echo $color; ?>">
                    <?php if(!empty($categories) && $categories[0]->name != ''): ?>
                      <a href="<?php echo get_category_link($categories[0]->cat_ID); ?>"><h4 class="category <?php echo $color; ?>"><?php echo $categories[0]->name; ?></h4></a>
                    <?php endif; ?>
                    <h1 class="ibm-padding-top-1 ibm-h1 <?php echo $color; ?>"><?php the_title(); ?></h1>
                    <article class="<?php echo $color; ?>"><?php the_excerpt(); ?></article>
                    <p class="ibm-button-link ibm-padding-bottom-1"><a href="<?php echo the_permalink(); ?>" class="ibm-btn-pri <?php echo $btn_color; ?>"><?php $my_theme = wp_get_theme(); _e('Read More', $my_theme->get( 'Name' )); ?></a></p>
                </div>

        </div><!-- .ibm-band -->
	</div>
    </div>
   </div>



<?php endwhile; endif; ?>
</div>
</div>
</div>
</div>

<?php wp_reset_postdata(); ?>