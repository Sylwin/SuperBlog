<?php 

$user_id = 0;
$isEditingUser = false;
$username = "";
$email = "";

if (isset($_POST['create_user'])) {
	createUser($_POST);
}

if (isset($_GET['edit-user'])) {
	$isEditingUser = true;
	$user_id = $_GET['edit-user'];
	editUser($user_id);
}

if (isset($_POST['update_user'])) {
	updateUser($_POST);
}

if (isset($_GET['delete-user'])) {
	$user_id = $_GET['delete-user'];
	deleteUser($user_id);
}

function createUser($request_values){
	global $conn, $errors, $username, $email;
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
	} else if (strlen($password) < 8) {
		array_push($errors, "Password should have at least 8 characters long"); 
	} else if (preg_match('/[0-9]/', $password) < 1) {
		array_push($errors, "Password should contains at least 1 number"); 
	} else if (preg_match('/[A-Za-z]/', $password) < 1) {
		array_push($errors, "Password should contains at least 1 letter"); 
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

		$_SESSION['message'] = "User created successfully";
		redirect_to(url_for('profile/actions/manage_users.php'));
		exit(0);
	}
}

function editUser($user_id)
{
	global $conn, $username, $isEditingUser, $user_id, $email;

	$sql = "SELECT * FROM users WHERE id=$user_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);

	$username = $user['username'];
	$email = $user['email'];
}


function updateUser($request_values){
	global $conn, $errors, $username, $isEditingUser, $user_id, $email;
	$user_id = $request_values['user_id'];
	$isEditingUser = false;

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

	if (count($errors) == 0) {
		$password = md5($password);

		$query = "UPDATE users SET username='$username', email='$email', password='$password' WHERE id=$user_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "User updated successfully";
		redirect_to(url_for('profile/actions/manage_users.php'));
		exit(0);
	} else {
		$isEditingUser = true;
	}
}

function deleteUser($user_id) {
	global $conn;
	$sql = "DELETE FROM users WHERE id=$user_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "User successfully deleted";
		$logged_in_user_id = $_SESSION['user']['id'];
		if ($logged_in_user_id === $user_id) {
			redirect_to(url_for('login/logout.php'));	
		} else {
			redirect_to(url_for('profile/actions/manage_users.php'));
		}
		exit(0);
	}
}

function getUsers(){
	global $conn;
	$sql = "SELECT * FROM users";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}

function getUserByUserId($user_id) {
	global $conn;
	$sql = "SELECT * FROM users WHERE id=$user_id;";
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $user;	
}

?>

