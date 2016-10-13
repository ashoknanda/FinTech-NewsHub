<?php
	function NH_renderAuthorDateLine($this_post){

		$postauthor = null;
		$authID = $this_post->post_author;
		$userdata = get_userdata($authID);  
		$postauthor =  $userdata->user_nicename; //Setting author to post author set in WP if Newscred nc-author does not exist.

		$custom_fields = get_post_custom($this_post->ID);
		$nc_author = array();
		$nc_author = $custom_fields['nc-author'] ? $custom_fields['nc-author'] : "";

		if(is_object($nc_author)){
			foreach ( $nc_author as $key => $value ) {
				$postauthor = $value;
			}
		}
		//-----------------------------------------------------
		//  By ${author} ${date}
		$ret = '';
		if($postauthor != ''){
			$ret = "By ".$postauthor.', ';
		}
		$ret = $ret.get_the_time(get_option('date_format'), $this_post->ID);

		return $ret;
	}
?>