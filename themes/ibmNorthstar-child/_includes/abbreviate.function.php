<?php

function abbreviate( $strString, $intLength = NULL ) {
        $defaultAbbrevLength = 8;   //Default abbreviation length if none is specified
  
	//Set up the string for processing
	$strString = preg_replace("/[^A-Za-z0-9]/", '', $strString);	//Remove non-alphanumeric characters
	$strString = ucfirst( $strString );				//Capitalize the first character (helps with abbreviation calcs)
	$stringIndex = 0;
	//Figure out everything we need to know about the resulting abbreviation string
	$uppercaseCount   = preg_match_all('/[A-Z]/', $strString, $uppercaseLetters, PREG_OFFSET_CAPTURE);	//Record occurences of uppercase letters and their indecies in the $uppercaseLetters array, take note of how many there are
	$targetLength     = isset( $intLength ) ? intval( $intLength ) : $defaultAbbrevLength;        		  //Maximum length of the abbreviation
	$uppercaseCount   = $uppercaseCount > $targetLength ? $targetLength : $uppercaseCount; 			      	//If there are more uppercase letters than the target length, adjust uppercaseCount to ignore overflow
	$targetWordLength = round( $targetLength / intval( $uppercaseCount ) );								              //How many characters need to be taken from each uppercase-designated "word" in order to best meet the target length?
	$abbrevLength     = 0;		    //How long the abbreviation currently is
	$abbreviation     = '';		    //The actual abbreviation
	//Create respective arrays for the occurence indecies and the actual characters of uppercase characters within the string
	for($i = 0; $i < $uppercaseCount; $i++) {
		//$ucIndicies[] = $uppercaseLetters[1];  //Not actually used. Could be used to calculate abbreviations more efficiently than the routine below by strictly considering indecies
		$ucLetters[] = $uppercaseLetters[0][$i][0];
	}
	$characterDeficit = 0;	            //Gets incremented when an uppercase letter is encountered before $targetCharsPerWord characters have been collected since the last UC char.
	$wordIndex = $targetWordLength;			//HACK: keeps track of how many characters have been carried into the abbreviation since the last UC char
	while( $stringIndex < strlen( $strString ) ) {	//Process the whole input string...
		if( $abbrevLength >= $targetLength ) 		      //...unless the abbreviation has hit the target length cap
			break;
		$currentChar = $strString[ $stringIndex++ ];	//Grab a character from the string, advance the string cursor
		if( in_array( $currentChar, $ucLetters ) ) { 	       //If handling a UC char, consider it a new word
			$characterDeficit += $targetWordLength - $wordIndex;	//If UC chars are closer together than targetWordLength, keeps track of how many extra characters are required to fit the target length of the abbreviation
			$wordIndex = 0;											                  //Set the wordIndex to reflect a new word
		} else if( $wordIndex >= $targetWordLength ) {
			if( $characterDeficit == 0 )                //If the word is full and we're not short any characters, ignore the character
				continue;
			else
				$characterDefecit--;	                    //If we are short some characters, decrement the defecit and carry on with adding the character to the abbreviation
		}
		$abbreviation .= $currentChar;	//Add the character to the abbreviation
		$abbrevLength++;				        //Increment abbreviation length
		$wordIndex++;					          //Increment the number of characters for this word
	}
	return $abbreviation;
}
?>