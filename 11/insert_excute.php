<?php
session_start();

require_once './h.php';

if(!isset($_POST['post_flg'])){//もしもpost_flugがなければ　postして表示されたのか、ただ表示されたのかを見極めている
echo "パラメータが無いので削除処理は無し";
}else{
	$news_title = $_SESSION['news_title'];
	$news_detail = $_SESSION['news_detail'];
	$view_flg = $_SESSION['view_flg'];
	$image_file = $_SESSION['image_file'];
	$file_dir_path = $_SESSION['file_dir_path'];

//1. 接続します
$pdo = new PDO('mysql:dbname=demo_cms;host=localhost', 'root', '');
$stmt = $pdo->query('SET NAMES utf8');
	/*$stmt = $pdo->prepare('UPDATE cms_table SET news_title= :news_title, news_detail= :news_detail, viwe_flg= :viwe_flg WHERE id= :id');*/
	$stmt = $pdo->prepare("INSERT INTO cms_table (id, news_title, news_detail, image_file, view_flg, indate )VALUES(NULL, :news_title, :news_detail, :image_file, :view_flg, sysdate())");
	//$stmt->bindValue(':id', $id);
	$stmt->bindValue(':news_title', $news_title);
	$stmt->bindValue(':news_detail', $news_detail);
	$stmt->bindValue(':image_file', $image_file);
	$stmt->bindValue(':view_flg', $view_flg);

//var_dump($stmt);
$status = $stmt->execute();//sqlを実行してる
//var_dump($status);

if($status==false){//エラーが出る場合　falseが返ってくる
echo "SQLエラー";
$err = "SQLエラー";//例えば変数に代入しといてHTMLに表示させる
exit;//止まる　breakみたいなかんじ
}else{
header("Location: insert_complete.php");
//echo '<div  class="container"><h2>登録完了！</h2></div>';
}
}


