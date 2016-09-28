<?php
/* ----------------------------------------------------- */
/* ibm_news Custom Post Type */
/* ----------------------------------------------------- */

add_action( 'init', 'cpt_register_ibm_news' );
function cpt_register_ibm_news() {
	register_post_type( 'ibm_news',
		array(
			'labels' => array(
				'name' => __( 'News' ),
				'singular_name' => __( 'news' ),
				'menu_name' => 'News',
				'all_items' => 'All News'
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => array( 'slug' => 'news' ),
			'capability_type' => 'news',
			'has_archive' => false, 
			'hierarchical' => false,
			'menu_position' => null,
			'taxonomies' => array('post_tag', 'hide_posts'),
			'menu_icon' => 'dashicons-megaphone', // http://melchoyce.github.io/dashicons/
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
			'map_meta_cap' => true,			
		)
	);
	flush_rewrite_rules();
}

/* ----------------------------------------------------- */
/* EOF */
/* ----------------------------------------------------- */

?>