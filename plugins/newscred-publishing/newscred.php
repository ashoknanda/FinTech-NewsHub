<?php
/*
Plugin Name: NewsCred CMC
Description: Supercharge your NewsCred CMC experience with this plugin
Version: 0.0.11
Author: Matthew Isabel, Raju Hossain, Riyadh Al Nur
Author URI: http://www.newscred.com
*/

add_filter( 'xmlrpc_methods', 'nc_xmlrpc_methods' );

require_once ABSPATH . 'wp-admin/includes/post.php';
require_once(plugin_dir_path(__FILE__).'yoast.php');

include_once ABSPATH . 'wp-admin/includes/plugin.php';

if (is_plugin_active('search-everything/search-everything.php')) {
  // Search Everything uses search filters which are suppressed by default by
  // the XMLRPC search endpoint, so we need to un-suppress it
  add_action('parse_query', function ($wp_query) {
    $wp_query->query_vars['suppress_filters'] = false;
  });
}

function nc_xmlrpc_methods( $methods ) {
    $methods['wp.getPost'] = 'nc_getPost';
    $methods['nc.editImageMeta'] = 'nc_editImageMeta';
    return $methods;
}

function nc_getPost( $args ) {
    global $wp_xmlrpc_server;

    if ( ! isset( $args[4] ) ) {
        $args[4] = apply_filters( 'xmlrpc_default_post_fields', array( 'post', 'terms', 'custom_fields' ), 'nc_getPost' );
    }

    $post_obj = $wp_xmlrpc_server->wp_getPost( $args );

    $post_obj['permalink'] = nc_getPermalinkPath( $post_obj['post_id'] );
    $post_obj['slug'] = nc_getSlug( $post_obj['post_id'] );

    return $post_obj;
}

function nc_getPermalinkPath ( $post_id ) {
    list( $permalink, $postname ) = get_sample_permalink( $post_id );

    return $permalink;
}

function nc_getSlug ( $post_id ) {
    list( $permalink, $postname ) = get_sample_permalink( $post_id );

    return $postname;
}

function nc_editImageMeta( $args ) {
    $post_id  = (int) $args[3];
    $content_struct = $args[4];

    $my_post = array( 'ID' => $post_id );

    if (array_key_exists("post_excerpt", $content_struct)) {
      $my_post['post_excerpt'] = $content_struct['post_excerpt'];
    }

    if (count($my_post) > 1){
      // Update the post into the database
      wp_update_post( $my_post );
    }

    if (array_key_exists("image_alt", $content_struct)) {
      update_post_meta( $post_id, '_wp_attachment_image_alt', $content_struct['image_alt']);
    }

    return $my_post;
}
