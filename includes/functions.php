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

//clean string data for the DB
function clean_input( $dirty_data ){
	//use the DB connection already established
	global $db;
	//clean the data and 'return' it so we can continue working with it
	return mysqli_real_escape_string($db, strip_tags( $dirty_data ));
}

//display an array as a bulleted list
function list_array( $des_array ){
	if( is_array( $des_array ) ){
		echo '<ul>';
		foreach( $des_array as $item ){
			echo '<li>' . $item . '</li>';
		}
		echo '</ul>';
	}
}

//Display any user's picture at any size
function show_userpic( $user, $size ){
	global $db;
	$query_pic = "SELECT userpic 
			 FROM users
			 WHERE user_id = $user
			 AND userpic != ''
			 LIMIT 1"; 
	$result_pic = $db->query($query_pic);
	if( $result_pic->num_rows >= 1 ){
		$row_pic = $result_pic->fetch_assoc();
	?>
		<img src="<?php echo SITE_URL ?>/uploads/<?php echo $row_pic['userpic'] ?>_<?php echo $size ?>.jpg">
	<?php 
	}else{ ?>
		<img src="<?php echo SITE_URL; ?>/images/default.png">
	<?php 
	}
} //end function show_userpic


//no close PHP