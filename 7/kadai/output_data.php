<?php
require_once 'Encode.php';
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];
$sex = $_POST['sex'];
$language = $_POST['language'];
$language2 = $_POST['language2'];
$serverSideLang = $_POST['serverSideLang'];
$career = $_POST['career'];

$array = array($name, $email, $age, $sex, $language, $language2, $serverSideLang, $career);
$file = fopen('./data/data.csv','a');//追加書込み⽤用のみでオープンします。ファイルがなければ作成􏰀。戻り値はファイルポインタリソース。ファイルポインタを$fileへ格納
flock($file,LOCK_EX);//排他的ロック(書き手)とするには LOCK_EX をセット
fputcsv($file,$array);//配列をcsvとして格納。第一引数はファイルポインタ、第二引数は配列を渡す
flock($file,LOCK_UN);//(共有または排他的)ロックを開放するには LOCK_UN をセット
fclose($file);
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
		<dd><?php print(e($name)); ?></dd>
		<dt>メールアドレス：</dt>
		<dd><?php print(e($email)); ?></dd>
		<dt>年齢：</dt>
		<dd><?php print(e($age)); ?></dd>
		<dt>性別：</dt>
		<dd><?php print(e($sex)); ?></dd>
		<dt>好きな言語：</dt>
		<dd><?php print(e($language)); ?></dd>
		<dt>かっこいいと思う言語：</dt>
		<dd><?php print(e($language2)); ?></dd>
		<dt>気になるサーバーサイド言語：</dt>
		<dd><?php print(e($serverSideLang)); ?></dd>
		<dt>プログラミング経験：</dt>
		<dd><?php print(e($career)); ?></dd>
	</dl>
		<p><a href="result.php">結果を見る</a></p>
	</div>
</body>
</html>
