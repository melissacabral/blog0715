<section class="comment-form">
	<h2>Leave a comment</h2>

	<?php //user feedback
	if( isset($feedback) ){
		echo $feedback;
	} ?>

	<form action="#" method="post">
		<ol>
			<li>
				<label for="name">Name:</label>
				<input type="text" name="name" id="name">
			</li>
			<li>
				<label for="email">Email:</label>
				<input type="email" name="email" id="email">
			</li>
			<li>
				<label for="url">Website URL: (optional)</label>
				<input type="url" name="url" id="url">
			</li>
			<li>
				<label for="comment">Comment:</label>
				<textarea name="comment" id="comment"></textarea>
			</li>
			<li>
				<input type="submit" value="Leave a Comment">
				<input type="hidden" name="did_comment" value="1">
			</li>
		</ol>					
	</form>
</section>