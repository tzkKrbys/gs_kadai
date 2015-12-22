<?php
session_start();

require_once './h.php';

if(!isset($_POST['post_flg'])){//もしもpost_flugがなければ　postして表示されたのか、ただ表示されたのかを見極めている
	echo "パラメータが無いので削除処理は無し";
}else{
	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$age = $_POST['age'];
	$gender = $_POST['gender'];
	$naiyou = $_POST['naiyou'];

	$_SESSION['id'] = $_POST['id'];
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['age'] = $_POST['age'];
	$_SESSION['gender'] = $_POST['gender'];
	$_SESSION['naiyou'] = $_POST['naiyou'];

	//1. 接続します
	$pdo = new PDO('mysql:dbname=gs_db;host=localhost', 'root', 'hige0088');
	$stmt = $pdo->query('SET NAMES utf8');
	$stmt = $pdo->prepare('UPDATE gs_an_table SET name= :name, email= :email, age= :age, gender= :gender, naiyou= :naiyou WHERE id= :id');
	$stmt->bindValue(':id', $id);
	$stmt->bindValue(':name', $name);
	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':age', $age);
	$stmt->bindValue(':gender', $gender);
	$stmt->bindValue(':naiyou', $naiyou);
	var_dump($stmt);
	$status = $stmt->execute();//sqlを実行してる
	var_dump($status);
	
	if($status==false){//エラーが出る場合　falseが返ってくる
		echo "SQLエラー";
		$err = "SQLエラー";//例えば変数に代入しといてHTMLに表示させる
		exit;//止まる　breakみたいなかんじ
	}else{
		header("Location: update_complete.php");
		//echo '<div  class="container"><h2>登録完了！</h2></div>';
	}
}


