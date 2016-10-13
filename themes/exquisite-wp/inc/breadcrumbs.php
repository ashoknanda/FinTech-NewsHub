<?php
function archive_title($args = false) {
	$defaults 	 = array(
		'title' 		=> thb_which_archive(),
		'html'			=> "<h1{color}>{title}</h1>"
	);

	// Parse incoming $args into an array and merge it with $defaults
	$args = wp_parse_args( $args, $defaults );

	// OPTIONAL: Declare each item in $args as its own variable i.e. $type, $before.
	extract( $args, EXTR_SKIP );

	
	if (is_category()) {
		$color = GetCategoryColor(get_query_var('cat'));
		$html = str_replace('{color}', ' style="color:'.$color.';"', $html);
	} else {
		$html = str_replace('{color}', '', $html);
	}

	$html = str_replace('{title}', $title, $html);

	return $html;
} 
function thb_breadcrumb() {

	global $post, $wp_query;
	$id = $wp_query->get_queried_object_id(); 
	
	echo '<ul>';
	if ( !is_front_page() ) {
		echo '<li><a href="';
		echo home_url();
		echo '">'.__('Home', THB_THEME_NAME);
		echo "</a></li>";
	}

	if(is_singular('portfolio')) {
			$portfolio_main = get_post_meta($post->ID, 'portfolio_main', TRUE);
			if ($portfolio_main) {
				$portfolio_link = get_permalink($portfolio_main);
			} else {
				$portfolio_link = get_portfolio_page_link(get_the_ID()); 
			}
	    echo '<li><i class="fa fa-angle-right"></i>  <a href="' . $portfolio_link . '">' . __( 'Portfolio', THB_THEME_NAME ) . '</a></li>'; 
	    echo '<li><i class="fa fa-angle-right"></i> '.get_the_title().'</li>'; 
	}
	
	if(is_home()) { echo '<li><i class="fa fa-angle-right"></i> '.__('Blog', THB_THEME_NAME).'</li>'; }

	if(is_page() && !is_front_page()) {
	    $parents = array();
	    $parent_id = $post->post_parent;
	    while ( $parent_id ) :
	        $page = get_page( $parent_id );
	        $parents[]  = '<li><i class="fa fa-angle-right"></i> <a href="' . get_permalink( $page->ID ) . '" title="' . get_the_title( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>';
	        $parent_id  = $page->post_parent;
	    endwhile;
	    $parents = array_reverse( $parents );
	    echo join( ' ', $parents );
	    echo '<li><i class="fa fa-angle-right"></i> '.get_the_title().'</li>';
	}

	// OLD VERSION OF STATEMENT DIRECTLY BELOW (FEEL FREE TO DELETE THIS BLOCK IF THIS ISN'T BEING DEVELOPED ANYMORE)
	// if(is_single() && !is_singular('portfolio')) {
	//     $categories = get_the_category($id);
	//     if ( $categories ) :
	//         foreach ( $categories as $cat ) :
	//             $cats[] = '<li><i class="fa fa-angle-right"></i> <a href="' . get_category_link( $cat->term_id ) . '" title="' . $cat->name . '">' . $cat->name . '</a></li>';
	//         endforeach;
	//         echo join(' ', $cats);
	//     endif;
	//     echo '<li><i class="fa fa-angle-right"></i> '.get_the_title().'</li>';
	// }

	if(is_single() && !is_singular('portfolio')) {

		$postType = get_post_type( $id );

		switch ($postType) {

			case 'post':
			    echo '<li><i class="fa fa-angle-right"></i> <a href="' . get_permalink( 1849 ) . '">Articles</a></li>';
			    echo '<li><i class="fa fa-angle-right"></i> ' . get_the_title() . '</li>';
				break;

			case 'ibm_news':
			    echo '<li><i class="fa fa-angle-right"></i> <a href="' . get_permalink( 6709 ) . '">News</a></li>';
			    echo '<li><i class="fa fa-angle-right"></i> ' . get_the_title() . '</li>';
				break;

			case 'ibm_media':
				$categories = wp_get_post_terms( $id, 'media_cat', array( 'fields' => 'all', 'public' => true ) );
			    if ( $categories ) {
			        foreach ( $categories as $cat ) :
			            $cats[] = '<li><i class="fa fa-angle-right"></i> <a href="' . get_category_link( $cat->term_id ) . '" title="' . $cat->name . '">' . $cat->name . '</a></li>';
			        endforeach;
			        echo join(' ', $cats);
			    } else {
				    echo '<li><i class="fa fa-angle-right"></i> <a href="' . get_permalink( 1883 ) . '">Media</a></li>';
			    }
			    echo '<li><i class="fa fa-angle-right"></i> ' . get_the_title() . '</li>';
				break;

			case 'ibm_event':
				$eventType = get_post_meta( $id, '_ibm_event_type', true );
				$eventTime = get_post_meta( $id, '_ibm_event_end', true );
				if ($eventType == 'inperson' && $eventTime > time()) {
				    echo '<li><i class="fa fa-angle-right"></i> <a href="' . get_permalink( 1846 ) . '">Upcoming In-Person</a></li>';
				} else if ($eventType == 'inperson' && $eventTime <= time()) {
				    echo '<li><i class="fa fa-angle-right"></i> <a href="' . get_permalink( 1846 ) . '">In-Person</a></li>';
				} else if ($eventType == 'webinar' && $eventTime > time()) {
				    echo '<li><i class="fa fa-angle-right"></i> <a href="' . get_permalink( 1846 ) . '">Upcoming Webinars</a></li>';
				} else if ($eventType == 'webinar' && $eventTime <= time()) {
				    echo '<li><i class="fa fa-angle-right"></i> <a href="' . get_permalink( 1846 ) . '">On-Demand Webinars</a></li>';
				} else {
				    echo '<li><i class="fa fa-angle-right"></i> <a href="' . get_permalink( 1846 ) . '">Events</a></li>';
				}
			    echo '<li><i class="fa fa-angle-right"></i> ' . get_the_title() . '</li>';
				break;

			default:
					if ($postType == 'ibm_general_advisory' || $postType ==  'ibm_vulnerabilities' || $postType == 'ibm_malware'){
						echo '
						<li>
							<i class="fa fa-angle-right"></i> 
							<a href="/x-force/" title="X-Force">X-Force</a>
						</li>
						<li>
							<i class="fa fa-angle-right"></i> 
							<a href="/x-force/threat-center/" title="Threat Center">Threat Center</a>
						</li>';						
				    echo '<li><i class="fa fa-angle-right"></i> ' . get_the_title() . '</li>';
					}else{
				    echo '<li><i class="fa fa-angle-right"></i> ' . get_the_title() . '</li>';
					}
				break;

		}

	}


	if(is_archive()) { 
	
		if (is_category()) {			
			echo '<li><i class="fa fa-angle-right"></i> '.single_cat_title('',false).'</li>';

		} elseif ( class_exists( 'woocommerce' ) && is_woocommerce() && is_shop()) {
			echo '<li><i class="fa fa-angle-right"></i> '.get_the_title(woocommerce_get_page_id('shop')).'</li>';
		} else {
			echo '<li><i class="fa fa-angle-right"></i> '.thb_which_archive().'</li>'; 
		}
	}

	if(is_search()) { 
		echo '<li><i class="fa fa-angle-right"></i> '.thb_which_archive().'</li>'; 
	}

	echo "</ul>";

} 
function thb_which_archive() {
	$output = "";
	
	if ( is_category() )
	{
		$output = single_cat_title('',false);
	}
	elseif (is_day())
	{
		$output = __('Archive for date:', THB_THEME_NAME)." ".get_the_time('F jS, Y');
	}
	elseif (is_month())
	{
		$output = __('Archive for month:', THB_THEME_NAME)." ".get_the_time('F, Y');
	}
	elseif (is_year())
	{
		$output = __('Archive for year:', THB_THEME_NAME)." ".get_the_time('Y');
	}
	elseif (is_search())
	{
		global $wp_query;
		if(!empty($wp_query->found_posts))
		{
			if($wp_query->found_posts > 1)
			{
				$output =  __('Search results for:', THB_THEME_NAME)." ".esc_attr( get_search_query() );
			}
			else
			{
				$output =  __('Search result for:', THB_THEME_NAME)." ".esc_attr( get_search_query() );
			}
		}
		else
		{
			if(!empty($_GET['s']))
			{
				$output = __('Search results for:', THB_THEME_NAME)." ".esc_attr( get_search_query() );
			}
			else
			{
				$output = __('To search the site please enter a valid term', THB_THEME_NAME);
			}
		}

	}
	elseif (is_author())
	{
		$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		$output = __('Author Archive', THB_THEME_NAME)." ";

		if(isset($curauth->display_name)) $output .= __('for', THB_THEME_NAME)." ".$curauth->display_name;

	}
	elseif (is_tag())
	{
		$output = __('Tag Archive for:', THB_THEME_NAME)." ".single_tag_title('',false);
	}
	elseif(is_tax())
	{
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$output = __('Archive for:', THB_THEME_NAME)." ".$term->name;
	}
	else
	{
		$output = __('Archives', THB_THEME_NAME)." ";
	}

	if (isset($_GET['paged']) && !empty($_GET['paged']))
	{
		$output .= " (".__('Page', THB_THEME_NAME)." ".$_GET['paged'].")";
	}

	return $output;
}
?>