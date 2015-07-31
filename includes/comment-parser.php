<?php 
//parse the comment if the form was submitted
if( $_POST['did_comment'] ){
	//extract and clean the data
	$name 	= mysqli_real_escape_string( $db, strip_tags( $_POST['name'] ) );
	$email 	= mysqli_real_escape_string( $db, strip_tags( $_POST['email'] ) );
	$url		= mysqli_real_escape_string( $db, strip_tags( $_POST['url'] ) );
	$comment 	= mysqli_real_escape_string( $db, strip_tags( $_POST['comment'] ) );

	//validate - check for required fields
	$valid = true;

	//name or comment were left blank
	if( $name == '' OR $comment == '' ){
		$valid = false;
		$feedback = 'Please fill in all required fields.';
	}

	//invalid email
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = false;
		$feedback .= 'Please provide a valid email address.';
	}

	//if valid, add to the database
	if( $valid ){
		//set up query
		echo $query_insert = "INSERT INTO comments
					( date, name, email, url, body, post_id, is_approved )
					VALUES
					( now(), '$name', '$email', '$url', '$comment', $post_id, 1 )";
		//run it
		$result_insert = $db->query( $query_insert );

		//check it
		if( $db->affected_rows >= 1 ){
			//success!
			$feedback = 'Thank you for your comment!';
		}else{
			//error
			$feedback = 'Your comment could not be added';
		}
	} //end if valid
	
} //end parser
