<?php get_header(); ?>

  <?php get_template_part('_includes/v18_content_main_start'); ?>
<!-- Start dummy div -->
<div class="ibm-background-white-core">  
  <?php $pimages = get_field('leadspace_image');
  $fullwidth = get_field('full_width');
  $v18_sidebar = get_field('sidebar');
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

  <div class="ibm-columns ibm-padding-bottom-3 ">
  <div class="ibm-col-1-1 ibm-textcolor-gray-60 ibm-padding-top-3 ibm-padding-bottom-3">
<!-- <?php if($fullwidth){ ?>
    <div class="ibm-col-1-1 ibm-textcolor-gray-60 ibm-padding-top-3 ibm-padding-bottom-3">
<?php } else { ?>
    <div class="ibm-col-6-4 ibm-textcolor-gray-60 ibm-padding-top-3 ibm-padding-bottom-3">
<?php } ?> -->  
      <?php if (have_posts()) : while (have_posts()) : the_post();?>
        <?php the_content(); ?>
      <?php endwhile; endif; ?>
  </div>
<?php if(!$fullwidth){ ?>
    <div class="ibm-col-6-2 ibm-about-side ibm-padding-top-3">
    <?php if($v18_sidebar) {
      include('_includes/v18_sidebar.php');
    } ?>
</div>
<?php } ?>
</div>
</div> <!-- end dummy div -->



  <?php get_template_part('_includes/v18_content_main_end'); ?>

<?php get_footer(); ?>
