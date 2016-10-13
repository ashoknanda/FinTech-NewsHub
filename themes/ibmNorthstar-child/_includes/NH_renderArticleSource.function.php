<?php 
/*-----------------------------------------------------
 *	renders article source
 */
function NH_renderArticleSource($this_post, $renderContext){ 

	// let's process the info
	$custom_fields = get_post_custom($this_post->ID);

	// print_r($custom_fields);

	$nc_source = array();
	$nc_source = $custom_fields['nc-source'] ? $custom_fields['nc-source'] : array();
	$nc_source_group = $custom_fields['nc-source-group'] ? $custom_fields['nc-source-group'] : array();

	$this_postsource = isset($nc_source_group[0]) == true ? $nc_source_group[0] : (isset($nc_source[0])==true ? $nc_source[0] : 'THINK Marketing');

	if(strcasecmp ( $this_postsource , "ibm commerce" ) == 0){
		$this_postsource = 'THINK Marketing';
		$nc_source_abbrev = 'T';
	}else{
		$cleaned_nc_source = str_replace('the', "", $this_postsource);
		$nc_source_abbrev = $cleaned_nc_source[0];
	}

	switch($renderContext){

		case 'search-result':{
			$inverseLogoMarkClass = "inverse-logo-mark";
			break;
		}

		case 'right-rail':{

			$hideLogoMarkClass = "hide-logo-mark";

			break;
		}

		case 'content-page':{
			$inverseLogoMarkClass = "inverse-logo-mark";
			$logoMarkSizeClass = "logo-mark-small";
		}

		default:{
			
		}
	}

	$ret = "<div class=\"nh-source nh-article-source $logoMarkSizeClass $inverseLogoMarkClass $hideLogoMarkClass \">
			<div class=\"logo-mark-wrap\"><div class=\"logo-mark ibm-bold\">$nc_source_abbrev</div></div>
			<div class=\"title ibm-small\">$this_postsource</div>
	    </div>"
	;

	return $ret;
	
} ?>