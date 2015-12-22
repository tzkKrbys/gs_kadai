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
</head>
<body>
	<div  class="container">
	<h2>アンケート結果</h2>
	<table class="table table-striped  table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th>ID</th>
				<th><i class="glyphicon glyphicon-pencil"></i>名前</th>
				<th><i class="glyphicon glyphicon-envelope"></i>メールアドレス</th>
				<th><i class="glyphicon glyphicon-gift"></i>年齢</th>
				<th><i class="glyphicon glyphicon-user"></i>性別</th>
				<th>好きな言語</th>
				<th>かっこいいと思う言語</th>
				<th>気になるサーバーサイド言語</th>
				<th>プログラミング経験</th>
			</tr>
		</thead>
		<!--	<tr><th>ID</th><th>名前</th><th>メールアドレス</th><th>年齢</th><th>性別</th><th>好きな言語</th><th>かっこいいと思う言語</th><th>気になるサーバーサイド言語</th><th>プログラミング経験</th></tr>-->
		<?php
$fp = @fopen('./data/data.csv', 'r');//@はエラー制御演算子。@をつけておけばエラーが出ない。
flock($fp,LOCK_SH);//共有ロック(読み手)とするにはLOCK_SH
$id = 0;
while($array = fgetcsv($fp)){// fgetcsv()は行をCSVフォーマットのフィールドとして読込み処理を行い、読み込んだフィールドを含む配列を返す
	$num = count($array);//countー変数に含まれるすべての要素、あるいはオブジェクトに含まれる何かの数を数える、第一引数が配列、第二引数がなければ、配列内の数を数える
	$id++;
	echo '<tr><td>' . $id . "</td>";//通し番号
	for($i = 0; $i < $num; $i++){
		echo "<td>". $array[$i] . "</td>";
	}
	echo "</tr>";
}
flock($fp, LOCK_UN);//(共有または排他的)ロックを開放するには LOCK_UN をセット
fclose($fp);//オープンされたファイルポインタをクローズする
		?>

	</table>
		<p><a href="nextQuestionnaire.php">次のアンケートへ進む</a></p>
	</div>
</body>
</html>