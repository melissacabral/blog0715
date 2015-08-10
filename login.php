<?php 
//open or resume a session
session_start();
require('db-connect.php');

//do the login processing if they submitted the form
if( $_POST['did_login'] ){
	//extract user submitted data
	$username = mysqli_real_escape_string( $db, strip_tags($_POST['username']));
	$password = mysqli_real_escape_string( $db, strip_tags($_POST['password']));

	//validation:  check to see if the user's data is within the length limits
	if( strlen( $username ) >= 5 
	    AND strlen( $username ) <= 25 
	    AND strlen( $password ) >= 7 ){	

		//look up the user credentials in the DB
		$query = "SELECT user_id 
				FROM users
				WHERE username = '$username'
				AND password = sha1('$password')
				LIMIT 1";
		$result = $db->query($query);
		if( $result->num_rows == 1 ){
			//SUCCESS - remember them for 24 hours
			//make up a randomized security key
			$key = sha1(microtime() . 'uq348@(5et5*%$o8usdtget5,njse5yl/oj&$');
			//store the key as cookie and session
			setcookie( 'key', $key, time() + 60 * 60 * 24 );
			$_SESSION['key'] = $key;

			//figre out the user's id
			$row = $result->fetch_assoc();
			$user_id = $row['user_id'];

			//put the user's key in the DB
			$query_update = "UPDATE users
						SET login_key = '$key'
						WHERE user_id = $user_id";
			$result_update = $db->query($query_update);

			//store their user_id on their computer
			setcookie( 'user_id', $user_id, time() + 60 * 60 * 24 );
			$_SESSION['user_id'] = $user_id;

			//redirect to admin panel
			header( 'Location:' . SITE_URL . '/admin' );
		}else{
			//ERROR
			$error_message = 'Sorry, That combo is incorrect. Try again.';
		} //end of match check
	}else{
		//wrong length. show an error
		$error_message = 'Sorry, That combo is incorrect. Try again';
	} //end of length validation
} //end of parser

//LOG OUT. if the URL contains ?logout=true, destroy the session & cookie
if( $_GET['logout'] ){
	//delete the session ID
	session_destroy();
	unset( $_SESSION['loggedin'] );
	setcookie( 'loggedin', '', time() - 99999 );
}

//If the user returns within 24 hours (the expiration of the cookie)
//re-create the session
elseif( $_COOKIE['loggedin'] ){
	$_SESSION['loggedin'] = true;
	//redirect to profile page
	header( 'Location:' . SITE_URL . '/admin' );
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Log in to your account</title>
	<link rel="stylesheet" type="text/css" href="admin/css/admin-style.css">
</head>
<body class="login">
<h1>Log In:</h1>

<?php //show the error if it exists
if( isset( $error_message ) ){
	echo '<div class="error message">'. $error_message . '</div>';
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
	<label>Username:</label>
	<input type="text" name="username" value="<?php echo $_POST['username']; ?>">

	<label>Password:</label>
	<input type="password" name="password">

	<input type="submit" value="Log In">

	<!-- This is going to trigger our parsing logic -->
	<input type="hidden" name="did_login" value="true">
</form>

<a href="<?php echo SITE_URL ?>/register.php">Not a member?  Sign up for an account</a>

</body>
</html>