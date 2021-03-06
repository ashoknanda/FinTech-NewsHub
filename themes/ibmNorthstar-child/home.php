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


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
//Get latest Editors pick;
        $latest_editors_args = array(
            // 'category__and' => 'category'
            'tag_slug__and' => array('editor-pick'),
            'showposts' => 1,
            'orderby' => 'date'
        );

        $latest_editor_pick_post = get_posts( $latest_editors_args );
        wp_reset_query();


//Get latest Editors pick;
        // $latest_featured_args = array(
        //     // 'category__and' => 'category'
        //     'tag_slug__and' => array('featured'),
        //     'showposts' => 1,
        //     'orderby' => 'date'
        // );

        // $latest_featured_post = get_posts( $latest_featured_args );  
        // wp_reset_query();
        $twitter_user = 'IBMforMarketing';
        $twitter_hash_tag = 'THINKmarketing';

        $custom_args = array(
            'paged' => $paged,
            'post_type' => 'Post',
            'posts_per_page' => get_field("posts_per_page"),
            'post__not_in' => array( $latest_editor_pick_post[0]->ID ),
            'facetwp' => true,
            'orderby' => 'date'
        );

        $custom_query = new WP_Query($custom_args);        
?>


<div id="content">

<div class="ibm-columns filter-container" style="display:none;">
    <form class="ibm-row-form" method="post" action="__REPLACE_ME__">
        <p>
            <label style="display:inline-block;padding-right: 10px;">Filter:</label>
            <?php echo facetwp_display( 'facet', 'categories' ); ?>
        </p>
    </form>
</div>    

    <div data-id="dummyone">
        <div id="static-cards" class="ibm-columns ibm-cards">
            <?php 
                $dispCard = create_load_more_tile($latest_editor_pick_post[0]);
                echo $dispCard;
            ?>


        </div>
        <div id="story-space-2" class="ibm-columns ibm-cards" data-widget="masonry" data-items=".post">
            <div class="facetwp-template">  
                <?php
                $post_count = ($paged - 1)*10;
                $m3 = 0;
                if ($custom_query->have_posts()):
                   while ($custom_query->have_posts()):
                        $custom_query->the_post();
                        if($post->ID != $latest_editor_pick_post[0]->ID){
                            $post_count += 1;

                            include('_includes/post_listing_grid.php');                           
                        }
                   endwhile;
                elseif($paged==1):
                    $my_theme = wp_get_theme();
                    _e('Sorry, no posts matched your criteria.', $my_theme->get( 'Name' ));
                endif;
                ?>
            </div>
        </div>
    </div>
</div> <!-- #content -->

<?php
wp_reset_query();
get_template_part('_includes/v18_content_main_end');
?>

<?php
get_footer();
?>
