<?php

include_once __DIR__.'/NH_renderArticleSource.function.php';

function NH_renderArticleTopMeta($this_post, $context){

	$allTags = wp_get_post_tags($this_post->ID);
	$is_editor_pick = false;
	$is_events_post = false;
	$is_watson_tshirt = false;
	foreach ($allTags as $key => $value) {
		// print_r($value->name);
		if($value->name == 'editor_pick'){
			$is_editor_pick = true;
		}else if($value->name == 'events_post') {
			$is_events_post = true;
		}else if($value->name == 'watson_tshirt') {
			$is_watson_tshirt = true;
		}
	}

	switch($context){
		case 'card-featured':
		case 'card':{
			$editorsPickInverseClass = "nh-editors-pick-inverse";
			break;
		}
	}

	$ret = "<div class=\"nh-article-top-meta $editorsPickInverseClass \">".NH_renderArticleSource($this_post, $context);
	if($is_editor_pick == true){
		$ret = $ret.'<div class="nh-editors-pick-dogear ibm-recommended-link "><span class="ibm-small">Editor\'s pick</span></div>';
	}
	$ret = $ret.'</div>';

	return $ret;
}

?>