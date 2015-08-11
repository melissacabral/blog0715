<?php //parse the form if submitted
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
	//if valid, add to the db
	if($valid){
		//get the ID of the logged in person
		$user_id = $_SESSION['user_id'];
		$query_insert = "INSERT INTO posts
( title, date, user_id, body, category_id, allow_comments, is_published )
VALUES
( '$title', now(), $user_id, '$body', $category_id, $allow_comments, $is_published  )";
		
		$result_insert = $db->query($query_insert);
		//feedback
		if( $db->affected_rows == 1 ){
			$feedback = 'Success! Your post was saved.';
		}else{
			$feedback = 'Error. Your post could not be saved';
		} //end feedback
	} //end if valid

} //end parser ?>

<h1>Write a new post</h1>

<?php if( isset($feedback) ){
		echo $feedback;
	}
	list_array($errors); ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?page=write" method="post">
	<div class="twothirds panel noborder">
	<label>Title:</label>
	<input type="text" name="title">

	<label>Body:</label>
	<textarea name="body"></textarea>
	</div>

	<div class="onethird panel">

	<label>
		<input type="checkbox" name="is_published" value="1">
		Make this post public
	</label>

	<label>
		<input type="checkbox" name="allow_comments" value="1">
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
		<option value="<?php echo $row['category_id'] ?>">
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