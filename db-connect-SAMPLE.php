<?php
/*
Database Connection
Use the user credentials from "privileges" in Phpmydmin

			host, username, password, databse name
*/
$db = new mysqli( 'localhost', 'blog_mmc_user', 'h7TZ62zPeRKYS7qf', 
	'blog_mmc' );

//show an error message if there is a problem with the connection
if( $db->connect_errno > 0 ){
	die( 'Unable to connect to the Database.' );
}

// Set up filepath constants
// PATH is used in includes
define( 'SITE_PATH', 'C:\xampp\htdocs\melissa-php-0715\blog' );
//URL is used in <a href >, <img src >, <link> etc
define( 'SITE_URL', 'http://localhost/melissa-php-0715/blog' );


//Error reporting
error_reporting(E_ALL & ~E_NOTICE);
