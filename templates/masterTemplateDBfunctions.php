<?php 

function regUser($_username, $_userpass, $_useremail, $_userFName) {
	$main_server = "localhost";
	$regUserName = "";
	$regUserPass = "";
	$conn = mysqli_connect($main_server, $regUserName, $regUserPass, "bluejeansinvestdatabse");
	if (!$conn) {
	    die();
	    return false;
	    exit();
	}
	$usersSQL = "INSERT INTO users (userName, userPass, userEmail) VALUES (?,?,?)";
	$userStmt = mysqli_prepare($conn, $usersSQL);
	$userDetailsSQL = "INSERT INTO userdetails (userID, userFName) VALUES (?, ?)";
	$userDetailStmt = mysqli_prepare($conn, $userDetailsSQL);
	if(!$userStmt || !$userDetailStmt) {
		die();
		return false;
		exit();
	}
	$userBindParams = mysqli_stmt_bind_param($userStmt, "sss", $_username, $_userpass, $_useremail);
	$userExecParams = mysqli_stmt_execute($userStmt);
	$userID = mysqli_insert_id($conn);
	$userDetailsBindParams = mysqli_stmt_bind_param($userDetailStmt, "is", $userID, $_userFName);
	$userDetailsExecParams = mysqli_stmt_execute($userDetailStmt);
	if(!$userBindParams || !$userExecParams || !$userDetailsBindParams || !$userDetailsExecParams) {
		return false;
		exit();
	}
	mysqli_stmt_close($userStmt);
	mysqli_stmt_close($userDetailStmt);
	mysqli_close($conn);
	return true;
}

function getAllPosts() {
	$main_server = "localhost";
	$readOnlyUserName = "";
	$readOnlyUserPass = "";
	$postArray = array();
	$conn = mysqli_connect($main_server, $readOnlyUserName, $readOnlyUserPass, "bluejeansinvestdatabse");
	if (!$conn) {
	    die();
	    return false;
	    exit();
	}
	$results = mysqli_query($conn, "SELECT posts.*, userName FROM posts, users WHERE posts.userID = users.userID ORDER BY postDate DESC");
	while($row = mysqli_fetch_assoc($results)) {
		array_push($postArray, array($row["postID"], $row["postTitle"]));
	}
	mysqli_close($conn);
	return $postArray;
}

function getAllQuotes() {
	$main_server = "localhost";
	$readOnlyUserName = "";
	$readOnlyUserPass = "";
	$quotesArray = array();
	$conn = mysqli_connect($main_server, $readOnlyUserName, $readOnlyUserPass, "bluejeansinvestdatabse");
	if (!$conn) {
	    die();
	    return false;
	    exit();
	}
	$results = mysqli_query($conn, "SELECT * FROM Quotes");
	while($row = mysqli_fetch_assoc($results)) {
		array_push($quotesArray, array($row["quoteAuthor"], $row["quoteContent"]));
	}
	mysqli_close($conn);
	return $quotesArray;
}

?>