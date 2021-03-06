<?php

/*-----------------------------------------------------
 *	
 */

function NH_renderArticleCategories($this_post, $context){

	switch($context){

		case 'content-page':{
			$logoInverseClass = 'nh-article-categories-logo-inverse';
			break;
		}
	}
	
	$args = array(
		"fields" => "all"
	);
	$this_postCategories = wp_get_post_categories($this_post->ID, $args);
	$categories = $this_postCategories;
	$catNotIn = categoryListNotToShow(); //Gets the full list of categories not be shown on page. 
	
	$catcountvalue = 0; 
	$ret = '<div class="nh-article-categories '.$logoInverseClass.'">
        <div class="icon-wrap">
          <svg width="30px" height="24px" viewBox="50 276 30 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
              <desc>Created with Sketch.</desc>
              <defs></defs>
              <g id="tagIcon" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(51.000000, 277.000000)" stroke-linecap="round" stroke-linejoin="round">
                  <polygon id="Stroke-1" stroke="#FFFFFF" stroke-width="1.5" points="22.2101939 12.1441692 12.3168606 21.8960923 0.367648485 10.1184769 0.367648485 3.61747692 3.66486061 0.366553846 10.2609818 0.366553846"></polygon>
                  <polyline id="Stroke-3" stroke="#FFFFFF" stroke-width="1.5" points="10.260897 0.366384615 15.3297455 0.366384615 27.2789576 12.144 17.3856242 21.8959231 14.8512 19.3972308"></polyline>
                  <path d="M6.94637576,4.71603846 C6.34819394,4.12626923 5.37837576,4.12626923 4.78019394,4.71603846 C4.18201212,5.30580769 4.18201212,6.26111538 4.78019394,6.85173077 C5.37837576,7.44065385 6.34819394,7.44065385 6.94637576,6.85173077 C7.54455758,6.26111538 7.54455758,5.30580769 6.94637576,4.71603846 L6.94637576,4.71603846 Z" id="Stroke-5" stroke="#FFFFFF" stroke-width="1.5"></path>
              </g>
          </svg>
        </div>
        <div class="content-wrap">'
	;
	foreach($categories as $key => $value) {
		
		if($value->name != '' && $value->name != 'uncategorized' && !in_array($value->name, $catNotIn)){
			if($catcountvalue > 0){
				$ret = $ret.'<span>,</span> ';
			}
			$categoryId = get_cat_ID( $value->name );
			$categoryLink = get_category_link( $categoryId );

			$parent = get_category_parents( $value, true, ' &raquo; ' );
			$temp_str = explode(" &raquo; ", $parent);
			
			if(count($temp_str) > 1 && $temp_str[1] != ""){
				$parentAnchor = new SimpleXMLElement($temp_str[0]);
				if(strcasecmp($parentAnchor[0], 'Digital marketing') == 0 ){
					$categoryLink = $parentAnchor['href'].'?fwp_digital='.$value->slug;	
				}else if(strcasecmp($parentAnchor[0], 'Campaign management') == 0){
					$categoryLink = $parentAnchor['href'].'?fwp_campaign_management='.$value->slug;	
				}else if(strcasecmp($parentAnchor[0], 'Data & analytics') == 0){
					$categoryLink = $parentAnchor['href'].'?fwp_data_analytics='.$value->slug;	
				}else {
					$categoryLink = $parentAnchor['href'].'?fwp_category_level_2='.$value->slug;
				}
			}

			$ret = $ret."<a style=\"display:inline-block;\" class=\"nh-article-category ibm-small\" href=\"$categoryLink\">$value->name</a>";
			$catcountvalue +=1;
			if($catcountvalue >= 3){
				break;
			}
		}
	}

	return $ret.'</div></div>';
}

function NH_renderArticleCategoriesTitle($this_post, $context){
	switch($context){
		case 'content-page':{
			$logoInverseClass = 'nh-article-categories-logo-inverse';
			break;
		}
	}

	$args = array(
			"fields" => "all"
	);
	$this_postCategories = wp_get_post_categories($this_post->ID, $args);
	$categories = $this_postCategories;

	$catcountvalue = 0;
	$ret = '<div style="border: 2px solid #E3A20B; margin:-20px;width: 125px;height: 25px; font-weight: bold; padding: 10px; -webkit-border-radius: 0px 0px 51px 0px;-moz-border-radius: 0px 0px 51px 0px;border-radius: 0px 0px 51px 0px;background-color:#E3A20B;">'. '<div class="nh-article-categoriesDummy '.$logoInverseClass.'">

        <div class="content-wrap">'
			;
			foreach($categories as $key => $value) {

				if($value->name != '' && $value->name != 'uncategorized'){
					if($catcountvalue > 0){
						$ret = $ret.'<span>,</span> ';
					}
					$categoryId = get_cat_ID( $value->name );
					$categoryLink = get_category_link( $categoryId );
					$ret = $ret."$value->name";
					$catcountvalue +=1;
					if($catcountvalue >= 1){
						break;
					}
				}
			}
			return $ret.'</div></div></div>';
}


?>