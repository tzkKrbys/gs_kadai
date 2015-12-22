<?php
session_start();

require_once './h.php';



if(!isset($_POST["post_flg"])){//もしもpost_flugがなければ　postして表示されたのか、ただ表示されたのかを見極めている
	echo "パラメータが無いので削除処理は無し";
}else{
	$id = $_POST['id'];


	//1. 接続します
	$pdo = new PDO('mysql:dbname=gs_db;host=localhost', 'root', 'hige0088');
	//PDO（PHP Data Object）とは、PHP標準（5.1.0以降）のデータベース接続クラスのことです。
	//PDO::__construct — データベースへの接続を表す PDO インスタンスを生成する。PHP とデータベースサーバーの間の接続を表します。
	//hostはMySQLサーバーのドメイン名、IP,パスワード　
	//public PDO::__construct ( string $dsn [, string $username [, string $password [, array $options ]]] )　
	//DSNとは、ODBCなどのデータベース接続機構において、プログラムからデータベースを操作する際に対象となるデータベースを指定するための識別名。

	//2. DB文字コードを指定
	$stmt = $pdo->query('SET NAMES utf8');
	//「->」ですが、オブジェクト（クラス）のメソッドやフィールド変数を参照するための演算子です。
	//-> って何？
	//アロー演算子 と呼ばれます。インスタンスのプロパティを参照する演算子です。
	//PDO::query — SQL ステートメントを実行し、結果セットを PDOStatement オブジェクトとして返す

	//３．データ登録SQL作成
	$stmt = $pdo->prepare("DELETE FROM gs_an_table WHERE id = :id");
	//PDO::prepare 文を実行する準備を行い、文オブジェクトを返す
	//PDOStatement::execute() メソッドによって実行される SQL ステートメントを準備します。
	//prepareの中にSQL文を書いていく　コロンは下記を渡される
	//PDOStatement::bindValue 値をパラメータにバインドする
	$stmt->bindValue(':id', $id);//コロン　ここに入る値を代入してくれる　SQLに埋め込む
	$status = $stmt->execute();//sqlを実行してる
	//プリペアドステートメントを実行する
	//より成熟したデータベースの多くは、プリペアドステートメントという 概念をサポートしています。プリペアドステートメントとはいったい何の ことでしょう? これは、実行したい SQL をコンパイルした 一種のテンプレートのようなものです。パラメータ変数を使用することで SQL をカスタマイズすることが可能です。プリペアドステートメントには 2 つの大きな利点があります。
	if($status==false){//エラーが出る場合　falseが返ってくる
		echo "SQLエラー";
		$err = "SQLエラー";//例えば変数に代入しといてHTMLに表示させる
		exit;//止まる　breakみたいなかんじ
	}else{
		header("Location: delete_complete.php");
		//echo '<div  class="container"><h2>登録完了！</h2></div>';
	}
}


