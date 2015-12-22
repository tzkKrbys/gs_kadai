<?php
session_start();
$id = $_GET['page'];
if(!isset($_SESSION['page']) || is_null($_SESSION['page'])){
	$page = 0;
}else{
	$page = $_SESSION['page'];
}


$pdo = new PDO('mysql:dbname=gs_db;host=localhost','root','hige0088');
$stmt = $pdo->query('SET NAMES utf8');
$stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE id = :id");
$stmt->bindValue(':id', $id);
$flag = $stmt->execute();
//var_dump($flag);
//var_dump($id);
$view = "";
if($flag = FALSE){
	$view = "SQLエラー";
}else{
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$id = $result['id'];
		$indate = $result['indate'];
		$name = $result['name'];
		$email = $result['email'];
		$age = $result['age'];
		$gender = $result['gender'];
		$naiyou = $result['naiyou'];
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
		<script src="./js/jquery-2.1.3.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<h2>登録データ更新画面</h2>
			<p>日時：<?= $indate ?></p>
			<form method="post" action="update_execute.php" enctype="multipart/form-data" class="form-horizontal">
				
				<div class="form-group">
					<label for="name" class="col-sm-3 control-label">name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="name" id="name" placeholder="name" value="<?= $name ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">email</label>
					<div class="col-sm-9">
						<input type="email" class="form-control" name="email" id="email" placeholder="email" value="<?= $email ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="age" class="col-sm-3 control-label">age</label>
					<div class="col-sm-9">
						<select name="age" class="form-control">
							<?php
	for($i = 18; $i <= 60; $i++){
	print('<option value="'.$i.'"');
	if($i === (int)$age){print('selected');}
	print('>'.$i.'</option>');
}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="gender" class="col-sm-3 control-label">gender</label>
					<div class="col-sm-9">
						<?php
$gens = array('男性','女性','その他');
foreach($gens as $gen){
	print('<label>');
	print('<input type="radio" name="gender" value="'.$gen.'"');
	if($gen === $gender){ print('checked'); }
	print('>');
	print( $gen.'　</label>');

}
						?>
					</div>
				</div>


				<div class="form-group">
					<label for="naiyou" class="col-sm-3 control-label">naiyou</label>
					<div class="col-sm-9">
						<textarea name="naiyou" cols="50" rows="5"><?= $naiyou ?></textarea>
					</div>
				</div>

				<button type="submit" class="btn btn-primary btn-block">更新する</button>
				<input type="hidden" name="post_flg" value="1"><!--postして表示されたのか、ただ表示されたのかを見極めている-->
				<input type="hidden" name="id" value="<?= $id ?>">
			</form>
			<form action="delete.php" method="post">
				<input type="submit" id="deleteBtn" class="btn btn-danger btn-block" value="削除する"></button>
				<input type="hidden" name="post_flg" value="1">
				<input type="hidden" name="id" value="<?= $id ?>">
			</form>
			<p><a href="select.php?page=<?php print($page) ?>">一覧に戻る</a></p>
		</div>
	</body>
</html>
