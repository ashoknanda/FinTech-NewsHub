<?php
// Load more ajax and javascript.
// require_once('_includes/debug.php');
require_once('_includes/load_more.php');
// require_once('_includes/fw_load_more.php');
require_once('_includes/fw_infinite_load.php');

define('DISABLE_WP_CRON', 'true'); 
/**
* This function limits the excerpt to 20 words, instead of default 55 words.
*/
function wpdocs_custom_excerpt_length( $length ) {
    return 15;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

/**
* Custom search with Market place and News hub customization.
*/
function custom_search_plugin_register_query_vars( $vars ) {
    $vars[] = 'categories';
    $vars[] = 'tags';
    return $vars;
}
add_filter( 'query_vars', 'custom_search_plugin_register_query_vars' );


function dnh_pre_get_posts( $query ) {
    $mpSearchResult = array();
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_search()){
        return;
    }

    $query->set('post_type', 'post');

    $category = "";
    $ax = get_query_var('categories');
    if(!empty($ax)){
        $category = filter_var(get_query_var('categories'), FILTER_SANITIZE_ENCODED);
        $query->set('category_name', $category);
    }

    $tags = "";
    $bx = get_query_var('tags');
    if(!empty($bx)){
        $tags = filter_var(get_query_var('tags'), FILTER_SANITIZE_ENCODED);
        $query->set('tag_slug__in', $tags);
    }
}
add_action( 'pre_get_posts', 'dnh_pre_get_posts', 1 );



add_filter('template_include', 'dnh_custom_search_template');

function dnh_custom_search_template( $template ) {
  if ( is_search() ) {
    $ct = locate_template('page-search.php', false, false);
    if ( $ct ) $template = $ct;
  }
  return $template;
}


/**
    Facetwp search count;
*/
function my_facetwp_result_count( $output, $params ) {
    // $output = $params['lower'] . '-' . $params['upper'] . ' of ' . $params['total'] . ' results';
  $output = sprintf(_n('<strong>%s result</strong>', '<strong>%s results</strong>', $params['total']), $params['total']);
  $output .= ' to fuel the marketing mind';
  return $output;
}

add_filter( 'facetwp_result_count', 'my_facetwp_result_count', 10, 2 );

// function dnh_change_search_url_rewrite() {
// 	if ( is_search() && ! empty( $_GET['s'] ) ) {
// 		wp_redirect( home_url( "/search?s=" ) . urlencode( get_query_var( 's' ) ) );
// 		exit();
// 	}
// }
// add_action( 'template_redirect', 'dnh_change_search_url_rewrite' );


//This is for ajax user is loged in or not
function ajax_check_user_logged_in() {
    echo is_user_logged_in()?'yes':'no';
    die();
}
add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');


//Remove admin menu bar
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    show_admin_bar(false);
}


function add_content_type_class($postid){
  if ( has_category( 'poster', $postid ) ) {
    return 'nh-poster';
  } elseif ( has_category( 'video', $postid )) {
      return 'nh-video';
  } else {
      return 'nh-article';
  }
}

/**
 * change default sort label on facet
 *
 * @var options
 * @var params
 **/
function fwp_change_sort_label( $options, $params ) {
    $options['default']['label'] = 'Relevance';
    $options['date_desc']['label'] = 'Latest';
    return $options;
}
add_filter( 'facetwp_sort_options', 'fwp_change_sort_label', 10, 2 );

/**
 * undocumented class variable
 *
 * @var html
 * @var params
 **/

function my_facetwp_sort_html( $html, $params ) {
    $html = '<select style="width:175px;" class="facetwp-sort-select">';
    foreach ( $params['sort_options'] as $key => $atts ) {
        $html .= '<option value="' . $key . '">' . 'Sort by : '. $atts['label'] . '</option>';
    }
    $html .= '</select>';
    return $html;
}

add_filter( 'facetwp_sort_html', 'my_facetwp_sort_html', 10, 2 );


function my_facetwp_sort_options( $options, $params ) {
    unset( $options['title_desc'] );
    unset( $options['title_asc'] );
    unset( $options['date_asc'] );
    return $options;
}

add_filter( 'facetwp_sort_options', 'my_facetwp_sort_options', 10, 2 );


function categoryListNotToShow(){
  $naCategoryList = array();

  array_push($naCategoryList, 
    "Category",
    "Category level 3",
    "Category Level2",
    "Content advertising",
    "Content creation",
    "Content management",
    "Content marketing",
    "Digital asset management (DAM)",
    "Display advertising",
    "Gamification",
    "Interactive content",
    "Video marketing",
    "Community &amp; reviews",
    "Feedback &amp; chat",
    "Social advertising",
    "Social listening",
    "Social media marketing", 
    "Influencer marketing",
    "Communications",
    "Marketing mix",
    "Marketing services",
    "Data management platforms (DMP)",
    "Marketing automation",
    "Tag management",
    "Attribution models",
    "Call analytics",
    "Third party data",
    "Mobile analytics");

  return $naCategoryList;
}


function get_client_ip(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
}



//Ajax call for social counts 

function get_social_counts(){
    global $wp_query;
    wp_reset_query();
    $media = $_REQUEST["media"];
    $urltogetcount = $_REQUEST["urltogetcount"];
    echo do_shortcode("[".$media."-share url='".$urltogetcount."']");
    wp_die();
}

add_action( 'wp_ajax_get_social_counts', 'get_social_counts' );
add_action( 'wp_ajax_nopriv_get_social_counts', 'get_social_counts' );   

add_theme_support( 'post-thumbnails' ); 






/*-------------------------------- CATEGORY FILTERING -----------------------------*/


/**
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param int|array $cats The target categories. Integer ID or array of integer IDs
 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Passes $cats
 * @uses in_category() Passes $_post (can be empty)
 * @version 2.7
 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
 */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
    function post_is_in_descendant_category( $cats, $_post = null ) {
        foreach ( (array) $cats as $cat ) {
            // get_term_children() accepts integer ID only
            $descendants = get_term_children( (int) $cat, 'category' );
            if ( $descendants && in_category( $descendants, $_post ) )
                return $cat;
        }
        return 0;
    }
}