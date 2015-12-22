<?php
	session_start();

require_once './h.php';


?>


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>POSTデータ登録</title>
		<!-- Bootstrap -->
		<link href="./css/bootstrap.min.css" rel="stylesheet">
		<script src="js/jquery-2.1.3.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<h2>下記内容で投稿しました。</h2>
			<dl>
				<dt>name</dt>
				<dd><?php print($_SESSION['name']); ?></dd>
				<dt>email</dt>
				<dd><?php print($_SESSION['email']); ?></dd>
				<dt>age</dt>
				<dd><?php print($_SESSION['age']); ?></dd>
				<dt>gender</dt>
				<dd><?php print($_SESSION['gender']); ?></dd>
				<dt>naiyou</dt>
				<dd><?php print($_SESSION['naiyou']); ?></dd>
			</dl>
			<p><a href="index.php">戻る</a></p>
			<p><a href="select.php">一覧を見る</a></p>
		</div>
	</body>
</html>
