<?php get_header(); ?>
<!-- <script src="<?php //echo get_stylesheet_directory_uri().'/assets/js/infinite_load_fw.js'; ?>"></script> -->

  <?php get_template_part('_includes/v18_content_main_start'); ?>
  <?php $pimages = get_field('leadspace_image');
	$fullwidth = get_field('full_width');
  $v18_sidebar = get_field('sidebar');
  $columns = get_field('columns');
    $leadspace_title_size = get_field('leadspace_title_size');
    if(!$leadspace_title_size){
      $leadspace_title_size = 'ibm-h2';
    } ?>

<?php if($pimages!=''){ ?>
  <div id="ibm-leadspace-head" class="ibm-alternate <?php the_field('text_color'); ?>"
	style="background-image: url('<?php echo $pimages['sizes']['size-1440']; ?>');">
  <?php } else { ?>
                <div id="ibm-leadspace-head" class="ibm-alternate <?php the_field('text_color'); ?>"
                        style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/default-leadspace-1440x320.jpg);">
<?php } ?>
      <div id="ibm-leadspace-body">
          <div class="ibm-columns ibm-padding-top-3 ibm-padding-bottom-3">
              <div class="ibm-col-1-1"> <!-- ibm-center -->
                <h2 class="ibm-alternate <?php echo $leadspace_title_size; ?> ibm-alternate <?php the_field('leadspace_title_weight'); ?>"><?php echo the_field('display_title'); ?></h2>
                <p><?php echo the_field('description'); ?></p>
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

      <?php if (have_posts()) : while (have_posts()) : the_post();?>
<div class="ibm-columns ibm-padding-bottom-3 ibm-padding-top-3">
        <div class="ibm-col-1-1">
        <?php the_content(); ?>
        </div>
      </div>
      <div class="ibm-columns">
        <div class="ibm-col-<?php echo $columns; ?>">
        <ul class="ibm-link-list">
      <?php
        $categoriesDisplayed = 0;
        $categories = get_categories();
        $string_temp = "";
        $columnSplit = 1;
        $numCol = count($categories);
        if($columns == '2-1'){
          $columnSplit = 2;
        }
        if($columns == '6-2'){
          $columnSplit = 3;
        }
        $numCol = $numCol/$columnSplit;
        foreach ( $categories as $category )
        {
                if($category->name == 'Featured Carousel' || $category->name == 'Uncategorized'){
                  continue;
                }
                $categoriesDisplayed++;
                if($categoriesDisplayed>$numCol){
                  $string_temp .= '</ul></div>';
                  $string_temp .= '<div class="ibm-col-'.$columns.'"><ul class="ibm-link-list">';
                  $categoriesDisplayed = 0;
                }
                $cat_url = get_category_link(get_cat_ID($category->name));
                $string_temp .= '<li><a class="ibm-forward-link" href="';
                $string_temp .= $cat_url;
                $string_temp .= '">';
                $string_temp .= $category->name;
                $string_temp .= '</a></li>';
        }
        echo rtrim($string_temp);
         ?>
         </ul>
         </div>
         </div>
      <?php endwhile; endif; ?>
 </div>
</div>




  <?php get_template_part('_includes/v18_content_main_end'); ?>

<?php get_footer(); ?>
