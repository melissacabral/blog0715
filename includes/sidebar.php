<aside>
	
	<?php //get title and URL of all the links in alphabetical order by title 
	$query = "SELECT title, url
		    FROM links
		    ORDER BY title ASC";
	//run it
	$result = $db->query($query);
	//check it! are there rows to show
	if( $result->num_rows >= 1 ){
	?>
	<h2>Links</h2>
	<ul>
		<?php while( $row = $result->fetch_assoc() ){ ?>
		<li>
			<a href="<?php echo $row['url']; ?>" target="_blank">
			<?php echo $row['title']; ?>
			</a>
		</li>
		<?php }//end while ?>
	</ul>
	<?php }//end if rows found ?>


	
	<?php //get names of all categories in alphabetical in random order 
	$query = "SELECT name
		    FROM categories
		    ORDER BY RAND()";
	//run it
	$result = $db->query($query);
	//check it! are there rows to show
	if( $result->num_rows >= 1 ){
	?>
	<h2>Categories</h2>
	<ul>
		<?php while( $row = $result->fetch_assoc() ){ ?>
		<li>
			<?php echo $row['name']; ?>
		</li>
		<?php }//end while ?>
	</ul>
	<?php }//end if rows found ?>

	<?php //get recent posts 
	$query = "SELECT title, post_id
		    FROM posts
		    ORDER BY date DESC";
	//run it
	$result = $db->query($query);
	//check it! are there rows to show
	if( $result->num_rows >= 1 ){
	?>
	<h2>Latest Posts:</h2>
	<ul>
		<?php while( $row = $result->fetch_assoc() ){ ?>
		<li>
			<a href="single.php?post_id=<?php echo $row['post_id'] ?>">
			<?php echo $row['title']; ?>
			</a>
		</li>
		<?php }//end while ?>
	</ul>
	<?php }//end if rows found ?>



</aside>