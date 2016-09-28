<?php

// Custom Meta Boxes Setup
// Library Source: https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress
add_filter( 'cmb_meta_boxes', 'ibm_metaboxes' );
function ibm_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_ibm_';

	/* ----------------------------------------------------- */
	// Posts Metabox
	/* ----------------------------------------------------- */
	$meta_boxes['posts1'] = array(
		'id'         => 'test_metabox',
		'title'      => 'Options &amp; Settings',
		'pages'      => array( 'post', ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
				'name'    => 'Featured Post',
				'desc'    => '',
				'id'      => $prefix . 'featured_locations',
				'type'    => 'multicheck',
				'options' => array(
					//'home1' => 'Homepage - 4 Column Slider',
					'topstories' => 'Top Stories Widget',
				),
			),
			array(
				'name' => 'Embed Code',
				'desc' => 'this field should only be used when content cannot be embeded into the content area',
				'id'   => $prefix . 'post_embed',
				'type' => 'textarea',
			),
			array(
				'name' => 'Image Source',
				'desc' => '',
				'id'   => 'ibm_post_image_source',
				'type' => 'textarea_code',
			),
		),
	);

	/* ----------------------------------------------------- */
	// Events Metabox
	/* ----------------------------------------------------- */
	$meta_boxes['events1'] = array(
		'id' => 'event_info',
		'title' => 'Event Information',
		'pages' => array( 'ibm_event' ),
		'context' => 'normal',
		'fields' => array(
			array(
				'name'		=> 'Event Type',
				'id'		=> $prefix . 'event_type',
				'desc'		=> '',
				'type'		=> 'select',
				'options'	=> array(
					'webinar'		=> 'Webinar',
					'inperson'		=> 'In-Person'
				),
				'multiple'	=> false,
				'std'		=> array( 'no' )
			),
			array(
				'name'		=> 'Start Time',
				'id'		=> $prefix . "event_start",
				'type'		=> 'text_datetime_timestamp',
				'desc'		=> 'Date and time both required.'
			),
			array(
				'name'		=> 'End Time',
				'id'		=> $prefix . "event_end",
				'type'		=> 'text_datetime_timestamp',
				'desc'		=> 'Date and time both required.'
			),
			array(
				'name'		=> 'Time Zone',
				'id'		=> $prefix . "event_time_zone",
				'type'		=> 'select_timezone',
			),
			array(
				'name'		=> 'Location',
				'id'		=> $prefix . 'event_location',
				'desc'		=> 'Required for in-person events',
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			),
			array(
				'name'    => 'Featured Event',
				'desc'    => 'check all locations that you would like to feature this event',
				'id'      => $prefix . 'event_featured_locations',
				'type'    => 'multicheck',
				'options' => array(
					'events_hero' => 'Events Page Hero',
					'featured_event' => 'Featured Event Widget',
				),
			),
			array(
				'name'		=> 'GoToMeeting ID',
				'id'		=> $prefix . 'event_gtm_id',
				'desc'		=> 'Required for webinar registration form',
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			),
			array(
				'name'		=> 'Register Button URL',
				'id'		=> $prefix . 'event_register_url',
				'desc'		=> 'optional',
				'clone'		=> false,
				'type'		=> 'text_url',
				'std'		=> ''
			),
		)
	);

	$meta_boxes['events4'] = array(
		'id' => 'event_on24_info',
		'title' => 'ON24 Information',
		'pages' => array( 'ibm_event' ),
		'context' => 'normal',
		'fields' => array(
			array(
			    'desc' => 'The information below will integrate the register form with the appropriate ON24 event.',
			    'type' => 'title',
			    'id' => $prefix . 'event_on24_title'
			),
			array(
				'name'		=> 'Key',
				'id'		=> $prefix . 'event_on24_key',
				'desc'		=> '',
				'type'		=> 'text',
			),			
			array(
				'name'		=> 'Event ID',
				'id'		=> $prefix . 'event_on24_event_id',
				'desc'		=> '',
				'type'		=> 'text',
			),			
			array(
				'name'		=> 'Session ID',
				'id'		=> $prefix . 'event_on24_session_id',
				'desc'		=> "If the Sesssion ID is unknown, please use 1.",
				'type'		=> 'text',
				'default' => '1',
			),
		)
	);

	$meta_boxes['events3'] = array(
		'id' => 'event_banner',
		'title' => 'Featured Event Banner',
		'pages' => array( 'ibm_event' ),
		'context' => 'normal',
		'fields' => array(
			array(
				'name'    => 'Featured Event',
				'desc'    => '',
				'id'      => $prefix . 'event_banner_featured',
				'type'    => 'multicheck',
				'options' => array(
					'enabled' => 'Enabled',
				),
			),
			array(
				'name'		=> 'Headline',
				'id'		=> $prefix . 'event_banner_headline',
				'desc'		=> 'required: 75 characters max suggested',
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			),
			array(
				'name'		=> 'Register Button URL',
				'id'		=> $prefix . 'event_banner_url',
				'desc'		=> 'optional: button will link to event details page if no url is provided here',
				'clone'		=> false,
				'type'		=> 'text_url',
				'std'		=> ''
			),
		)
	);
	/* ----------------------------------------------------- */
	// News Metabox
	/* ----------------------------------------------------- */
	$meta_boxes['news1'] = array(
		'id'         => 'news_info',
		'title'      => 'Options &amp; Settings',
		'pages'      => array( 'ibm_news', ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
				'name'    => 'Featured News',
				'desc'    => '',
				'id'      => $prefix . 'featured_locations',
				'type'    => 'multicheck',
				'options' => array(
					'topnews' => 'Top News Widget',
				),
			),
			array(
				'name' => 'Image Source',
				'desc' => '',
				'id'   =>  'ibm_post_image_source',
				'type' => 'textarea_code',
			),			
		),
	);

	$eventsPrefix = 'minti_';
	$meta_boxes['events2'] = array(
		'id' => 'portfolio_info',
		'title' => '(Old) Event Information',
		'pages' => array( 'ibm_event' ),
		'context' => 'normal',
		'fields' => array(
			array(
				'name'		=> 'Title Bar',
				'id'		=> $eventsPrefix . "titlebar",
				'type'		=> 'select',
				'options'	=> array(
					'titlebar'			=> 'Title & Subtitle',
					'notitlebar'		=> 'No Title Bar'
				),
				'multiple'	=> false,
				'std'		=> array( 'title' )
			),
			array(
				'name'		=> 'Subtitle',
				'id'		=> $eventsPrefix . 'subtitle',
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			),	
			array(
				'name'		=> 'Location',
				'id'		=> $eventsPrefix . 'portfolio-client',
				'desc'		=> 'Leave empty if you do not want to show this.',
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			),
			array(
				'name'		=> 'Project link',
				'id'		=> $eventsPrefix . 'portfolio-link',
				'desc'		=> 'URL to the Project if available (Do not forget the http://)',
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			),
			array(
				'name'		=> 'Detail Layout',
				'id'		=> $eventsPrefix . 'portfolio-detaillayout',
				'desc'		=> 'Choose Layout for Detailpage',
				'type'		=> 'select',
				'options'	=> array(
					'wide'			=> 'Full Width',
					'sidebyside'	=> 'Side by Side'
				),
				'multiple'	=> false,
				'std'		=> array( 'no' )
			),
			array(
				'name'		=> 'Show Project Details?',
				'id'		=> $eventsPrefix . "portfolio-details",
				'type'		=> 'checkbox',
				'std'		=> true
			),
			array(
				'name'		=> 'Show Related Projects?',
				'id'		=> $eventsPrefix . "portfolio-relatedposts",
				'type'		=> 'checkbox',
				'desc'		=> 'This overwrites the global settings from Theme Options'
			),
			array(
				'name'		=> 'Link to Lightbox',
				'id'		=> $eventsPrefix . "portfolio-lightbox",
				'type'		=> 'select',
				'options'	=> array(
					'false'		=> 'false',
					'true'		=> 'true'
				),
				'multiple'	=> false,
				'std'		=> array( 'false' ),
				'desc'		=> 'Open Image in a Lightbox (on Overview, Homepage & Related Posts)'
			),
			array(
				'name'		=> '(OLD) Event Start Date',
				'id'		=> $eventsPrefix . "portfolio-start-date",
				'type'		=> 'text',
				'desc'		=> 'Event Start Datetime (YYYY-MM-DD HH:MM). This field will not be used going forth.'
			),
			array(
				'name'		=> '(OLD) Event End Date',
				'id'		=> $eventsPrefix . "portfolio-end-date",
				'type'		=> 'text',
				'desc'		=> 'Event End Datetime (YYYY-MM-DD HH:MM). This field will not be used going forth.'
			),
		)
	);

	/* ----------------------------------------------------- */
	// Users Metabox
	/* ----------------------------------------------------- */
	$meta_boxes['users1'] = array(
		'id'         => 'users1',
		'title'      => 'User Profile Metabox',
		'pages'      => array( 'user' ), // Tells CMB to use user_meta vs post_meta
		'show_names' => true,
		'cmb_styles' => false, // Show cmb bundled styles.. not needed on user profile page
		'fields'     => array(
			array(
				'name' => 'Featured Contributor',
				'desc' => 'check to show at top of contributors page',
				'id'   => $prefix . 'featured_contributor',
				'type' => 'checkbox',
			),
			array(
				'name' => 'Hidden User',
				'desc' => 'check to hide user from contributors pages',
				'id'   => $prefix . 'hidden_user',
				'type' => 'checkbox',
			),
			array(
				'name'		=> 'Professional Title',
				'id'		=> $prefix . "contributor_title",
				'type'		=> 'text',
				'desc'		=> ''
			),
			array(
				'name'		=> 'LinkedIn URL',
				'id'		=> $prefix . "contributor_linkedin",
				'type'		=> 'text_url',
				'desc'		=> ''
			),
			array(
				'name'         => 'Image(s)',
				'desc'         => '',
				'id'           => $prefix . 'contributor_image',
				'type'         => 'file',
				'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
			),
			array(
				'name'		=> 'Areas of interest',
				'id'		=> $prefix . "contributor_interest_areas",
				'type'		=> 'text',
				'desc'		=> ''
			),
			array(
				'name'		=> 'How many posts do you expect to submit over the next 12 months?',
				'id'		=> $prefix . "contributor_post_expect_submit_12_months",
				'type'		=> 'text',
				'desc'		=> ''
			),
			array(
				'name'		=> 'How did you hear about us?',
				'id'		=> $prefix . "contributor_how_did_hear_about_us",
				'type'		=> 'text',
				'desc'		=> ''
			),
		)
	);

	/* ----------------------------------------------------- */
	// Media Metabox
	/* ----------------------------------------------------- */
	$meta_boxes['media1'] = array(
		'id' => 'media_info',
		'title' => 'Media Information',
		'pages' => array( 'ibm_media' ),
		'context' => 'normal',
		'fields' => array(
			array(
				'name'    => 'Featured Media',
				'desc'    => 'check all locations that you would like to feature this media item',
				'id'      => $prefix . 'media_featured_locations',
				'type'    => 'multicheck',
				'options' => array(
					'featured_media' => 'Featured Media Widget',
				),
			),
			array(
				'name' => 'Embed Code',
				'desc' => 'this field should only be used when content cannot be embeded into the content area',
				'id'   => $prefix . 'media_embed',
				'type' => 'textarea',
			),
		)
	);

	/* ----------------------------------------------------- */
	// Co-Contributors Metabox
	/* ----------------------------------------------------- */
	$meta_boxes['co_contributors'] = array(
		'id'         => 'co_contributors',
		'title'      => 'Co-Contributors',
		'pages'      => array( 'ibm_news', 'ibm_event', 'post', ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
				'name'    => 'Co-Contributors (IDs)',
				'id'      => $prefix . 'co_contributors',
				'type'		=> 'text',
				'desc'		=> 'Optional: comma-separated list of contributor IDs <br> Example: 123,456,789',
				'repeatable' => true
			),
		),
	);

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'lib_metaboxes/init.php' );
	}

}
?>