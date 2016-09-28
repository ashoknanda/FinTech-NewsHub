<?php

function NH_getCardBgColor(){
	$bgColor = '#e0e0e0';
  
	if($background_attributes == ''){

		if(isset($GLOBALS['nhCardColorOrder']) != true) $GLOBALS['nhCardColorOrder'] = 0;

		$bgColors = array('#00B4A0', '#4178BE', '#5AA700', '#A6266E', '#9855D4', '#FF5003', '#E59200');
		$bgColor = $bgColors[$GLOBALS['nhCardColorOrder']]; // bgColors is set at the top of this file

		$GLOBALS['nhCardColorOrder'] = $GLOBALS['nhCardColorOrder'] + 1;
		if($GLOBALS['nhCardColorOrder'] >= count($bgColors)) $GLOBALS['nhCardColorOrder'] = 0;

	}

	return $bgColor;
}