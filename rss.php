<?php require('db-connect.php'); 
function convTimestamp( $uglydate ){
	$date = new DateTime( $uglydate );
	return $nicedate = $date->format('D, d M Y H:i:s O');
}
?>
<?xml version="1.0" encoding="utf-8"?> 
<rss version="2.0">
	<channel>
		<title>Melissa's Blog Posts</title>
		<link><?php echo SITE_URL; ?></link>
		<description>A simple RSS Demo</description>
		<?php //get 10 latest published posts
		$query = "SELECT posts.title, posts.body, posts.date, posts.post_id, users.email, users.username 
		FROM posts, users
		WHERE posts.is_published = 1
		AND posts.user_id = users.user_id
		ORDER BY posts.date DESC
		LIMIT 10";
		$result = $db->query($query);
		if( $result->num_rows >= 1 ){ 
			while( $row = $result->fetch_assoc() ){ ?>
			<item>
				<title><?php echo $row['title']; ?></title>
				<link><?php echo SITE_URL; ?>/single.php?post_id=<?php echo $row['post_id']; ?></link>
				<guid><?php echo SITE_URL; ?>/single.php?post_id=<?php echo $row['post_id']; ?></guid>
				<description><![CDATA[<?php echo $row['body']; ?>]]></description>
				<author><?php echo $row['email'] ?> 
					(<?php echo $row['username'] ?>)</author>
					<pubDate><?php echo convTimestamp($row['date']); ?></pubDate>
				</item>
				<?php 
			} //end while
		} //end if ?>
	</channel>
</rss>