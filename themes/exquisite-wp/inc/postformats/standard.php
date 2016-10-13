<?php 
$image_id = get_post_thumbnail_id();
$image_url = wp_get_attachment_image_src($image_id,'full'); $image_url = $image_url[0];
?>
<div class="post-gallery nolink">
	<?php 
		if(is_single()) {
			the_post_thumbnail('single'); 
		} else { 
			the_post_thumbnail('blog');  
		}
	?>
</div>
<?php
if ( get_post_meta( get_the_ID(), 'ibm_post_image_source', true ) ) {
?>
<div class="div-article-image-source">
  <?php echo get_post_meta( get_the_ID(), 'ibm_post_image_source', true ); ?>
</div>
<?php
}
?>