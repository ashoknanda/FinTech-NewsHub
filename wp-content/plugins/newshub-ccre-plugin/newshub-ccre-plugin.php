<?php

/**
 * Plugin Name: Newshub CCRE Plugin
 * Plugin URI: http://www.ibm.com
 * Description: This is a plugin that allows get data from CCRE using JQuery Ajax functionality in WordPress
 * Version: 1.0.0
 * Author: Umesh kumar
 * License: IBM
 **/

	define( 'NHCCRE_PATH', dirname(__FILE__) . '/' );



	class CCREIntegration{
		public static function javascript() {
			global $wp_query;
			wp_reset_query();
			if ( ! is_front_page() && ( is_page() || is_single() || is_search()) ) {
				// wp_register_script('ccre_ajax', plugins_url( 'js/ccre_ajax.js', __FILE__ ));
				wp_register_script('ccre_ajax_load', plugins_url( 'js/ccre_ajax_load.js', __FILE__ ));

				$post_id = get_the_ID();

				// $post_categories = wp_get_post_categories( $post_id );
				// $cats = array();
				     
				// if(!empty($post_categories)){
				// 	foreach($post_categories as $c){
				// 	    $cat = get_category( $c );
				// 	    $cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
				// 	}					
				// }else if(is_search()){
				// 	$search_query = get_search_query();
				// 	array_push($cats, $search_query);
				// }
				


				// $ccre_params = array(
				// 	'url' => "http://cpedevelopmentJAVA.mybluemix.net/freetextrec",
				// 	'postid' => $post_id,
				// 	'string_temp' => $cats
				// );

				// if(is_ssl()){
				// 	$ccre_params['url'] = "https://cpedevelopmentJAVA.mybluemix.net/freetextrec";
				// }
				// wp_localize_script('ccre_ajax', 'ccre_params', $ccre_params);
				wp_localize_script( 'ccre_ajax_load', 'load_url', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'post_id' => $post_id));

				// wp_enqueue_script( 'ccre_ajax', plugins_url( 'js/ccre_ajax.js', __FILE__ ), array('jquery'), '1.0', true );
			    wp_enqueue_script( 'ccre_ajax_load', plugins_url( 'js/ccre_ajax_load.js', __FILE__ ), array('jquery'), '1.0', true );
			    wp_enqueue_style('ccre_widget', plugins_url('css/ccre_widget.css', __FILE__), false, 'all');
			}
		}

		public static function ccre_ajax_load() {

			global $wp_query;
			wp_reset_query();

			$post_id = $_REQUEST["post_id"];

			$post_categories = get_the_category( $post_id );
			$cats = array();

			if(!empty($post_categories)){
				foreach($post_categories as $c){
				    $cat = get_category( $c );
				    array_push($cats, $cat->name);
				}					
			}else if(is_search()){
				$search_query = get_search_query();
				array_push($cats, $search_query);
			}
		
					
			$ccre_url = "http://cognitivepersonalization.mybluemix.net/freetextrec";

			if(is_ssl()){
				$ccre_url = "https://cognitivepersonalization.mybluemix.net/freetextrec";
			}

			$not_to_pass = CCREIntegration::categoryListNotToPass();

			$cat_to_pass = array_udiff($cats, $not_to_pass, 'strcasecmp');
	
			$cat_ids = implode(',',$cat_to_pass);


			$xml = json_encode(array('q' => $cat_ids?$cat_ids:"INDUSTRY",
										'industry' => 'UNCLASSIFIED',
										'subindustry' => 'UNCLASSIFIED',
										'numresults' => 5));

			$context = stream_context_create(array(
				'http' => array(
					'method' => 'POST',
					'header' => 'Content-Type: application/json',
					'content' => $xml
				)
			));

			$tups = plugins_url( 'img/result_thumbsup_select.png', __FILE__ );
			$tupd = plugins_url( 'img/result_thumbup_unselect.png', __FILE__ );
			$tdws = plugins_url( 'img/result_thumbdown_select.png', __FILE__ );
			$tdwd = plugins_url( 'img/result_thumbdown_unselect.png', __FILE__ );

			$result = file_get_contents($ccre_url, false, $context);
			$retHtml = "";
			$className = "ibm-arrow-forward-link nh-asset-marketplace";
			// $result = '{"results":'.$result.'}';
			$json_2 = json_decode($result, true);
			if(isset($json_2)){
				$count_items_shown = 0;
				foreach ($json_2 as $item) {
					if($item['SCORE'] > 0.5 ){
						echo '<li class="ccre_container_item"><p class="ibm-ind-link">';
						echo '<a class="'.$className.'" data-score="'.$item["SCORE"].'" data-docid="'.$item["DOCID"].'" data-url="'.$item["URL"].'" onclick="linkClicked(this);" href="#">'.$item["TITLE"].'</a>';

						// echo '<span class="likebtn-wrapper" data-theme="custom" data-icon_l_url="'.$tupd.'" data-icon_l_url_v="'.$tups.'" data-icon_d_url="'.$tdws.'" data-icon_d_url_v="'.$tdwd.'" data-white_label="true" data-identifier="'.$item["DOCID"].'" data-show_like_label="false" data-counter_show="false" data-popup_width="0" data-share_enabled="false" data-tooltip_enabled="false" data-event_handler="likeButtonClicked" data-site_id="57d43fae9b1d1b42405feedd" ></span><script>(function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");</script>';
						echo '</p></li>';

						$count_items_shown +=1;
					}
				}

				if($count_items_shown == 0){
					echo "<p>I don't have any suggestions for you right now.</p>";
				}

			}else{
				echo '<p>Apologies , we are having trouble talking to Watson. Please check back later.</p>';
			}

			// var_dump($json_2[0]);
			// echo $retHtml;

			wp_die();
		}

		public static function categoryListNotToPass(){
		  $naCategoryList = array();
/*,
		    "Content advertising",
		    "Content creation",
		    "Content management",
		    "Content marketing",
		    "Digital asset management (DAM)",
		    "Display advertising",
		    "Gamification",
		    "Interactive content",
		    "Video marketing",
		    "Community & reviews",
		    "Feedback & chat",
		    "Social advertising",
		    "Social listening",
		    "Social media marketing", 
		    "Influencer marketing",
		    "Communications",
		    "Marketing mix",
		    "Marketing services",
		    "Data management platforms (DMP)",
		    "Marketing automation",
		    "Tag management",
		    "Call analytics",
		    "Third party data",
		    "Mobile analytics"

		    */
		  array_push($naCategoryList, 
		  	"Uncategorized",
		    "Category",
		    "Category level 3",
		    "Category Level2",
		    "Digital marketing",
		    "Campaign management",
		    "Data & analytics");

		  return $naCategoryList;
		}


		public static function widget(){	
			register_widget( 'CCRE_Widget' );		
		}
	}

	
	add_action( 'wp_head', 'CCREIntegration::javascript' );


	add_action( 'wp_ajax_ccre_ajax_load', 'CCREIntegration::ccre_ajax_load' );
	add_action( 'wp_ajax_nopriv_ccre_ajax_load', 'CCREIntegration::ccre_ajax_load' );	
	// Widget
	include_once( NHCCRE_PATH . 'widget.php' );
	add_action( 'widgets_init', 'CCREIntegration::widget' );




?>