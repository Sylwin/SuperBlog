<div class="navbar">
		<div class="site-name">
			<a href="<?php echo url_for('index.php'); ?>"><h1>Super Blog</h1></a>
		</div>
		<?php if (isset($_SESSION['user']['username'])) { ?>
				<div class="menu">
					<span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp;
					<a href="<?php echo url_for('index.php'); ?>" class="menu-button">HOME</a>
					<a href="<?php echo url_for('profile/profile.php'); ?>" class="menu-button">PROFILE</a>
					<a href="<?php echo url_for('login/logout.php'); ?>" class="menu-button">LOGOUT</a>
				</div>

			<?php }	else{ ?>
				<div class="login">
					<a href="<?php echo url_for('login/login.php');?>" class="menu-button">LOGIN</a>
					<a href="<?php echo url_for('login/register.php');?>" class="menu-button">REGISTER</a>
				</div>
			<?php } ?>
</div>