<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>部屋内容変更</title>
<link rel = "stylesheet" href = "login.css">
<script type = "text/javascript" src = "../js/jquery-1.12.3.min.js"></script>
<script type = "text/javascript" src = "changeRoomMember.js"></script>
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
	if(empty($_SESSION['roomID'])){
?>
	<script>
	location.href = "auth.php";
	</script>
<?php
	}
?>
<header>
	<ul>
		<a class = "menu" href = "auth.php"><li>部屋一覧へ</li></a>
		<a class = "menu" name = "title" href = "chat.php"><li>部屋に戻る</li></a>
		<a class = "menu" href = "logout.php"><li>ログアウト</li></a>
	</ul>
</header>
<form action = 'changedRoomMember.php' method = 'POST'>
<p>
変更する内容を選択：
<input required type = "radio" name = "change" value = "ins">追加&#009;
<input required type = "radio" name = "change" value = "del">削除
</p>
<p id = "createField">
</p>
<p>
<div id = "createText">追加するアカウント入力部分を追加</div>
</p>
<p>
<input class = "input" type = "submit" value = "変更を実施">
</p>
</form>
</body>
