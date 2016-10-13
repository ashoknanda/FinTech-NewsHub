<?php get_header(); ?>
  

  <?php get_template_part('_includes/v18_content_main_start'); ?>
  <?php $pimages = get_field('leadspace_image');
        $v18_sidebar = get_field('sidebar');
        $leadspace_title_size = get_field('leadspace_title_size');
    if(!$leadspace_title_size){
      $leadspace_title_size = 'ibm-h1';
    } ?>

<?php if($pimages != ''){ ?>
  <div id="ibm-leadspace-head" class="ibm-alternate <?php the_field('text_color'); ?>"
style="background-image: url('<?php echo $pimages['sizes']['size-1440']; ?>');">
<?php } else { ?>
                <div id="ibm-leadspace-head" class="ibm-alternate <?php the_field('text_color'); ?>"
                        style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/default-leadspace-1440x320.jpg);">
<?php } ?>
      <div id="ibm-leadspace-body">
          <div class="ibm-columns ibm-padding-top-3 ibm-padding-bottom-3">
              <div class="ibm-col-1-1"> <!-- ibm-center -->
                <h1 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight'); ?>"><?php echo the_field('display_title'); ?></h1>
                <p><?php echo the_field('description'); ?></p>
              </div>
          </div>
      </div>
  </div>

  <div class="ibm-columns ibm-padding-bottom-3">
    <div class="ibm-col-6-4 ibm-textcolor-gray-60 ibm-padding-top-2">
      <?php if (have_posts()) : while (have_posts()) : the_post();?>
        <?php the_content(); ?>
      <?php endwhile; endif; ?>
</div>
  <div class="ibm-blog__article">
  <div class="ibm-col-6-2 ibm-blog__article-side">
    <div class="ibm-blog__share">
        <?php if($v18_sidebar) {
      include('_includes/v18_sidebar.php');
    } ?>
  </div>
  </div>
  </div>


  <?php get_template_part('_includes/v18_content_main_end'); ?>

<?php get_footer(); ?>