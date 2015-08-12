<?php 
$user_id = $_SESSION['user_id'];
//delete parser
if( $_GET['action'] == 'delete' ){
	//which post are we deleting?
	$post_id = $_GET['post_id'];
	$query_delete = "DELETE FROM posts
				WHERE post_id = $post_id
				AND user_id = $user_id";
	$result_query  = $db->query($query_delete);	
} ?>

<h2>Manage Your Posts</h2>
<?php //get all the posts that were written by the logged in user

$query = "SELECT post_id, title, is_published
	    FROM posts
	    WHERE user_id = $user_id
	    ORDER BY date DESC";
$result = $db->query($query); 
if( $result->num_rows >= 1 ){ ?>
<ul>
	<?php while( $row = $result->fetch_assoc() ){ ?>
	<li>
		<?php echo $row['title']; ?>
		<i><?php echo ($row['is_published'] == 1) ? 'public' : 'draft' ; ?></i>
		<a href="<?php echo SITE_URL; ?>/admin/?page=edit&amp;post_id=<?php echo $row['post_id'] ?>">
			edit
		</a>
		<a href="?page=manage&amp;action=delete&amp;post_id=<?php echo $row['post_id'] ?>" class="warn" onclick="return confirmAction()">
			delete
		</a>
	</li>
	<?php } ?>
</ul>

<script>
// Function to confirm permanent actions. use onclick.
function confirmAction(){
	var agree = confirm("This is permanent. Are you sure?");
	if(agree){
		return true;
	}else{
		return false;
	}
}
</script>
<?php }//end if there are posts ?>