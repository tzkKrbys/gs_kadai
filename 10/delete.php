<?php
session_start();

require_once './h.php';



if(!isset($_POST["post_flg"])){//もしもpost_flgがなければ　postして表示されたのか、ただ表示されたのかを見極めている
echo "パラメータが無いので削除処理は無し";
}else{
	$id = $_POST['id'];
	$pdo = new PDO('mysql:dbname=demo_cms;host=localhost', 'root', '');//1. 接続します
	$stmt = $pdo->query('SET NAMES utf8');//2. DB文字コードを指定
	$stmt = $pdo->prepare("DELETE FROM cms_table WHERE id = :id");//３．データ登録SQL作成
	$stmt->bindValue(':id', $id);//コロン　ここに入る値を代入してくれる　SQLに埋め込む
	$status = $stmt->execute();//sqlを実行してる
	if($status==false){//エラーが出る場合　falseが返ってくる
		echo "SQLエラー";
		$err = "SQLエラー";//例えば変数に代入しといてHTMLに表示させる
		exit;//止まる　breakみたいなかんじ
	}else{
		header("Location: delete_complete.php");
	}
}


