<?php
function get_coremetric_options() {
    global $coremetric_options;
    if (is_front_page()) {
        $coremetric_primary_category = 'SI_HOME';
    }else if (is_category()) {
        $coremetric_primary_category = 'SI_' . strtoupper(get_category(get_query_var('cat'))->slug);
    }else if (is_single()) {
        $slug = '';
        if (get_post_type() == "ibm_event"){
            $slug = get_post_meta(get_the_ID(), '_ibm_event_type', true);
            if ($slug =='webinar' && get_post_meta(get_the_ID(), '_ibm_event_end', true) < time()){
                $slug ='On-Demand';
            }
        }else if (get_post_type() == "ibm_media"){
            $slug = wp_get_post_terms(get_the_ID(), 'media_cat', array('fields' => 'all', 'public' => true));
            if (count($slug) > 0){
                $slug = $slug[0]->name;
            }else{
                $coremetric_primary_category = "Uncategorized";
            }
        }else if (get_post_type() == "ibm_news"){
            $slug ='news';
        }else{
            $cats = get_the_category();
            if (count($cats) > 0){
                $slug = $cats[0]->name;
            }else{
                $coremetric_primary_category = "Uncategorized";
            }
        }
        $coremetric_primary_category = 'SI_' . $slug;
    }else if (is_author()) {
        $coremetric_primary_category = 'SI_AUTHOR';
    }else if (is_search()) {
        $coremetric_primary_category = 'SI_SEARCH';
        $search_param = ( isset($_GET["s"]) ) ? sanitize_text_field($_GET["s"]) : '';
        $coremetric_options['page']['category']['primaryCategory'] = $coremetric_primary_category;
    }else if (is_page()) {
        global $post;
        $coremetric_primary_category = 'SI_' . $post->post_name;
    }else{
        $coremetric_primary_category = "SI_Uncategorized";
    }
    $coremetric_primary_category = ($coremetric_primary_category);

    if (!is_search()) {
        $coremetric_options = array(
            'page' => array(
                'pageInfo' => array(
                    'ibm' => array(
                        'siteID' => '$siteID',
                    ),
                ),
                'category' => array(
                    'primaryCategory' => $coremetric_primary_category,
                ),
            ),
        );
    }
    if (is_search()) {
        $coremetric_options['page']['pageInfo']['onsiteSearchTerm'] = $search_param;
    }
    return (object) $coremetric_options;
}
function get_coremetric_category() {
	//CJA adapted from above to only return the primary category or search snippet
    global $coremetric_options;
    if (is_front_page()) {
        $coremetric_primary_category = 'SI_HOME';
    }else if (is_category()) {
        $coremetric_primary_category = 'SI_' . strtoupper(get_category(get_query_var('cat'))->slug);
    }else if (is_single()) {
        $slug = '';
        if (get_post_type() == "ibm_event"){
            $slug = get_post_meta(get_the_ID(), '_ibm_event_type', true);
            if ($slug =='webinar' && get_post_meta(get_the_ID(), '_ibm_event_end', true) < time()){
                $slug ='On-Demand';
            }
        }else if (get_post_type() == "ibm_media"){
            $slug = wp_get_post_terms(get_the_ID(), 'media_cat', array('fields' => 'all', 'public' => true));
            if (count($slug) > 0){
                $slug = $slug[0]->name;
            }else{
                $coremetric_primary_category = "Uncategorized";
            }
        }else if (get_post_type() == "ibm_news"){
            $slug ='news';
        }else{
            $cats = get_the_category();
            if (count($cats) > 0){
                $slug = $cats[0]->name;
            }else{
                $coremetric_primary_category = "Uncategorized";
            }
        }
        $coremetric_primary_category = 'SI_' . $slug;
    }else if (is_author()) {
        $coremetric_primary_category = 'SI_AUTHOR';
    }else if (is_search()) {
        $coremetric_primary_category = 'SI_SEARCH';
        $search_param = ( isset($_GET["s"]) ) ? sanitize_text_field($_GET["s"]) : '';
        $coremetric_options['page']['category']['primaryCategory'] = $coremetric_primary_category;
    }else if (is_page()) {
        global $post;
        $coremetric_primary_category = 'SI_' . $post->post_name;
    }else{
        $coremetric_primary_category = "SI_Uncategorized";
    }

    if (!is_search()) 
	{
		return "category: {primaryCategory: '$coremetric_primary_category'}";
	}
	else
	{
		return "onsiteSearchTerm: '$search_param'";
	}
}
