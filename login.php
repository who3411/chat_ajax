<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ログイン画面</title>
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
<h1>ログイン画面</h1>
<form action = "auth.php" method = "POST">
<p>
ログインIDを入力(半角英数字20字以内)：
<input required pattern = "[A-Za-z0-9]+" maxlength = 20 name = "id" class = "input" type = "text">
</p>
<p>
パスワードを入力(半角英数字20字以内)
<input required pattern = "[A-Za-z0-9]+" maxlength = 20 name = "pass" class = "input" type = "password">
</p>
<p>
<input id = "login" class = "input" type = "submit" value = "ログイン">
</p>
<p>
登録していない方は<a href = "resist.php">コチラ</a>
</p>
</form>
</body>
