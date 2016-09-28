<?php

/*

This file contains functions which clean and update the Wordpress functionality.
Highly infuenced/stolen from the bones Wordpress template (http://themble.com/bones/).

*/

// ---------------------------------------------------------------------------
// BOOTSTRAP
// This is the start of it all, first theme event hook. Begin cleaning up the Wordpress output and adding theme styles

    add_action('after_setup_theme', 'theme_setup');

    function theme_setup() {
        console.log('theme_setup...');

        // launching operation cleanup
        add_action( 'init', 'theme_head_cleanup' );
        // A better title
        add_filter( 'wp_title', 'rw_title', 10, 3 );
        // remove pesky injected css for recent comments widget
        add_filter( 'wp_head', 'theme_remove_wp_widget_recent_comments_style', 1 );
        // clean up comment styles in the head
        add_action( 'wp_head', 'theme_remove_recent_comments_style', 1 );

        // clean up gallery output in wp
        add_filter( 'gallery_style', 'theme_gallery_style' );

        // enqueue base scripts and styles
        add_action( 'wp_enqueue_scripts', 'theme_scripts_and_styles', 999 );

        // cleaning up random code around images
        //add_filter( 'the_content', 'theme_filter_ptags_on_images' );

        // Clean up the Comment form a bit to work better with V18
        add_filter( 'comment_form_defaults', 'custom_comment_form_defaults' );

        // Deactivate the emoji stuff in Wordpress
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );

        // We need images, right?
        add_theme_support( 'post-thumbnails', array( 'post', 'page') );


        // Add the ACF options page.
        if (function_exists('acf_add_options_page')) acf_add_options_page();

    };

// ---------------------------------------------------------------------------
// Clean up WP_HEAD
// The default wordpress head is a mess. Let's clean it up by removing all the junk we don't need.

    function theme_head_cleanup() {
        // category feeds
        // Add feeds back for this site.
        remove_action( 'wp_head', 'feed_links_extra', 3 );
        // post and comment feeds
        // Add feeds back for this site.
        remove_action( 'wp_head', 'feed_links', 2 );
        // EditURI link
        remove_action( 'wp_head', 'rsd_link' );
        // windows live writer
        remove_action( 'wp_head', 'wlwmanifest_link' );
        // previous link
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
        // start link
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
        // links for adjacent posts
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        // WP version
        remove_action( 'wp_head', 'wp_generator' );

        // remove WP version from css
        add_filter( 'style_loader_src', 'theme_remove_wp_ver_css_js', 9999 );
        // remove Wp version from scripts
        add_filter( 'script_loader_src', 'theme_remove_wp_ver_css_js', 9999 );

    }


// ---------------------------------------------------------------------------
// Add theme CSS and JS

    function theme_scripts_and_styles() {
        console.log('theme_scripts_and_styles...');

        global $wp_styles;

        // Don't do this in the Admin Panel
        if (is_admin()) return;

        // comment reply script for threaded comments
        /*
        if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
              wp_enqueue_script( 'comment-reply' );
        }
        */

        // Extensions
        /*
        wp_enqueue_style( 'vendor_jssocials_css', get_stylesheet_directory_uri() . '/assets/vendor/jssocials-0.2.0/jssocials.css', array(), '', 'all' );
        wp_enqueue_style( 'vendor_jssocials_css_theme', get_stylesheet_directory_uri() . '/assets/vendor/jssocials-0.2.0/jssocials-theme-flat.css', array(), '', 'all' );
        wp_enqueue_script( 'vendor_jssocials_js', (get_stylesheet_directory_uri().'/assets/vendor/jssocials-0.2.0/jssocials.js'), array('jquery'), '', true );
        */

        // Theme Stuff
        wp_enqueue_style( 'site_css', get_stylesheet_directory_uri() . '/assets/css/style.css', array(), '', 'all' );
        wp_enqueue_script( 'site_js', (get_stylesheet_directory_uri().'/assets/js/site.js'), array('jquery'), '', true );
        wp_enqueue_script( 'social_card_js', (get_stylesheet_directory_uri().'/assets/js/social_card.js'), array(), '', true );
        wp_deregister_script('jquery');


    }


// ---------------------------------------------------------------------------
// Helper functions

    function custom_comment_form_defaults($defaults){
        $my_theme = wp_get_theme();
        $defaults['comment_notes_before'] = '<p class="ibm-item-note-alternate">'
                                          . '<span>Your email address will not be published.</span>'
                                          . '<span>' . sprintf( __('Required fields are marked %s',$my_theme->get( 'Name' )), '<em class="required">*</em>' ) . '</span>'
                                          . '</p>';
        return $defaults;
    }

    // Remove version number from CSS and JS embed.
    function theme_remove_wp_ver_css_js($src) {
        if (strpos($src, 'ver=' )) $src = remove_query_arg( 'ver', $src );
        return $src;
    };

    // Clean up the meta title and make it more SEO friendly.
    // http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
    function rw_title( $title, $sep, $seplocation ) {
        global $page, $paged;

        // Don't affect in feeds.
        if ( is_feed() ) return $title;

        // Add the blog's name
        if ( 'right' == $seplocation ) {
        $title .= get_bloginfo( 'name' );
        } else {
        $title = get_bloginfo( 'name' ) . $title;
        }

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );

        if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title .= " {$sep} {$site_description}";
        }

        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 ) {
            $my_theme = wp_get_theme();
        $title .= " {$sep} " . sprintf( __( 'Page %s', $my_theme->get( 'Name' ) ), max( $paged, $page ) );
        }

        return $title;

    }

    // remove injected CSS for recent comments widget
    function theme_remove_wp_widget_recent_comments_style() {
        if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
            remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
        }
    }

    // remove injected CSS from recent comments widget
    function theme_remove_recent_comments_style() {
        global $wp_widget_factory;
        if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
            remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
        }
    }

    // remove injected CSS from gallery
    function theme_gallery_style($css) {
        return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
    }

    // Remove the P from around IMG
    // http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
    function theme_filter_ptags_on_images($content){
        return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    }

add_action('do_meta_boxes', 'theme_remove_featured_image_box');

function theme_remove_featured_image_box() {
    remove_meta_box( 'postimagediv', 'post', 'side' );
    remove_meta_box( 'postimagediv', 'page', 'side' );
}
