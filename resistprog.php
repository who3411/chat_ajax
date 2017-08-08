<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>登録完了画面</title>
<link rel="stylesheet" href="login.css">
</head>
<body>
<?php
	define("BACKFILE", "regist.php");
	if(!empty($_SESSION['id']) && !empty($_SESSION['name'])){
?>
	<script>
	location.href = BACKFILE;
	</script>
<?php
	}
	if($_POST['pass'] != $_POST['cpass']){
?>
	<script>
	alert("You mistake pass");
	location.href = BACKFILE;
	</script>
<?php
	}
	$id = htmlspecialchars($_POST['id']);
	$name = htmlspecialchars($_POST['name']);
	$pass = htmlspecialchars($_POST['pass']);
	$mysqli = new mysqli("localhost", "account_root", "testpass", "test");
	if(mysqli_connect_errno()){
		die("MySQL connection error: ". mysqli_connect_errno());
	}
	$sql = 'SELECT * FROM account WHERE id = "'. $id. '";';
	if(!($result = $mysqli->query($sql))){
		die("SQL error: ". $mysqli->error);
		exit();
	}
	if(!$result){
?>
	<script>
	alert("This id has already used\nretry regist");
	loation.href = BACKFILE;
	</script>
<?php
	}
	$sql = 'INSERT INTO account VALUES("'. $id. '", "'. $name. '", "'. $pass. '");';
	if(!($result = $mysqli->query($sql))){
		die("SQL error: ". $mysqli->error);
		exit();
	}
	echo "<p>". $name. "様の登録が完了しました。</p>";
?>
<p>
<a href = "login.php">ログインするにはコチラ</a>
</p>
</body>
