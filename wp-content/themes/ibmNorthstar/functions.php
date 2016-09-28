<?php
// Site customizations.
require_once('_library/site.php');
// Admin customizations.
require_once('_library/admin.php');
// Helper functions called from various templates.
require_once('_library/helpers.php');
// Comments template, kinda messy so let's keep it separate.
require_once('_library/comments.php');
// ACF fields
require_once('_library/acf.php');

//Initialize the update checker.
require 'theme-updates/theme-update-checker.php';
$update_checker = new ThemeUpdateChecker(
'ibmNorthstar',                                            //Theme folder name, AKA "slug".
'https://admin.blogs.pre.ibm.event.ibm.com/wordpress-code/info.json'        //URL of the metadata file.
);



function NorthStar_setup() {
    $my_theme = wp_get_theme();
    $domain = $my_theme->get( 'Name' );
    // wp-content/languages/theme-name/de_DE.mo
    load_theme_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain );
    // wp-content/themes/child-theme-name/languages/de_DE.mo
    load_theme_textdomain( $domain, get_stylesheet_directory() . '/languages' );
    // wp-content/themes/theme-name/languages/de_DE.mo
    load_theme_textdomain( $domain, get_template_directory() . '/languages' );

    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'NorthStar_setup' );

$templateDirectory = get_template_directory();

add_action('admin_notices', 'showAdminMessages');

add_filter( 'comments_open', 'my_comments_open', 10, 2 );

function my_comments_open( $open, $post_id ) {

    $global = (get_option("default_comment_status") == "open" ? true : false);
    $local = get_field('allow_comments', $post_id);
    if($local == "")
    {
        $local = "Global";
    }
    if($local == "Global")
    {
        $local = $global;
    }
    else
    {
        $local = ($local == "Yes" ? true : false);
    }

    return $local;
}


if (is_dir($templateDirectory."/api") && file_exists($templateDirectory."/api/data.json") && ((file_get_contents($templateDirectory."/api/data.json") == "{}") || (time() - filemtime($templateDirectory."/api/data.json") > 86400)))
{
    $json_data = new stdClass();
    $json_data->name = get_bloginfo('name');
    $json_data->description = get_bloginfo('description');
    $json_data->url = home_url();
    $temp = wp_get_theme();
    $json_data->theme = new stdClass();
    $json_data->theme->name = $temp->get('Name');
    $json_data->theme->version = $temp->get('Version');
    if(!@file_put_contents($templateDirectory."/api/data.json",json_encode($json_data)))
    {
    }
}

function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
$user_id = get_current_user_id();
$current_user = wp_get_current_user();
$profile_url = get_edit_profile_url( $user_id );

$my_theme = wp_get_theme();

if ( 0 != $user_id ) {
/* Add the "My Account" menu */
$avatar = get_avatar( $user_id, 28 );
$howdy = sprintf( __('Welcome, %1$s',$my_theme->get( 'Name' )), $current_user->display_name );
$class = empty( $avatar ) ? '' : 'with-avatar';

$wp_admin_bar->add_menu( array(
'id' => 'my-account',
'parent' => 'top-secondary',
'title' => $howdy . $avatar,
'href' => $profile_url,
'meta' => array(
'class' => $class,
),
) );

}
}

add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );

function admin_css() {
    wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin.css' );
}
add_action('admin_print_styles', 'admin_css' );

function wpdocs_theme_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );

//todo
function showAdminMessages()
{
    $my_theme = wp_get_theme();
    $plugin_messages = array();

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if(!is_plugin_active( 'advanced-custom-fields/acf.php' ))
    {
        $plugin_messages[] = __('This theme requires you to install the', $my_theme->get( 'Name' )) . ' Advanced Custom Fields plugin, <a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank">' . __('download it from here', $my_theme->get( 'Name' )) . '</a> ' . __('or', $my_theme->get( 'Name' )) . ' <a href="plugin-install.php?tab=search&type=term&s=Advanced+Custom+Fields" target="_self">' . __('click here to install it', $my_theme->get( 'Name' )) . '</a>.';
    }

    if(!is_plugin_active( 'user-role-editor/user-role-editor.php' ))
    {
        $plugin_messages[] = __('This theme requires you to install the', $my_theme->get( 'Name' )) . ' User Role Editor plugin, <a href="https://wordpress.org/plugins/user-role-editor/" target="_blank">' . __('download it from here', $my_theme->get( 'Name' )) . '</a> ' . __('or', $my_theme->get( 'Name' )) . ' <a href="plugin-install.php?tab=search&type=term&s=User+Role+Editor" target="_self">' . __('click here to install it', $my_theme->get( 'Name' )) . '</a>';
    }

        if(!is_plugin_active( 'wp-password-policy-manager/wp-password-policy-manager.php' ))
    {
        $plugin_messages[] = __('This theme requires you to install the', $my_theme->get( 'Name' )) . ' Wordpress Password Policy Manager plugin, <a href="https://wordpress.org/plugins/wp-password-policy-manager/" target="_blank">' . __('download it from here', $my_theme->get( 'Name' )) . '</a> ' . __('or', $my_theme->get( 'Name' )) . ' <a href="plugin-install.php?tab=search&type=term&s=wp+password+policy+manager" target="_self">' . __('click here to install it', $my_theme->get( 'Name' )) . '</a>';
    }


    if(count($plugin_messages) > 0)
    {
        echo '<div id="message" class="error">';

            foreach($plugin_messages as $message)
            {
                echo '<p><strong>'.$message.'</strong></p>';
            }

        echo '</div>';
    }
}

//Removing <p> tags from ACF display_title field

remove_filter('acf_the_content', 'wpautop');

function custom_theme_setup()
{
    if(isset($feature) && isset($arguments))
    {
        add_theme_support($feature, $arguments);
    }
}
add_action('after_setup_theme', 'custom_theme_setup');

add_action('admin_menu', 'add_new_settings_fields');

function add_new_settings_fields() {
    $my_theme = wp_get_theme();
    $themeName = $my_theme->get( 'Name' );
    add_options_page(__('Meta Data', 'Meta Data', $themeName), '8', 'meta-data', 'renderMetaDataPage');
    add_options_page(__('Optional NS Widgets', $themeName), __('Optional NS Widgets', $themeName), '9', 'optional-ns-widgets', 'renderOptionalNSWidgetsPage');
}

add_action('admin_init', 'my_general_section');
function my_general_section() {
    $my_theme = wp_get_theme();
    add_settings_section(
        'post_listing_style', // Section ID
        __('Post Listing Design', $my_theme->get( 'Name' )), // Section Title
        'my_section_options_callback', // Callback
        'reading' // What Page?
    );

    add_settings_field( // Option 1
        'post_listing_choice_homepage', // Option ID
        __('Post listing style for homepage', $my_theme->get( 'Name' )), // Label
        'renderNewRadioField', // !important - This is where the args go!
        'reading', // Page it will be displayed
        'post_listing_style', // Name of our section
        array( // The $args
            'post_listing_choice_homepage', // Should match Option ID
            array( //possible choices (value => label)
                "post_listing_choice_homepage_grid" => __('Grid', $my_theme->get( 'Name' )),
                "post_listing_choice_homepage_stack" => __('Stack', $my_theme->get( 'Name' ))
                ),
            'post_listing_choice_homepage_grid' //Default choice, when no value has been saved
        )
    );

    add_settings_field( // Option 1
        'post_listing_choice_others', // Option ID
        __('Post listing style for other pages', $my_theme->get( 'Name' )), // Label
        'renderNewRadioField', // !important - This is where the args go!
        'reading', // Page it will be displayed
        'post_listing_style', // Name of our section
        array( // The $args
            'post_listing_choice_others', // Should match Option ID
            array( //possible choices (value => label)
                "post_listing_choice_others_grid" => __('Grid', $my_theme->get( 'Name' )),
                "post_listing_choice_others_stack" => __('Stack', $my_theme->get( 'Name' ))
                ),
            'post_listing_choice_others_grid' //Default choice, when no value has been saved
        )
    );

    add_settings_field( // Option 2
        'post_listing_image_visibility', // Option ID
        __('Post Listing Image Visibility', $my_theme->get( 'Name' )), // Label
        'renderNewRadioField', // !important - This is where the args go!
        'reading', // Page it will be displayed
        'post_listing_style', // Name of our section (General Settings)
        array( // The $args
            'post_listing_image_visibility', // Should match Option ID
            array( //possible choices (value => label)
                "post_listing_image_visibility_always" => __('Always show post images', $my_theme->get( 'Name' )),
                "post_listing_image_visibility_if_available" => __('Show post images if available', $my_theme->get( 'Name' )),
                "post_listing_image_visibility_never" => __('Never show post images', $my_theme->get( 'Name' ))
                ),
            'post_listing_image_visibility_if_available' //Default choice, when no value has been saved
        )
    );

    add_settings_field( // Option 1
        'post_listing_choice_show_full_article', // Option ID
        __('For each article in listing, show', $my_theme->get( 'Name' )), // Label
        'renderNewRadioField', // !important - This is where the args go!
        'reading', // Page it will be displayed
        'post_listing_style', // Name of our section
        array( // The $args
            'post_listing_choice_show_full_article', // Should match Option ID
            array( //possible choices (value => label)
                "post_listing_choice_show_full_article_full" => __('Full text', $my_theme->get( 'Name' )),
                "post_listing_choice_show_full_article_summary" => __('Summary', $my_theme->get( 'Name' ))
                ),
            'post_listing_choice_show_full_article_summary' //Default choice, when no value has been saved
        )
    );

    add_settings_section(
        'miscellaneous_overrides', // Section ID
        __('Miscellaneous Overrides', $my_theme->get( 'Name' )), // Section Title
        null, // Callback
        'reading' // What Page?
    );

    register_setting('reading','post_listing_choice_homepage', 'esc_attr');
    register_setting('reading','post_listing_choice_others', 'esc_attr');
    register_setting('reading','post_listing_image_visibility', 'esc_attr');
    register_setting('reading','post_listing_choice_show_full_article', 'esc_attr');

    add_settings_field( // Option 2
        'force_all_posts_to_full_width', // Option ID
        __('Force all posts to full width', $my_theme->get( 'Name' )), // Label
        'renderNewCheckBoxField', // !important - This is where the args go!
        'reading', // Page it will be displayed
        'miscellaneous_overrides', // Name of our section (General Settings)
        array( // The $args
            'force_all_posts_to_full_width', // Should match Option ID
            __('Enable', $my_theme->get( 'Name' ))
        )
    );
    add_settings_field( // Option 2
        'force_all_posts_to_social_share', // Option ID
        __('Display social share icons on all posts', $my_theme->get( 'Name' )), // Label
        'renderNewCheckBoxField', // !important - This is where the args go!
        'reading', // Page it will be displayed
        'miscellaneous_overrides', // Name of our section (General Settings)
        array( // The $args
            'force_all_posts_to_social_share', // Should match Option ID
            __('Enable', $my_theme->get( 'Name' ))
        )
    );

      add_settings_field( // Option 2
        'hide_author_from_posts', // Option ID
        __('Hide author from posts', $my_theme->get( 'Name' )), // Label
        'renderNewCheckBoxField', // !important - This is where the args go!
        'reading', // Page it will be displayed
        'miscellaneous_overrides', // Name of our section (General Settings)
        array( // The $args
            'hide_author_from_posts', // Should match Option ID
            __('Enable', $my_theme->get( 'Name' ))
        )
    );

    register_setting('reading','force_all_posts_to_full_width', 'esc_attr');
    register_setting('reading','force_all_posts_to_social_share', 'esc_attr');
    register_setting('reading','hide_author_from_posts', 'esc_attr');

    add_settings_section(
        'google_analytics_section', // Section ID
        __('Google Analytics', $my_theme->get( 'Name' )), // Section Title
        null, // Callback
        'general' // What Page?
    );

    add_settings_field( // Option 2
        'google_analytics_UA', // Option ID
        __('Google Analytics UA', $my_theme->get( 'Name' )), // Label
        'renderNewTextField', // !important - This is where the args go!
        'general', // Page it will be displayed
        'google_analytics_section', // Name of our section (General Settings)
        array( // The $args
            'google_analytics_UA' // Should match Option ID
        )
    );

    register_setting('general','google_analytics_UA', 'esc_attr');

}

function my_section_options_callback() { // Section Callback
    $my_theme = wp_get_theme();
    echo '<p>'.__('Set up how post lists looks like on the blog', $my_theme->get( 'Name' )).'</p>';
}

function renderNewTextField($args) {
    $saved_value = get_option($args[0]);
    echo "<fieldset>";
    echo '<input name="'. $args[0] .'" id="'.$args[0].'" type="text"';
    if($saved_value == "")
    {
        echo 'value="UA-79125772-1"';
    }
    else
    {
        echo 'value="'.$saved_value.'"';
    }
    echo '">';
    echo "</fieldset>";
}

function renderNewCheckBoxField($args) {  // Textbox Callback
    $saved_value = get_option($args[0]);
    echo "<fieldset>";
    echo '<label for="'.$args[0].'"><input name="'. $args[0] .'" id="'.$args[0].'" type="checkbox"';
    if($saved_value == "on")
    {
        echo ' checked="checked" ';
    }
    echo '">'.$args[1].'</label>';
    echo "</fieldset>";

}

function renderNewRadioField($args) {  // Textbox Callback
    $saved_value = get_option($args[0]);
    echo "<fieldset><p>";
    foreach($args[1] as $value => $label)
    {
        echo '<label for="'.$value.'"><input name="'. $args[0] .'" id="'.$value.'" value="'.$value.'" type="radio"';
        if(($saved_value !== "" && $saved_value == $value) or ($saved_value == "" && $value == $args[2]))
        {
            echo ' checked="checked" ';
        }
        echo '>' . $label . '</label><br/>';
    }
    echo "</p></fieldset>";

}


function renderOptionalNSWidgetsPage() {
    $my_theme = wp_get_theme();
    ?>
    <div class='wrap'>
    <h2><?php echo __('Optional v18 Widgets', $my_theme->get( 'Name' )); ?></h2>
    <form method="post" action="options.php">
    <?php wp_nonce_field('update-options') ?>

    <div id="message" class="notice is-dismissible">
        <p><strong><a href="http://nsdev.somerslab.ibm.com/v18/htmldoc.php#doc-v18files" target="_blank"><?php echo __('Learn more', $my_theme->get( 'Name' )); ?></a> <?php echo __('at official v18 documentation.', $my_theme->get( 'Name' )); ?></strong></p>
    </div>

    <p>
        <strong><?php echo __('Data tables or table widgets', $my_theme->get( 'Name' )); ?></strong><br />
        <?php echo __('These are needed if you are using any data tables on your page and using the alternate highlight or styles, or any of the table widgets available like row selector, table scroll, sorting, filtering, pagination, etc.', $my_theme->get( 'Name' )); ?>
        <br/>
        <label for="v18_optional_widget_dataTablesOrTable">
            <input
                type="checkbox"
                id="v18_optional_widget_dataTablesOrTable"
                name="v18_optional_widget_dataTablesOrTable"
                <?php /* echo (get_option('v18_optional_widget_dataTablesOrTable') == "on" ? "checked='checked'" : ""); */ ?> checked
                disabled <?php //disabled, because this is needed in the theme ?>
            />
            <?php echo __('Enable', $my_theme->get( 'Name' )); ?>
        </label>
    </p>

    <p>
        <strong><?php echo __('Forms or form widgets', $my_theme->get( 'Name' )); ?></strong><br />
        <?php echo __('If you have any forms on your page, including the "pull-down navigator" select list, these are required for styling and widgets to work.', $my_theme->get( 'Name' )); ?>
        <br/>
        <label for="v18_optional_widget_formsOrForm">
            <input
                type="checkbox"
                id="v18_optional_widget_formsOrForm"
                name="v18_optional_widget_formsOrForm"
                <?php /* echo (get_option('v18_optional_widget_formsOrForm') == "on" ? "checked='checked'" : ""); */ ?> checked
                disabled <?php //disabled, because this is needed in the theme ?>
            />
            <?php echo __('Enable', $my_theme->get( 'Name' )); ?>
        </label>
    </p>

    <p>
        <strong><?php echo __('Code syntax highlighter', $my_theme->get( 'Name' )); ?></strong><br />
        <?php echo __('This enables the widget that color-codes your &lt;pre&gt; tag contents (code) and allows you to number the lines, highlight specific lines, and allow the user to select all and copy the code block.', $my_theme->get( 'Name' )); ?>
        <br/>
        <label for="v18_optional_widget_syntaxHighlighter">
            <input
                type="checkbox"
                id="v18_optional_widget_syntaxHighlighter"
                name="v18_optional_widget_syntaxHighlighter"
                <?php echo (get_option('v18_optional_widget_syntaxHighlighter') == "on" ? "checked='checked'" : ""); ?>
            />
            <?php echo __('Enable', $my_theme->get( 'Name' )); ?>
        </label>
    </p>

    <p>
        <strong><?php echo __('Dynamic tabs', $my_theme->get( 'Name' )); ?></strong><br />
        <?php echo __('Required for either the primary tab navigation or content space dynamic tabs widget. Enables the tabs to act like a basic show/hide and show the tab contents of the selected one.', $my_theme->get( 'Name' )); ?>
        <br/>
        <label for="v18_optional_widget_dynamicTabs">
            <input
                type="checkbox"
                id="v18_optional_widget_dynamicTabs"
                name="v18_optional_widget_dynamicTabs"
                <?php echo (get_option('v18_optional_widget_dynamicTabs') == "on" ? "checked='checked'" : ""); ?>
            />
            <?php echo __('Enable', $my_theme->get( 'Name' )); ?>
        </label>
    </p>

    <p>
        <strong><?php echo __('Mustache', $my_theme->get( 'Name' )); ?></strong><br />
        <?php echo __('This is an implementation of the mustache template system in JavaScript. Front-end web apps with MVC type setups will benefit from this. Makes it easy to AJAX an HTML template and replace variables in the template with content from a data object.', $my_theme->get( 'Name' )); ?><br/>
        <?php echo __('Example:', $my_theme->get( 'Name' )); ?> <a href="http://mustache.github.io/#demo" target="_blank">http://mustache.github.io/#demo</a>.<br/>
        <?php echo __('In other words, make complex use of JavaScript\'s replace() function easy. If you are doing a lot of templating or complex replace()s where you need some logic, this will help you.', $my_theme->get( 'Name' )); ?>
        <br/>
        <label for="v18_optional_widget_mustache">
            <input
                type="checkbox"
                id="v18_optional_widget_mustache"
                name="v18_optional_widget_mustache"
                <?php echo (get_option('v18_optional_widget_mustache') == "on" ? "checked='checked'" : ""); ?>
            />
            <?php echo __('Enable', $my_theme->get( 'Name' )); ?>
        </label>
    </p>

    <p><input type="submit" name="Submit" value="<?php echo __('Save Changes', $my_theme->get( 'Name' )); ?>" /></p>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="v18_optional_widget_syntaxHighlighter,v18_optional_widget_dataTablesOrTable,v18_optional_widget_dynamicTabs,v18_optional_widget_formsOrForm,v18_optional_widget_mustache" />

    </form>
    </div>
    <?php
}

function renderMetaDataPage() {
    ?>
    <div class='wrap'>
    <h2><?php echo __('Meta Data Setup', $my_theme->get( 'Name' )); ?></h2>
    <form method="post" action="options.php">
    <?php wp_nonce_field('update-options') ?>

    <h3><?php echo __('Blog settings', $my_theme->get( 'Name' )); ?></h3>

    <p><strong><?php echo __('Blog Owner:', $my_theme->get( 'Name' )); ?></strong><br />
    <input type="text" style="width:500px;" name="meta_page_owner" value="<?php echo get_option('meta_page_owner'); ?>" /></p>

    <p><strong><?php echo __('Blog Description:', $my_theme->get( 'Name' )); ?></strong><br />

    <textarea name="meta_page_description" style="width:500px;" rows="4" cols="45"><?php echo get_option('meta_page_description'); ?></textarea></p>

    <p><strong><?php echo __('Country:', $my_theme->get( 'Name' )); ?></strong><br />

    <select name="meta_country"  style="width:500px;">

    <?php

    $homepage = (substr(str_replace("ibmweb.dynnav.localeselector.dataCallback(","",preg_replace('/^.+\n/', '', preg_replace('/^.+\n/', '', file_get_contents('http://1.www.s81c.com/common/js/dynamicnav/www/countrylist/usen-utf8.js')))), 0, -2));
    $homepage = str_replace("translations",'"translations"',$homepage);
    $homepage = str_replace("mapView",'"mapView"',$homepage);
    $homepage = str_replace("listView",'"listView"',$homepage);
    $homepage = str_replace("sortBy",'"sortBy"',$homepage);
    $homepage = str_replace("select:",'"select":',$homepage);
    $homepage = str_replace("regionList:",'"regionList":',$homepage);
    $homepage = str_replace("name:",'"name":',$homepage);
    $homepage = str_replace("key:",'"key":',$homepage);
    $homepage = str_replace("locale:",'"locale":',$homepage);
    $homepage = str_replace("countryList:",'"countryList":',$homepage);
    $homepage = str_replace('// the name of the region','',$homepage);
    $homepage = json_decode(str_replace("'",'"',$homepage));

    foreach($homepage->regionList as $regionList)
    {
        echo "<option disabled></option>";
        echo "<option disabled>".$regionList->name."</option>";
        echo "<option disabled></option>";
        foreach($regionList->countryList as $countryList)
        {
            echo "<option ".($countryList->locale[0][0] == get_option('meta_country') ? "selected" : "")." value=\"".$countryList->locale[0][0]."\">".$countryList->name."</option>";
        }
    }


    ?></select>

    <h3><?php echo __('Tracking settings', $my_theme->get( 'Name' )); ?></h3>

    <p><strong><?php echo __('Primary Category:', $my_theme->get( 'Name' )); ?></strong><br />
    <input type="text" style="width:500px;" name="meta_page_primarycategory" value="<?php echo get_option('meta_page_primarycategory'); ?>" /></p>

    <p><strong><?php echo __('Site ID:', $my_theme->get( 'Name' )); ?></strong><br />
    <input type="text" style="width:500px;" name="meta_page_siteid" value="<?php echo get_option('meta_page_siteid'); ?>" /></p>

    <h4><?php echo __('GBT Tags', $my_theme->get( 'Name' )); ?></h4>

    <p><strong><?php echo __('IBM BU:', $my_theme->get( 'Name' )); ?></strong><br />
    <input type="text" style="width:500px;" name="meta_page_gbt10_IBM_BU" value="<?php echo get_option('meta_page_gbt10_IBM_BU'); ?>" /></p>

    <p><strong><?php echo __('Product Segment:', $my_theme->get( 'Name' )); ?></strong><br />
    <input type="text" style="width:500px;" name="meta_page_gbt17_Product_Segment" value="<?php echo get_option('meta_page_gbt17_Product_Segment'); ?>" /></p>

    <p><strong><?php echo __('Primary Brand:', $my_theme->get( 'Name' )); ?></strong><br />
    <input type="text" style="width:500px;" name="meta_page_gbt20_Primary_Brand" value="<?php echo get_option('meta_page_gbt20_Primary_Brand'); ?>" /></p>

    <p><strong><?php echo __('Product Family:', $my_theme->get( 'Name' )); ?></strong><br />
    <input type="text" style="width:500px;" name="meta_page_gbt30_Product_Family" value="<?php echo get_option('meta_page_gbt30_Product_Family'); ?>" /></p>

    </select>

    <p><input type="submit" name="Submit" value="<?php echo __('Update Meta Data', $my_theme->get( 'Name' )); ?>" /></p>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="meta_page_owner,meta_country,meta_page_description,meta_page_primarycategory,meta_page_siteid,meta_page_gbt10_IBM_BU,meta_page_gbt17_Product_Segment,meta_page_gbt20_Primary_Brand,meta_page_gbt30_Product_Family" />

    </form>
    </div>
    <?php
}
// ---------------------------------------------------------------------------
// OEMBED SIZE OPTIONS

if (!isset($content_width)) {
    $content_width = 680;
}

// ---------------------------------------------------------------------------
// THUMBNAIL SIZE OPTIONS

update_option('thumbnail_crop', array(
    'right',
    'center'
));
add_image_size('size-380', 380, 380, array(
    'right',
    'center'
));
add_image_size('size-780', 780, 780, array(
    'right',
    'center'
));
add_image_size('size-1200', 1200, 1200, array(
    'right',
    'center'
));
add_image_size('size-1440', 1440, 1440, array(
    'right',
    'center'
));
add_image_size('size-2400', 2400, 2400, array(
    'right',
    'center'
));
add_image_size('size-2880', 2880, 2880, array(
    'right',
    'center'
));

add_filter('image_size_names_choose', function($sizes)
{
    $my_theme = wp_get_theme();
    return array_merge($sizes, array(
        'size-380' => __('380px by 380px',$my_theme->get( 'Name' )),
        'size-780' => __('780px by 780px',$my_theme->get( 'Name' )),
        'size-1200' => __('1200px by 1200px',$my_theme->get( 'Name' )),
        'size-1440' => __('1440px by 1440px',$my_theme->get( 'Name' )),
        'size-2400' => __('2400px by 2400px',$my_theme->get( 'Name' )),
        'size-2880' => __('2880px by 2880px',$my_theme->get( 'Name' ))
    ));
});

// // original
add_image_size('thumb-600', 600, 600, true);
add_image_size('thumb-300', 300, 300, true);
add_image_size('thumb-150', 150, 150, true);

add_filter('image_size_names_choose', function($sizes)
{
    $my_theme = wp_get_theme();
    return array_merge($sizes, array(
        'thumb-600' => __('600px by 600px',$my_theme->get( 'Name' )),
        'thumb-300' => __('300px by 300px',$my_theme->get( 'Name' ))
    ));
});


// // Featured Post Meta Box
add_theme_support('post-thumbnails');


the_post_thumbnail(); // without parameter -> 'post-thumbnail'

the_post_thumbnail('thumbnail'); // Thumbnail (default 150px x 150px max)
the_post_thumbnail('medium'); // Medium resolution (default 300px x 300px max)
the_post_thumbnail('large'); // Large resolution (default 1024px x 1024px max)
the_post_thumbnail('full'); // Full resolution (original size uploaded)

the_post_thumbnail(array(
    100,
    100
)); // Other resolutions

add_theme_support('post-thumbnails');
add_theme_support('post-thumbnails', array(
    'post'
)); // Posts only
add_theme_support('post-thumbnails', array(
    'article'
)); // Articles only
add_theme_support('post-thumbnails', array(
    'page'
)); // Pages only

if (!function_exists('ibmNorthstar_entry_meta')): /**
 * Prints HTML with meta information for current post: categories  + custom taxonomies terms, tags, permalink, author, and date.
 * @since ibmNorthstar
 */
    function ibmNorthstar_entry_meta()
    {
        $my_theme = wp_get_theme();
        $tag_list = get_the_tag_list('', ', ');

        // taxonomies (categories and other terms)
        $id                  = get_the_ID();
        $taxonomy_terms_list = "";
        foreach (get_object_taxonomies(get_post_type($id)) as $taxonomy) {
            $terms_list = get_the_term_list($id, $taxonomy, '', ', ');
            if ($taxonomy_terms_list && $terms_list)
                $taxonomy_terms_list .= ', ' . $terms_list;
            else
                $taxonomy_terms_list .= $terms_list;
        }

        $date = sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>', esc_url(get_permalink()), esc_attr(get_the_time()), esc_attr(get_the_date('c')), esc_html(get_the_date()));

        $author = sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_attr(sprintf(__('View all posts by Drew %s', 'ibmNorthstar'), get_the_author())), get_the_author());

        // Translators: 1 is taxonmies terms, 2 is tag, 3 is the date and 4 is the author's name.
        if ($tag_list) {
            $utility_text = __('This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', $my_theme->get( 'Name' ));
        } elseif ($taxonomy_terms_list) {
            $utility_text = __('This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', $my_theme->get( 'Name' ));
        } else {
            $utility_text = __('This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', $my_theme->get( 'Name' ));
        }

        printf($utility_text, $taxonomy_terms_list, $tag_list, $date, $author);
    }
endif;

function custom_pagination($numpages = '', $pagerange = '', $paged = '')
{

    if (empty($pagerange)) {
        $pagerange = 2;
    }

        #base pagination code below taken from reference at http://callmenick.com/post/custom-wordpress-loop-with-pagination

    /**
     * This first part of our function is a fallback
     * for custom pagination inside a regular loop that
     * uses the global $paged and global $wp_query variables.
     *
     * It's good because we can now override default pagination
     * in our theme, and use this function in default quries
     * and custom queries.
     */
    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }
    if ($numpages == '') {
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if (!$numpages) {
            $numpages = 1;
        }
    }

    $url_parameters = (isset($_GET['lang']) ? $_GET['lang'] : "");
    if($url_parameters == ''){
        $format = 'page/%#%';
    }
    else{
        $format = 'page/%#%/?lang=' . $url_parameters;
    }

    /**
     * We construct the pagination arguments to enter into our paginate_links
     * function.
     */
    $my_theme = wp_get_theme();
    $pagination_args = array(
        'base' => reset((explode('?', get_pagenum_link(1)))) . '%_%',
        'format' => $format,
        'total' => $numpages,
        'current' => $paged,
        'show_all' => False,
        'end_size' => 1,
        'mid_size' => $pagerange,
        'prev_next' => True,
        'prev_text' => __('Previous',$my_theme->get( 'Name' )),
        'next_text' => __('Next',$my_theme->get( 'Name' )),
        'type' => 'array',
        'add_args' => false,
        'add_fragment' => ''
    );

    $paginate_links = paginate_links($pagination_args);

        #v18 override below.  This is where the base Wordpress markup is converted to v18.

    if ($paginate_links) {

    echo "<ul role=\"navigation\" aria-label=\"Pagination\" class=\"ibm-pagination ibm-pagination--centered\">";

    foreach ($paginate_links as $pgl) {
        if (strpos($pgl, 'Previous') != false) {
            echo "<li>" . str_replace("prev page-numbers", "prev page-numbers ibm-previous-link ibm-inlinelink", $pgl);
        } else if (strpos($pgl, 'Next') != false) {
            echo "<li>" . str_replace("next page-numbers", "next page-numbers ibm-next-link ibm-inlinelink ibm-icon-after", $pgl);
        } else if (strpos($pgl, 'span') != false) {
            echo "<li class=\"ibm-pagination__page\">" . str_replace("span class='page-numbers current'", "a aria-selected='true'", $pgl);
        } else {
            echo "<li class=\"ibm-pagination__page\">$pgl</li>";
        }
    }
    echo "</ul>";
}
  }
function v18_tags( $before = null, $sep = ', ', $after = '' ){
    $my_theme = wp_get_theme();
    if ( null === $before )
        $before = __('Tags: ',$my_theme->get( 'Name' ));
    echo get_the_v18_tag_list($before, $sep, $after);
}

function get_the_v18_tag_list( $before = '', $sep = '', $after = '', $id = 0 ) {

    /**
     * Filter the tags list for a given post.
     *
     * @since 2.3.0
     *
     * @param string $tag_list List of tags.
     * @param string $before   String to use before tags.
     * @param string $sep      String to use between the tags.
     * @param string $after    String to use after tags.
     * @param int    $id       Post ID.
     */
    return apply_filters( 'the_tags', get_the_v18_term_list( $id, 'post_tag', $before, $sep, $after ), $before, $sep, $after, $id );
}

/**
 * Retrieve a post's terms as a list with specified format.
 *
 * @since 2.5.0
 *
 * @param int $id Post ID.
 * @param string $taxonomy Taxonomy name.
 * @param string $before Optional. Before list.
 * @param string $sep Optional. Separate items using this.
 * @param string $after Optional. After list.
 * @return string|false|WP_Error A list of terms on success, false if there are no terms, WP_Error on failure.
 */
function get_the_v18_term_list( $id, $taxonomy, $before = '', $sep = '', $after = '' ) {
    $terms = get_the_terms( $id, $taxonomy );

    if ( is_wp_error( $terms ) )
        return $terms;

    if ( empty( $terms ) )
        return false;

    $links = array();

    foreach ( $terms as $term ) {
        $link = get_term_link( $term, $taxonomy );
        if ( is_wp_error( $link ) ) {
            return $link;
        }
        $links[] = '<a class="ibm-btn-sec" href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a>';
    }

    /**
     * Filter the term links for a given taxonomy.
     *
     * The dynamic portion of the filter name, `$taxonomy`, refers
     * to the taxonomy slug.
     *
     * @since 2.5.0
     *
     * @param array $links An array of term links.
     */
    $term_links = apply_filters( "term_links-$taxonomy", $links );

    return $before . join( $sep, $term_links ) . $after;
}
