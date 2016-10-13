<?php

function NH_getCardBgColor(){
	$bgColor = '#e0e0e0';
  
	if($background_attributes == ''){

		if(isset($GLOBALS['nhCardColorOrder']) != true) $GLOBALS['nhCardColorOrder'] = 0;

		$bgColors = array('#D74108', '#5596E6', '#008571', '#4B8400', '#734098');
		$bgColor = $bgColors[$GLOBALS['nhCardColorOrder']]; // bgColors is set at the top of this file

		$GLOBALS['nhCardColorOrder'] = $GLOBALS['nhCardColorOrder'] + 1;
		if($GLOBALS['nhCardColorOrder'] >= count($bgColors)) $GLOBALS['nhCardColorOrder'] = 0;

	}

	return $bgColor;
}