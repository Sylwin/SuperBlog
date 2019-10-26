<?php  include('../../../private/initialize.php'); ?>

<?php 
	redirect_if_not_logged_in();
	$page_title = 'Super Blog | Manage Users'; 
	$users = getUsers();
?>
<?php  include(SHARED_PATH . '/head_section.php'); ?>
	
	<?php include(SHARED_PATH . '/navbar.php') ?>
	<div class="container content">
		
		<?php include('../menu.php') ?>
		
		<div class="action create-post-div">
			<?php if ($isEditingUser === true): ?> 
				<h1 class="page-title">Edit User</h1>
			<?php else: ?>
				<h1 class="page-title">Create User</h1>
			<?php endif ?>

			<form method="post" action="<?php echo url_for('profile/actions/create_user.php'); ?>" >

				<?php include(SHARED_PATH . '/errors.php') ?>

				<?php if ($isEditingUser === true): ?>
					<input type="hidden" name="user_id" value="<?php echo h($user_id); ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo h($username); ?>" placeholder="Username">
				<input type="email" name="email" value="<?php echo h($email) ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<input type="password" name="passwordConfirmation" placeholder="Password confirmation">
				
				<?php if ($isEditingUser === true): ?> 
					<button type="submit" class="btn" name="update_user">Update</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_user">Save User</button>
				<?php endif ?>
			</form>
		</div>
		
	</div>
</body>
</html>