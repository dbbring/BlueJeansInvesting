<?php
	require 'vendor/autoload.php';
	$templates = new League\Plates\Engine('templates');
	$templates->registerFunction('renderPostContent', function () {
		$post_id = intval($_GET['id']);
		$postArray = array();
		$servername = "localhost";
		$db_username = "";
		$db_password = "";
		$conn = mysqli_connect($servername, $db_username, $db_password, "bluejeansinvestdatabse");
		if (!$conn) {
		    die();
		    return false;
		    exit();
		}
		$results = mysqli_query($conn, "SELECT posts.*, userName, userdetails.* FROM posts, users, userdetails WHERE postID = $post_id AND posts.userID = users.userID AND users.userID = userdetails.userID");
		$row = mysqli_fetch_assoc($results);
		array_push($postArray, $row["userName"], $row["postTitle"], $row["postDate"], $row["postImage1"], $row["postImage2"], $row["postContent"], $row["userImage"], $row["userSummary"], $row["userFName"]);
		mysqli_close($conn);
		return $postArray;
		});

	echo $templates->render('single');
?>