<?php  include('../../../private/initialize.php'); ?>

<?php 
	redirect_if_not_logged_in();
	
	$page_title = 'Super Blog | Manage Posts'; 
	$posts = getAllPosts(); 
?>

<?php  include(SHARED_PATH . '/head_section.php'); ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include('../menu.php'); ?>

		<!-- Display records from DB-->
		<div class="table-div" style="width: 80%;">
			<!-- Display notification message -->
			<?php include(SHARED_PATH . '/messages.php') ?>

			<?php if (empty($posts)): ?>
				<h1 style="text-align: center; margin-top: 20px;">No posts in the database.</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						<th>N</th>
						<th>Title</th>
						<th>Author</th>
						<th><small>Published</small></th>
						<th><small>Edit</small></th>
						<th><small>Delete</small></th>
					</thead>
					<tbody>
					<?php foreach ($posts as $key => $post): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td>
								<a style="text-transform: uppercase;" href="<?php echo url_for('posts/post.php')?>?post-id=<?php echo h(u($post['id']));?>"><?php echo $post['post_title']; ?></a>
							</td>
							<td><?php echo $post['author']; ?></td>
												
							<td>
							<?php if ($post['published'] == true): ?>
								<a class="fa fa-check btn unpublish"
									href="manage_posts.php?unpublish=<?php echo h(u($post['id'])) ?>">
								</a>
							<?php else: ?>
								<a class="fa fa-times btn publish"
									href="manage_posts.php?publish=<?php echo h(u($post['id'])) ?>">
								</a>
							<?php endif ?>
							</td>
		
							<td>
								<a class="fa fa-pencil btn edit"
									href="create_post.php?edit-post=<?php echo h(u($post['id'])) ?>">
								</a>
							</td>
							<td>
								<a  class="fa fa-trash btn delete" 
									href="create_post.php?delete-post=<?php echo h(u($post['id'])) ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>

			<a class="centered-button" href="create_post.php">Create New Post</a>

		</div>
		
	</div>
</body>
</html>