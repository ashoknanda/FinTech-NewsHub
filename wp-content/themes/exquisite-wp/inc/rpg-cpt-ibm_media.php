<?php
/* ----------------------------------------------------- */
/* ibm_media Custom Post Type */
/* ----------------------------------------------------- */

add_action( 'init', 'cpt_register_ibm_media' );
function cpt_register_ibm_media() {
	register_post_type( 'ibm_media',
		array(
			'labels' => array(
				'name' => __( 'Media' ),
				'singular_name' => __( 'media' ),
				'menu_name' => 'Media Items',
				'all_items' => 'All Media'
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => array( 'slug' => 'media' ),
			'capability_type' => 'media',
			'has_archive' => false, 
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => 'dashicons-images-alt2', // http://melchoyce.github.io/dashicons/
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'post-formats' ),
			'map_meta_cap' => true,			
		)
	);
	flush_rewrite_rules();
}

add_action( 'init', 'create_res_tax' );
function create_res_tax() {
	// Add new "ibm_media" taxonomy to Posts
	register_taxonomy('media_cat', 'ibm_media', 
		array(
			// Hierarchical taxonomy (like categories)
			'hierarchical' => true,
			// This array of options controls the labels displayed in the WordPress Admin UI
			'label' => __( 'Media Categories' ),
			// Control the slugs used for this taxonomy
			'rewrite' => array(
				'slug' => 'media-type', // This controls the base slug that will display before each term
				'hierarchical' => true,
				'with_front' => true
			),
		)
	);
	flush_rewrite_rules();
}


/* ----------------------------------------------------- */
/* EOF */
/* ----------------------------------------------------- */

?>