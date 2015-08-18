<?php 
$user_id = $_SESSION['user_id'];
//delete parser
if( $_GET['action'] == 'delete' ){
	//which comment are we deleting?
	$comment_id = $_GET['comment_id'];
	$query_delete = "DELETE FROM comments
	WHERE comment_id = $comment_id";
	$result_query  = $db->query($query_delete);	
} ?>

<h2>Manage Comments on Your Posts</h2>
<?php //get all the posts that were written by the logged in user

$query = "SELECT DISTINCT posts.post_id, posts.title
FROM posts, comments
WHERE posts.user_id = $user_id
AND posts.post_id = comments.post_id
ORDER BY posts.date DESC";
$result = $db->query($query); 
if( $result->num_rows >= 1 ){ 
	while( $row = $result->fetch_assoc() ){ ?>
	<h3><?php echo $row['title']; ?></h3>

			<?php //get all comments on this post
			$post_id = $row['post_id'];
			$query_comm = "SELECT * FROM comments WHERE post_id = $post_id";
			$result_comm = $db->query($query_comm); 
			if( $result_comm->num_rows >= 1 ){ ?>
			<table class="comment-table">
				<?php while($row_comm = $result_comm->fetch_assoc()){ ?>
					<tr>
						<td>
							<b><?php echo $row_comm['name'] ; ?> said: </b>
						</td>
						<td colspan="3">	
							<?php echo $row_comm['body'] ;?>
						</td>
						<td>
							<a href="?page=comments&amp;action=delete&amp;comment_id=<?php echo $row_comm['comment_id'] ?>" class="warn button">
								delete
							</a>
						</td>
					</tr>
				<?php	} ?>
			</table>
			<?php }else{
				echo 'no comments';
			} ?>

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
<?php }else{
	echo 'There are no comments on your posts';
}//end if there are posts ?>