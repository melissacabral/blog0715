<?php 
session_start();
require('../db-connect.php'); 
include( SITE_PATH . '/includes/functions.php' );
//which admin page are we viewing?
//admin/?page=dashboard
$page = $_GET['page'];

//user authentication is inside the header file
include( SITE_PATH . '/admin/admin-header.php' );
?>
<main>

<?php switch($page){
		case 'write':
			include( SITE_PATH . '/admin/admin-write.php' );
		break;
		case 'manage':
			include( SITE_PATH . '/admin/admin-manage.php' );
		break;
		case 'comments':
			include( SITE_PATH . '/admin/admin-comments.php' );
		break;
		default:
			include( SITE_PATH . '/admin/admin-dashboard.php' );
	} ?>
	
</main>
<?php include( SITE_PATH . '/admin/admin-footer.php' ); ?>