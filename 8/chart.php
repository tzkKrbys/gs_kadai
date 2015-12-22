

<?php
require_once './h.php';


//1. 接続します
$pdo = new PDO('mysql:dbname=an;host=localhost', 'root', 'hige0088');

//2. DB文字コードを指定
$stmt = $pdo->query('SET NAMES utf8');

//３．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM an_table");

//４．SQL実行
$flag = $stmt->execute();

var_dump($stmt);
print('<br>');
var_dump($flag);

//データ表示
/*$view="";*/
/*$tableView="";*/
$reason = "";
$reason1 = 0;
$reason2 = 0;
$reason3 = 0;
$reason4 = 0;
$reason5 = 0;

if($flag==false){
	$view = "SQLエラー";
}else{
	while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
		//PDOStatement::fetch — 結果セットから次の行を取得する
		//PDOStatementオブジェクトに関連付けられた結果セットから1行取得します。 fetch_style パラメータは、PDO がその行をどの様に返すかを決定します。
		//PDO::FETCH_ASSOC: は、結果セットに 返された際のカラム名で添字を付けた配列を返します。
		switch ($result['reason']){
			case '背景がかわいい':
				$reason1++;
				break;
			case 'おにぎりがかわいい':
				$reason2++;
				break;
			case 'サランラップがかわいい':
				$reason3++;
				break;
			case '持ち方がかわいい':
				$reason4++;
				break;
			case '存在自体がかわいい':
				$reason5++;
				break;
		}
		
		$reason .= $result['reason'];
		
		$view .= '<div> ' . $result['id'] . "," .$result['name'] . ',' . $result['email'] . ',' . $result['age'] . ',' . $result['naiyou'] . ',' . $result['indate'] . '</div>';
		$tableView .= '<tr><td>'.$result['id'].'</td><td>'.$result['name'].'</td><td>'.$result['email'].'</td><td>'.$result['age'].'</td><td>'.$result['naiyou'].'</td><td>'.$result['indate'].'</td></tr>';
	}
}
print('<br>');
var_dump($reason);
print('<br>');
var_dump($reason1);
?>






<?php
/*$drawScript ='グラフデーターを書くまでの記述';
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
	if ($i != 0) {
		$drawScript .=", ['" . $row['item'] . "', " . $row['num'] . "]";
	} else {
		$drawScript .= "['項目', '数'], ['" . $row['item'] . "', " . $row['num'] . "]";
		// 一つ目の項目は 前に コンマ がいらないのと要素を入れる必要があるため
	}
	$i++;
}
print $drawScript . '後必要な記述';*/






?>




<?php
$drawScript ='グラフデーターを書くまでの記述';
$i = 0;
/*while ($row = mysql_fetch_assoc($result)) {
	if ($i != 0) {
		$drawScript .=", ['" . $row['item'] . "', " . $row['num'] . "]";
	} else {
		$drawScript .= "['項目', '数'], ['" . $row['item'] . "', " . $row['num'] . "]";
		// 一つ目の項目は 前に コンマ がいらないのと要素を入れる必要があるため
	}
	$i++;
}*/
print $drawScript . '後必要な記述';
?>




<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script><script type="text/javascript">// <![CDATA[
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['', ''],
			['背景がかわいい', <?= $reason1 ?>],
			['おにぎりがかわいい',<?= $reason2?>],
			['サランラップがかわいい',$reason3],
			['持ち方がかわいい',$reason4],
			['存在自体がかわいい',$reason5],
			['可愛くない',$reason6]
		]);

		var options = {
			title: 'かわいい理由について'
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		chart.draw(data, options);
	}
	// ]]></script></pre>
	<div id="piechart" style="width: 900px; height: 500px;"></div>
	<pre>
</body>
</html>
