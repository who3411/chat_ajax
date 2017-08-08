<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>部屋一覧</title>
<link rel = "stylesheet" href = "login.css">
<script type = 'text/javascript' src = '../js/jquery-1.12.3.min.js'></script>
<script type = 'text/javascript' src = 'auth.js'></script>
</head>
<body id = "chat">
<?php
	if(empty($_SESSION['id']) || empty($_SESSION['name'])){
		$id = htmlspecialchars($_POST['id']);
		$pass = htmlspecialchars($_POST['pass']);
		$mysqli = new mysqli("localhost", "account_root", "testpass", "test");
		if(mysqli_connect_errno()){
			die("MySQL connection error: " . mysqli_connect_errno());
			exit();
		}
		$sql = 'SELECT * FROM account WHERE id = "'. $id. '" AND pass = "'. $pass. '";';
		if(!($result = $mysqli->query($sql))){
			die("SQL error: " . $mysqli->error);
			exit();
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if($id == $row['id'] && $pass == $row['pass']){
			$_SESSION['id'] = $row['id'];
			$_SESSION['name'] = $row['name'];
		}else{
?>
		<script>
		alert("You mistake id or pass\nretry login");
		location.href = "login.php";
		</script>
<?php
		}
	}
	unset($_SESSION['roomID']);
?>
<header>
	<ul>
		<a class = "menu" href = "createRoom.php"><li>部屋を作成</li></a>
		<li id = "li_main"><h1 id = "title">部屋を選択</h1></li>
		<a class = "menu" href = "logout.php"><li>ログアウト</li></a>
	</ul>
</header>
<form name = "chat" action = "chat.php" method = "POST">
<?php
	$mysqli = new mysqli("localhost", "account_root", "testpass", "test");
	if(mysqli_connect_errno()){
		die("MySQL connection error: " . mysqli_connect_errno());
		exit();
	}
	$sql = 'SELECT room.id AS roomID, room.name AS roomName, ';
	$sql .= 'room.id AS roomID, room.time AS createTime';
	$sql .= ' FROM account, room, roomMember WHERE account.id = roomMember.accountID AND ';
	$sql .= 'room.id = roomMember.roomID AND account.id = "'. $_SESSION['id']. '";';
	if(!($result = $mysqli->query($sql))){
		die("SQL error: " . $mysqli->error);
		exit();
	}
	$roomNumber = 0;
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$sql = 'SELECT account.name AS name FROM account, room, roomMember';
		$sql .= ' WHERE account.id = roomMember.accountID AND room.id = roomMember.roomID';
		$sql .= ' AND room.id = "'. $row['roomID']. '"';
		$sql .= ' AND account.id <> "'. $_SESSION['id']. '";';
		if(!($result2 = $mysqli->query($sql))){
			die("SQL error: " . $mysqli->error);
			exit();
		}
		echo '<div class = "chatRoom">';
		echo '<input type = "hidden" name = "room'. $roomNumber. '" ';
		echo 'id = "room'. $roomNumber. '" value = "'. $row['roomID']. '">';
		echo '<h2>'. $row['roomName']. '</h2>';
		$i = 0;
		$accountcnt = $result2->num_rows;
		if($accountcnt > 0){
			echo '他アカウント名：';
			while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
				echo $row2['name']. '&#009;';
				if($i++ == 4){
					echo 'など計'. $accountcnt. '人';
					break;
				}
			}
		}
		echo '</div>';
		$roomNumber++;
	}
?>
</form>
</body>
