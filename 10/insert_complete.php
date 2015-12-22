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
				<dt>id</dt>
				<dd><?php print($_SESSION['id']); ?></dd>
				<dt>news_title</dt>
				<dd><?php print($_SESSION['news_title']); ?></dd>
				<dt>news_detail</dt>
				<dd><?php print($_SESSION['news_detail']); ?></dd>
				<dt>$image_file</dt>
				<dd><?php print('<img src="' . $_SESSION['file_dir_path'] . $_SESSION['image_file'] . '">'); ?></dd>
				<dt>view_flg</dt>
				<dd><?php print($_SESSION['view_flg']); ?></dd>
			</dl>
			<p><a href="insert.php">戻る</a></p>
			<p><a href="list.php">一覧を見る</a></p>
		</div>
	</body>
</html>
