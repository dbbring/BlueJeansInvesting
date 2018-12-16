<?php
	require 'vendor/autoload.php';
	$templates = new League\Plates\Engine('templates');
	$templates->registerFunction('renderPostContent', function () {
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
		$results = mysqli_query($conn, "SELECT posts.*, userName FROM posts, users WHERE posts.userID = users.userID ORDER BY postDate DESC");
		while($row = mysqli_fetch_assoc($results)) {
			array_push($postArray, array($row["userName"],$row["postID"], $row["postTitle"], $row["postDate"], $row["postImage1"]));
		}
		mysqli_close($conn);
		return $postArray;
		});

	$templates->registerFunction('searchFunc', function($searchTerm) {
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
			$queryTerms = "%" . $searchTerm . "%";
			$sql = "SELECT postID, postTitle, postDate, postImage1 FROM posts WHERE postTitle LIKE ?";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "s", $queryTerms);
			mysqli_stmt_execute($stmt);
			$results = mysqli_stmt_get_result($stmt);
			if($results->num_rows == 0) {
				$postArray = array();
			} 
			else
			{
				while($row = mysqli_fetch_assoc($results)) {
					array_push($postArray, array($row["postID"], $row["postTitle"], $row["postDate"], $row["postImage1"]));
				}
			}
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			return $postArray;
		});

	echo $templates->render('index');
?>