<?php
	session_start();
	session_destroy();
	header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ログアウト画面</title>
<link rel = "stylesheet" href = "login.css">
</head>
<body>
<p>
ログアウトが完了しました。
</p>
<a href="login.php">ログイン画面へ</a>
</body>
