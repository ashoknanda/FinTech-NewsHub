<?php



// ---------------------------------------------------------------------------
// The Dashboard is a mess, let's clean it up a bit.

    add_action( 'wp_dashboard_setup', function() {
        global $wp_meta_boxes;

        // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);        // Right Now Widget
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);         // Activity Widget
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);  // Comments Widget
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);   // Incoming Links Widget
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);          // Plugins Widget
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);        // Quick Press Widget
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);      // Recent Drafts Widget
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);            //
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);          //

        // remove plugin dashboard boxes
        unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);            // Yoast's SEO Plugin Widget
        unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);         // Gravity Forms Plugin Widget
        unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);    // bbPress Plugin Widget

    });

