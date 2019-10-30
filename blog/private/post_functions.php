<?php 

$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$description = "";
$body = "";
$featured_image = "";
$post_topic = "";
$user_id = 0;

function getPublishedPostsByTopic($topic_id) {
	global $conn;
	$sql = "SELECT * FROM posts ps 
			WHERE ps.id IN 
			(SELECT pt.post_id FROM post_topic pt 
				WHERE pt.topic_id=$topic_id GROUP BY pt.post_id 
				HAVING COUNT(1) = 1)";
	$result = mysqli_query($conn, $sql);
	
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}

function getPostAuthor($post_id) {
	global $conn;
	
	$sql = "SELECT * FROM users WHERE id=(SELECT user_id FROM posts WHERE id='$post_id');";
	$result = mysqli_query($conn, $sql);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

function getPost($post_id) {
	global $conn;
	
	$sql = "SELECT * FROM posts WHERE id='$post_id' AND published=true";
	$result = mysqli_query($conn, $sql);

	$post = mysqli_fetch_assoc($result);
	if ($post) {
		$post['topic'] = getPostTopic($post['id']);
	}
	return $post;
}

function getAllPosts() {
	global $conn;
	
	$sql = "SELECT * FROM posts";
	
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['author'] = getPostAuthorById($post['user_id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}

function getPostAuthorById($user_id) {
	global $conn;
	$sql = "SELECT username FROM users WHERE id=$user_id";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		return mysqli_fetch_assoc($result)['username'];
	} else {
		return null;
	}
}

function getAllPostsByUserId($user_id) {
	global $conn;
	$sql = "SELECT * FROM posts WHERE user_id=$user_id";
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']);
		$post['author'] = getPostAuthorById($post['user_id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}

function getPublishedPosts() {
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true";
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']);
		$post['author'] = getPostAuthorById($post['user_id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}


function getPostTopic($post_id) {
	global $conn;
	$sql = "SELECT * FROM topics WHERE id=
			(SELECT topic_id FROM post_topic WHERE post_id=$post_id LIMIT 1) LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}

if (isset($_POST['create_post'])) { 
	createPost($_POST); 
}

if (isset($_GET['edit-post'])) {
	$isEditingPost = true;
	$post_id = $_GET['edit-post'];
	editPost($post_id);
}

if (isset($_POST['update_post'])) {
	updatePost($_POST);
}

if (isset($_GET['delete-post'])) {
	$post_id = $_GET['delete-post'];
	deletePost($post_id);
}

function createPost($request_values) {

	global $conn, $errors, $title, $featured_image, $topic_id, $body, $published, $user_id;
	$title = esc($request_values['title']);
	$description = esc($request_values['description']);
	$body = htmlentities(esc($request_values['body']));
	if (isset($request_values['topic_id'])) {
		$topic_id = esc($request_values['topic_id']);
	}
	if (isset($request_values['publish'])) {
		$published = esc($request_values['publish']);
	}

	if (empty($title)) { 
		array_push($errors, "Post title is required"); 
	}
	if (empty($description)) { array_push($errors, "Post description is required"); }
	if (empty($body)) { array_push($errors, "Post body is required"); }
	if (empty($topic_id)) { array_push($errors, "Post topic is required"); }

  	$featured_image = $_FILES['featured_image']['name'];
  	if (empty($featured_image)) { array_push($errors, "Featured image is required"); }

  	$target = $_SERVER['DOCUMENT_ROOT'] . "/public/static/images/" . basename($featured_image);
  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
  		array_push($errors, "Failed to upload image. Please check file settings for your server");
  	}
	
	$post_check_query = "SELECT * FROM posts WHERE post_title='$title' LIMIT 1";
	$result = mysqli_query($conn, $post_check_query);

	if (mysqli_num_rows($result) > 0) {
		array_push($errors, "A post already exists with that title.");
	}
	
	if (count($errors) == 0) {
		$user_id = $_SESSION['user']['id'];
		$query = "INSERT INTO posts (post_title, description, post_text, creation_date, modification_date, user_id, published, image) VALUES('$title', '$description', '$body', now(), now(), '$user_id', $published, '$featured_image')";
		
		if(mysqli_query($conn, $query)){
			$inserted_post_id = mysqli_insert_id($conn);
			
			$sql = "INSERT INTO post_topic (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
			mysqli_query($conn, $sql);

			$_SESSION['message'] = "Post created successfully";
			
			redirect_to(url_for("profile/actions/manage_posts.php"));
			exit(0);
		}
	}
}

function editPost($post_id) {

	global $conn, $title, $body, $description, $published, $isEditingPost, $post_id;

	$sql = "SELECT * FROM posts WHERE id=$post_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$post = mysqli_fetch_assoc($result);
	
	$title = $post['post_title'];
	$body = $post['post_text'];
	$description = $post['description'];
	$published = $post['published'];
}

function updatePost($request_values) {

	global $conn, $errors, $post_id, $title, $description, $featured_image, $topic_id, $body, $published, $isEditingPost;
	$isEditingPost = false;

	$title = esc($request_values['title']);
	$body = esc($request_values['body']);
	$description = esc($request_values['description']);
	$post_id = esc($request_values['post_id']);
	if (isset($request_values['topic_id'])) {
		$topic_id = esc($request_values['topic_id']);
	}
	if (isset($request_values['publish'])) {
		$published = esc($request_values['publish']);
	}

	if (empty($title)) { 
		array_push($errors, "Post title is required"); 
	}
	if (empty($description)) { 
		array_push($errors, "Post description is required"); 
	}
	if (empty($body)) { 
		array_push($errors, "Post body is required"); 
	}

	
	$featured_image = $_FILES['featured_image']['name'];
  	if (empty($featured_image)) { 
  		array_push($errors, "Featured image is required"); 
  	}

  	$target = $_SERVER['DOCUMENT_ROOT'] . "/blog/public/static/images/" . basename($featured_image);
  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
  		array_push($errors, "Failed to upload image. Please check file settings for your server");
  	}

	if (count($errors) == 0) {
		$query = "UPDATE posts SET post_title='$title', image='$featured_image', post_text='$body', published=$published, modification_date=now() WHERE id=$post_id";
	
		if(mysqli_query($conn, $query)){
			if (isset($topic_id)) {
				$inserted_post_id = mysqli_insert_id($conn);
				$sql = "INSERT INTO post_topic (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
				mysqli_query($conn, $sql);
				$_SESSION['message'] = "Post updated successfully";
				redirect_to(url_for("profile/actions/manage_posts.php"));
				exit(0);
			}
		}
		$_SESSION['message'] = "Post updated successfully";
		redirect_to(url_for("profile/actions/manage_posts.php"));
		exit(0);
	} else {
		$isEditingPost = true;
	}
}

function deletePost($post_id){
	global $conn;
	$sql = "DELETE FROM posts WHERE id=$post_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Post successfully deleted";
		redirect_to(url_for("profile/actions/manage_posts.php"));
		exit(0);
	}
}

if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
	$message = "";
	if (isset($_GET['publish'])) {
		$message = "Post published successfully";
		$post_id = $_GET['publish'];
	} else if (isset($_GET['unpublish'])) {
		$message = "Post successfully unpublished";
		$post_id = $_GET['unpublish'];
	}
	togglePublishPost($post_id, $message);
}

function togglePublishPost($post_id, $message) {
	global $conn;
	$sql = "UPDATE posts SET published=!published WHERE id=$post_id";
	
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = $message;
		redirect_to(url_for("profile/actions/manage_posts.php"));
		exit(0);
	}
}
?>
