<?php
session_start();
$id = $_GET['page'];
if(!isset($_SESSION['page']) || is_null($_SESSION['page'])){
$page = 0;
}else{
$page = $_SESSION['page'];
}


$pdo = new PDO('mysql:dbname=demo_cms;host=localhost','root','');
$stmt = $pdo->query('SET NAMES utf8');
$stmt = $pdo->prepare("SELECT * FROM cms_table WHERE id = :id");
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
		$news_title = $result['news_title'];
		$news_detail = $result['news_detail'];
		$image_file = $result['image_file'];
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
<script src="./js/jquery-2.1.3.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<h2>登録データ更新画面</h2>
	<p>日時：<?= $indate ?></p>
	<form method="post" action="update_execute.php" enctype="multipart/form-data" class="form-horizontal">

		<div class="form-group">
			<label for="indate" class="col-sm-3 control-label">indate</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="indate" id="indate" placeholder="indate" value="<?= $indate ?>">
			</div>
		</div>
		
		<div class="form-group">
			<label for="news_title" class="col-sm-3 control-label">news_title</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="news_title" id="news_title" placeholder="news_title" value="<?= $news_title ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="news_detail" class="col-sm-3 control-label">news_detail</label>
			<div class="col-sm-9">
				<textarea name="news_detail" cols="50" rows="5"><?= $news_detail ?></textarea>
			</div>
		</div>
		
		<!-- Main[Start] -->
		<input type="file" accept="image/*;capture=camera" id="image_file" value="<?= $image_file ?>" name="upfile">
			<input type="hidden" name="file_upload_flg" value="1">
			<div id="fileapi"><img id="image_view"></div>
			<div id="photarea"><img src="upload/<?=$image_file?>"></div>
		<!-- Main[End] -->
		
<!--		<div class="form-group">
			<label for="view_flg" class="col-sm-3 control-label">view_flg</label>
			<div class="col-sm-9">
			<select name="view_flg" class="form-control">
			<?php
	/*			for($i = 0; $i < 2; $i++){
					print('<option value="' . $i . '"');
					if($i === (int)$view_flg){
						print('selected');
					}
					print('>'.$i.'</option>');
				}*/
				?>
			</select>
			</div>
		</div>-->
		
		<div class="form-group">
			<label for="view_flg" class="col-sm-3 control-label">view_flg</label>
			<div class="col-sm-9">
			<?php
				for($i = 0; $i < 2; $i++){
					print('<input type="radio" name="view_flg" value="' . $i . '"');
					if($i === (int)$view_flg){
						print('checked');
					}
					if($i === 0){
						print('>非表示');
					}else{
						print('>表示');
					}
				}
				?>
			</select>
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
	<p><a href="list.php?page=<?php print($page) ?>">一覧に戻る</a></p>
</div>
</body>
</html>
