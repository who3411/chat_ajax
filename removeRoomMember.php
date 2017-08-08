<?php
	session_start();
	$mysqli = new mysqli("localhost", "account_root", "testpass", "test");
	if(mysqli_connect_errno()){
		die("MySQL connection error: ". mysqli_connect_errno());
	}
	$sql = 'SELECT * FROM roomMember WHERE roomID = "'. $_SESSION['roomID']. '" ';
	$sql .= 'AND accountID <> "'. $_SESSION['id']. '";';
	if(!($result = $mysqli->query($sql))){
		die('SQL error: '. $mysqli->error);
		exit();
	}
	$returnData = '<select name = "member">';
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$returnData .= '<option value = "'. $row['accountID']. '">';
		$returnData .= $row['accountID']. '</option>';
	}
	$returnData .= '</select>';
	echo $returnData;
?>
