
<?php
require_once './h.php';
?>

<?php
if(!isset($_POST["post_flg"])){//もしもpost_flugがなければ　postして表示されたのか、ただ表示されたのかを見極めている
	//echo "パラメータが無いので登録処理は無し";
}else{
	/*$lat = $_POST["lat"];
	$lon = $_POST["lon"];
	$img = $_FILES["upfile"]["name"];*/

	$name = $_POST["name"];
	$email = $_POST["email"];
	$age = $_POST["age"];
	$reason = $_POST["reason"];
	//※FILESはDEMOなので取得してません。

	//1. 接続します
	$pdo = new PDO('mysql:dbname=an;host=localhost', 'root', 'hige0088');
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
	$stmt = $pdo->prepare("INSERT INTO an_table (id, name, email, age, reason, indate )VALUES(NULL, :name, :email, :age, :reason, sysdate())");
	//PDO::prepare 文を実行する準備を行い、文オブジェクトを返す
	//PDOStatement::execute() メソッドによって実行される SQL ステートメントを準備します。
	//prepareの中にSQL文を書いていく　コロンは下記を渡される
	$stmt->bindValue(':name', $name);//コロン　ここに入る値を代入してくれる　SQLに埋め込む
	//PDOStatement::bindValue 値をパラメータにバインドする
	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':age', $age);
	$stmt->bindValue(':reason', $reason);
	$status = $stmt->execute();//sqlを実行してる
	//プリペアドステートメントを実行する
	//より成熟したデータベースの多くは、プリペアドステートメントという 概念をサポートしています。プリペアドステートメントとはいったい何の ことでしょう? これは、実行したい SQL をコンパイルした 一種のテンプレートのようなものです。パラメータ変数を使用することで SQL をカスタマイズすることが可能です。プリペアドステートメントには 2 つの大きな利点があります。
	if($status==false){//エラーが出る場合　falseが返ってくる
		echo "SQLエラー";
		$err = "SQLエラー";//例えば変数に代入しといてHTMLに表示させる
		exit;//止まる　breakみたいなかんじ
	}else{
		echo '<div  class="container"><h2>登録完了！</h2></div>';
	}
}
?>


<?php
mb_language('japanese');
mb_internal_encoding('UTF-8');

if(!empty($_POST['email'])){//もし$_POST['email']にデータが入っていれば
	$to = $_POST['email'];//宛先
	$subject = /*$_POST['subject']*/'アンケートへの協力ありがとうございました。';//件名
	//$body = '名前：'.print(h($name)).'メールアドレス：'.print(h($email)).'年齢：'.print(h($age)).'コメント：'.print(h($naiyou));//本文
	$body = /*$_POST['message']*/'名前：'.$name.'メールアドレス：'.$email.'年齢：'.$age.'コメント：'.$naiyou;//本文
	$from = mb_encode_mimeheader(mb_convert_encoding('つづき','JIS','UTF-8')).'<tzk@tzaugment.moo.jp>';//MIME ヘッダエンコーディング方式によって文字列 str をエンコードします。

	$success = mb_send_mail($to,$subject,$body,'From:'.$from);//mb_send_mail ($to ,$subject ,$message ,$additional_headers = NULL ,$additional_parameter = NULL)
}
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<title>アンケート結果</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>
		<div  class="container">
			<h2>ご回答ありがとうございました</h2>
			<p>以下の内容で送信いたしました。</p>
			<dl class="dl-horizontal">
				<dt>名前：</dt>
				<dd><?php print(h($name)); ?></dd>
				<dt>メールアドレス：</dt>
				<dd><?php print(h($email)); ?></dd>
				<dt>年齢：</dt>
				<dd><?php print(h($age)); ?></dd>
				<dt>どこがかわいい：</dt>
				<dd><?php print(h($reason)); ?></dd>
			</dl>
			<p><a href="pie_chart.php">投票結果を見る</a></p>
		</div>
	</body>
</html>