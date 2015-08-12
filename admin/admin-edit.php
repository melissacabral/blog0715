<?php 
//which post are we editing?
$post_id = $_GET['post_id'];
//get the ID of the logged in person
$user_id = $_SESSION['user_id'];

//parse the form if submitted
if( $_POST['did_post'] ){
	//sanitize everything for the DB
	$title 		= clean_input($_POST['title']);
	$body 		= clean_input($_POST['body']);
	$is_published 	= clean_input($_POST['is_published']);
	$allow_comments 	= clean_input($_POST['allow_comments']);
	$category_id 	= clean_input($_POST['category_id']);

	//validate - required fields
	$valid = true;

	if( $title == '' OR $body == '' ){
		$valid = false;
		$errors['required'] = 'Title and body are required';
	}

	//convert blank checkboxes to 0
	if( $is_published == '' ){
		$is_published = 0;
	}

	if( $allow_comments == '' ){
		$allow_comments = 0;
	}
	//if valid, update the db
	if($valid){
		$query_update = "UPDATE posts
				     SET
				     title = '$title',
				     body = '$body',
				     is_published = $is_published,
				     allow_comments = $allow_comments,
				     category_id = $category_id
				     WHERE post_id = $post_id";
		$result_update = $db->query($query_update);
		//check to see if any changes were made
		if( $db->affected_rows == 1 ){
			$feedback = 'Your changes have been saved.';
		}else{
			$feedback = 'No changes were made to the post.';
		}		
		
	} //end if valid

} //end parser 

//get all the info about this post, and make sure the logged in person wrote it
$query_post = "SELECT * 
		FROM posts
		WHERE post_id = $post_id
		AND user_id = $user_id
		LIMIT 1";
$result_post  = $db->query($query_post);
if( $result_post->num_rows >= 1 ){
	//no while loop needed since this query just gets one post
	$row_post = $result_post->fetch_assoc();
?>

<h1>Edit Post</h1>

<?php if( isset($feedback) ){
		echo $feedback;
	}
	list_array($errors); ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?page=edit&amp;post_id=<?php echo $post_id ?>" method="post">
	<div class="twothirds panel noborder">
	<label>Title:</label>
	<input type="text" name="title" value="<?php echo $row_post['title']; ?>">

	<label>Body:</label>
	<textarea name="body"><?php echo $row_post['body']; ?></textarea>
	</div>

	<div class="onethird panel">

	<label>
		<input type="checkbox" name="is_published" value="1" <?php 
			if( $row_post['is_published'] ){
				echo 'checked';
			}
		 ?>>
		Make this post public
	</label>

	<label>
		<input type="checkbox" name="allow_comments" value="1" <?php 
			if( $row_post['allow_comments'] ){
				echo 'checked';
			}
		 ?>>
		Allow people to comment on this post
	</label>

	<label>Category:</label>
	<select name="category_id">
		<?php //get all the categories in alpha order by name
		$query = "SELECT * FROM categories 
			    ORDER BY name ASC"; 
		$result = $db->query($query);
		if( $result->num_rows >= 1 ){ 
			while( $row = $result->fetch_assoc() ){ ?>
		<option value="<?php echo $row['category_id'] ?>" <?php 
			if( $row_post['category_id'] == $row['category_id'] ){
				echo 'selected';
			}
		 ?> >
			<?php echo $row['name'] ?>
		</option>
		<?php 
			} //end while
		} //end if ?>
		
	</select>

	<input type="submit" value="Save Post">
	<input type="hidden" name="did_post" value="true">
	</div>

</form>

<?php 
} //end if post found
else{
	echo 'Invalid Post';
} ?>