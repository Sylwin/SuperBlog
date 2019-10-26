<?php 

$errors = [];

function url_for($script_path) {
	if($script_path[0] != '/') {
		$script_path = "/" . $script_path;
	}
	return BASE_URL . $script_path;
}

function esc(String $value) {	
	global $conn;

	$val = trim($value);
	$val = mysqli_real_escape_string($conn, $value);

	return $val;
}

function redirect_to($location) {
  	header("Location: " . $location);
  	
}

function redirect_if_not_logged_in() {
	if (!isset($_SESSION['user'])) {
		array_push($errors, "You have to be logged in to see this page!");
		redirect_to(url_for('login/login.php'));
	}
}

function u($string="") {
  return urlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

?>