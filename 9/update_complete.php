<?php
session_start();

require_once './h.php';


var_dump($_SESSION['id']);
$pdo = new PDO('mysql:dbname=gs_db;host=localhost','root','hige0088');
$stmt = $pdo->query('SET NAMES utf8');
$stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE id=:id");
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
	$name = $result['name'];
	$email = $result['email'];
	$age = $result['age'];
	$gender = $result['gender'];
	$naiyou = $result['naiyou'];
	}
	}
var_dump($view);

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
				<dt>name</dt>
				<dd><?php print($name); ?></dd>
				<dt>email</dt>
				<dd><?php print($email); ?></dd>
				<dt>age</dt>
				<dd><?php print($age); ?></dd>
				<dt>gender</dt>
				<dd><?php print($gender); ?></dd>
				<dt>naiyou</dt>
				<dd><?php print($naiyou); ?></dd>
			</dl>
			<p><a href="index.php">戻る</a></p>
			<p><a href="select.php">一覧を見る</a></p>
		</div>
	</body>
</html>
