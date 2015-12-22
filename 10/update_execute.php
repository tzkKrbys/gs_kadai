<?php
session_start();

require_once './h.php';

if(!isset($_POST['post_flg'])){//もしもpost_flugがなければ　postして表示されたのか、ただ表示されたのかを見極めている
	echo "パラメータが無いので削除処理は無し";
}else{
	$id = $_POST['id'];
	$news_title = $_POST['news_title'];
	$news_detail = $_POST['news_detail'];
	$view_flg = $_POST['view_flg'];
	$indate = $_POST['indate'];

	$_SESSION['id'] = $_POST['id'];
	$_SESSION['news_title'] = $_POST['news_title'];
	$_SESSION['news_detail'] = $_POST['news_detail'];
	$_SESSION['view_flg'] = $_POST['view_flg'];
	$_SESSION['indate'] = $_POST['indate'];

	//1. 接続します
	$pdo = new PDO('mysql:dbname=demo_cms;host=localhost', 'root', '');
	$stmt = $pdo->query('SET NAMES utf8');
	$stmt = $pdo->prepare('UPDATE cms_table SET news_title= :news_title, news_detail= :news_detail, view_flg= :view_flg, indate= :indate WHERE id= :id');
	$stmt->bindValue(':id', $id);
	$stmt->bindValue(':news_title', $news_title);
	$stmt->bindValue(':news_detail', $news_detail);
	$stmt->bindValue(':view_flg', $view_flg);
	$stmt->bindValue(':indate', $indate);
	$status = $stmt->execute();//sqlを実行してる

	if($status==false){//エラーが出る場合　falseが返ってくる
		echo "SQLエラー";
		$err = "SQLエラー";//例えば変数に代入しといてHTMLに表示させる
		exit;//止まる　breakみたいなかんじ
	}else{
		header("Location: update_complete.php");
		//echo '<div  class="container"><h2>登録完了！</h2></div>';
	}
}


