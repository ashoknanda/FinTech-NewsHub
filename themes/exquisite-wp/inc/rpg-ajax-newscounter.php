<?php
// News Counter AJAX Functionality
function news_count_ajax() {

    sleep(.5); // add a little delay to prevent abuse

    // define variables to be used (to prevent warnings/errors in older versions of PHP)
    $return = array();
    $return['error'] = false;
    $return['msg'] = '';

    // check if cookie exists, grab value if it does, reset it either way
    if ( isset( $_COOKIE['news_counter'] ) && is_numeric($_COOKIE['news_counter']) && (int)$_COOKIE['news_counter'] == $_COOKIE['news_counter'] ) {
        $news_counter_cookie = $_COOKIE['news_counter'];
    } else {
        $news_counter_cookie = strtotime("-30 days");
    }
    setcookie( "news_counter", time(), time() + 31536000, '/' );

    // now let's see how many news items have been posted since the timestamp returned above
    $newscount_args = array(
       'post_type' => 'ibm_news',
       'date_query' => array(
            array(
                'after' => array(
                    'year' => date("Y", $news_counter_cookie),
                    'month' => date("n", $news_counter_cookie),
                    'day' => date("j", $news_counter_cookie)
                )
            )
        )
    );
    $newscount_query = new WP_Query($newscount_args);
    $newscount_number = $newscount_query->found_posts;

    // if result is a number (checking for good measure) and is 99+, display it as 99+ instead of the whole number
    if ( is_numeric($newscount_number) && $newscount_number >= 99 ) {
        $newscount_number = '99+';
    }

    // put the number found above into a variable to be returned
    // $return['msg'] .= $newscount_number . ' news posts since ' . date("r", $news_counter_cookie); // DEBUG
    $return['msg'] .= $newscount_number;

    // return JSON-encoded results
    echo json_encode($return);

    die(); // die just in case

}
add_action('wp_ajax_news_count_ajax', 'news_count_ajax');
add_action('wp_ajax_nopriv_news_count_ajax', 'news_count_ajax');

?>