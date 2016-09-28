<aside class="single-meta">

	<div class="author">

		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="All Posts by <?php the_author(); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 70); ?></a>

		<p class="author_name"><?php the_author_posts_link(); ?></p>

		<?php if (get_the_author_meta('_ibm_contributor_title')) { ?><p class="author_title"><?php echo get_the_author_meta('_ibm_contributor_title'); ?></p><?php } ?>

		<?php if (get_the_author_meta('twitter')) : ?>
			<a href="<?php echo get_the_author_meta('twitter'); ?>" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow <?php the_author(); ?></a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<?php endif; ?>

		<p class="author_bio">
		<?php
			$bio = wordwrap(get_the_author_meta('description'), 180);
			$bio = explode("\n", $bio);
			$bio = $bio[0] . '...';
			echo $bio;
		?>
		</p>

		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="All Posts by <?php the_author(); ?>" class="author_link">See All Posts</a>

	</div>
	<?php if(get_post_meta($post->ID, 'minigallery', TRUE) == 'yes') { ?>
		<div class="widget cf widget_minigallery" rel="gallery">
			<h6 class="force"><?php _e( 'Mini Gallery', THB_THEME_NAME ); ?></h6>
		<?php 
				$attachments = get_post_meta($post->ID, 'pp_gallery_slider', TRUE);
				$attachment_array = explode(',', $attachments);
		?>
		<?php foreach ($attachment_array as $attachment) : ?>
		    <?php
		    		$attachmentmeta = get_post($attachment);
		        $src = wp_get_attachment_image_src($attachment, array(110, 80)); 
		        $image_url = wp_get_attachment_image_src($attachment,'full'); $image_url = $image_url[0];
		    ?>
        <a href="<?php echo $image_url; ?>" class="enlarge" title="<?php echo $attachmentmeta->post_excerpt; ?>"><img src="<?php echo $src[0]; ?>" /></a>
		<?php endforeach; ?>
		</div>
	<?php } ?>
</aside>