<?php 
//user authentication. The whole admin panel requires a login
//get the keys off of the user's computer
$key = $_SESSION['key'];
$user_id = $_SESSION['user_id'];

//look for these keys in the DB
$query = "SELECT *
		FROM users
		WHERE login_key = '$key'
		AND   user_id   = $user_id
		LIMIT 1";
$result = $db->query($query);
//check to see if this returned 0 rows
if($result->num_rows == 0){
	//send the user to the login form
	header('Location:' . SITE_URL . '/login.php');
}
//@TODO Add constants for user info
?>
<!doctype html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="css/admin-style.css">
</head>
<body>
	<header>
		<h1>Blog Admin Panel</h1>
		<nav>
			<ul>
				<li><a href="<?php echo SITE_URL; ?>/admin">Dashboard</a></li>
				<li><a href="<?php echo SITE_URL; ?>/admin/?page=write">
					Write Post</a></li>
				<li><a href="<?php echo SITE_URL; ?>/admin/?page=manage">
					Manage Posts</a></li>
				<li><a href="<?php echo SITE_URL; ?>/admin/?page=comments">
					Manage Comments</a></li>
				<li><a href="<?php echo SITE_URL; ?>/admin">Edit Profile</a></li>
			</ul>
		</nav>
		<ul class="utilities">
			<li><a href="<?php echo SITE_URL ?>">View Blog</a></li>
			<li><a href="<?php echo SITE_URL; ?>/login.php?logout=true" class="warn">Log Out!</a></li>
		</ul>
	</header>