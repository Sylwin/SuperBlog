<?php  include('../../../private/initialize.php'); ?>

<?php 
	redirect_if_not_logged_in();
	$page_title = 'Super Blog | Manage Users'; 
	$users = getUsers();
?>
<?php  include(SHARED_PATH . '/head_section.php'); ?>
	
	<div class="container content">
		
		<?php include('../menu.php') ?>
		
		<div class="table-div" style="width: 60%;">
			
			<?php include(SHARED_PATH . '/messages.php') ?>

			<?php if (empty($users)): ?>
				<h1>No users in the database.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>User</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
					<?php foreach ($users as $key => $user): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td>
								<?php echo $user['username']; ?>, &nbsp;
								<?php echo $user['email']; ?>	
							</td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="create_user.php?edit-user=<?php echo h(u($user['id'])) ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete" 
								    href="create_user.php?delete-user=<?php echo h(u($user['id'])) ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>

			<a class="centered-button" href="create_user.php">Create New User</a>
		</div>
		
	</div>
</body>
</html>