<?php
 
/*
Plugin Name: NewsHub Social Media Count
Plugin URI: http://www.ibm.com/insights/marketing
Description: Display social media count.
Version: 1.0
Author: Umesh kumar
*/

class Newshub_Social_Count {
 
    function __construct() {
 
        add_shortcode( 'facebook-share', array( $this, 'facebook_share' ) );
 
        add_shortcode( 'facebook-page-like', array( $this, 'facebook_page_like' ) );
 
        add_shortcode( 'pinterest-count', array( $this, 'pinterest_count' ) );
 
        // add_shortcode( 'tweet-count', array( $this, 'tweet_count' ) );
 
        add_shortcode( 'google-plus', array( $this, 'google_plus_count' ) );
 
        add_shortcode( 'linkedin-share', array( $this, 'linkedin_share' ) );
 
        add_shortcode( 'stumbledupon', array( $this, 'stumbledupon_share' ) );
    }

	function get_response_body( $url, $type = '' ) {
	 
	    $response = wp_remote_get( $url );
	    $body     = wp_remote_retrieve_body( $response );
	 
	    // if api call is pinterest, make the response pure json
	    if ( $type == 'pinterest' ) {
	        $body = preg_replace( '/^receiveCount\((.*)\)$/', '\\1', $body );
	    }
	 
	    return json_decode( $body );
	}  
	
	function post_response_body( $url ) {
	 
	    $query = '
	    [{
	        "method": "pos.plusones.get",
	        "id": "p",
	        "params": {"nolog": true, "id": "' . $url . '", "source": "widget", "userId": "@viewer", "groupId": "@self"},
	        "jsonrpc": "2.0",
	        "key": "p",
	        "apiVersion": "v1"
	    }]
	    ';
	 
	    $response = wp_remote_post(
	        'https://clients6.google.com/rpc',
	        array(
	            'headers' => array( 'Content-type' => 'application/json' ),
	            'body'    => $query
	        )
	    );
	 
	    return json_decode( wp_remote_retrieve_body( $response ), true );
	}	


	function facebook_share( $atts ) {
        $url      = $atts['url'];
        $api_call = 'http://graph.facebook.com/?id=' . $url;
        $count = $this->get_response_body( $api_call )->share->share_count;
        // return '<span style="padding:10px;display:inline-block;">'.$this->get_response_body( $api_call )->shares . ' Facebook Likes & Shares</span>';
        return $count == 0?0:$count;
 
    }

    function facebook_page_like( $atts ) {
        $username = $atts['username'];
        $api_call = 'http://graph.facebook.com/?id=http://facebook.com/' . $username;
        $count = $this->get_response_body( $api_call )->likes;
 
        // return '<span style="padding:10px;display:inline-block;">'.$this->get_response_body( $api_call )->likes . ' Facebook Page Like</span>';
        return $count;
    }

    function pinterest_count( $atts ) {
 
        $url      = $atts['url'];
        $api_call = 'http://api.pinterest.com/v1/urls/count.json?callback%20&url=' . $url;
        $count = $this->get_response_body( $api_call, 'pinterest' )->count;
 
        // return '<span style="padding:10px;display:inline-block;">'.$this->get_response_body( $api_call, 'pinterest' )->count . ' Pinterest Pins</span>';
        return $count ;
    }

    // function tweet_count( $atts ) {
 
    //     $url      = $atts['url'];
    //     $api_call = 'https://cdn.api.twitter.com/1/urls/count.json?url=' . $url;
 
    //     return $this->get_response_body( $api_call )->count . ' Tweets';
 
    // }

    function linkedin_share( $atts ) {
        $url      = $atts['url'];
        $api_call = 'https://www.linkedin.com/countserv/count/share?url=' . $url . '&format=json';
        $count    = $this->get_response_body( $api_call )->count;
 
        // return '<span style="padding:10px;display:inline-block;">'.$count . ' LinkedIn Shares</span>';   
        return $count;
        
    }

    function stumbledupon_share( $atts ) {
        $url      = $atts['url'];
        $api_call = 'https://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $url;
        $count    = $this->get_response_body( $api_call )->result->views;
 
        // return '<span style="padding:10px;display:inline-block;">'.$count . ' Stumbles</span>';
        return $count == 0?'':$count;
    }

    function google_plus_count( $atts ) {
        $url   = $atts['url'];
        $postURL = $this->post_response_body( $url );
        $count = $postURL[0]['result']['metadata']['globalCounts']['count'];
 
        // return '<span style="padding:10px;display:inline-block;">'.$count . ' Google Plus</span>';
        return $count;
    }

    static function get_instance() {
        static $instance = false;
 
        if ( ! $instance ) {
            $instance = new self;
        }
 
    }

} 

Newshub_Social_Count::get_instance();

