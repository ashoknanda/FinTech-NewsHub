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

    <form class="ibm-row-form" method="post" action="__REPLACE_ME__">
        <p style="float:right;display:block;margin-right:2.3rem;">
            <label style="display:inline-block;">Some select list:</label>
            <?php echo facetwp_display( 'facet', 'categories' ); ?>
            <?php echo facetwp_display( 'facet', 'industry' ); ?>
            <!-- <div><?php echo do_shortcode('[facetwp sort="true"]' ); ?></div> -->
        </p>
    </form>

    <!-- <?php echo facetwp_display( 'facet', 'search' ); ?> -->
    <div data-id="dummyone">
        <div id="story-space-2" class="ibm-columns ibm-cards" data-widget="masonry" data-items=".post">
            <div class="facetwp-template">
                <?php
                $post_count = ($paged - 1)*10;
                if (have_posts()):
                   while (have_posts()):
                        the_post();
                    $post_count += 1;
                       include('_includes/post_listing_grid.php');
                   endwhile;
                else:
                    $my_theme = wp_get_theme();
                    echo '<div class="nh-no-post-matched-message">';
                    _e('Sorry, no posts matched your criteria.', $my_theme->get( 'Name' ));
                    echo '</div class="nh-no-post-matched-message">';
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
