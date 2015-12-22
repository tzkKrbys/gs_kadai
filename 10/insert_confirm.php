<?php
session_start();

require_once './h.php';



if(!isset($_POST["post_flg"])){//もしもpost_flugがなければ　postして表示されたのか、ただ表示されたのかを見極めている
echo "パラメータが無いので登録処理は無し";
}else{
	//if(isset($_POST['id'])===TRUE){ $_SESSION['id'] = $_POST['id']; }
	if(isset($_POST['news_title'])===TRUE){
		$_SESSION['news_title'] = $_POST['news_title'];
	}
	if(isset($_POST['news_detail'])===TRUE){
		$_SESSION['news_detail'] = $_POST['news_detail'];
	}
	if(isset($_POST['view_flg'])===TRUE){
		$_SESSION['view_flg'] = $_POST['view_flg'];
	}


	//$id = $_POST['id'];
	$news_title = $_POST['news_title'];
	$news_detail = $_POST['news_detail'];
	$view_flg = $_POST['view_flg'];


}








/*session_start();*/
$img = "";

//FileUpload処理
if (!isset($_FILES['upfile']['error']) || !is_int($_FILES['upfile']['error']) || !isset($_POST["file_upload_flg"]) || $_POST["file_upload_flg"]!="1") {
	// echo 'パラメータが不正です';
}else{
	$file_name = $_FILES["upfile"]["name"];  //"1.jpg"ファイル名取得
	$extension = pathinfo($file_name, PATHINFO_EXTENSION); //拡張子取得
	$tmp_path  = $_FILES["upfile"]["tmp_name"]; //"/usr/www/tmp/1.jpg"アップロード先のTempフォルダ
	$file_dir_path = "./upload/";  //アップロードフォルダへのPath
	$uniq_name = date("YmdHis").md5(uniqid(microtime(),1)).session_id() . "." . $extension; //ユニークファイル名作成

	// FileUpload [--Start--]
	if ( is_uploaded_file( $tmp_path ) ) {
		if ( move_uploaded_file( $tmp_path, $file_dir_path . $uniq_name ) ) {
			chmod( $file_dir_path . $uniq_name, 0644 );
			//echo $uniq_name . "をアップロードしました。";
			$img = '<img src="'. $file_dir_path . $uniq_name . '" >';
			$_SESSION['image_file'] = $uniq_name;
			$_SESSION['file_dir_path'] = $file_dir_path;
		} else {
			$res = "Error:アップロードできませんでした。";
			echo($res);
		}
	}
	// FileUpload [--End--]
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
	<!--<dt>id</dt>
	<dd><?php print($id); ?></dd>-->
	<dt>news_title</dt>
	<dd><?php print($news_title); ?></dd>
	<dt>news_title</dt>
	<dd><?php print($news_detail); ?></dd>
	<dt>image_file</dt>
	<dd><?php print($img); ?></dd>
	<dt>view_flg</dt>
	<dd><?php print($view_flg); ?></dd>
</dl>
<form action="insert_excute.php" method="post">
<input type="submit" value="投稿する">
<input type="button" value="訂正する" onclick="history.back()">
<input type="hidden" name="post_flg" value="1"><!--postして表示されたのか、ただ表示されたのかを見極めている-->
</form>
</div>
</body>
</html>



