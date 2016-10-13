<?php 
// Register Custom Taxonomy that allows us to hide posts on the homepage, category pages, 
//tags, and contributor pages

function hide_posts() {

	$labels = array(
		'name'                       => _x( 'Hide Posts', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Hide Post', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Hide Posts', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'hide_posts', array( 'post', ' ibm_news' ), $args );

}
add_action( 'init', 'hide_posts', 0 );


//Remove Hide Posts from the Admin Menu
function remove_hide_posts_wp_menu() {
  remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=hide_posts' );
  remove_submenu_page( 'edit.php?post_type=ibm_news', 'edit-tags.php?taxonomy=hide_posts&post_type=ibm_news' );
}
add_action( 'admin_menu', 'remove_hide_posts_wp_menu', 999 );


//Insert the terms
function insert_hide_terms() {
	//insert the term homepage to hide posts and news on the homepage
	wp_insert_term(
		'Home Page',
		'hide_posts',
		array(
		  'description'	=> 'This term is used to hide posts and news on the homepage',
		  'slug' 		=> 'homepage'
		)
	);
	//insert the term Contributors Page to hide posts and news articles on a contributors page
	wp_insert_term(
		'Contributor Page',
		'hide_posts',
		array(
		  'description'	=> 'This term is used to hide posts and news on the contributors page',
		  'slug' 		=> 'contributors-page'
		)
	);
	//insert the term Topics to hide posts and news articles on a Topic page
	wp_insert_term(
		'Categories',
		'hide_posts',
		array(
		  'description'	=> 'This term is used to hide posts and news on the Topic pages',
		  'slug' 		=> 'categories'
		)
	);
	//insert the term Topics to hide posts and news articles on a Topic page
	wp_insert_term(
		'News Page',
		'hide_posts',
		array(
		  'description'	=> 'This term is used to hide news articles on the News Stream Landing Page',
		  'slug' 		=> 'news'
		)
	);
}
add_action( 'init', 'insert_hide_terms' );


//Add styling to hide a few things
function hide_posts_styles() {
  echo '<style>
    #hide_posts-add-toggle {
      display: none;
    }
    #adminmenu .wp-has-current-submenu ul>li>a[href="edit-tags.php?taxonomy=hide_posts&post_type=ibm_news"],
    #adminmenu .wp-submenu a[href="edit-tags.php?taxonomy=hide_posts&post_type=ibm_news"] {
    	display: none;
    }
  </style>';
}
add_action('admin_head', 'hide_posts_styles');

?>