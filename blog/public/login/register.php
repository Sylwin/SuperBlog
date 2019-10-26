<?php require_once('../../private/initialize.php'); ?>
<?php require_once('../../private/registration_login.php') ?>

<?php $page_title = 'Super Blog | Register'; ?>
<?php include(SHARED_PATH . '/head_section.php'); ?>
	
	<?php include(SHARED_PATH . '/navbar.php'); ?>
	
	<div class="container">
		<div style="width: 40%; margin: 20px auto;">
			<form method="post" action="register.php" >
				<div class='form-header'>
					<h2>Registration</h2>
				</div>
				<?php include(SHARED_PATH . '/errors.php') ?>
				
				<input type="text" name="username" value="<?php echo h($username); ?>" placeholder="Username">
				<input type="email" name="email" value="<?php echo h($email) ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<input type="password" name="passwordConfirmation" placeholder="Password confirmation">
				<button type="submit" class="btn" name="register_btn">Sign up</button>
				
			</form>
		</div>
	</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
