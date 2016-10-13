<?php

function rpgHeaderTweets() {

	$return = ''; // HTML to be returned at the end

	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	$settings = array(
	    'oauth_access_token' => ot_get_option('twitter_bar_accesstoken'),
	    'oauth_access_token_secret' => ot_get_option('twitter_bar_accesstokensecret'),
	    'consumer_key' => ot_get_option('twitter_bar_consumerkey'),
	    'consumer_secret' => ot_get_option('twitter_bar_consumersecret')
	);

	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$getfield = '?screen_name=ibmsecurity';
	$requestMethod = 'GET';

	$twitter = new TwitterAPIExchange($settings);

	$response = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();

	$response = json_decode($response);

	$i = 1;
	if (!empty($response)) {
		foreach($response as $response ) {
			$return .= '<div class="item"><span class="dot">•</span>';
			$return .= convert_links($response->text);
			$return .= '<a href="https://twitter.com/ibmsecurity" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @ibmsecurity</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			$return .= '</div>';
			if ($i++ == 5) break;
		}
	}

	return $return;

}

//convert links to clickable format
function convert_links($status,$targetBlank=true,$linkMaxLen=250){
 
	// the target
	$target=$targetBlank ? " target=\"_blank\" " : "";
	 
	// convert link to url
	$status = preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);
	 
	// convert @ to follow
	$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);
	 
	// convert # to search
	$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);
	 
	// return the status
	return $status;
}

//convert dates to readable format	
function relative_time($a) {
	//get current timestampt
	$b = strtotime("now"); 
	//get timestamp when tweet created
	$c = strtotime($a);
	//get difference
	$d = $b - $c;
	//calculate different time values
	$minute = 60;
	$hour = $minute * 60;
	$day = $hour * 24;
	$week = $day * 7;
		
	if(is_numeric($d) && $d > 0) {
		//if less then 3 seconds
		if($d < 3) return "right now";
		//if less then minute
		if($d < $minute) return floor($d) . " seconds ago";
		//if less then 2 minutes
		if($d < $minute * 2) return "about 1 minute ago";
		//if less then hour
		if($d < $hour) return floor($d / $minute) . " minutes ago";
		//if less then 2 hours
		if($d < $hour * 2) return "about 1 hour ago";
		//if less then day
		if($d < $day) return floor($d / $hour) . " hours ago";
		//if more then day, but less then 2 days
		if($d > $day && $d < $day * 2) return "yesterday";
		//if less then year
		if($d < $day * 365) return floor($d / $day) . " days ago";
		//else return more than a year
		return "over a year ago";
	}
}	


?>