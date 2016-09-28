<?php

/*-----------------------------------------------------------------------------------

	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file.
	You have been warned!

-------------------------------------------------------------------------------------*/


// Define Theme Name for localization
if (!defined('THB_THEME_NAME')) {
	define('THB_THEME_NAME', 'exquisite');
}

date_default_timezone_set('America/New_York');

// Translation
add_action('after_setup_theme', 'lang_setup');
function lang_setup(){
	load_theme_textdomain(THB_THEME_NAME, get_template_directory() . '/inc/languages');
}

// Option-Tree Theme Mode
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
include_once( 'inc/ot-fonts.php' );
include_once( 'inc/ot-radioimages.php' );
include_once( 'inc/ot-metaboxes.php' );
include_once( 'inc/ot-themeoptions.php' );

if ( ! class_exists( 'OT_Loader' ) ) {
	include_once( 'admin/ot-loader.php' );
}
// Script Calls
require_once('inc/script-calls.php');

// Breadcrumbs
require_once('inc/breadcrumbs.php');

// Excerpts
require_once('inc/excerpts.php');

// Custom Titles
require_once('inc/wptitle.php');

// Pagination
require_once('inc/wp-pagenavi.php');

// Post Formats
add_theme_support('post-formats', array('video', 'image', 'gallery'));

// Masonry Load More
require_once('inc/masonry-ajax.php');
add_action("wp_ajax_nopriv_thb_ajax_home", "load_more_posts_home");
add_action("wp_ajax_thb_ajax_home", "load_more_posts_home");
add_action("wp_ajax_nopriv_thb_ajax_topics", "load_more_posts");
add_action("wp_ajax_thb_ajax_topics", "load_more_posts");
add_action("wp_ajax_nopriv_thb_ajax_home2", "load_more_posts_type2");
add_action("wp_ajax_thb_ajax_home2", "load_more_posts_type2");
add_action("wp_ajax_nopriv_thb_ajax_contributors", "load_more_contributors");
add_action("wp_ajax_thb_ajax_contributors", "load_more_contributors");
add_action("wp_ajax_nopriv_thb_ajax_media", "load_more_media");
add_action("wp_ajax_thb_ajax_media", "load_more_media");
add_action("wp_ajax_nopriv_thb_ajax_category", "load_more_category");
add_action("wp_ajax_thb_ajax_category", "load_more_category");
add_action("wp_ajax_nopriv_thb_ajax_news", "load_more_news");
add_action("wp_ajax_thb_ajax_news", "load_more_news");
add_action("wp_ajax_nopriv_thb_ajax_webinars", "load_more_webinars");
add_action("wp_ajax_thb_ajax_webinars", "load_more_webinars");

// TGM Plugin Activation Class
require_once('inc/class-tgm-plugin-activation.php');
require_once('inc/plugins.php');

// Enable Featured Images
require_once('inc/postthumbs.php');

// Activate WP3 Menu Support
require_once('inc/wp3menu.php');

// Enable Sidebars
require_once('inc/sidebar.php');

// Custom Comments
require_once('inc/comments.php');

// Widgets
require_once('inc/widgets.php');

// Like functionality
require_once('inc/themelike.php');

// Related Posts
require_once('inc/related.php');

// Weather
require_once('inc/weather.php');

// Custom Login Logo
require_once('inc/customloginlogo.php');

// Do Shortcodes inside Widgets
add_filter('widget_text', 'do_shortcode');

// Twitter oAuth
require_once('inc/twitter_oauth.php');
require_once('inc/twitter_gettweets.php');

// Misc 
require_once('inc/misc.php');

// Mega Menu Functionality
require_once('inc/rpg-megamenu-walker.php');

// Shortcodes (mostly adding support for shortcodes used on their old site)
require_once('inc/rpg-shortcodes.php');

// Custom Meta Boxes
require_once('inc/rpg-metaboxes.php');

// Custom Post Types
require_once('inc/rpg-cpt-ibm_event.php');
require_once('inc/rpg-cpt-ibm_media.php');
require_once('inc/rpg-cpt-ibm_news.php');

// Custom Taxonomy
require_once('inc/rpg-taxonomy-display.php');

// RPG Header Twitter Feed (and Twitter API Library)
require_once('inc/TwitterAPIExchange.php');
require_once('inc/rpg-header-tweets.php');

// RPG Widgets (in individual files for ease of modifying)
require_once('inc/rpg-widget-upcomingwebinars.php');
require_once('inc/rpg-widget-ondemandwebinars.php');
require_once('inc/rpg-widget-categoryposts.php');
require_once('inc/rpg-widget-recentposts.php');
require_once('inc/rpg-widget-recent-xforce.php');
require_once('inc/rpg-widget-recentnews.php');
require_once('inc/rpg-widget-trendingposts.php');
require_once('inc/rpg-widget-followbox.php');
require_once('inc/rpg-widget-categoryrssbox.php');
require_once('inc/rpg-widget-rssbox.php');
require_once('inc/rpg-widget-rssbox-news.php');
require_once('inc/rpg-widget-rssbox-xforce.php');
require_once('inc/rpg-widget-newsletterbox-x-force.php');
require_once('inc/rpg-widget-topstories.php');
require_once('inc/rpg-widget-topnews.php');
require_once('inc/rpg-widget-fearuredevent.php');
require_once('inc/rpg-widget-fearuredmedia.php');
require_once('inc/rpg-widget-addtocalendar.php');
require_once('inc/rpg-widget-twitter.php');
require_once('inc/rpg-ajax-newscounter.php');
require_once('inc/rpg-quantcast-tags.php');

require_once('inc/rpg-user.php');

require_once('inc/coremetric.php');

//Remove posts and news items that are hidden on contributor pages
function conditional_contributor_hidden_posts( $query ) {

    if ( is_author() ) {
        
        $query->set( 'tax_query', 
        	array(
				array(
					'taxonomy'  => 'hide_posts',
					'field'     => 'slug',
					'terms'     => 'contributors-page', // exclude items tagged with contributors-page
					'operator'  => 'NOT IN'
				)
			)
		);
        return;
    }

}
add_action( 'pre_get_posts', 'conditional_contributor_hidden_posts', 1 );

?>