<?php
/*
Plugin Name: News Hub Collections Plugin
Plugin URI:  http://ibm.com/think/marketing
Description: Basic WordPress Plugin Header Comment
Version:     1.0.0
Author:      Jason McAlpin
Author URI:  https://jasonmcalpin.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( "Nope, don't touch that" );

/*

Setup 

 */

// Register Custom Post Type
function collection_post_type() {
	$labels = array(
		'name'                  => _x( 'Collections', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Collection', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Collections', 'text_domain' ),
		'name_admin_bar'        => __( 'Collection', 'text_domain' ),
		'archives'              => __( 'Collection Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Collection:', 'text_domain' ),
		'all_items'             => __( 'All Collections', 'text_domain' ),
		'add_new_item'          => __( 'Add New Collection', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Collection', 'text_domain' ),
		'edit_item'             => __( 'Edit Collection', 'text_domain' ),
		'update_item'           => __( 'Update Collection', 'text_domain' ),
		'view_item'             => __( 'View Collection', 'text_domain' ),
		'search_items'          => __( 'Search Collection', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into Collection', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this collection', 'text_domain' ),
		'items_list'            => __( 'Collections list', 'text_domain' ),
		'items_list_navigation' => __( 'Collections list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter collections list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Collection Type', 'text_domain' ),
		'description'           => __( 'Collection list', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'register_meta_box_cb' => 'add_collection_metaboxes'
	);
	register_post_type( 'collection', $args );
}

add_action( 'init', 'collection_post_type', 0 );


function add_collection_metaboxes() {
	    add_meta_box('nh_collections_title', 'Collection Title', 'nh_collections_title', 'collections', 'normal', 'default');
	}

	function nh_collections_title() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$location = get_post_meta($post->ID, '_location', true);
	
	// Echo out the field
	echo '<input type="text" name="_location" value="' . $location  . '" class="widefat" />';

}

function define_const (){
	// print_r(the_category());
	define(NH_CATEGORY_PARENT, get_cat_ID( 'Category' ));
	// print_r(NH_CATEGORY_PARENT); // 568
	define(NH_MARKETING, get_cat_ID( 'Digital marketing' ));
	//  Content
	// print_r(NH_MARKETING); // 588
	$data_id = get_category_by_slug( 'data' );
	define(NH_DATA_ANALYTICS, $data_id -> term_id);
	// Predictive Modeling
	// print_r(NH_DATA_ANALYTICS); // 571
	define(NH_CAMPAIGN, get_cat_ID( 'Campaign management' ));
	// Campaign planning
	// print_r(NH_CAMPAIGN); // 590
	define(NH_EMAILMARKETING, get_cat_ID( 'Email marketing' ));
	// print_r(NH_EMAILMARKETING); // 596
}

add_action( 'init', 'define_const', 0 );


function nh_install()
{
    // trigger our function that registers the custom post type
    collection_post_type();
    // clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'nh_install');



function nh_deactivation()
{
    // our post type will be automatically removed, so no need to unregister it
 
    // clear the permalinks to remove our post type's rules
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'nh_deactivation');

function nh_render_ad($collection_category){
	$collection_item = get_category($collection_category,false);
	$collection_parent = $collection_item->category_parent;
	$collection_id ='';
	$collection_ids = [];
	$args = array ();

	if ( $collection_parent ===  NH_EMAILMARKETING) {
		$collection_id = NH_EMAILMARKETING;

		$args = array(
			'post_type' => 'collection',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'cat' => $collection_id
		);

	}elseif ( $collection_parent ===  NH_MARKETING) {
		$collection_id = NH_MARKETING;

		$args = array(
			'post_type' => 'collection',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'parent' => $collection_id
		);

	} elseif ($collection_parent === NH_DATA_ANALYTICS) {

		$collection_id = NH_DATA_ANALYTICS;

		$args = array(
			'post_type' => 'collection',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'parent' => $collection_id
		);
	} elseif ($collection_parent === NH_CAMPAIGN) {

		$collection_id = NH_CAMPAIGN;

		$args = array(
			'post_type' => 'collection',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'parent' => $collection_id
		);
	} elseif ( $collection_category ===  NH_EMAILMARKETING) {
		$collection_id = NH_EMAILMARKETING;

		$args = array(
			'post_type' => 'collection',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'cat' => $collection_id
		);

	}elseif ( $collection_category ===  NH_MARKETING) {
		$collection_id = NH_MARKETING;

		$args = array(
			'post_type' => 'collection',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'cat' => $collection_id
		);

	} elseif ($collection_category === NH_DATA_ANALYTICS) {

		$collection_id = NH_DATA_ANALYTICS;

		$args = array(
			'post_type' => 'collection',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'cat' => $collection_id
		);
	} elseif ($collection_category === NH_CAMPAIGN) {

		$collection_id = NH_CAMPAIGN;

		$args = array(
			'post_type' => 'collection',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'cat' => $collection_id
		);
	} else {
		$collection_ids = array( NH_EMAILMARKETING, NH_MARKETING, NH_DATA_ANALYTICS, NH_CAMPAIGN );
		$args = array(
			'post_type' => 'collection',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'parent' =>  $collection_ids
		);
	}

	$collections = new WP_Query( $args );
	// print_r($collections);
	while ( $collections->have_posts() ) : $collections->the_post();
		// $url = get_post_meta( get_the_ID(), 'collection_URL', true );
		?>
		<div class="nh-promo-card-holder">
		<script>
console.log("Main ids of collection email tiles : <?php echo NH_EMAILMARKETING; ?>");
console.log("collection category got in plugin : <?php echo $collection_category; ?>");
		</script>
	 <?php 
		 remove_filter('the_content', 'wpautop');
		 the_content(); 
	 ?>
	 </div>
	 <?php
	endwhile;
}



/*

init. 
collection should have custom fields

1. get list of arrays

2. get list of page categories 

3. match array against categories

if not in array check if parent is in array

if nothing in array then random collection

if in array then random collection

if parent in array random children

if none is in array then random all

if array then set design of collection

render collection with design from content.
 */
?>