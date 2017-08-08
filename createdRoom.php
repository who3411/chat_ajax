<?php session_start(); ?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="login.css">
</head>
<body id = "chat">
<?php
	define("BACKFILE", "createRoom.php");
	if(empty($_SESSION['id']) || empty($_SESSION['name'])){
?>
	<script>
	location.href = 'login.php';
	</script>
<?php
	}
	$mysqli = new mysqli("localhost", "account_root", "testpass", "test");
	if(mysqli_connect_errno()){
		die("MySQL connection error: ". mysqli_connect_errno());
	}
	$roomName = htmlspecialchars($_POST['roomName']);
	$accountnct = 0;
	if(!empty($_POST['friend0'])){
		$sql = 'SELECT * FROM account WHERE ';
		for($i = 0;!empty($_POST['friend'.$i]);$i++){
			$friend[$i] = htmlspecialchars($_POST['friend'.$i]);
			if($friend[$i] == $_SESSION['id']){
?>
			<script>
			alert('Your name mustn\'t written.\nretry create room.');
			location.href = 'createRoom.php';
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
		location.href = 'createRoom.php';
		</script>
<?php
		}
	}
	$sql = 'SELECT * FROM room WHERE name = "'. $roomName. '";';
	if(!($result = $mysqli->query($sql))){
		die("SQL error: ". $mysqli->error);
		exit();
	}
	if(!$result){
?>
	<script>
	alert("This roomName has already used\nretry create room");
	loation.href = BACKFILE;
	</script>
<?php
	}
	$sql = 'INSERT INTO room VALUES(NULL, "'. $roomName. '", NULL);';
	if(!($result = $mysqli->query($sql))){
		die("SQL error: ". $mysqli->error);
		exit();
	}
	$roomID = $mysqli->insert_id;
	$friend[$accountcnt] = $_SESSION['id'];
	for($i = 0;$i < $accountcnt + 1;$i++){
		$sql = 'INSERT INTO roomMember VALUES("'. $friend[$i]. '", "'. $roomID. '");';
		if(!($result = $mysqli->query($sql))){
			die("SQL error: ". $mysqli->error);
			exit();
		}
	}
?>
<script>
alert('部屋の作成が完了しました。\n部屋一覧ページに戻ります。');
location.href = 'auth.php';
</script>
</body>
