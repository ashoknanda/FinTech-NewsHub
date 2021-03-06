<?php get_header(); ?>

	<?php get_template_part('_includes/v18_content_main_start');
  $leadspace_title_size = get_field('leadspace_title_size');
    if(!$leadspace_title_size){
      $leadspace_title_size = 'ibm-h1';
    } ?>



  <?php $pimages = get_field('leadspace_image'); ?>
<?php if($pimages!= ''){ ?>
  <div id="ibm-leadspace-head" class="ibm-alternate <?php the_field('text_color'); ?>"
      data-desktop-lg-retina="<?php echo $pimages['sizes']['size-2880']; ?>"
      data-desktop-lg="<?php echo $pimages['sizes']['size-1440']; ?>"
      data-desktop-retina="<?php echo $pimages['sizes']['size-2400']; ?>"
      data-desktop="<?php echo $pimages['sizes']['size-1200']; ?>"
      data-tablet-retina="<?php echo $pimages['sizes']['size-1200']; ?>"
      data-tablet="<?php echo $pimages['sizes']['size-780']; ?>"
      data-mobile-retina="<?php echo $pimages['sizes']['size-780']; ?>"
      data-mobile="<?php echo $pimages['sizes']['size-380']; ?>"
      style="background-image: url('<?php echo $pimages['url']; ?>')">
      <?php } else { ?>
                <div id="ibm-leadspace-head" class="ibm-padding-top-2 ibm-padding-bottom-2 ibm-alternate <?php the_field('text_color'); ?>"
                        style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/default-leadspace-1440x320.jpg);">
<?php } ?>
      <div id="ibm-leadspace-body">
          <div class="ibm-columns ibm-padding-top-3 ibm-padding-bottom-3">
              <div class="ibm-col-1-1"> <!-- ibm-center -->
                <h1 class="<?php echo $leadspace_title_size; ?> <?php the_field('leadspace_title_weight'); ?>"><?php echo get_field('display_title'); ?></h1>
                <p class="<?php the_field('leadspace_description_size'); ?> <?php the_field('leadspace_description_weight'); ?>"><?php echo the_field('description'); ?></p>
              </div>
          </div>
      </div>
  </div>

	<div id="content" class="ibm-blog__postgrid">

		<div class="ibm-columns ibm-padding-top-2" data-widget="setsameheight" data-items=".ibm-blog__post-author">

<?php

while (have_posts()):
	the_post(); ?>


<?php
	$args = array(
		'blog_id' => $GLOBALS['blog_id'],
		'role' => '',
		'meta_key' => '',
		'meta_value' => '',
		'meta_compare' => '',
		'meta_query' => array() ,
		'date_query' => array() ,
		'include' => array() ,
		'exclude' => array() ,
		'orderby' => 'login',
		'order' => 'ASC',
		'offset' => '',
		'search' => '',
		'number' => '',
		'count_total' => false,
		'fields' => 'all',
		'who' => ''
	);
	$users = get_users($args);
	$count = 1;
?>
  <!-- start listing loop -->

<?php
	foreach($users as $user): ?>


  <?php

		// var_dump($user);

		$uid = $user->data->ID;
		$ulink = get_author_posts_url($uid);
		$uname = $user->data->display_name;
    $user_info = get_userdata($uid);
    $uavatar = get_field('author_icon', 'user_' . $uid);
    $udescription = get_field('job_title', 'user_' . $uid . '');;
		$u_post_count = count_user_posts($uid);

		// var_dump($uthumb);

		$u_social_twitter = get_field('ibm_author_social_twitter', 'user_' . $uid . '');
		$u_social_linkedin = get_field('ibm_author_social_linkedin', 'user_' . $uid . '');
		$u_social_facebook = get_field('ibm_author_social_facebook', 'user_' . $uid . '');

		// var_dump('posts:' . $u_post_count);

?>

  <?php
		if ($u_post_count > 0): ?>
  <div class="ibm-col-6-2 ibm-col-medium-6-3 ibm-blog__post-author ibm-center">
    <div class="inner">
            <div class="ibm-blog__post-author-thumb ibm-blog__contributor-thumb">
            <?php if($uavatar != ""){ ?>
                <div><a href="<?php echo $ulink ?>"><div style="background-image:url('<?php echo $uavatar; ?>'); background-size:cover; background-position:center center;" ></div></a></div>
                <?php } else { ?>
                <div><a href="<?php echo $ulink ?>"><?php echo get_avatar($user_info->user_email); ?></a></div>
                <?php } ?>
            </div>
      <h3 class="ibm-padding-bottom-0"><a href="<?php echo $ulink; ?>"><?php echo $uname; ?></a></h3>
	<p class="auth-description ibm-padding-bottom-0"><?php echo $udescription; ?></p>
        <p class="postcount ibm-padding-bottom-0"><a href="<?php echo $ulink; ?>">Posts: <span><?php echo $u_post_count; ?></span></a></p>
      <div>
        <p class="ibm-icononly ibm-center ibm-blog__author-social">
            <!-- twitter -->
        <?php
			if ($u_social_twitter): ?>
          <a class="ibm-twitter-encircled-link" href="<?php echo $u_social_twitter; ?>" target="blank"></a>
        <?php
			endif; ?>

        <!-- linkedin -->
        <?php
			if ($u_social_linkedin): ?>
          <a class="ibm-linkedin-encircled-link" href="<?php echo $u_social_linkedin; ?>" target="blank"></a>
        <?php
			endif; ?>

        <!-- facebook -->
        <?php
			if ($u_social_facebook): ?>
          <a class="ibm-facebook-encircled-link" href="<?php echo $u_social_facebook; ?>" target="blank"></a>
        <?php
			endif; ?>
      </p>
	</div>
    </div>
  </div>

  <?php
		endif; ?>

<?php
	endforeach; ?>

</div>
</div>

<?php
endwhile; ?>





<?php get_template_part('_includes/v18_content_main_end'); ?>

<?php get_footer(); ?>