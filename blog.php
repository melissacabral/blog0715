<?php 
require('db-connect.php'); 
include( SITE_PATH . '/includes/functions.php');
include( SITE_PATH . '/includes/header.php');
?>

<main>
	<?php 
	//write a query to get just title, body,  date, and category name of all published posts, newest first
	$query = "SELECT posts.title, posts.body, posts.date, categories.name, posts.post_id
		    FROM posts, categories
		    WHERE posts.is_published = 1
		    AND posts.category_id = categories.category_id
		    ORDER BY posts.date DESC";
      //run it
	$result = $db->query($query);
	//check it!  are there rows in the result?
	if( $result->num_rows >= 1 ){
		//success - rows were found - loop through them!
		while( $row = $result->fetch_assoc() ){
			//display one post (row)
			?>
			<article>
				<h2><a href="single.php?post_id=<?php echo $row['post_id'] ?>">
					<?php echo $row['title']; ?>
				</a></h2>
				<p><?php echo $row['body']; ?></p>
				<footer>Posted on: 
				<?php echo convert_date( $row['date'] ) ?>
				In the category: <?php echo $row['name'] ?>
				</footer>
			</article>
	<?php
		}
	}else{
		//no rows found
		echo 'Sorry, no posts found.';
	}
	 ?>
</main>

<?php include( SITE_PATH . '/includes/sidebar.php'); ?>

<?php include( SITE_PATH . '/includes/footer.php'); ?>