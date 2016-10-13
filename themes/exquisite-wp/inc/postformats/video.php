<?php global $wp_embed;
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'full'); $image_url = $image_url[0]; ?>
<div class="post-gallery flex-video widescreen">
	<?php $embed = get_post_meta($post->ID, 'post_video', TRUE); ?>
	<?php if ($embed !='') { ?>
	  <?php echo $wp_embed->run_shortcode('[embed]'.$embed.'[/embed]'); ?>
	<?php } ?>
	
</div>