<?php  include('../../../private/initialize.php'); ?>

<?php 
	redirect_if_not_logged_in();
	$page_title = 'Super Blog | Manage Topics'; 
	$topics = getAllTopics();
?>
<?php  include(SHARED_PATH . '/head_section.php'); ?>
	
	<?php include(SHARED_PATH . '/navbar.php') ?>
	<div class="container content">
		
		<?php include('../menu.php') ?>

		<div class="action">
			<?php if ($isEditingTopic === true): ?> 
				<h1 class="page-title">Edit Topics</h1>
			<?php else: ?>
				<h1 class="page-title">Create Topic</h1>
			<?php endif ?>

			<form method="post" action="<?php echo url_for('profile/actions/manage_topics.php'); ?>" >
				
				<?php include(SHARED_PATH . '/errors.php') ?>

				<?php if ($isEditingTopic === true): ?>
					<input type="hidden" name="topic_id" value="<?php echo h($topic_id); ?>">
				<?php endif ?>

				<input type="text" name="topic_name" value="<?php echo h($topic_name); ?>" placeholder="Topic">
				
				<?php if ($isEditingTopic === true): ?> 
					<button type="submit" class="btn" name="update_topic">Update</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_topic">Save Topic</button>
				<?php endif ?>
			</form>
		</div>

		<div class="table-div">
			
			<?php include(SHARED_PATH . '/messages.php') ?>

			<?php if (empty($topics)): ?>
				<h1>No topics in the database.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Topic Name</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
					<?php foreach ($topics as $key => $topic): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td>
								<?php echo $topic['name']; ?>
							</td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="manage_topics.php?edit-topic=<?php echo h(u($topic['id'])) ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete"								
									href="manage_topics.php?delete-topic=<?php echo h(u($topic['id'])) ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>

		</div>
		
	</div>
</body>
</html>