<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>新規登録画面</title>
<link rel = "stylesheet" href = "login.css"></style>
<?php
	if(!empty($_SESSION['id']) && !empty($_SESSION['name'])){
?>
	<script>
	location.href = "auth.php";
	</script>
<?php
	}
?>
</head>
<body>
<h1>新規登録画面</h1>
<form action = "resistprog.php" method = "POST">
<p>
ログインIDを入力(半角英数字20字以内)：
<input required pattern = "[A-Za-z0-9]+" maxlength = 20 name = "id" class = "input" type = "text">
</p>
<p>
ニックネームを入力(15文字以内)：
<input required maxlength = 20 name = "name" class = "input" type = "text">
</p>
<p>
パスワードを入力(半角英数字20字以内)：
<input required pattern = "[A-Za-z0-9]+" maxlength = 20 name = "pass" class = "input" type = "password">
</p>
<p>
パスワードを再入力(半角英数字20字以内)：
<input required pattern = "[A-Za-z0-9]+" maxlength = 20 name = "cpass" class = "input" type = "password">
</p>
<p>
<input id = "login" class = "input" type = "submit" value = "新規登録">
</p>
<p>
ログインする方は<a href = "login.php">コチラ</a>
</p>
</form>
</body>
