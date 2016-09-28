<?php
function theme_pagination($pages = '', $range = 1, $category = false)
{  
	$showitems = 3;
	
	global $paged;
	if(empty($paged)) $paged = 1;
	
	if($pages == '')
	{
	   global $wp_query;
	   $pages = $wp_query->max_num_pages;
	   if(!$pages)
	   {
	       $pages = 1;
	   }
	}   
	if ($category) {
		$pages = $pages - 1;
	}
	if(1 != $pages)
	{
	   echo '<aside class="pagenavi row"><ul class="six mobile-two columns">';
	
	
	   if($paged > 1 && $showitems < $pages) echo '<li class="arrow"><a href="'.get_pagenum_link($paged - 1).'"><i class="fa fa-angle-left"></i></a></li>';
	
	   for ($i=1; $i <= $pages; $i++)
	   {
	       if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	       {
	           echo ($paged == $i)? "<li class='disabled'><a>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
	       }
	   }
	
	   if ($paged < $pages && $showitems < $pages) echo '<li class="arrow"><a href="'.get_pagenum_link($paged + 1).'"><i class="fa fa-angle-right"></i></a></li>';  
	   echo '</ul><div class="six mobile-two columns"><span class="pages">'.$paged.' of '.$pages.'</span></div></aside>';
	}
	
	if(1==2){paginate_links(); posts_nav_link(); next_posts_link(); previous_posts_link();}
}


function theme_pagination2($pages = '', $range = 1, $category = false)
{  
	$showitems = 2;
	
	global $paged2;
	if(empty($paged2)) $paged2 = 1;
	
	if($pages == '')
	{
	   global $wp_query;
	   $pages = $wp_query->max_num_pages;
	   if(!$pages)
	   {
	       $pages = 1;
	   }
	}   
	if ($category) {
		$pages = $pages - 1;
	}
	if(1 != $pages)
	{
	   echo '<aside class="pagenavi row"><ul class="six mobile-two columns">';
	
	
	   if($paged2 > 1 && $showitems < $pages) echo '<li class="arrow"><a href="'.get_pagenum_link2($paged2 - 1).'"><i class="fa fa-angle-left"></i></a></li>';
	
	   for ($i=1; $i <= $pages; $i++)
	   {
	       if (1 != $pages &&( !($i >= $paged2+$range+1 || $i <= $paged2-$range-1) || $pages <= $showitems ))
	       {
	           echo ($paged2 == $i)? "<li class='disabled'><a>".$i."</a></li>":"<li><a href='".get_pagenum_link2($i)."'>".$i."</a></li>";
	       }
	   }
	
	   if ($paged2 < $pages && $showitems < $pages) echo '<li class="arrow"><a href="'.get_pagenum_link2($paged2 + 1).'"><i class="fa fa-angle-right"></i></a></li>';  
	   echo '</ul><div class="six mobile-two columns"><span class="pages">'.$paged2.' of '.$pages.'</span></div></aside>';
	}
	
	if(1==2){paginate_links(); posts_nav_link(); next_posts_link(); previous_posts_link();}
}



function get_pagenum_link2($pagenum = 1, $escape = true ) {
	global $wp_rewrite;

	$pagenum = (int) $pagenum;

	$request = remove_query_arg( 'pu' );

	$home_root = parse_url(home_url());
	$home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
	$home_root = preg_quote( $home_root, '|' );

	$request = preg_replace('|^'. $home_root . '|i', '', $request);
	$request = preg_replace('|^/+|', '', $request);

	$base = trailingslashit( get_bloginfo( 'url' ) );

	if ( $pagenum > 1 ) {
		$result = add_query_arg( 'pu', $pagenum, $base . $request );
	} else {
		$result = $base . $request;
	}
	
	$result = apply_filters( 'get_pagenum_link', $result );

	if ( $escape )
		return esc_url( $result );
	else
		return esc_url_raw( $result );
}
?>