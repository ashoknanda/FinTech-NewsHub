<?php

/* Custom Background Support */
$args = array(
	'default-color' => 'f4f4f4'
);
add_theme_support( 'custom-background', $args );


/* Add SoundCloud oEmbed */
function add_oembed_soundcloud(){
	wp_oembed_add_provider( 'http://soundcloud.com/*', 'http://soundcloud.com/oembed' );
	wp_oembed_add_provider( '#http://(www\.)?youtube\.com/watch.*#i', 'http://www.youtube.com/oembed', true );
	wp_oembed_add_provider( '#https://(www\.)?youtube\.com/watch.*#i', 'http://www.youtube.com/oembed', true );
}
add_action('init','add_oembed_soundcloud');

/* Get Portfolio Page Link */
function get_portfolio_page_link($post_id) {
    global $wpdb;
	
    $results = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta
    WHERE meta_key='_wp_page_template' AND meta_value='template-portfolio.php' OR meta_value='template-portfolio-shapes.php' OR meta_value='template-portfolio-paginated.php'");

    foreach ($results as $result) 
    {
        $page_id = $result->post_id;
    }
	
    return get_page_link($page_id);
} 

/* Required Settings */
//if(!isset($content_width)) $content_width = 1170;
add_theme_support( 'automatic-feed-links' );

/* Read More class */
add_filter( 'the_content_more_link', 'add_morelink_classes' );
function add_morelink_classes( $more_link_html ) {
	// Example - else this var has no scope inside the function
	global $var_declared_outside_function;

	$new_classes = array( 'btn' );
	$more_link_html = str_replace( 'class="more-link', 'class="' . implode( ' ', $new_classes ) . ' more-link', $more_link_html );

	return $more_link_html;
}

/* Remove WP default inline CSS for ".recentcomments a" from header */
add_action('widgets_init', 'my_remove_recent_comments_style');
function my_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

/* Remove Unwanted Tags */
function remove_invalid_tags($str, $tags) 
{
    foreach($tags as $tag)
    {
    	$str = preg_replace('#^<\/'.$tag.'>|<'.$tag.'>$#', '', $str);
    }

    return $str;
}

/* Category Rel Fix */
function remove_category_list_rel( $output ) {
    return str_replace( ' rel="category tag"', '', $output );
}
 
add_filter( 'wp_list_categories', 'remove_category_list_rel' );
add_filter( 'the_category', 'remove_category_list_rel' );

/* Editor Styling */
add_editor_style();

/* Add Twitter oEmbed */
add_filter('oembed_result','twitter_no_width',10,3);
function twitter_no_width($html, $url, $args) {
    if (false !== strpos($url, 'twitter.com')) {
        $html = str_replace('width="550"','',$html);
    }
    return $html;
}

// Remove default styling for Gallery Shortcode
add_filter('gallery_style',
	create_function(
		'$css',
		'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'
	)
);

/* Fix Image Margins */
class fixImageMargins{
    public $xs = 0; //change this to change the amount of extra spacing

    public function __construct(){
        add_filter('img_caption_shortcode', array(&$this, 'fixme'), 10, 3);
    }
    public function fixme($x=null, $attr, $content){

        extract(shortcode_atts(array(
                'id'    => '',
                'align'    => 'alignnone',
                'width'    => '',
                'caption' => ''
            ), $attr));

        if ( 1 > (int) $width || empty($caption) ) {
            return $content;
        }

        if ( $id ) $id = 'id="' . $id . '" ';

    return '<div ' . $id . 'class="wp-caption ' . $align . '" style="width: ' . ((int) $width + $this->xs) . 'px">'
    . $content . '<p class="wp-caption-text"><i class="fa fa-picture"></i> ' . $caption . '</p></div>';
    }
}
$fixImageMargins = new fixImageMargins();

/* Different Sub Category Templates */
function sub_category_template() { 
    
    // Get the category id from global query variables
    $cat = get_query_var('cat');

    if(!empty($cat)) {    
        
        // Get the detailed category object
        $category = get_category($cat);

        // Check if it is sub-category and having a parent, also check if the template file exists
        if( $category->parent != '0') { 
            
            // Include the template for sub-catgeory
            get_template_part('csub-category');
            exit;
        }
        return;
    }
    return;

}
add_action('template_redirect', 'sub_category_template');

/* Author FB, TW & G+ Links */
function my_new_contactmethods( $contactmethods ) {
// Add Twitter
$contactmethods['twitter'] = 'Twitter URL';
// Add Facebook
$contactmethods['facebook'] = 'Facebook URL';
// Add Google+
$contactmethods['googleplus'] = 'Google Plus URL';

return $contactmethods;
}
add_filter('user_contactmethods','my_new_contactmethods',10,1);


/* Get Homepage Categories & Order */
function thb_DisplayStars($count) {
	$output = '';
	for($x=1;$x<=$count;$x++) {
      $output .= '<i class="fa fa-star"></i>';
  }
  if (strpos($count,'.')) {
      $output .= '<i class="fa fa-star-half-full"></i>';
      $x++;
  }
  while ($x<=5) {
      $output .= '<i class="fa fa-star-o"></i>';
      $x++;
  }
  
  return '<span class="stars">'.$output.'</span>';
}

/* Display Post Meta */
function thb_DisplayPostMeta($date = true, $likes = true, $comments = true, $author = true) { 
	$output = '<aside class="post-meta">';
	$output .= '<ul>';
		if ($date) { $output .= '<li><a href="'.get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')).'">'.get_the_date('M j, Y').'</a></li>';}
		if ($likes) { if (ot_get_option('disablelike') == 'no') { $output .= '<li>&bull;  '.thb_printLikes(get_the_ID()).'</li>'; } }
//		if ($comments) { $output .= '<li>&bull; '. get_comments_popup_link('<i class="fa fa-comment-o"></i> 0', '<i class="fa fa-comment-o"></i> 1', '<i class="fa fa-comment-o"></i> %', 'postcommentcount', '<i class="fa fa-comment-o"></i> -').'</li>'; }
		if ($author) { $output .= '<li class="right">By <em><a href="'.get_author_posts_url(get_the_author_meta("ID")) .'">'.get_the_author_meta("display_name") .'</a></em><a href="'.get_author_posts_url(get_the_author_meta("ID")) .'">'. get_avatar( get_the_author_meta("ID"),"26").'</a></li>'; }
	$output .= '</ul>';
	$output .= '</aside>';
	
	return $output;
}

/* Get Homepage Categories & Order */
function thb_HomePageCategories() {
	$categories = ot_get_option('home_categories');
	$order = ot_get_option('home_category_order'); 
	
	if(!empty($categories) && !empty($order)) { 
		function flatten_array($array, &$out = array()) {
		    foreach($array as $key => $child) {
		        array_push($out,$child['id']); 
		    }
		    return $out;
		}
		
		$out2 = flatten_array($order); 
		$result = array_intersect($out2, $categories);
	} else { $result = ''; }

	return $result;
}

/* Get Single Category */
function thb_GetSingleCategory($id = false) { 
  if ( (int) $id ) {
    $cat = get_category($id);
    if ( ! empty($cat) ) {
       $backup = $cat->term_id;
       if ( $cat->parent == 0 ) $id = $cat->term_id;
    }
  }
  if ( empty($id)) {
    $id = '';
    $categories = get_the_category();

    if ( empty( $categories ) ) return;
    while ( empty($id) && ! empty($categories) ) {
      $cat = array_shift($categories);
      if ( $cat->parent == 0 ) $id = $cat->term_id;
    }
  }
  // if no parent cat found, but a not-parent cat id passed to function use that
  if ( ! (int) $id && isset($backup) ) $id = $backup;
  if ( ! (int) $id ) return;
  return $id;
}

/* Display Single Category */
function thb_DisplaySingleCategory($boxed = true, $id = false, $colorEnabled = true) { 
  if ( (int) $id ) {
    $cat = get_category($id);
    if ( ! empty($cat) ) {
       $backup = $cat->term_id;
       $id = $cat->term_id;
    }
  }
  if ( empty($id)) {
    $id = '';
    $categories = get_the_category();

    if ( empty( $categories ) ) return;
    while ( empty($id) && ! empty($categories) ) {
      $cat = array_shift($categories);
      $id = $cat->term_id;
    }
  }
  // if no parent cat found, but a not-parent cat id passed to function use that
  if ( ! (int) $id && isset($backup) ) $id = $backup;
  if ( ! (int) $id ) return;
  $name = get_cat_name($id);
  $url = esc_url( get_category_link($id) );
  $wcolor = $boxed ? 'background' : 'color';
  $class = $boxed ? ' class="boxed"' : '';
  $color = GetCategoryColor($id);
  if ($colorEnabled) {
	  $frmt = '<a href="%s"%s title="%s" style="%s:%s;">%s</a>';
	  return sprintf( $frmt, $url, $class, esc_attr($name), $wcolor, $color, esc_html($name) );
  } else {
	  $frmt = '<a href="%s"%s title="%s">%s</a>';
	  return sprintf( $frmt, $url, $class, esc_attr($name), esc_html($name) );
  }
}
/* Get Rating Color */
function thb_GetAverageRatingColor($id) {

	$ratingType = get_post_meta($id, 'rating_type', TRUE);
	
	if ($ratingType == 'star') {
		$features = get_post_meta($id, 'post_ratings', TRUE); $count = count($features); $total = '0';
		foreach($features as $feature) {
			$total += $feature['feature_rating'];
		}
		
		$num = round($total / $count, 1);
		
		switch ($num){
	      case ($num>= 0 && $num<= 1): 
	          return '#d10000';
	      break;
	      case ($num> 1 && $num<= 2): 
	          return '#d96b00';
	      break;
	      case ($num> 2 && $num<= 3): 
	          return '#d9c100';
	      break;
				case ($num> 3 && $num<= 4): 
				    return '#92cd03';
				break;
	      case ($num> 4): 
	          return '#04bc02';
	      break;
	   }
	} else if ($ratingType == 'percentage') {
	 	$features = get_post_meta($id, 'post_ratings_percentage', TRUE); $count = count($features); $total = '0';
	 	foreach($features as $feature) {
	 		$total += $feature['feature_percentage'];
	 	}
	 	
	 	$num = round($total / $count, 0);
	 	
	 	switch ($num){
	 	    case ($num>= 0 && $num<= 20): 
	 	        return '#d10000';
	 	    break;
	 	    case ($num> 20 && $num<= 40): 
	 	        return '#d96b00';
	 	    break;
	 	    case ($num> 40 && $num<= 60): 
	 	        return '#d9c100';
	 	    break;
	 			case ($num> 60 && $num<= 80): 
	 			    return '#92cd03';
	 			break;
	 	    case ($num> 80): 
	 	        return '#04bc02';
	 	    break;
	 	}
	}
}
/* Get Average Rating */
function thb_GetAverageRating($id) {
	$ratingType = get_post_meta($id, 'rating_type', TRUE);
	
	if ($ratingType == 'star') {
		$features = get_post_meta($id, 'post_ratings', TRUE); $count = count($features); $total = '0';
		foreach($features as $feature) {
			$total += $feature['feature_rating'];
		}
		
		return '<aside class="imagetag">'.round($total / $count, 1).'</aside>';
	} else if ($ratingType == 'percentage') {
	 	$features = get_post_meta($id, 'post_ratings_percentage', TRUE); $count = count($features); $total = '0';
	 	foreach($features as $feature) {
	 		$total += $feature['feature_percentage'];
	 	}
	 	
	 	return '<aside class="imagetag rating">'.round($total / $count, 0).'%</aside>';
	}
}
/* Display Average Rating or Video Icon */
function thb_DisplayImageTag($id) {
	$postformat = get_post_format($id);
	if (get_post_meta($id, 'is_review', TRUE) == 'yes') {
		return thb_GetAverageRating($id);
	} else if ($postformat == 'video'){ 
		return '<aside class="imagetag" title="Video"><i class="fa fa-play"></i></aside>';
	} else if ($postformat == 'gallery'){
		return '<aside class="imagetag" title="Gallery"><i class="fa fa-picture-o"></i></aside>';
	} else if ($postformat == 'image'){
		return '<aside class="imagetag" title="Image"><i class="fa fa-camera"></i></aside>';
	}else {
		return false;
	}
}

/* Get Category Color */
function GetCategoryColor($id) {
	$color = ot_get_option('category_colors_'. $id, '#222');
	return $color;
}

/* Add Colors to Category */
class CategoryColors_Walker extends Walker_Category {
	private $in_sub_menu = 0;
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '<div class="category-holder"><ul>';
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '</ul>';
	}
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

	    $cat_name = esc_attr( $category->name );
		$cat_id = esc_attr( $category->term_id );
		$cat_color = GetCategoryColor($cat_id);
	    $cat_name = apply_filters( 'list_cats', $cat_name, $category );

		$termchildren = get_term_children( $category->term_id, $category->taxonomy );
		
	    // Detect first child of submenu then add class active
	    $aclass = '';
	    $datacolor = '';
		if( $depth == 1 ) {
		    if( ! $this->in_sub_menu ) {
		        $aclass = 'class="active"';   
		        $this->in_sub_menu = 1;
		    }
		}
		if( $depth == 0 ) {
				$datacolor = 'data-color="'.$cat_color.'"';
		    $this->in_sub_menu = 0;
		}
		
	    $link = '<a '.$aclass.' href="' . esc_url( get_term_link($category) ) . '" '.$datacolor.' title="' . esc_attr( sprintf(__( 'View all posts filed under %s' ), $cat_name) ) . '">'.$cat_name . '</a>';

		$output .= '<li>'.$link;
		
		
	}
	function end_el( &$output, $category, $depth = 0, $args = array() ) {
		$termchildren = get_terms( $category->taxonomy, array( 'child_of' => $category->term_id, 'hide_empty'    => false, ) );
		
		if($depth==0 && $termchildren){
			$output .= '<div class="category-children">';
			
			$i = 0;
			foreach ($termchildren as $child) {
				$output .= '<div'.(($i===0)?' class="active"':'').'>';
		      	$query = new WP_Query(array( 
		            'posts_per_page'    => 4, 
		            'no_found_rows'     => true, 
		            'post_status'       => 'publish', 
		            'cat'               => $child->term_id
		        ));

		        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
						$output.= '
						<div class="row post">
							<div class="three columns post-gallery"><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_post_thumbnail().'</a></div>
							<div class="nine columns post">
								<div class="post-title">
									<h4><a href="'.get_permalink().'" rel="bookmark" title="'.get_the_title().'" class="postlink">'.get_the_title().'</a></h4>
								</div>
								<div class="post-content">
									'.thb_DisplayPostMeta(true,true,true,false).'
								</div>
							</div>
						</div>';
		 
			        wp_reset_postdata();

		        endwhile; else: endif;


			  $output .= '<a href="'.get_category_link($child->term_id).'" class="gotocategory" title="'.$child->name.'">View all</a>';
			  $output .= "</div>";
			  $i++;
			}
			
			$output .= "</div></div>";
		} else {
		
		}
		$output .= "</li>";
	}
}

// Remove news categories from RSS feed
add_action('pre_get_posts', 'exclude_category' );
function exclude_category( &$wp_query ) {
   if( is_feed() ) { // Exclude from home, feed, but not from category page/feed
        set_query_var('category__not_in', array(598,599,600)); // Exclude category with ID 120
    }
}

// Function that returns all timezones supported by php (used by rpg-metaboxes.php)
function generate_timezone_list()
{
    static $regions = array(
        DateTimeZone::AFRICA,
        DateTimeZone::AMERICA,
        DateTimeZone::ANTARCTICA,
        DateTimeZone::ASIA,
        DateTimeZone::ATLANTIC,
        DateTimeZone::AUSTRALIA,
        DateTimeZone::EUROPE,
        DateTimeZone::INDIAN,
        DateTimeZone::PACIFIC,
    );

    $timezones = array();
    foreach( $regions as $region )
    {
        $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
    }

    $timezone_offsets = array();
    foreach( $timezones as $timezone )
    {
        $tz = new DateTimeZone($timezone);
        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
    }

    // sort timezone by offset
    asort($timezone_offsets);

    $timezone_list = array();
    foreach( $timezone_offsets as $timezone => $offset )
    {
        $offset_prefix = $offset < 0 ? '-' : '+';
        $offset_formatted = gmdate( 'H:i', abs($offset) );

        $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

        $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
    }

    $timezone_list = array('America/New_York' => 'Default (America/New_York)') + $timezone_list;

    return $timezone_list;
}

// Function to return readable timestamp for events
// Note: this function was originally built because the client wanted Australian EST/EDT to display as AEST/AEDT
function get_event_datetime( $timestamp, $show_timezone = false, $timezone = 'America/New_York' ) {

	date_default_timezone_set( $timezone ); // set default timezone as desired

	if ( $show_timezone === true ) {
		// we want to overwrite Australian EST/EDT with AEST/AEDT (that's the primary/original goal of this function)
		if ( $timezone == 'Australia/Melbourne' && date("T") == 'EST' ) {
			$return = date( "F j, Y @ g:i A", $timestamp );
			$return .= ' AEST';
		} else if ( $timezone == 'Australia/Melbourne' && date("T") == 'EDT' ) {
			$return = date( "F j, Y @ g:i A", $timestamp );
			$return .= ' AEDT';
		} else {
			$return = date( "F j, Y @ g:i A T", $timestamp );
		}
	} else {
		$return = date( "F j, Y @ g:i A", $timestamp );
	}

	date_default_timezone_set( 'America/New_York' ); // reset default timezone to EST/EDT

	return $return;

}

function set_default_time_zone_config(){
	if (defined('DEFAULT_TIME_ZONE')){
		date_default_timezone_set(DEFAULT_TIME_ZONE); // set default timezone as desired
	}else{
		date_default_timezone_set('America/New_York'); // set default timezone as desired		
	}
}
// Function to return readable timestamp for events
// Note: this function was originally built because the client wanted Australian EST/EDT to display as AEST/AEDT
function get_event_datetime2( $timestamp, $show_timezone = false, $timezone = 'America/New_York' ) {
	$date = date("F j, Y g:i A", $timestamp);
	$deff_offset = get_timezone_offset($timezone, $date) * 60;
	$timezone = (str_replace('UTC-', 'Etc/GMT+', str_replace('UTC+', 'Etc/GMT-', $timezone)));

	set_default_time_zone_config();
	
	$return = date("F j, Y @ g:i A", $timestamp);

	date_default_timezone_set($timezone); // set default timezone as desired

	$timezone_text = date(" T", $timestamp);
	$timezone_text = (str_replace('GMT+', 'UTC-', str_replace('GMT-', 'UTC+', $timezone_text )));
	$return .= $timezone_text;

	date_default_timezone_set( 'America/New_York' ); // reset default timezone to EST/EDT

	return $return;

}


// Function to return readable timestamp for events
// Note: this function was originally built because the client wanted Australian EST/EDT to display as AEST/AEDT
function get_event_datetime_timeze_change( $timestamp, $show_timezone = false, $timezone = 'America/New_York', $end_time = false ) {
	$timezone2 = (str_replace('UTC-', 'Etc/GMT+', str_replace('UTC+', 'Etc/GMT-', $timezone)));
	set_default_time_zone_config();

	if ( $show_timezone === true ) {
		// we want to overwrite Australian EST/EDT with AEST/AEDT (that's the primary/original goal of this function)
		if ( $timezone == 'Australia/Melbourne' && date("T") == 'EST' ) {
			$return = date( "F j, Y @ g:i A", $timestamp );
			$return .= ' AEST';
		} else if ( $timezone == 'Australia/Melbourne' && date("T") == 'EDT' ) {
			$return = date( "F j, Y @ g:i A", $timestamp );
			$return .= ' AEDT';
		} else {
			$return = date( "F j, Y @ g:i A T", $timestamp );
			date_default_timezone_set($timezone2); // set default timezone as desired
			$return .= date(" T", $timestamp);			
			set_default_time_zone_config();
		}
	} else {
		$return = date( "F j, Y @ g:i A", $timestamp );
	}	
	$attrs = get_timezone_arguments_element($timestamp);
	$data_timezone_type = "1";
	if ($end_time == true) {
		$data_timezone_type = "10";
	}
	$return = '<span class="change_timezone_text"'. $attrs.' data-timezone-type="'.$data_timezone_type.'">' . $return . '</span>';

	date_default_timezone_set( 'America/New_York' ); // reset default timezone to EST/EDT
	return $return;
}
function get_timezone_arguments_element($ibm_event_start = null, $ibm_event_end = null, $timezone = null){
	set_default_time_zone_config();
	if(empty($ibm_event_start)) {
		$ibm_event_start = get_post_meta(get_the_ID(), '_ibm_event_start', true);
	}
	if(empty($ibm_event_end)) {
		$ibm_event_end = get_post_meta(get_the_ID(), '_ibm_event_end', true);
	}
	if(empty($timezone)) {
		$timezone = get_post_meta(get_the_ID(), '_ibm_event_time_zone', true);
	}
	$date = date("F j, Y g:i A", $ibm_event_start);
	$date_end = date("F j, Y g:i A", $ibm_event_end );

	$attrs = ' data-timezone-date="' . $date . '"';
	$attrs .= ' data-timezone-date-end="' . $date_end . '"';
	$attrs .= ' data-timezone-name="' . $timezone . '"';
	$attrs .= ' data-timezone-timestamp="' . $ibm_event_start . '"';
	$attrs .= ' data-timezone-timestamp-end="' . $ibm_event_end . '"';
	$attrs .= ' data-timezone-offset="' . get_timezone_offset($timezone, $date) . '"';
	$attrs .= ' data-timezone-offset-end="' . get_timezone_offset($timezone, $date_end) . '"';
	$attrs .= ' data-timezone-offset-def="' . get_timezone_offset('EDT', $date) . '"';

	date_default_timezone_set( 'America/New_York' ); // reset default timezone to EST/EDT

	return $attrs;
}


function get_timezone_offset($remote_tz, $date) {
	if (strrpos($remote_tz, "UTC+") === false && strrpos($remote_tz, "UTC-") === false && !empty($remote_tz)) {
		$origin_tz = 'UTC';
    $origin_dtz = new DateTimeZone($origin_tz);
    $remote_dtz = new DateTimeZone($remote_tz);
    $origin_dt = new DateTime($date, $origin_dtz);
    $remote_dt = new DateTime($date, $remote_dtz);
    $offset = $remote_dtz->getOffset($remote_dt) - $origin_dtz->getOffset($origin_dt);
    date_default_timezone_set( 'America/New_York' );
    return $offset / 60;
  }else if (empty($remote_tz)){
  	return 0;
  }else{
  	return (str_replace('UTC', '', str_replace('UTC+', '', $remote_tz)) * 60);
  }
}

// Function to include custom post types in author.php
function custom_post_author_archive( &$query )
{
    if ( $query->is_author ) {
		$query->set(
			'post_type',
			array(
				'post',
				'ibm_news',
				'ibm_media'
			)
		);
		$query->set(
			'posts_per_page',
			99
		);
	}
    remove_action( 'pre_get_posts', 'custom_post_author_archive' ); // run once!
}
add_action( 'pre_get_posts', 'custom_post_author_archive' );


add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl() { ?>
	<script type="text/javascript">
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
<?php
}

// Function to use on contributors page template that includes custom post types in the post count
// As of 10/2014, count_user_posts() does not count or support custom post types
function rpg_count_user_posts( $userid ) {
	global $wp_query, $wpdb;
	$curauth = $wp_query->get_queried_object();
	$post_count = $wpdb->get_var(
		"SELECT COUNT(ID) FROM $wpdb->posts 
		WHERE post_author = '$userid' 
		AND post_type IN ('post', 'ibm_news', 'ibm_media') 
		AND post_status = 'publish'"
	);
	return $post_count;
}

add_action('the_post', 'the_post_add_space', 1);  

function the_post_add_space( $post_object ) {
	if (!empty($post_object)){
		if (!empty($post_object->post_content )){
	  	$post_object->post_content = str_replace('</p><p>http', "</p>\n<p>\nhttp", $post_object->post_content);
	  	$post_object->post_content = str_replace('</p>', "\n</p>", $post_object->post_content);
	  	$post_object->post_content = str_replace("\n\n</p>", "\n</p>", $post_object->post_content);
		}
	}
  return $post_object;
}

function securityintelligence_rel_author_filter($link) {
	if (false !== strpos($link, 'rel="author"')) {
    $link = str_replace('rel="author"', '', $link);
	}
  return $link;
}
add_filter('the_author_posts_link', 'securityintelligence_rel_author_filter', 10, 1);

remove_all_actions( 'do_feed_rss2' );
add_action( 'do_feed_rss2', 'si_feed_rss2', 10, 1 );

function si_feed_rss2( $for_comments ) {
	header("Cache-Control: max-age=0, private, no-store, no-cache, must-revalidate");
    do_feed_rss2( $for_comments ); // Call default function	
}

function the_post_title_event_limit( $title ) {
	if (strlen($title) > 110){
		return substr($title , 0, 110).'...';
	}else{
		return $title;
	}
}

?>