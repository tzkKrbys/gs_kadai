<?php
session_start();

require_once './h.php';



if(!isset($_POST["post_flg"])){//もしもpost_flugがなければ　postして表示されたのか、ただ表示されたのかを見極めている
	echo "パラメータが無いので登録処理は無し";
}else{
/*	if(isset($_POST['name'])===TRUE){ $_SESSION['name'] = $_POST['name']; }
	if(isset($_POST['email'])===TRUE){ $_SESSION['email'] = $_POST['email']; }
	if(isset($_POST['age'])===TRUE){ $_SESSION['age'] = $_POST['age']; }
	if(isset($_POST['gender'])===TRUE){ $_SESSION['gender'] = $_POST['gender']; }
	if(isset($_POST['naiyou'])===TRUE){ $_SESSION['naiyou'] = $_POST['naiyou']; }*/


	$name = $_SESSION['name'];
	$email = $_SESSION['email'];
	$age = $_SESSION['age'];
	$gender = $_SESSION['gender'];
	$naiyou = $_SESSION['naiyou'];


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
	$stmt = $pdo->prepare("INSERT INTO gs_an_table (id, name, email, age, gender, naiyou, indate )VALUES(NULL, :name, :email, :age, :gender, :naiyou, sysdate())");
	//PDO::prepare 文を実行する準備を行い、文オブジェクトを返す
	//PDOStatement::execute() メソッドによって実行される SQL ステートメントを準備します。
	//prepareの中にSQL文を書いていく　コロンは下記を渡される
	//PDOStatement::bindValue 値をパラメータにバインドする
	$stmt->bindValue(':name', $name);//コロン　ここに入る値を代入してくれる　SQLに埋め込む
	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':age', $age);
	$stmt->bindValue(':gender', $gender);
	$stmt->bindValue(':naiyou', $naiyou);
	$status = $stmt->execute();//sqlを実行してる
	//プリペアドステートメントを実行する
	//より成熟したデータベースの多くは、プリペアドステートメントという 概念をサポートしています。プリペアドステートメントとはいったい何の ことでしょう? これは、実行したい SQL をコンパイルした 一種のテンプレートのようなものです。パラメータ変数を使用することで SQL をカスタマイズすることが可能です。プリペアドステートメントには 2 つの大きな利点があります。
	if($status==false){//エラーが出る場合　falseが返ってくる
		echo "SQLエラー";
		$err = "SQLエラー";//例えば変数に代入しといてHTMLに表示させる
		exit;//止まる　breakみたいなかんじ
	}else{
		header("Location: index_complete.php");
		//echo '<div  class="container"><h2>登録完了！</h2></div>';
	}
}




?>


<?php
//メール送信機能
//mb_language('japanese');
//mb_internal_encoding('UTF-8');

//if(!empty($_POST['email'])){//もし$_POST['email']にデータが入っていれば
//$to = $_POST['email'];//宛先
//	$subject = /*$_POST['subject']*/'アンケートへの協力ありがとうございました。';//件名
//	//$body = '名前：'.print(h($name)).'メールアドレス：'.print(h($email)).'年齢：'.print(h($age)).'コメント：'.print(h($naiyou));//本文
//	$body = /*$_POST['message']*/'名前：'.$name.'メールアドレス：'.$email.'年齢：'.$age.'コメント：'.$naiyou;//本文
//	$from = mb_encode_mimeheader(mb_convert_encoding('つづき','JIS','UTF-8')).'<tzk@tzaugment.moo.jp>';//MIME ヘッダエンコーディング方式によって文字列 str をエンコードします。

//	$success = mb_send_mail($to,$subject,$body,'From:'.$from);//mb_send_mail ($to ,$subject ,$message ,$additional_headers = NULL ,$additional_parameter = NULL)
//}
?>
