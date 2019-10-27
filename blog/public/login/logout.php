<?php 
	require_once("../../private/initialize.php");

	session_unset($_SESSION['user']);
	session_destroy();
	redirect_to(url_for('index.php'));
?>