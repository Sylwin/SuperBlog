<?php  require_once('../../../private/initialize.php'); ?>

<?php 
	redirect_if_not_logged_in();
	$topics = getAllTopics();	
?>

<?php $page_title = 'Super Blog | Create Post'; ?>
<?php  include(SHARED_PATH . '/head_section.php'); ?>

	<div class="container content">
		
		<?php include('../menu.php') ?>
		
		<div class="action create-post-div">
			<?php if ($isEditingPost === true): ?> 
				<h1 class="page-title">Edit Post</h1>
			<?php else: ?>
				<h1 class="page-title">Create Post</h1>
			<?php endif ?>
			
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('profile/actions/create_post.php'); ?>" >
				
				<?php include(SHARED_PATH . '/errors.php') ?>

				<?php if ($isEditingPost === true): ?>
					<input type="hidden" name="post_id" value="<?php echo h($post_id); ?>">
				<?php endif ?>

				<input type="text" name="title" value="<?php echo $title; ?>" placeholder="Title">
				<input type="text" name="description" value="<?php echo h($description); ?>" placeholder="Description">
				<label style="float: left; margin: 5px auto 5px;">Featured image</label>
				<input type="file" name="featured_image">
				<textarea name="body" id="body" cols="30" rows="10"><?php echo h($body); ?></textarea>
				<select name="topic_id">
					<option value="" selected disabled>Choose topic</option>
					<?php foreach ($topics as $topic): ?>
						<option value="<?php echo $topic['id']; ?>">
							<?php echo $topic['name']; ?>
						</option>
					<?php endforeach ?>
				</select>
				
					<?php if ($published == true): ?>
						<label for="publish">
							Publish
							<input type="checkbox" value="1" name="publish" checked="checked">&nbsp;
						</label>
					<?php else: ?>
						<label for="publish">
							Publish
							<input type="checkbox" value="1" name="publish">&nbsp;
						</label>
					<?php endif ?>
	
				<?php if ($isEditingPost === true): ?> 
					<button type="submit" class="btn" name="update_post">Update</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_post">Save Post</button>
				<?php endif ?>

			</form>
		</div>
	</div>
</body>
</html>

<script>
	CKEDITOR.replace('body');
</script>