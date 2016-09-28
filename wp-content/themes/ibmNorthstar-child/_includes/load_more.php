<?php

// include_once __DIR__.'/NH_renderArticleSource.function.php';
// include_once __DIR__.'/NH_renderArticleCategories.function.php';
// include_once __DIR__.'/NH_renderArticleTopMeta.function.php';
// include_once __DIR__.'/NH_trim_text.function.php';
include_once __DIR__.'/NH_renderCard.function.php';
include_once __DIR__.'/NH_getCardBgColor.function.php';

add_action("wp_enqueue_scripts", "newshub_script_enqueue", 999);
function newshub_script_enqueue() {
  wp_enqueue_script('homepage_infinity_scroll', (get_stylesheet_directory_uri() . '/assets/js/homepage_infinity_scroll.js'), array('jquery'), '', true );
  wp_localize_script('homepage_infinity_scroll', 'homepage_infinity_scrollURL', array(
    'ajax_url' => admin_url( 'admin-ajax.php'),
    'tile_offset_size' => get_option('posts_per_page')
  ));
}

add_action( 'wp_ajax_nopriv_homepage_infinity_scroll_result', 'post_homepage_infinity_scroll_result' );
add_action( 'wp_ajax_homepage_infinity_scroll_result', 'post_homepage_infinity_scroll_result' );

function post_homepage_infinity_scroll_result() {
	$homepage_infinity_scroll_offset = sanitize_text_field($_REQUEST['page_offset']);

	$my_current_section = '';


	$home_page_array = home_page_layout($my_current_section, $homepage_infinity_scroll_offset );

	$tile_set = '';

	foreach ($home_page_array as $tile) {
		$tile_set .= create_load_more_tile($tile);
	}

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
    // echo 'ajax called ' . $homepage_infinity_scroll_offset;
		echo $tile_set;
		die();
	} else {
		echo ' ';
		exit();
	}
}
/*
code to get list of child categories
<ul>
<?php
$wp_reset_query(); // just in case the original query_string got disturbed
$this_cat = get_query_var('cat'); // get the category of this category archive page
wp_list_categories('child_of=' . $this_cat . '&title_li='); // list child categories
?>
</ul>
*/

function home_page_layout($my_current_section, $offset_position = 0) {
		// The Query
		$queryArgs = array(
			'posts_per_page'   => get_option('posts_per_page'),
			'offset'           => $offset_position,
			//'category'         => $my_current_section,
			// 'orderby'          => 'modified',
			// 'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			// 'meta_query' 	   => array(
			// 						array(
			// 						'key' => $current_section,
			// 						'value' => '1'
			// 						),
			// 						array(
			// 						'key' => 'wpcf-new_home_page_show',
			// 						'value' => '1'
			// 						),
			// 					  ),
			'post_type'        => 'post',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => true );

		$news_posts = get_posts( $queryArgs );
		//$totalposts = query_posts( $queryArgs );

		wp_reset_postdata();
		return $news_posts;
	}



  function create_load_more_tile($post1,$showSiteCard=false) {
    setup_postdata($post1);
    $post_id = $post1->ID;
    $post_type = $post1->post_type;

    $pimages = get_field('card_image',$post_id);
    // print_r($post1);
    
        $twitter_user = 'IBMforMarketing';
        $twitter_hash_tag = 'THINKmarketing';

    //Code to get all Ads for the post categories.
    // print_r($categories);
    // $allcatids = array_map(create_function('$o', 'return $o->name;'), $categories) ;
    // // print_r($allcatids);
    // $all_term_ids = get_ad_group_id($allcatids);

    // print_r(implode(',',$all_term_ids));

      $postauthor = null;
      $authID = $post1->post_author;
      $userdata = get_userdata($authID);
      $postauthor =  $userdata->user_nicename; //Setting author to post author set in WP if Newscred nc-author does not exist.
      $custom_fields = get_post_custom($post1->ID);
      $nc_author = array();
      $nc_author = $custom_fields['nc-author']?$custom_fields['nc-author']:"";
      if(isset($nc_author)){
        foreach ( $nc_author as $key => $value ) {
          $postauthor = $value;
        }
      }
    

      //Identify it is editors_pick.
      $allTags = wp_get_post_tags($post1->ID);
      $is_editor_pick = false;
      foreach ($allTags as $key => $value) {
        // print_r($value->name);
        if($value->name == 'editor_pick'){
          $is_editor_pick = true;
        }
      }    

      //-----------------------------------------------------
      //  set up images

      $imgobjfromnc= wp_get_attachment_image_src( get_post_thumbnail_id($post1->ID), 'large_size' );

      $background_attributes = '';

      if($imgobjfromnc && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")){
        $background_attributes = 'background-image: url(' . $imgobjfromnc[0] . ')';
      }else if($pimages && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")){
        $background_attributes = 'background-image: url(' . $pimages['sizes']['large'] . ')';
      }else{
        if((get_option('post_listing_image_visibility') == "post_listing_image_visibility_if_available") or (get_option('post_listing_image_visibility') == "post_listing_image_visibility_never")){

        }
      }

      //-----------------------------------------------------
      //  By ${author} ${date}

      $byAndDate = '';
      if($postauthor != ''){
        $byAndDate = "By ".$postauthor.', ';
      }
      $byAndDate = $byAndDate.get_the_time(get_option('date_format'), $post1->ID);
      // print_r($post1);

      $postexcerpt = get_excerpt_by_id($post1);

      $email_body = urlencode("\r\n")."You might enjoy reading this article from THINK Marketing: " . rawurlencode($post->post_title) . urlencode("\r\n\r\n") . get_permalink();
    ob_start();
    ?>
  <!-- This section is for regular card arrangement , but still need count for Ads showing -->
  <!-- Regular card block Ads insert block-->

  <!-- Regular card block-->

  <div class="ibm-col-6-2 post nh-card-wrap <?php echo $post1->post_type; ?>" data-post-id="bannerlogo" data-post-count="<?php if(isset($card_count) !== true) $card_count = 0; echo $card_count; $card_count = $card_count +1; ?>">
    <div class="ibm-col-6-2 post nh-card-wrap nh-card-wrap-height nh-home-branding static-banner" style="width:100%;background-color:#373737;">
      <div class="inner-wrap">
        <div class="rebus-wrap" style="background-image:url(<?php echo get_stylesheet_directory_uri().'/assets/img/TM-rebus-intro-v1.0.0-optimization-1.gif?animation-start='.rand(0,9999999); ?>);">
        <div class="title-wrap">
          <div class="title">
            <div class="ibm-bold think">THINK</div>
            <div class="ibm-textcolor-teal-40 ibm-bold marketing">Marketing</div>
          </div>
          <div class="static-banner-copy">Fuel for the marketing mind</div>
        </div>
        </div>
      </div>
    </div>
  </div>

  <?php NH_renderCard($post1, 'card-featured', 0, $bgColor, $twitter_hash_tag, wp_get_theme()); ?>
    



     <?php return ob_get_clean();
  }

  function get_ad_group_id($catName){
          $ads_args = array(
              'name' => $catName,
              'hide_empty' => false,
          );

          $postslist = get_terms('dfads_group', $ads_args);
          $all_ids = array_map(create_function('$o', 'return $o->term_id;'), $postslist);
          return implode(',',$all_ids);
  }

  function generate_editor_pics(){
    global $post;
          $editors_args = array(
              // 'category__and' => 'category'
              'tag_slug__and' => array('editor-pick'),
              'showposts' => 5,
              'orderby' => 'date'
          );

          $postslist = get_posts( $editors_args );

          if(!empty($postslist)) {
            ob_start();
            ?>

              <div class="ibm-card__content ibm-link-list " style="border:1px solid #c7c7c7;margin-top:20px;">
                <h3 class="ibm-h3 ">Editors Picks</h3>
                  <ul class="tagged-list">
                    <?php foreach ($postslist as $posting) :  setup_postdata($posting);  $pimg1 = get_field('card_image');?>
                      <li style="height:30px;display: block;">
                        <div style="display: inline-block; float:left; clear: both;width: 30px; height:30px;">
                            <?php if(get_field('card_image') && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")) { ?>
                              <img width="30" align="left" height="30" src="<?php echo $pimg1['sizes']['large']; ?>" alt="thumb" />
                            <?php } else{ ?>
                              <img width="30" align="left" height="30" alt="" style="background: #DEDEDE;" src="thumb" />
                            <?php } ?>
                        </div>
                        <a href="<?php the_permalink() ?>"  style="display:inline-block;float:right;width:calc(100% - 35px);height:30px;overflow:hidden;" class="ibm-textcolor-gray-80 ibm_light"><?php the_title(); ?></a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
              </div>

          <?php
          return ob_get_clean();
        }
      }
 // echo  generate_editor_pics(); // - how it is called

      function generate_latest_pics(){
        global $post;
        $recent_args = array(
            'showposts' => 5,
            'orderby' => 'date'
        );

        $recent_postslist = get_posts( $recent_args );
        if(!empty($recent_postslist)) {
          ob_start();
          ?>
          <div class="ibm-card__content ibm-link-list " style="border:1px solid #c7c7c7;margin-top:20px;">
            <h3 class="ibm-h3 ">Recent Posts</h3>
              <ul class="tagged-list">
                <?php foreach ($recent_postslist as $posting) :  setup_postdata($posting); $pimg = get_field('card_image');?>
                  <li style="height:30px;display: block;">
                      <div style="display: inline-block; float:left; clear: both;width: 30px; height:30px;">
                        <?php if(get_field('card_image') && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")) { ?>
                            <img width="30" align="left" height="30" src="<?php echo $pimg['sizes']['large']; ?>" alt="thumb" />
                        <?php } else{ ?>
                          <img width="30" align="left" height="30" alt="" style="background: #DEDEDE;" src="thumb" />
                        <?php } ?>
                      </div>
                      <a href="<?php the_permalink() ?>" style="display:inline-block;float:right;width:calc(100% - 35px);height:30px;overflow:hidden;" class="ibm-textcolor-gray-80 ibm_light"><?php the_title(); ?></a>
                  </li>
                <?php endforeach; ?>
              </ul>
          </div>

      <?php
      return ob_get_clean();
    }
    }


function wp_get_all_popular_ids(){
    global $wpdb;

    $sql = "
    SELECT
      distinct p.ID
    FROM
      {$wpdb->prefix}most_popular mp
      INNER JOIN {$wpdb->prefix}posts p ON mp.post_id = p.ID
    WHERE
      p.post_type IN ( 'post' ) AND
      p.post_status = 'publish'
    ORDER BY 7_day_stats DESC
    LIMIT 30
  ";

  $result = $wpdb->get_results( $wpdb->prepare( $sql), OBJECT );
  if ( ! $result) {
    return array();
  }

  $itemList = "";
  $prefix = "";
// print_r($result);

  foreach ($result as $item)
  {
    $itemList .= $prefix . $item->ID;
    $prefix = ', ';
  }
  return $itemList;
}

function wp_get_trending( $args = array() ) {
  global $wpdb, $paged, $max_num_pages, $current_date;
  
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $post_per_page = 5;//intval(get_query_var('posts_per_page'));
  $offset = ($paged - 1)*$post_per_page;

// print_r($paged . " , posts per page : ".$post_per_page." , $offset : ".$offset." , max num pages: ".$max_num_pages);
  // Default arguments
  // $limit = 5;
  $post_type = array( 'post' );
  $range = 'weekly';
  
  // if ( isset( $args['limit'] ) ) {
  //   $limit = $args['limit'];
  // }
  
  if ( isset( $args['post_type'] ) ) {
    if ( is_array( $args['post_type'] ) ) {
      $post_type = $args['post_type'];
    } else {
      $post_type = array( $args['post_type'] );
    }
  }
  
  if ( isset( $args['range'] ) ) {
    $range = $args['range'];
  }
  
  switch( $range ) {
    CASE 'all_time':
      $order = "ORDER BY all_time_stats DESC";
      break;
    CASE 'monthly':
      $order = "ORDER BY 30_day_stats DESC";
      break;
    CASE 'weekly':
      $order = "ORDER BY 7_day_stats DESC";
      break;
    CASE 'daily':
      $order = "ORDER BY 1_day_stats DESC";
      break;
    DEFAULT:
      $order = "ORDER BY all_time_stats DESC";
      break;
  }

  $holder = implode( ',', array_fill( 0, count( $post_type ), '%s') );
  
  $sql = "
    SELECT
      p.*
    FROM
      {$wpdb->prefix}most_popular mp
      INNER JOIN {$wpdb->prefix}posts p ON mp.post_id = p.ID
    WHERE
      p.post_type IN ( $holder ) AND
      p.post_status = 'publish'
    {$order}
    LIMIT {$offset} , {$post_per_page}
  ";

  $result = $wpdb->get_results( $wpdb->prepare( $sql, array_merge( $post_type, array( $limit ) ) ), OBJECT );
  
  if ( ! $result) {
    return array();
  }

  $sql2 = "
    SELECT
      distinct COUNT(*)
    FROM
      {$wpdb->prefix}most_popular mp
      INNER JOIN {$wpdb->prefix}posts p ON mp.post_id = p.ID
    WHERE
      p.post_type IN ( 'post' ) AND
      p.post_status = 'publish'
  ";

  $sql_posts_total = $wpdb->get_var($sql2);
  // print_r($sql_posts_total);
  $max_num_pages = ceil($sql_posts_total / $post_per_page);
  
  return $result;
}


function get_excerpt_by_id($post, $length = 15, $tags = '<a><em><strong>', $extra = ' [...]') {
 
  if(is_int($post)) {
    $post = get_post($post);
  } elseif(!is_object($post)) {
    return false;
  }
 
  if(has_excerpt($post->ID)) {
    $the_excerpt = $post->post_excerpt;
    return apply_filters('the_content', $the_excerpt);
  } else {
    $the_excerpt = $post->post_content;
  }
 
  $the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
  $the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
  $excerpt_waste = array_pop($the_excerpt);
  $the_excerpt = implode($the_excerpt);
  $the_excerpt .= $extra;
 
  return apply_filters('the_content', $the_excerpt);
}

  //  echo  generate_latest_pics(); // - how it is called
?>
