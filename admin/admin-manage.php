<h2>Manage Your Posts</h2>
<?php //get all the posts that were written by the logged in user
$user_id = $_SESSION['user_id'];
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
		<a href="?action=delete&amp;post_id=<?php echo $row['post_id'] ?>" class="warn">
			delete
		</a>
	</li>
	<?php } ?>
</ul>
<?php }//end if there are posts ?>