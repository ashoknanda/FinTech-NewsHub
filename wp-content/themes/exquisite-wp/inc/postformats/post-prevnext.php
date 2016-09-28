<?php 
$post_date = the_date('', '', '', FALSE);
$post_date = strtotime($post_date);
$http_change_date = strtotime('2015-8-4');
$share_this_permalink = get_permalink();

if ($post_date < $http_change_date){
	$share_this_permalink = str_replace('https','http', $share_this_permalink); 
}
?>
<!-- Start Share -->
<aside id="sharethispost" class="sharethispost cf hide-on-print">
	<div class="placeholder">
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style" addthis:url="<?php echo $share_this_permalink; ?>">
			<a class="addthis_button_facebook_share" fb:share:layout="button_count"></a>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
			<a class="addthis_button_tweet"></a>
			<a class="addthis_button_linkedin_counter"></a>
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_counter addthis_pill_style"></a>
		</div>
		<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
		<script type="text/javascript">
		var addthis_share = addthis_share || {}
		addthis_share = {
	        passthrough : {
                twitter: {
                		via: "ibmsecurity",
                        //text: "TEXT"
                },
				url_transforms : {
					shorten: {
						twitter: 'bitly'
					}
				}, 
				shorteners : {
					bitly : {} 
				}
	        }
		}
		</script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53591bdd1bf9985c"></script>
		<!-- AddThis Button END -->
	</div>
	<a href="#" class="sharenow"><?php _e( 'Share This Article', THB_THEME_NAME ); ?> <i class="fa fa-plus"></i></a>
</aside>
<!-- End Share -->
<!-- Start Previous / Next Post -->
<?php 
	$prev_post = get_adjacent_post(false, '', true);
	
	if(!empty($prev_post)) {
		$excerpt = $prev_post->post_content;
		$previd = $prev_post->ID;
		$thumb = get_the_post_thumbnail($previd, 'slider');
		
		echo '<div class="post post-navi hide-on-print prev"><div class="post-gallery">'.$thumb.'<div class="overlay"></div></div><div class="post-title"><h2><a href="' . get_permalink($previd) . '" title="' . $prev_post->post_title . '">' . ShortenText($prev_post->post_title, 50). '</a></h2></div></div>'; 
	}
?>
<?php
	$next_post = get_adjacent_post(false, '', false);
	
	if(!empty($next_post)) {
		$excerptnext = $next_post->post_content;
		$nextid = $next_post->ID;
		$thumb = get_the_post_thumbnail($nextid, 'slider');
		
		echo '<div class="post post-navi hide-on-print next"><div class="post-gallery">'.$thumb.'<div class="overlay"></div></div><div class="post-title"><h2><a href="' . get_permalink($nextid) . '" title="' . $next_post->post_title . '">' . ShortenText($next_post->post_title, 50). '</a></h2></div></div>'; 
	}
?>
<?php wp_reset_query(); ?>
<!-- End Previous / Next Post -->