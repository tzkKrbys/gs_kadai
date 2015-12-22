<?php
session_start();

require_once './h.php';


var_dump($_SESSION['id']);
$pdo = new PDO('mysql:dbname=demo_cms;host=localhost','root','');
$stmt = $pdo->query('SET NAMES utf8');
$stmt = $pdo->prepare("SELECT * FROM cms_table WHERE id=:id");
$stmt->bindValue(':id', $_SESSION['id']);
$flag = $stmt->execute();

$view = "";
if($flag =  false){
	$view = "SQLエラー";
}else{
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		/*$view .= '
<tr>
	<td>'.$result['indate'].'</td>
	<td>'.$result['name'].'</td>
	<td>'.$result['email'].'</td>
	<td>'.$result['age'].'</td>
	<td>'.$result['gender'].'</td>
	<td>'.$result['naiyou'].'</td>
<tr>';*/
		$indate = $result['indate'];
		$news_title = $result['news_title'];
		$news_detail = $result['news_detail'];
		$view_flg = $result['view_flg'];
	}
}
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
			<h2>下記内容で更新しました。</h2>
			<dl>
				<dt>news_title</dt>
				<dd><?php print($news_title); ?></dd>
				<dt>news_detail</dt>
				<dd><?php print($news_detail); ?></dd>
				<dt>view_flg</dt>
				<dd><?php print($view_flg); ?></dd>
				<dt>indate</dt>
				<dd><?php print($indate); ?></dd>
			</dl>
			<p><a href="index.php">戻る</a></p>
			<p><a href="list.php">一覧を見る</a></p>
		</div>
	</body>
</html>
