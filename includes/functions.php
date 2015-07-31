<?php
//make datetime easier to read
function convert_date( $uglydate ){
	$date = new DateTime( $uglydate );
	return $nicedate = $date->format('F j, Y');
}

//shorten any string of text, like the body of a post
function shorten_it( $text ){
	return substr($text, 0, 200) . '&hellip;';
}
/**
 * Shorten a string to a set number of words
 * @param string $text - The text we are shortening
 * @param  int $limit - the number of words
 * @return string - the shortened text
 * @link  http://stackoverflow.com/questions/965235/how-can-i-truncate-a-string-to-the-first-20-words-in-php
 */
function limit_text($text, $limit) {
	if (str_word_count($text, 0) > $limit) {
		$words = str_word_count($text, 2);
		$pos = array_keys($words);
		$text = substr($text, 0, $pos[$limit]) . '...';
	}
	return $text;
}


//no close PHP