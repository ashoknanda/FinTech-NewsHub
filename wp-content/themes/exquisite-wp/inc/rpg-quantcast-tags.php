<?php
function rpg_quantcast_tags() {

	$quantcast_tag = '';

	$object_id = get_queried_object_id();

	$object_tags = array(
		'1720' => 'Homepage',
		'354622' => 'Become A Contributor',
		'6709' => 'News',
		'1903' => 'Contributors',
		'1849' => 'Topics',
		'1846' => 'Events',
		'84' => 'Industries',
		'97' => 'X Force Research',
		'1883' => 'Media',
		'654' => 'Vulnerabilities + Threats',
		'Events' => 'Register'
	);

	// Logic that determines which tag should be used for the object id
	if ( array_key_exists( $object_id, $object_tags ) ) {
		$quantcast_tag = $object_tags[$object_id];
	} else if ( get_post_type( $object_id ) == 'ibm_event' ) {
		$quantcast_tag = $object_tags['Events'];
	}

	// Echo out the quantcast script, as long as the tag is not empty (as it was instantiated)
	if ( !empty($quantcast_tag) ) {
		echo '
<!-- Start Quantcast Tag (' . $object_id . ') -->
<script type="text/javascript">
	var _qevents = _qevents || [];
	(function() {
		var elem = document.createElement(\'script\');
		elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
		elem.async = true;
		elem.type = "text/javascript";
		var scpt = document.getElementsByTagName(\'script\')[0];
		scpt.parentNode.insertBefore(elem, scpt);
	})();
	_qevents.push(
		{qacct:"p-qEBnzj56H95XS",labels:"_fp.event.' . $quantcast_tag . '"}
	);
</script>
<noscript>
	<img src="//pixel.quantserve.com/pixel/p-qEBnzj56H95XS.gif?labels=_fp.event.' . urlencode($quantcast_tag) . '" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/>
</noscript>
<!-- End Quantcast tag -->' . "\n\n";
	}

}
add_action('wp_footer', 'rpg_quantcast_tags', 100);
?>