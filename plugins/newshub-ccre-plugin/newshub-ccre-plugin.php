<?php

/**
 * Plugin Name: Newshub CCRE Plugin
 * Plugin URI: http://www.ibm.com
 * Description: This is a plugin that allows get data from CCRE using JQuery Ajax functionality in WordPress
 * Version: 1.0.0
 * Author: Umesh kumar
 * License: IBM
 **/

	include_once(__DIR__.'/../../themes/ibmNorthstar-child/_includes/NH_renderArticleSource.function.php');
	include_once __DIR__.'/../../themes/ibmNorthstar-child/_includes/NH_trim_text.function.php';
	include_once __DIR__.'/../../themes/ibmNorthstar-child/_includes/NH_getCardBgColor.function.php';
	define( 'NHCCRE_PATH', dirname(__FILE__) . '/' );



	class CCREIntegration{
		public static function javascript() {
			global $wp_query;
			wp_reset_query();
			if ( ! is_front_page() && ( is_page() || is_single() || is_search()) ) {
				// wp_register_script('ccre_ajax', plugins_url( 'js/ccre_ajax.js', __FILE__ ));
				wp_register_script('ccre_ajax_load', plugins_url( 'js/ccre_ajax_load.js', __FILE__ ));

				$post_id = get_the_ID();

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
				


				// $ccre_params = array(
				// 	'url' => "http://cpedevelopmentJAVA.mybluemix.net/freetextrec",
				// 	'postid' => $post_id,
				// 	'string_temp' => $cats
				// );

				// if(is_ssl()){
				// 	$ccre_params['url'] = "https://cpedevelopmentJAVA.mybluemix.net/freetextrec";
				// }
				// wp_localize_script('ccre_ajax', 'ccre_params', $ccre_params);

				$not_to_pass = CCREIntegration::categoryListNotToPass();

				$cat_to_pass = array_udiff($cats, $not_to_pass, 'strcasecmp');
		
				$cat_ids = implode(',',$cat_to_pass);				
				wp_localize_script( 'ccre_ajax_load', 'load_url', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'post_id' => $post_id, 'categories_passed' => $cat_ids));

				// wp_enqueue_script( 'ccre_ajax', plugins_url( 'js/ccre_ajax.js', __FILE__ ), array('jquery'), '1.0', true );
			    wp_enqueue_script( 'ccre_ajax_load', plugins_url( 'js/ccre_ajax_load.js', __FILE__ ), array('jquery'), '1.0', true );
			    wp_enqueue_style('ccre_widget', plugins_url('css/ccre_widget.css', __FILE__), false, 'all');
			}
		}

		public static function ccre_ajax_load() {

			global $wp_query;
			wp_reset_query();

			$post_id = $_REQUEST["post_id"];
			$invalid_characters = array("$", "%", "#", "<", ">", "|");
			$post_id = str_replace($invalid_characters, "", $post_id);


			$cp = $_REQUEST["categories_passed"];
			$cp = str_replace($invalid_characters, "", $cp);
			// print_r($cp);

			// $post_categories = get_the_category( $post_id );
			// $cats = array();

			// if(!empty($post_categories)){
			// 	foreach($post_categories as $c){
			// 	    $cat = get_category( $c );
			// 	    array_push($cats, $cat->name);
			// 	}					
			// }else if(is_search()){
			// 	$search_query = get_search_query();
			// 	array_push($cats, $search_query);
			// }
		
			// $ccre_url = "http://cognitivepersonalization.mybluemix.net/freetextrec";
			$ccre_url = "http://cpedevelopmentJAVA.mybluemix.net/freetextrec";

			if(is_ssl()){
				// $ccre_url = "https://cognitivepersonalization.mybluemix.net/freetextrec";
				$ccre_url = "https://cpedevelopmentJAVA.mybluemix.net/freetextrec";
			}

			// $not_to_pass = CCREIntegration::categoryListNotToPass();

			// $cat_to_pass = array_udiff($cats, $not_to_pass, 'strcasecmp');
	
			// $cat_ids = implode(',',$cat_to_pass);


			$xml = json_encode(array('q' => $cp?$cp:"INDUSTRY",
										'industry' => 'UNCLASSIFIED',
										'subindustry' => 'UNCLASSIFIED',
										'contentset' => 'NHM:4,PDP:5',
										'numresults' => 9));

			$context = stream_context_create(array(
				'http' => array(
					'timeout' => 10,
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
				$article_count = 0;
				$marketplace_count = 0;
				$all_articles = '';
				$all_marketplace = '';


				foreach ($json_2 as $item) {
					if($item['SCORE'] > 0.5 && $item["DOCID"] != $post_id ){
						// print_r($item);						
						if($item['CONTENT_TYPE'] == 'newscred' && $article_count < 3){
							$bgColor = NH_getCardBgColor();

							$bckImg = $item['IMAGE_URL'] ? $item['IMAGE_URL']:'';

							$classtoadd = "nh-show-item";
							if($article_count >= 2){
								$classtoadd = "nh-extra-card nh-hide";
							}
							$modified_title = trim_text($item["TITLE"], 107, true, true);
		                    $all_articles = $all_articles.'
		                    <li class="'.$classtoadd.'">	                    
		                      <div class="custom_post_list_image" style="background-color:'.$bgColor.'; background-image:url('.$bckImg.');">
		                      </div>
		                      <div class="custom_post_list_content">
		                      	<div class="ibm-small ibm-bold nh-ccre-type">Article</div>
		                        <a href="'.$item["URL"].'" class="ibm-textcolor-gray-80 ibm-bold custom_post_label"  data-score="'.$item["SCORE"].'" data-docid="'.$item["DOCID"].'" data-url="'.$item["URL"].'" data-type="article">
		                          <div class="nh-right-rail-list-ellipsis">'.$item["TITLE"].'</div>
		                        </a>
		                      </div>
		                      <a class="nh-card-hover-chevron ibm-chevron-right-light-link ibm-blog__header-link nh-transition-triggerer" href= "#" data-score="'.$item["SCORE"].'" data-docid="'.$item["DOCID"].'" data-url="'.$item["URL"].'"></a>
		                    </li>';		
		                    //OLD Layout					
							// $all_articles = $all_articles.'<li class="ccre_container_item">
							// 					<p class="ibm-ind-link">
							// 						<a style="color:#000;" class="'.$className.'" data-score="'.$item["SCORE"].'" data-docid="'.$item["DOCID"].'" data-url="'.$item["URL"].'" onclick="linkClicked(this);" href="#">'.$item["TITLE"].
							// 						'</a>
							// 					</p>
							// 				  </li>';
							$article_count += 1; 

						}elseif($item['CONTENT_TYPE'] == 'marketplace' && $marketplace_count < 5){
							$bgColor = NH_getCardBgColor();

							$bckImg = plugins_url( 'img/product-icon.jpg', __FILE__ );

							$type_content = 'Offering';
							if(stripos($item["TITLE"], 'Course') !== false){
								$type_content = 'Course';
								$bckImg = plugins_url( 'img/courses-icon.jpg', __FILE__ );
							}

							$classtoadd = "nh-show-item";
							if($marketplace_count >= 2){
								$classtoadd = "nh-extra-card nh-hide";
							}

		                    $all_marketplace = $all_marketplace.'<li class="'.$classtoadd.'">
		                      <div class="custom_post_list_image" style="background-color:'.$bgColor.'; background-image:url('.$bckImg.');">
		                      </div>
		                      <div class="custom_post_list_content">
		                      	<div class="ibm-small ibm-bold">'.$type_content.'</div>
		                        <a href="#" class="ibm-textcolor-gray-80 ibm-bold custom_post_label"  data-score="'.$item["SCORE"].'" data-docid="'.$item["DOCID"].'" data-url="'.$item["URL"].'">
		                          <div class="nh-right-rail-list-ellipsis">'.$item["TITLE"].'</div>
		                        </a>
		                        <div class="meta ibm-small ibm-textcolor-gray-50 ">'.$item["ABSTRACT"].'</div>
		                      </div>
        						<a class="nh-card-hover-chevron ibm-chevron-right-light-link ibm-blog__header-link nh-transition-triggerer" href= "#" data-score="'.$item["SCORE"].'" data-docid="'.$item["DOCID"].'" data-url="'.$item["URL"].'"></a>		                      
		                    </li>';	

							// $all_marketplace = $all_marketplace.'<li class="ccre_container_item">
							// 					<p class="ibm-ind-link">
							// 						<a class="'.$className.'" data-score="'.$item["SCORE"].'" data-docid="'.$item["DOCID"].'" data-url="'.$item["URL"].'" onclick="linkClicked(this);" href="#">'.$item["TITLE"].
							// 						'</a>
							// 					</p>
							// 				  </li>';
							$marketplace_count += 1;
						}

						$count_items_shown +=1;

						if($count_items_shown >= 8){
							break;
						}
						
					}
				}	


				// $all_articles = $all_articles.'</ul></li>';		
				// $all_marketplace = $all_marketplace.'</ul></li>';		

				if($count_items_shown == 0){
					echo "<p>I'm still learning and don't have a suggestion yet. Stay tuned1.</p>";
				}else {
					echo '<ul>';
					echo $all_articles;
					echo $all_marketplace;
					echo '</ul>';
					if($count_items_shown > 4){
						echo '<a href="#" class="nh-show-more ibm-small ibm-bold">SHOW MORE +</a>';
						echo '<a href="#" style="display:none;" class="nh-show-less ibm-small ibm-bold">SHOW LESS -</a>';
					}
				}

			}else{
				echo "<p>I'm still learning and don't have a suggestion yet. Stay tuned2.</p>";
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
		    "Data &amp; analytics");

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