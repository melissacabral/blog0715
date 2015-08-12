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
<table>
	<tr>
		<th>Title</th>
		<th>date</th>
		<th>status</th>
		<th>delete</th>


	</tr>
	<?php while( $row = $result->fetch_assoc() ){ ?>
	<tr>
		<td>
			<a href="<?php echo SITE_URL; ?>/admin/?page=edit&amp;post_id=<?php echo $row['post_id'] ?>" ><?php echo $row['title']; ?></a>
		</td><td>
			<?php echo convert_date( $row['date'] ); ?>
		</td><td>
			<i><?php echo ($row['is_published'] == 1) ? 'public' : 'draft' ; ?></i>
		</td><td>
			<a href="?page=manage&amp;action=delete&amp;post_id=<?php echo $row['post_id'] ?>" class="warn button" onclick="return confirmAction()" >
				delete
			</a>
		</td>
	</tr>
	<?php } ?>
</table>

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