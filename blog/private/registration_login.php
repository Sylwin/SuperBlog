<?php 

$username = "";
$email    = "";

if (isset($_POST['login_btn'])) {
	loginUser($_POST);
}
if (isset($_POST['register_btn'])) {
	registerUser($_POST);
}

function loginUser($request_values) {
	global $conn, $errors;
	$username = esc($_POST['username']);
	$password = esc($_POST['password']);

	if (empty($username)) { 
		array_push($errors, "Username required"); 
	}
	if (empty($password)) { 
		array_push($errors, "Password required"); 
	}
	if (empty($errors)) {
		$password = md5($password);
	
		$sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			$reg_user_id = mysqli_fetch_assoc($result)['id']; 

			$_SESSION['user'] = getUserById($reg_user_id); 

			redirect_to(url_for("profile/profile.php"));

			exit(0);
		} else {
			array_push($errors, 'Wrong credentials.');
		}
	}
}

function registerUser($request_values) {
	global $conn, $errors;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);

	if (empty($username)) { 
		array_push($errors, "Uhmm...We gonna need the username"); 
	}
	if (empty($email)) { 
		array_push($errors, "Oops.. Email is missing"); 
	}
	if (empty($password)) { 
		array_push($errors, "uh-oh you forgot the password"); 
	}
	if ($password != $passwordConfirmation) { 
		array_push($errors, "The two passwords do not match"); 
	}
	
	$user_check_query = "SELECT * FROM users WHERE username='$username' 
							OR email='$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);

	if ($user) {
		if ($user['username'] === $username) {
		  array_push($errors, "Username already exists");
		}
		if ($user['email'] === $email) {
		  array_push($errors, "Email already exists");
		}
	}

	if (count($errors) == 0) {
		$password = md5($password);
		$query = "INSERT INTO users (username, email, password, creation_date) 
				  VALUES('$username', '$email', '$password', now())";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Welcome " . $username . "! Your account has been created successfully. You can now log in!";
		redirect_to(url_for('login/login.php'));
		exit(0);
	}
}

function getUserById($id) {
	global $conn;
	$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);

	return $user; 
}
?>