<?php
	require 'vendor/autoload.php';
	$templates = new League\Plates\Engine('templates');
	$templates->registerFunction('verifyUser', function ($submittedUserName, $submittedUserPass) {
		$servername = "localhost";
		$db_username = "";
		$db_password = "";
		$resultsFromDB = array();
		$returningArray = array();
		$conn = mysqli_connect($servername, $db_username, $db_password, "bluejeansinvestdatabse");
		if (!$conn) {
		    die();
		    return false;
		    exit();
		}
		$sql = "SELECT Users.*, UserDetails.* from Users, UserDetails WHERE userName = ? AND Users.userID = UserDetails.UserID;";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "s", $submittedUserName);
		mysqli_stmt_execute($stmt);
		$results = mysqli_stmt_get_result($stmt);
		if($results->num_rows == 0) {
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			header('Location: /BlueJeansInvesting/index.php');
		} 
		else
		{
			while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
				array_push($resultsFromDB, $row["userName"], $row["userPass"]);
				array_push($returningArray, $row["userFName"], $row["userSymbol1"], $row["userSymbol2"], $row["userSymbol3"]);
			}
			if(password_verify($submittedUserPass, $resultsFromDB[1])){
				mysqli_stmt_close($stmt);
				mysqli_close($conn);
				return($returningArray);
			}
			else
			{
				mysqli_stmt_close($stmt);
				mysqli_close($conn);
				header('Location: /BlueJeansInvesting/index.php');
			}
		}
	});

	$templates->registerFunction('deleteSymbol', function ($position, $userFirstName) {
		$servername = "localhost";
		$db_username = "";
		$db_password = "";
		$conn = mysqli_connect($servername, $db_username, $db_password, "bluejeansinvestdatabse");
		if(!$conn) {
			die();
			exit();
		}
		$deleteSymbolSQL = "UPDATE userdetails SET userSymbol" . $position . " = null WHERE userFName = ?;";
		$deleteSymbolStmt = mysqli_prepare($conn, $deleteSymbolSQL);
		$deleteSymbolBindParams = mysqli_stmt_bind_param($deleteSymbolStmt, "s", $userFirstName);
		$deleteSymbolExecParams = mysqli_stmt_execute($deleteSymbolStmt);
		$newTickersArr = array();
		$nullSQL = "SELECT userSymbol1, userSymbol2, userSymbol3 FROM userdetails WHERE userFName = '" . $userFirstName . "'";
		$nullStmt = mysqli_prepare($conn, $nullSQL);
		$nullBindParams = mysqli_stmt_bind_param($nullStmt, "s", $userFirstName);
		$nullExecParams = mysqli_stmt_execute($nullStmt);
		$nullResults = mysqli_stmt_get_result($nullStmt);
		while($row = mysqli_fetch_assoc($nullResults)) {
			$newTickersArr = array($row["userSymbol1"], $row["userSymbol2"], $row["userSymbol3"]);
		}
		mysqli_stmt_close($deleteSymbolStmt);
		mysqli_stmt_close($nullStmt);
		mysqli_close($conn);
		return($newTickersArr);
	});

	$templates->registerFunction('addSymbol', function ($symbol, $userFirstName) {
		// Check DB for nulls if no avail then insert into first slot, parametize input
		$symbol = strtoupper($symbol);
		$initalValue = array();
		$openSymbolSlot = null;
		$servername = "localhost";
		$db_username = "";
		$db_password = "";
		$conn = mysqli_connect($servername, $db_username, $db_password, "bluejeansinvestdatabse");
		if (!$conn) {
		    die();
		    exit();
		}
		$nullSQL = "SELECT userSymbol1, userSymbol2, userSymbol3 FROM userdetails WHERE userFName = ?";
		$nullStmt = mysqli_prepare($conn, $nullSQL);
		$nullBindParams = mysqli_stmt_bind_param($nullStmt, "s", $userFirstName);
		$nullExecParams = mysqli_stmt_execute($nullStmt);
		$nullResults = mysqli_stmt_get_result($nullStmt);
		while($row = mysqli_fetch_assoc($nullResults)) {
			$initalValue = array($row["userSymbol1"], $row["userSymbol2"], $row["userSymbol3"]);
		}
		for($i = 0; $i < count($initalValue); $i++) {
			if(is_null($initalValue[$i])) {
				$openSymbolSlot = $i+1;
			}
		}
		if($openSymbolSlot === 1) {
			$symbolPosition = "userSymbol1";
			$initalValue[0] = $symbol;
		}
		else if ($openSymbolSlot === 2) {
			$symbolPosition = "userSymbol2";
			$initalValue[1] = $symbol;
		}
		else if($openSymbolSlot === 3) {
			$symbolPosition = "userSymbol3";
			$initalValue[2] = $symbol;
		}
		else {
			$symbolPosition = "userSymbol1";
			$initalValue[0] = $symbol;
		}
		$addSymbolSQL = "UPDATE userdetails SET ". $symbolPosition ." = ? WHERE userFName = ?;";
		$addSymbolStmt = mysqli_prepare($conn, $addSymbolSQL);
		$addSymbolBindParams = mysqli_stmt_bind_param($addSymbolStmt, "ss", $symbol, $userFirstName);
		$addSymbolExecParams = mysqli_stmt_execute($addSymbolStmt);
		mysqli_stmt_close($addSymbolStmt);
		mysqli_stmt_close($nullStmt);
		mysqli_close($conn);
		return $initalValue;
	});

	echo $templates->render('dashboard');
?>