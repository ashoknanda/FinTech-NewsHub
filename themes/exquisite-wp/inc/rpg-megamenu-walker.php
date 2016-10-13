<?php
class rpg_walker_nav_menu extends Walker_Nav_Menu {
	private $in_sub_menu = 0;
	private $accepted_types = array( 'category', 'media_cat' );

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '<div class="category-holder"><ul>';
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '</ul>';
	}
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ( $depth === 0 ) { // Top level nav items
			$this->in_sub_menu = 0;
	    // $output .= print_r($item);
	    if ($item->object_id === '6709') {
	    	// special treatment for the News page
		    $output .= '<li class="item-news"><a href="' . esc_attr( $item->url ) . '" title="News Stream">News Stream</a>';
	    } else {
		    $output .= '<li><a href="' . esc_attr( $item->url ) . '">' . apply_filters( 'the_title', $item->title, $item->ID ) . '</a>';
	    }
		} else if ( $depth === 1 && in_array( $item->object, $this->accepted_types ) ) { // Only show second level items if they are categories (that's all this menu supports for now)
	    $cat_name = esc_attr( $item->title );
			$cat_id = esc_attr( $item->object_id );
			$cat_color = GetCategoryColor($cat_id);
	    $cat_name = apply_filters( 'list_cats', $cat_name, $item );
	    $termchildren = get_term_children( $item->object_id, $item->type_label );

	    // Detect first child of submenu then add class active
	    $aclass = '';
	    $datacolor = '';
	    if( ! $this->in_sub_menu ) {
	        $aclass = 'class="active"';   
	        $this->in_sub_menu = 1;
	    }
		
	    $link = '<a '.$aclass.' href="' . esc_attr( $item->url ) . '" '.$datacolor.' title="' . esc_attr( sprintf(__( 'View all posts filed under %s' ), $cat_name) ) . '">'.$cat_name . '</a>';

			$output .= '<li>'.$link;
		} else if ( $depth === 1 && $item->object == 'page') {
	    $cat_name = esc_attr( $item->title );
			$cat_id = esc_attr( $item->object_id );
			$cat_color = GetCategoryColor($cat_id);
	    $cat_name = apply_filters( 'list_cats', $cat_name, $item );
	    $termchildren = get_term_children( $item->object_id, $item->type_label );

	    // Detect first child of submenu then add class active
	    $aclass = '';
	    $datacolor = '';
	    if( ! $this->in_sub_menu ) {
	        $aclass = 'class="active"';   
	        $this->in_sub_menu = 1;
	    }
		
	    $link = '<a '.$aclass.' href="' . esc_attr( $item->url ) . '" '.$datacolor.' title="' . esc_attr( sprintf(__( 'View all posts filed under %s' ), $cat_name) ) . '">'.$cat_name . '</a>';

			$output .= '<li>'.$link;
		}
	}
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( $depth === 0 ) {
			$menu_items = wp_get_nav_menu_items(527, array('post_type' => 'nav_menu_item', 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
			if ( !empty( $menu_items ) ) {

				//print_r( $menu_items );
				$output .= '<div class="category-children">';
				$i = 0;

				foreach ( (array) $menu_items as $key => $menu_item ) {
					$output .= '<div'.(($i===0)?' class="active"':'').'>'; // add active class to first item

					if ($menu_item->object == 'category') {
						$query = new WP_Query(array( 
							'posts_per_page' => 3,
							'no_found_rows' => true,
							'post_status' => 'publish',
							'cat' => $menu_item->object_id,
							'tax_query' => array(
								array(
									'taxonomy'  => 'hide_posts',
									'field'     => 'slug',
									'terms'     => 'categories', // exclude items tagged with homepage
									'operator'  => 'NOT IN'
								)
							)
						));
					} else if ($menu_item->object == 'media_cat') {
						$query = new WP_Query(array( 
							'post_type' => 'ibm_media',
							'posts_per_page' => 3,
							'no_found_rows' => true,
							'post_status' => 'publish',
							'tax_query' => array(
								array(
									'taxonomy' => $menu_item->object,
									'field' => 'id',
									'terms' => $menu_item->object_id
								)
							),
						));
					} 
					else if ($menu_item->object == 'page') {
						$query1 = new WP_Query(array( 
							'post_type' => 'page',
							'p' => $menu_item->object_id,							
							'no_found_rows' => true,
							'post_status' => 'publish',
							'posts_per_page' => 1,
						));
						if ($query1->have_posts()) : while ($query1->have_posts()) : 
							$query1->the_post();
							$post = $query1->post;
							if (get_page_template_slug($post->ID) == 'template-x-force-list.php'){
								$query = new WP_Query(array( 
									'post_type' => array(                   
		                    'ibm_general_advisory',                         
		                    'ibm_vulnerabilities',                         
		                    'ibm_malware',                     
		                    ),  
									'orderby' => '_ibm_vulnerabilities_notification_date _ibm_malware_disclosure _ibm_general_advisory_notification_date date',
									'no_found_rows' => true,
									'post_status' => 'publish',
									'posts_per_page' => 3,
								));
							}else{
								$query = $query1;
							}
						endwhile; else: endif;
					}
					if ($query) {
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
					}
					$output .= '<a href="'.esc_url($menu_items[$i]->url).'" class="gotocategory" title="'.$menu_items[$i]->name.'">View all</a>';
					$output .= '</div>';
					$i++;
				}
				$output .= '</div>';
			}
			$output .= "</li>";
		} else if ( $depth === 1 && in_array( $item->object, $this->accepted_types ) ) { // Only show second level items if they are categories (that's all this menu supports for now)
			$output .= '</li>';
		}
	}
}
?>