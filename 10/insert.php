<?php
session_start();
/*if(!isset($_SESSION["id"]) || is_null($_SESSION["id"])){
	$id = "";
}else{
	$id = $_SESSION["id"];
}*/
if(!isset($_SESSION["news_title"]) || is_null($_SESSION["news_title"])){
	$news_title = "";
}else{
	$news_title = $_SESSION["news_title"];
}
if(!isset($_SESSION["news_detail"]) || is_null($_SESSION["news_detail"])){
	$news_detail = "";
}else{
	$news_detail = $_SESSION["news_title"];
}
if(!isset($_SESSION["view_flg"]) || is_null($_SESSION["view_flg"])){
	$view_flg = "";
}else{
	$view_flg = $_SESSION["view_flg"];
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
			<h2>新規投稿画面</h2>
			<form method="post" action="insert_confirm.php" enctype="multipart/form-data" id="send_file" class="form-horizontal">
				<div class="form-group">
					<label for="news_title" class="col-sm-3 control-label">ニュースタイトル</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="news_title" id="news_title" placeholder="news title">
					</div>
				</div>
<!--

				<div class="form-group">
					<label for="gender" class="col-sm-3 control-label">gender</label>
					<div class="col-sm-9">
						<?php
/*$gens = array('男性','女性','その他');
foreach($gens as $gen){
	print('<label>');
	print('<input type="radio" name="gender" value="'.$gen.'"');
	if($gen === $gender){ print('checked'); }
	print('>');
	print( $gen.'　</label>');
}*/
						?>

					</div>
				</div>
-->

				<div class="form-group">
					<label for="news_detail" class="col-sm-3 control-label">記事本文</label>
					<div class="col-sm-9">
						<textarea name="news_detail" cols="50" rows="5"></textarea>
					</div>
				</div>
				
				<!--<div class="container-fluid">
					<div class="jumbotron">-->
						<!--<h1>PHP＆JS＆HTML５</h1>
						<p>最初にカメラ・写真の選択をおこない、サーバにアップロードします。PHP側で受け取りサーバに置く処理をおこないます。</p>
						<p><a href="#" id="select_btn" class="btn btn-primary btn-lg">カメラ/写真選択</a></p>
						<p><a href="#" id="upload_btn" class="btn btn-success btn-lg">Fileアップロード</a></p>-->
						<!--<form method="post" action="fileupload1.php" enctype="multipart/form-data" id="send_file">-->
							<input type="file" accept="image/*;capture=camera" id="image_file" value="" name="upfile">
							<input type="hidden" name="file_upload_flg" value="1">
						<!--</form>
					</div>
					<div id="fileapi"><img id="image_view"></div>
					<div id="photarea"></div>
				</div>-->

				<button type="submit" class="btn btn-primary btn-block">Submit</button>
				<input type="hidden" name="view_flg" value="1">
				<input type="hidden" name="post_flg" value="1"><!--postして表示されたのか、ただ表示されたのかを見極めている-->
			</form>
			<p><a href="list.php">一覧を見る</a></p>
		</div>


		<!-- Javascript -->
		<script>
		</script>
	</body>
</html>t