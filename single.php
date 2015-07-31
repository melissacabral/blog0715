<?php 
require('db-connect.php'); 
include( SITE_PATH . '/includes/functions.php');
include( SITE_PATH . '/includes/header.php');

//figure out which post to show
$post_id = $_GET['post_id'];
?>

<main>
	<?php 
	//write a query to get just title, body,  date, and category name of the post we are trying to view
	$query = "SELECT posts.title, posts.body, posts.date, categories.name
		    FROM posts, categories
		    WHERE posts.is_published = 1
		    AND posts.category_id = categories.category_id
		    AND posts.post_id = $post_id
		    LIMIT 1";
      //run it
	$result = $db->query($query);
	//check it!  are there rows in the result?
	if( $result->num_rows >= 1 ){
		//success - rows were found - loop through them!
		while( $row = $result->fetch_assoc() ){
			//display one post (row)
			?>
			<article>
				<h2><?php echo $row['title']; ?></h2>
				<p><?php echo $row['body']; ?></p>
				<footer>Posted on: 
				<?php echo convert_date( $row['date'] ) ?>
				In the category: <?php echo $row['name'] ?>
				</footer>
			</article>

			<section class="comments">
				<?php //get all the approved comments on this post, newest first
				$query_comments = "SELECT url, name, body, date
							FROM comments
							WHERE is_approved = 1
							AND post_id = $post_id
							ORDER BY date DESC";
				//run it
				$result_comments = $db->query($query_comments);
				//check it
				if( $result_comments->num_rows >= 1 ){
				 ?>
				<h2>Comments:</h2>
				<ul>
					<?php //loop it
					while( $row = $result_comments->fetch_assoc() ){ ?>
					<li>
						<h3>
							From: <a href="<?php echo $row['url']; ?>" rel="nofollow">
							<?php echo $row['name']; ?></a> 
							on <?php echo convert_date($row['date']); ?>
						</h3>
						<p><?php echo $row['body'] ?></p>
					</li>
					<?php }//end while ?>
				</ul>
				<?php 
				}//end if comments found
				else{
					echo 'No comments on this post yet.';
				} ?>
			</section>
	<?php
		}
	}else{
		//no rows found
		echo 'Sorry, no posts found.';
	}
	 ?>
	<a href="<?php echo SITE_URL; ?>/blog.php">Continue reading my blog...</a>
</main>

<?php include( SITE_PATH . '/includes/sidebar.php'); ?>

<?php include( SITE_PATH . '/includes/footer.php'); ?>