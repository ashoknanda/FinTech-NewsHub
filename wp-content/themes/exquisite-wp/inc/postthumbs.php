<?php
// Enable WP Post Thumbnails
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 110, 80, true );
	add_image_size('featured', 312, 375, true );
	add_image_size('slider', 752, 535, true );
	add_image_size('category-slider', 938, 580, true );
	add_image_size('recent', 284, 190, true );
	add_image_size('widget', 293, 170, true );
	add_image_size('category-home3', 534, 265, true );
	add_image_size('single', 938, 535, true );
	add_image_size('blog', 938, 465, true );
}

/**
 * Default post thumbnail image.
 * 
 * @param  string $html The Output HTML of the post thumbnail
 * @param  int $post_id The post ID
 * @param  int $post_thumbnail_id The attachment id of the image
 * @param  string $size The size requested or default
 * @param  mixed string/array $attr Query string or array of attributes
 * @return string $html the Output HTML of the post thumbnail
 * NOTE: Each custom image size (set in add_image_size functions above) needs a default thumbnail in /assets/img/
 */
function wpse64763_post_thumbnail_fb( $html, $post_id, $post_thumbnail_id, $size, $attr )
{
    if ( empty( $html ) )
    {
    	global $_wp_additional_image_sizes;
        return sprintf(
            '<img src="%s" width="%s" height="%s" class="noimg" />',
            get_template_directory_uri().'/assets/img/featured-' . $size . '.jpg',
            $_wp_additional_image_sizes[$size]['width'],
            $_wp_additional_image_sizes[$size]['height']
        );
    }

    return $html;
}
add_filter( 'post_thumbnail_html', 'wpse64763_post_thumbnail_fb', 20, 5 );

?>