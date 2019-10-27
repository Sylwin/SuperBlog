<?php require_once('../../private/initialize.php'); ?>
<?php require_once('../../private/registration_login.php') ?>

<?php $page_title = 'Super Blog | Sign in'; ?>
<?php include(SHARED_PATH . '/head_section.php'); ?>
	
	<div class="container">
		<div style="width: 40%; margin: 20px auto;">
			<form method="post" action="login.php" >
				<div class='form-header'>
					<h2>Login</h2>
				</div>
				<?php include(SHARED_PATH . '/errors.php') ?>
				<?php include(SHARED_PATH . '/messages.php') ?>

				<input type="text" name="username" value="<?php echo $username; ?>" value="" placeholder="Username">
				<input type="password" name="password" placeholder="Password">
				<button type="submit" class="btn" name="login_btn">Sign in</button>
			</form>
		</div>
	</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
