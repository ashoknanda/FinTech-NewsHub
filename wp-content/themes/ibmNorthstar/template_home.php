<?php
/*
Template Name: Home page Temlate
*/
get_header();
?>

<?php
get_template_part('_includes/v18_content_main_start');
?>

    <div id="content">



<?php
/**
 * Limit the main query search results to 25.
 *
 * We only want to filter the limit on the front end of the site, so we use
 * is_admin() to check that we aren't on the admin side.
 *
 * We also only want to filter the main query, so we check that this is it
 * with $query->is_main_query().
 *
 * Finally, we only want to change the limit for searches, so we check that
 * this query is a search with $query->is_search().
 *
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/post_limits
 *
 * @param string $limit The 'LIMIT' clause for the query.
 * @param object $query The current query object.
 *
 * @return string The filtered LIMIT.
 */
function wpcodex_filter_main_search_post_limits($limit, $query)
{

    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        return 'LIMIT 0, 25';
    }

    return $limit;
} ?>
<div class="ibm-band ibm-background-white-core">
<div class="ibm-columns">
</div></div>
<?php

// get_template_part('_includes/post_featured');
$value = get_option( 'post_listing_choice_homepage', '' );
if(esc_attr($value) == "post_listing_choice_homepage_stack")
{
?><div id="story-space"><?php
}
else
{
?><div id="story-space" class="ibm-columns ibm-cards" data-widget="masonry" data-items=".post"><?php
}

add_filter('post_limits', 'wpcodex_filter_main_search_post_limits', 12, 2);

// ---------------------------------------------------------------------------
// Query

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$carousel_count = 0;

$custom_args = array(
    'paged' => $paged,
    'post_type' => 'Post',
    'posts_per_page' => get_field("posts_per_page"),
    'orderby' => 'date'
);

$custom_query = new WP_Query($custom_args);
//$max          = $posts->max_num_pages;
//$post_spot = 0;
//$post_highlighted_spot = 0;
//$grid_with_highlights = true;
//$highlighted_posts = [];
$post_count = 0;
if ($custom_query->have_posts()){
    while ($custom_query->have_posts()):
        $post_count += 1;
        $custom_query->the_post();
        $isFeatured = false;
        $categories = get_the_category();
        foreach ( $categories as $category ) {
            if($category->name == 'Featured Carousel'){
                $carousel_count = $carousel_count + 1;
                $isFeatured = true;
            }
        }
        if($isFeatured == true && $carousel_count <= 3){
            $isFeatured = false;
        }
        else {
            if(esc_attr(get_option( 'post_listing_choice_homepage', '' )) == "post_listing_choice_homepage_stack")
            {
                include('_includes/post_listing_stack.php');
            }
            else
            {
                include('_includes/post_listing_grid.php');
            }
        }
    endwhile;
}else{
?>
<p><?php
    $my_theme = wp_get_theme();
    _e('Sorry, no posts matched your criteria.', $my_theme->get( 'Name' ));
?></p>
<?php
}
?>

</div> <!-- .ibm-columns -->


</div> <!-- #content -->

<!-- pagination here -->
<?php
if (function_exists("custom_pagination")) {
    custom_pagination($custom_query->max_num_pages, "", $paged);
    wp_reset_postdata();
} else {
    $my_theme = wp_get_theme();
    _e("<p>Sorry, no posts matched your criteria.</p>", $my_theme->get( 'Name' ));
}
?>


	<?php
get_template_part('_includes/v18_content_main_end');
?>

<?php
get_footer();
?>
