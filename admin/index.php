<?php 
session_start();
require('../db-connect.php'); 
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
				<li><a href="#">Dashboard</a></li>
				<li><a href="#">Write Post</a></li>
				<li><a href="#">Manage Posts</a></li>
				<li><a href="#">Manage Comments</a></li>
				<li><a href="#">Edit Profile</a></li>
			</ul>
		</nav>
		<ul class="utilities">
			<li><a href="<?php echo SITE_URL; ?>/login.php?logout=true" class="warn">Log Out!</a></li>
		</ul>
	</header>

	<main>
		<h1>USERNAME's Dashboard:</h1>
		<section class="onehalf panel">
			<h2>Your Content:</h2>
			<ul>
				<li>You have written XX published posts</li>
				<li>You have written XX Post Drafts</li>
				<li>Latest Draft: POST TITLE</li>
			</ul>
			
		</section>
		<section class="onehalf panel">
			<h2>Most Popular:</h2>
			<ul>
				<li>POST TITLE with XX comments</li>
				<li>POST TITLE with XX comments</li>
				<li>POST TITLE with XX comments</li>
			</ul>
		</section>

	</main>

	<footer>
		&copy; 2015 Your Name Here!
	</footer>
</body>
</html>