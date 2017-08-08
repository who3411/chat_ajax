<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>部屋メンバー変更</title>
<link rel="stylesheet" href="login.css">
</head>
<body id = "chat">
<?php
	define("BACKFILE", "changeRoomMember.php");
	if(empty($_SESSION['id']) || empty($_SESSION['name'])){
?>
	<script>
	location.href = 'login.php';
	</script>
<?php
	}
	if(empty($_SESSION['roomID'])){
?>
	<script>
	location.href = 'auth.php';
	</script>
<?php
}
	$mysqli = new mysqli("localhost", "account_root", "testpass", "test");
	if(mysqli_connect_errno()){
		die("MySQL connection error: ". mysqli_connect_errno());
	}
	$roomName = htmlspecialchars($_POST['roomName']);
	$accountnct = 0;
	if($_POST['change'] === 'ins'){
		$sql = 'SELECT * FROM account WHERE ';
		for($i = 0;!empty($_POST['friend'.$i]);$i++){
			$friend[$i] = htmlspecialchars($_POST['friend'.$i]);
			if($friend[$i] == $_SESSION['id']){
?>
			<script>
			alert('Your name mustn\'t written.\nretry create room.');
			location.href = 'changeRoomMember.php';
			</script>
<?php
			}
			$sql .= ('id = "'. $friend[$i]. '"'. (empty($_POST['friend'.($i+1)]) ? ';' : ' OR '));
		}
		if(!($result = $mysqli->query($sql))){
			die("SQL error: ". $mysqli->error);
			exit();
		}
		$accountcnt = $result->num_rows;
		if(!($i == $accountcnt)){
?>
		<script>
		alert('You mistake account\nretry create room.');
		location.href = 'changeRoomMember.php';
		</script>
<?php
		}
		$sql = str_replace('account', 'roomMember', $sql);
		$sql = str_replace('id = ', 'accountID = ', $sql);
		$sql = str_replace('WHERE ', 'WHERE roomID = '. $_SESSION['roomID']. ' AND (', $sql);
		$sql = str_replace(';', ');', $sql);
		if(!($result = $mysqli->query($sql))){
			die("SQL error: ". $mysqli->error);
			exit();
		}
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			for($i = 0;$i < $accountcnt;$i++){
				if($row['accountID'] === $friend[$i]){
?>
					<script>
					alert('Don\'t create new member\nretry change');
					location.href = 'changeRoomMember.php';
					</script>
<?php
				}
			}
		}
		for($i = 0;$i < $accountcnt;$i++){
			$sql = 'INSERT INTO roomMember VALUES("'. $friend[$i]. '", "'. $_SESSION['roomID']. '");';
			if(!($result = $mysqli->query($sql))){
				die("SQL error: ". $mysqli->error);
				exit();
			}
		}
	}else{
		foreach($_POST as $i => $j)	echo "$i = $j<br>";
		$sql = 'DELETE FROM roomMember WHERE accountID = "'. $_POST['member']. '" ';
		$sql .= 'AND roomID = '. $_SESSION['roomID']. ';';
		if(!($result = $mysqli->query($sql))){
			die("SQL error: ". $mysqli->error);
			exit();
		}
	}
?>
<script>
alert('変更が完了しました。\nチャットページに戻ります。');
location.href = 'chat.php';
</script>
</body>
