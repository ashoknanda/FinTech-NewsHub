<?php
/* ----------------------------------------------------- */
/* ibm_event Custom Post Type */
/* ----------------------------------------------------- */

// Adds Custom Post Type
add_action('init', 'ibm_event_register'); 

// Adds columns in the admin view for thumbnail and taxonomies
add_filter( 'manage_edit-ibm_event_columns', 'ibm_event_edit_columns' );
add_action( 'manage_posts_custom_column', 'ibm_event_column_display', 10, 2 );

// Allows filtering of posts by taxonomy in the admin view
add_action( 'restrict_manage_posts', 'ibm_event_add_taxonomy_filters' ); 

// Add Icons
add_action( 'admin_head', 'ibm_event_icon' );

function ibm_event_register() {  

	global $data;
	
	$labels = array(
		'name' => __( 'Events', 'minti-framework' ),
		'singular_name' => __( 'Event', 'minti-framework' ),
		'add_new' => __( 'Add New Event', 'minti-framework' ),
		'add_new_item' => __( 'Add New Event Item', 'minti-framework' ),
		'edit_item' => __( 'Edit Event Item', 'minti-framework' ),
		'new_item' => __( 'Add New Event Item', 'minti-framework' ),
		'view_item' => __( 'View Item', 'minti-framework' ),
		'search_items' => __( 'Search Events', 'minti-framework' ),
		'not_found' => __( 'No event items found', 'minti-framework' ),
		'not_found_in_trash' => __( 'No event items found in trash', 'minti-framework' )
	);
	
    $args = array(  
        'labels' => $labels,
        //'singular_label' => __('Event'),  
        'public' => true,  
        'show_ui' => true,  
        'capability_type' => 'post',  
        'hierarchical' => false,  
        'rewrite' => array('slug' => 'events'), // Permalinks format
        'taxonomies' => array('post_tag'), //add tag support to events
		'menu_icon' => 'dashicons-calendar', // http://melchoyce.github.io/dashicons/
		'supports' => array('title', 'editor', 'thumbnail', 'comments')  
       );  
  
    register_post_type( 'ibm_event' , $args );  
}  

register_taxonomy("ibm_event_filter", array("ibm_event"), array("hierarchical" => true, "label" => "Events Filter", "singular_label" => "Event Filter", "rewrite" => true));

/**
 * Add Columns to ibm_event Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */
 
function ibm_event_edit_columns( $ibm_event_columns ) {
	$ibm_event_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => _x('Title', 'column name'),
		"thumbnail" => __('Thumbnail', 'ibm_eventposttype'),
		"ibm_event_filter" => __('Filter', 'ibm_eventposttype'),
		"author" => __('Author', 'ibm_eventposttype'),
		"comments" => __('Comments', 'ibm_eventposttype'),
		"date" => __('Date', 'ibm_eventposttype'),
	);
	$ibm_event_columns['comments'] = '<div class="vers"><img alt="Comments" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>';
	return $ibm_event_columns;
}

function ibm_event_column_display( $ibm_event_columns, $post_id ) {

	// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview
	
	switch ( $ibm_event_columns ) {
		
		// Display the thumbnail in the column view
		case "thumbnail":
			$width = (int) 35;
			$height = (int) 35;
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
			
			// Display the featured image in the column view if possible
			if ( $thumbnail_id ) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}
			if ( isset( $thumb ) ) {
				echo $thumb;
			} else {
				echo __('None', 'ibm_eventposttype');
			}
			break;	
			
		// Display the ibm_event tags in the column view
		case "ibm_event_filter":
		
		if ( $category_list = get_the_term_list( $post_id, 'ibm_event_filter', '', ', ', '' ) ) {
			echo $category_list;
		} else {
			echo __('None', 'ibm_eventposttype');
		}
		break;			
	}
}

/**
 * Adds taxonomy filters to the ibm_event admin page
 * Code artfully lifed from http://pippinsplugins.com
 */
 
function ibm_event_add_taxonomy_filters() {
	global $typenow;
	
	// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array( 'ibm_event_filter' );
 
	// must set this to the post type you want the filter(s) displayed on
	if ( $typenow == 'ibm_event' ) {
 
		foreach ( $taxonomies as $tax_slug ) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj = get_taxonomy( $tax_slug );
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if ( count( $terms ) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>$tax_name</option>";
				foreach ( $terms as $term ) {
					echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
				}
				echo "</select>";
			}
		}
	}
}

/**
 * Displays the custom post type icon in the dashboard
 */
	 
function ibm_event_icon() { ?>
	    <style type="text/css" media="screen">
	        #menu-posts-ibm_event .wp-menu-image {
	            background: url(<?php echo get_template_directory_uri() . '/framework/images/admin/ibm_event-icon.png'; ?>) no-repeat 6px 6px !important;
	        }
			#menu-posts-ibm_event:hover .wp-menu-image, #menu-posts-ibm_event.wp-has-current-submenu .wp-menu-image {
	            background-position:6px -16px !important;
	        }
			#icon-edit.icon32-posts-ibm_event {background: url(<?php echo get_template_directory_uri() . '/framework/images/admin/ibm_event-32x32.png'; ?>) no-repeat;}
	    </style>
	<?php } 

/* ----------------------------------------------------- */
/* EOF */
/* ----------------------------------------------------- */

?>