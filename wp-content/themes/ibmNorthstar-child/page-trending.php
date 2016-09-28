<?php
get_header();
?>
<!-- <script src="<?php //echo get_stylesheet_directory_uri().'/assets/js/infinite_load_fw.js'; ?>"></script>  -->

<?php
get_template_part('_includes/v18_content_main_start');

function my_facetwp_is_main_query( $is_main_query, $query ) {
    if ( isset( $query->query_vars['facetwp'] ) ) {
        $is_main_query = true;
    }
    return $is_main_query;
}
add_filter( 'facetwp_is_main_query', 'my_facetwp_is_main_query', 10, 2 );


        $twitter_user = 'IBMforMarketing';
        $twitter_hash_tag = 'NewWaytoEngage';


$ids_from_query = wp_get_all_popular_ids();
$postidstofetch = explode(",",$ids_from_query);

// $paged = (get_query_var('paged')) ? get_query_var('paged') : get_query_var('fwp_paged') ? get_query_var('fwp_paged'):1;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$custom_args = array(
    'post__in' => $postidstofetch,
    'posts_per_page' => get_field("posts_per_page"),
    'facetwp' => true,
    'orderby' => 'post__in'
);



// add_filter( 'posts_clauses', 'filter_by_popular', 10, 2 );
// function filter_by_popular( $clauses, $query_object ){
//     $join = &$clauses['join'];
//     if (! empty( $join ) ) $join .= ' ';
//     $join .= " INNER JOIN {$wpdb->prefix}most_popular mp on mp.post_id = {$wpdb->posts}.ID";

//     $where = &$clauses['where'];
//     $where .= " AND p.post_type IN 'post' AND p.post_status = 'publish'"; 

//     $orderby = &$clauses['orderby'];
//     $orderby = "{wpdb->prefix}most_popular.7_day_stats DESC ".$orderby;

//     // print_r($clauses);
//     return $clauses;
// }

$custom_query = new WP_Query($custom_args);

?>
<div id="content">

<div class="ibm-columns filter-container" style="display:none;">
    <form class="ibm-row-form" method="post" action="__REPLACE_ME__">
        <p>
            <label style="display:inline-block;padding-right: 10px;">Filter:</label>
            <?php echo facetwp_display( 'facet', 'categories' ); ?>
            <?php echo facetwp_display( 'facet', 'topics' ); ?>
        </p>
    </form>
</div> 

    <!-- <div data-id="dummyone"> -->
        <div id="story-space-2" class="ibm-columns ibm-cards" style="" data-widget="masonry" data-items=".post">
            <div class="facetwp-template"> 
                <?php
                $post_count = ($paged - 1)*10;
                $m3 = 0;
                if ($custom_query->have_posts()):
                    while ($custom_query->have_posts()):
                        $post_count += 1;
                        $custom_query->the_post();

                // if (isset($custom_posts)):
                //    global $post;
                //    foreach ($custom_posts as $post):
                //         setup_postdata($post);
                        // $post_count += 1;

                       include('_includes/post_listing_grid.php');
                   // endforeach;
                       endwhile;
                elseif($paged==1):
                    $my_theme = wp_get_theme();
                    echo '<div class="nh-no-post-matched-message">';
                    _e('Sorry, no posts matched your criteria.', $my_theme->get( 'Name' ));
                    echo '</div>';
                endif;
                ?>
            </div>
        </div>
<!--         <div>Should show load more here ...<?php //next_posts_link('Load More..',$max_num_pages); ?></div> -->
    <!-- </div> -->
</div> <!-- #content -->

<?php
wp_reset_query();
get_template_part('_includes/v18_content_main_end');
?>

<?php
get_footer();
?>
