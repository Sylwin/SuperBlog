<?php 
	session_start();

	define('PRIVATE_PATH', dirname(__FILE__));
	define('PROJECT_PATH', dirname(PRIVATE_PATH));
 	define('PUBLIC_PATH', PROJECT_PATH . '/public');
	define('SHARED_PATH', PRIVATE_PATH . '/shared');


 	$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
  	$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  	define('BASE_URL', $doc_root);


	require_once('database.php');
	$conn = db_connect();

  	require_once('util_functions.php');
	require_once('topic_functions.php');
	require_once('post_functions.php');
	require_once('user_functions.php');

?>