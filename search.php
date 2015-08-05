<?php 
require('db-connect.php'); 
include( SITE_PATH . '/includes/header.php' );

//figure out what they searched for. Query string looks like ?phrase=value
$phrase = mysqli_real_escape_string($db, $_GET['phrase']);

//pagination configuration
$per_page = 2;	//how many to show at a time
$page_number = 1; //what page to start on
?>
<main>

	<?php //get all the published posts that have titles and bodies that match the phrase
	$query = "SELECT post_id, title, body
			FROM posts
			WHERE is_published = 1
			AND 
			( title LIKE '%$phrase%'
			OR body LIKE '%$phrase%' ) "; 
	//run it
	$result = $db->query($query);
	//check it
	$total = $result->num_rows;
	if( $total >= 1 ){
		//pagination math
		//how many pages do we need?
		$total_pages = ceil($total / $per_page) ;

		//what page are we trying to show?
		//path looks like search.php?phrase=bla&page=3
		if( $_GET['page'] ){
			$page_number = $_GET['page'];
		}
		//make sure we are viewing a valid page
		if( $page_number <= $total_pages ){
			//modify the original query to get a subset of the results
			// LIMIT offset, per_page
			$offset = ( $page_number - 1 ) * $per_page;

			$query_modified = $query . " LIMIT $offset, $per_page";
			//run the new query
			$result_modified = $db->query($query_modified);
	?>
	<h1>Search Results</h1>
	<h2><?php echo $total; ?> posts found for <?php echo $phrase; ?> <br />
	Showing page <?php echo $page_number; ?> of <?php echo $total_pages ?></h2>

	<?php //loop it
	while( $row = $result_modified->fetch_assoc() ){ ?>
	<article>
		<h2><a href="<?php echo SITE_URL; ?>/single.php?post_id=<?php 
			echo $row['post_id']; ?>">

		<?php echo $row['title']; ?>
		</a></h2>
		<p><?php echo $row['body']; ?></p>
	</article>
	<?php } //end while ?>

	<?php //make vars for prev and next pages
	$prev = $page_number - 1;
	$next = $page_number + 1;
	 ?>
	<section class="pagination">
		<?php if( $page_number > 1 ){ ?>
		<a href="?phrase=<?php echo $phrase ?>&amp;page=<?php 
			echo $prev; ?>">Previous Page</a>
		<?php }else{ ?>
		<span class="inactive">Prev</span>
		<?php	} ?>
		
		<?php if( $page_number < $total_pages ){ ?>
		<a href="?phrase=<?php echo $phrase ?>&amp;page=<?php 
			echo $next; ?>">Next Page</a>
		<?php }else{ ?>
		<span class="inactive">Next</span>
		<?php	} ?>

	</section>
	
	<?php 
		}else{
			echo 'Invalid page';
		}
	}else{
		echo 'Sorry, no posts match your search';
	} ?>
</main>
<?php 
include( SITE_PATH . '/includes/sidebar.php' ); 
include( SITE_PATH . '/includes/footer.php' ); 
?>