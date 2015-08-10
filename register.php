<?php
session_start(); 
require('db-connect.php');
include( SITE_PATH . '/includes/functions.php' );

//Parse the registration form
if( $_POST['did_register'] ){
	//sanitize the data
	$username 	= clean_input($_POST['username']);
	$email 	= clean_input($_POST['email']);
	$password 	= clean_input($_POST['password']);
	//make sha version of the password for storage
	$sha_password = sha1($password);

	//validate all fields
	$valid = true;

	//username not within the limits
	if( strlen($username) < 5 OR strlen($username) > 25 ){
		$valid = false;
		$errors['username'] = 'Your username is not the right length';
	}else{
		//length is OK, check to see if username already taken
		$query_username = "SELECT username
					FROM users
					WHERE username = '$username'
					LIMIT 1";
		$result_username = $db->query($query_username);
		//if one row found, username is already taken
		if( $result_username->num_rows == 1 ){
			$valid = false;
			$errors['username'] = 'That username is already taken';
		}
	}//end username check

	//check for bad email address
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = false;
		$errors['email'] = 'Please choose a valid email address';
	}else{
		//email is valid, but make sure it isn't already taken
		$query_email = "SELECT email 
					FROM users 
					WHERE email = '$email'
					LIMIT 1";
		$result_email = $db->query($query_email);
		if( $result_email->num_rows == 1 ){
			$valid = false;
			$errors['email'] = 'That email address is already taken. Try another';
		}
	}//end email check

	//make sure password isn't short
	if( strlen( $password ) < 7 ){
		$valid = false;
		$errors['password'] = 'Your password must be at least 7 characters long';
	}
	//if valid, add the user to the DB
	if( $valid ){
		$query_newuser = "INSERT INTO users
					(username, email, password, is_admin)
					VALUES
					('$username' , '$email' , '$sha_password' , 1 )";
		//run it
		$result_newuser = $db->query($query_newuser);

		//if the user was added successfully, redirect to the login form
		if( $db->affected_rows == 1 ){
			//log them in
			//SUCCESS - remember them for 24 hours
			//make up a randomized security key
			$key = sha1(microtime() . 'uq348@(5et5*%$o8usdtget5,njse5yl/oj&$');
			//store the key as cookie and session
			setcookie( 'key', $key, time() + 60 * 60 * 24 );
			$_SESSION['key'] = $key;

			//figre out the user's id			
			$user_id = $db->insert_id;

			//put the user's key in the DB
			$query_update = "UPDATE users
						SET login_key = '$key'
						WHERE user_id = $user_id";
			$result_update = $db->query($query_update);

			//store their user_id on their computer
			setcookie( 'user_id', $user_id, time() + 60 * 60 * 24 );
			$_SESSION['user_id'] = $user_id;
			//redirect
			header('Location:admin/index.php');
		}else{
			$errors['db'] = 'An error occured when creating your account.';
		}
	}//end if valid	
	
} //end parser
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create an Account</title>
	<link rel="stylesheet" type="text/css" href="admin/css/admin-style.css">
</head>
<body class="login">
	<h1>Create an Account</h1>
	
	<?php 
	if(isset($errors)){
		echo '<div class="error message">';
		list_array($errors); 
		echo '</div>';
	}?>

	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
		<label>Username: <span class="req">*</span></label>
		<input type="text" name="username" required>
		<span class="hint">Choose a username between 5 and 25 characters.</span>

		<label>Email Address: <span class="req">*</span></label>
		<input type="email" name="email" required>

		<label>Password: <span class="req">*</span></label>
		<input type="password" name="password" required>
		<span class="hint">Choose a password that is at least 7 characters.</span>

		<input type="submit" value="Sign Up">
		<input type="hidden" name="did_register" value="true">
	</form>

</body>
</html>