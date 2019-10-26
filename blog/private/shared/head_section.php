<?php
  if(!isset($page_title)) { 
  	$page_title = 'Blog | Home'; 
  }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Noto+Serif|Tangerine" rel="stylesheet">
	<!-- Font awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<!-- ckeditor -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
	<!-- Styling for public area -->

	<link rel="stylesheet" href="<?php echo url_for('/static/css/admin_styling.css'); ?>">
	<link rel="stylesheet" href="<?php echo url_for('/static/css/public_styling.css'); ?>">
	<title><?php echo h($page_title); ?></title>
</head>
<body>