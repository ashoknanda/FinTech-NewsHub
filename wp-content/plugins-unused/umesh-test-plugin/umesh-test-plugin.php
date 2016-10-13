<?php
/*
Plugin Name: Umesh Test Plugin
*/

function callVoices() {
	if(is_page){
		$voicesURL = "https://www-304.ibm.com/social/aggregator/rest/v2/86/voices/";
		if(isset($_GET['testUmesh'])) {
			$voicesURL = "https://www-304.ibm.com/social/aggregator/rest/v2/86/voices/search?q=";
			$query = filter_input(INPUT_GET, 'testUmesh', FILTER_SANITIZE_ENCODED);

			$voicesURL = $voicesURL . $query;

		}

		$jsonResult = file_get_contents($voicesURL);

		$dataObject = json_decode($jsonResult, true);

		$current_user = wp_get_current_user();
		echo 'Username: ' . $current_user -> user_login;

		echo json_encode($dataObject["totalCount"]);
	}
}
add_action('get_header', 'callVoices');

?>