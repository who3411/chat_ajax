<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>部屋作成</title>
<link rel = "stylesheet" href = "login.css">
<script type = "text/javascript" src = "../js/jquery-1.12.3.min.js"></script>
<script type = "text/javascript" src = "create.js"></script>
</head>
<body id = "chat">
<?php
	if(empty($_SESSION['id']) || empty($_SESSION['name'])){
?>
	<script>
	location.href = "login.php";
	</script>
<?php
	}
?>
<header>
	<ul>
		<a class = "menu" href = "auth.php"><li>部屋一覧へ</li></a>
		<li id = "li_main"><h1 id = "title">部屋を作成</h1></li>
		<a class = "menu" href = "logout.php"><li>ログアウト</li></a>
	</ul>
</header>
<p>
<form action = 'createdRoom.php' method = 'POST'>
部屋の名前を入力(15文字以内):
<input required maxlength = 15 class = "input" name = "roomName" type = "text">
</p>
<p id = "createField">
<div id = "createText">追加するアカウント入力部分を追加</div>
</p>
<p>
<input class = "input" type = "submit" value = "部屋を作成">
</p>
</form>
</body>
