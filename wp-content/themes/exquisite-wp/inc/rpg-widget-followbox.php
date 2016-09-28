<?php
class RPG_FollowBox extends WP_Widget {

	//process the new widget
	public function __construct() {
		$option = array(
			'classname' => 'RPG_FollowBox',
			'description' => 'RPG - Follow Box'
		);

		$this->WP_Widget('RPG_FollowBox', 'RPG - Follow Box', $option);

	}

	//build the widget settings form
	function form($instance) {
		echo '<p>Blue box with follow buttons for Facebook and LinkedIn.</p>';
	}

	//save the widget settings
	function update($new_instance, $old_instance) {
		return $old_instance;
	}

	//display the widget
	function widget($args, $instance) {

		global $post;
		$category = get_the_category($post->ID);

		?>

<?php
$post_date = the_date('', '', '', FALSE);
$post_date = strtotime($post_date);
$http_change_date = strtotime('2015-8-4');
$share_this_permalink = get_permalink();

if ($post_date < $http_change_date){
	$share_this_permalink = str_replace('https','http', $share_this_permalink);
}
?>
		<div class="widget cf widget_follow_box">
			<div class="row twelve columns">
				<!-- AddThis Follow BEGIN -->
				<div class="addthis_toolbox addthis_32x32_style addthis_default_style" addthis:url="<?php echo $share_this_permalink; ?>">
					<div class="three columns">
						<a class="addthis_button_facebook_follow" addthis:userid="ibmsecurity"></a>
					</div>
					<div class="three columns">
						<a class="addthis_button_linkedin_follow" addthis:userid="ibm-security" addthis:usertype="company"></a>
					</div>
					<div class="three columns">
						<a class="addthis_button_twitter_follow" addthis:userid="ibmsecurity"></a>
					</div>
					<div class="three columns">
						<a href="https://www.youtube.com/c/IBMSecurity" target="_blank"><img src="<?php echo esc_url( home_url( '/' ) ); ?>
wp-content/themes/exquisite-wp/assets/img/youtube_icon.png"></a>
						<!-- <a class="addthis_button_youtube_follow" addthis:userid="ibmsecuritysolutions"></a>
					 --></div>
				</div>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53591bdd1bf9985c"></script>
				<!-- AddThis Follow END -->
			</div>
		</div>

		<?php
	}

}

add_action('widgets_init', 'RPG_FollowBox_register');
function RPG_FollowBox_register() {
	register_widget('RPG_FollowBox');
}
?>
