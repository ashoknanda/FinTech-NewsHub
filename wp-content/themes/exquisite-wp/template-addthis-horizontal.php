<!-- AddThis Button BEGIN -->
<?php 
$post_date = the_date('', '', '', FALSE);
$post_date = strtotime($post_date);
$http_change_date = strtotime('2015-8-4');
$share_this_permalink = get_permalink();

if ($post_date < $http_change_date){
	$share_this_permalink = str_replace('https','http', $share_this_permalink); 
}
?>
<div class="addthis_toolbox addthis_default_style"  addthis:url="<?php echo $share_this_permalink; ?>">
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
    		via: "ibmsecurity"
        }
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
</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53591bdd1bf9985c"></script>
<!-- AddThis Button END -->