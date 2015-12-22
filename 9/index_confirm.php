<?php
session_start();

require_once './h.php';



if(!isset($_POST["post_flg"])){//もしもpost_flugがなければ　postして表示されたのか、ただ表示されたのかを見極めている
	echo "パラメータが無いので登録処理は無し";
}else{
	if(isset($_POST['name'])===TRUE){ $_SESSION['name'] = $_POST['name']; }
	if(isset($_POST['email'])===TRUE){ $_SESSION['email'] = $_POST['email']; }
	if(isset($_POST['age'])===TRUE){ $_SESSION['age'] = $_POST['age']; }
	if(isset($_POST['gender'])===TRUE){ $_SESSION['gender'] = $_POST['gender']; }
	if(isset($_POST['naiyou'])===TRUE){ $_SESSION['naiyou'] = $_POST['naiyou']; }


	$name = $_POST['name'];
	$email = $_POST['email'];
	$age = $_POST['age'];
	$gender = $_POST['gender'];
	$naiyou = $_POST['naiyou'];


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
			<h2>下記内容で投稿しますか？</h2>
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
			<form action="index_insert.php" method="post">
				<input type="submit" value="投稿する">
				<input type="button" value="訂正する" onclick="history.back()">
				<input type="hidden" name="post_flg" value="1"><!--postして表示されたのか、ただ表示されたのかを見極めている-->
			</form>
		</div>
	</body>
</html>



