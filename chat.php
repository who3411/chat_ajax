<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
	if(empty($_SESSION['id']) || empty($_SESSION['name'])){
?>
	<script>
	location.href = "login.php";
	</script>
<?php
	}
	if(empty($_SESSION['roomID'])){
		$_SESSION['roomID'] = $_POST['roomID'];
	}
	$roomName = htmlspecialchars($_POST['roomName']);
	$_SESSION['querycnt'] = 0;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $roomName; ?></title>
	<link rel="stylesheet" href="style2.css">
	<link rel="stylesheet" href="login.css">
	<script src="../js/jquery-1.12.3.min.js"></script>
	<script src="main2.js"></script>
</head>
<body id = "chat">
<header>
	<ul>
		<a class = "menu" href = "auth.php"><li>部屋一覧へ</li></a>
		<a class = "menu" href = "changeRoomMember.php"><li id = "li_main">アカウントを追加/削除</li></a>
		<a class = "menu" href = "logout.php"><li>ログアウト</li></a>
	</ul>
</header>
<div id="containar">
	<div id="talkField">
	<h1><?php echo $roomName; ?></h1>
		<div id="result"></div>
		<br class="clear_balloon"/>
	</div>
</div>
<div id="inputField">
	<input required maxlength = 200 type="text" id="message">
	<label for="file" id="filebutton">
		<span id="filename">file select</span>
		<input type="file" id="file">
	</label>
	<input type="button" id="greet" value="send">
</div>
</body>
</html>
