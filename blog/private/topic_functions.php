<?php 

$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";

if (isset($_POST['create_topic'])) { 
	createTopic($_POST); 
}
if (isset($_GET['edit-topic'])) {
	$isEditingTopic = true;
	$topic_id = $_GET['edit-topic'];
	editTopic($topic_id);
}
if (isset($_POST['update_topic'])) {
	updateTopic($_POST);
}
if (isset($_GET['delete-topic'])) {
	$topic_id = $_GET['delete-topic'];
	deleteTopic($topic_id);
}

function createTopic($request_values){
	global $conn, $errors, $topic_name;
	$topic_name = esc($request_values['topic_name']);
	
	if (empty($topic_name)) { 
		array_push($errors, "Topic name required"); 
	}
	
	$topic_check_query = "SELECT * FROM topics WHERE name='$topic_name' LIMIT 1";
	$result = mysqli_query($conn, $topic_check_query);
	if (mysqli_num_rows($result) > 0) {
		array_push($errors, "Topic already exists");
	}
	
	if (count($errors) == 0) {
		$query = "INSERT INTO topics (name) VALUES('$topic_name')";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Topic created successfully";
		redirect_to(url_for('profile/actions/manage_topics.php'));
		exit(0);
	}
}

function editTopic($topic_id) {
	global $conn, $topic_name, $isEditingTopic, $topic_id;
	$sql = "SELECT * FROM topics WHERE id=$topic_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	
	$topic_name = $topic['name'];
}

function updateTopic($request_values) {
	global $conn, $errors, $topic_name, $topic_id;
	$topic_name = esc($request_values['topic_name']);
	$topic_id = esc($request_values['topic_id']);
	
	if (empty($topic_name)) { 
		array_push($errors, "Topic name required"); 
	}

	if (count($errors) == 0) {
		$query = "UPDATE topics SET name='$topic_name' WHERE id=$topic_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Topic updated successfully";
		redirect_to(url_for('profile/actions/manage_topics.php'));
		exit(0);
	}
}

function deleteTopic($topic_id) {
	global $conn;
	$sql = "DELETE FROM topics WHERE id=$topic_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Topic successfully deleted";
		redirect_to(url_for('profile/actions/manage_topics.php'));
		exit(0);
	}
}

function getAllTopics()
{
	global $conn;
	$sql = "SELECT * FROM topics";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}

function getTopicNameById($id)
{
	global $conn;
	$sql = "SELECT name FROM topics WHERE id=$id";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic['name'];
}

?>

