

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


//データ表示
/*$view="";*/
/*$tableView="";*/
$reason = array(
	'背景がかわいい' => 0,
	'おにぎりがかわいい' => 0,
	'サランラップがかわいい' => 0,
	'持ち方がかわいい' => 0,
	'存在自体がかわいい' => 0,
	'全然かわいくない' => 0
);


if($flag==false){
	$view = "SQLエラー";
}else{
	while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
		//PDOStatement::fetch — 結果セットから次の行を取得する
		//PDOStatementオブジェクトに関連付けられた結果セットから1行取得します。 fetch_style パラメータは、PDO がその行をどの様に返すかを決定します。
		//PDO::FETCH_ASSOC: は、結果セットに 返された際のカラム名で添字を付けた配列を返します。

		
		switch ($result["reason"]){
			case '背景がかわいい':
				$reason['背景がかわいい']++;
				break;
			case 'おにぎりがかわいい':
			$reason['おにぎりがかわいい']++;
				break;
			case 'サランラップがかわいい':
			$reason['サランラップがかわいい']++;
				break;
			case '持ち方がかわいい':
			$reason['持ち方がかわいい']++;
				break;
			case '存在自体がかわいい':
			$reason['存在自体がかわいい']++;
				break;
			case '全然かわいくない':
			$reason['全然かわいくない']++;
				break;
		}
	}
}

?>
 

 <?php
# 別ファイルのユーザー定義関数「makeChartParts()」を読み込みます。
require_once './make_chart_parts.php';

// グラフ1の値
$data = array();
$data[] = array('', 'かわいさの理由');
$data[] = array('背景がかわいい', $reason['背景がかわいい']);
$data[] = array('おにぎりがかわいい', $reason['おにぎりがかわいい']);
$data[] = array('サランラップがかわいい', $reason['サランラップがかわいい']);
$data[] = array('持ち方がかわいい', $reason['持ち方がかわいい']);
$data[] = array('存在自体がかわいい', $reason['存在自体がかわいい']);
$data[] = array('全然かわいくない', $reason['全然かわいくない']);

// グラフ1のオプション
$options = array(
	'title'  => 'かわいさの理由',  // グラフタイトル
  'titleTextStyle' => array('fontSize' => 22),  // タイトルのスタイル
  'width'  => 900,  // 幅
  'height' => 500,  // 高さ
	'legend' => array('position' => 'right', 'alignment' => 'center'));  // 凡例

// グラフ種類（円グラフ）
$type = 'PieChart';

// 「グラフ1」グラフ描画のJavaScriptの関数、表示させる<div>タグの生成
list($chart1, $div1) = makeChartParts($data, $options, $type);

// グラフ2の値
/*$data = array();
$data[] = array('', '2010年');
$data[] = array('15歳未満', 14.5);
$data[] = array('15～64歳', 65.2);
$data[] = array('65歳以上', 20.3);*/

// グラフ2のオプション（グラフ1のオプションのタイトルのみを変更）
//$options['title'] = '2010年';

// 「グラフ2」グラフ描画のJavaScriptの関数、表示させる<div>タグの生成
//list($chart2, $div2) = makeChartParts($data, $options, $type);
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
<title>円グラフを生成したい</title>
<script src="https://www.google.com/jsapi"></script>
<script>
<?php
# グラフ描画関数を表示します。
echo $chart1, $chart2;
?>
</script>
<link href="../../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
	<h2>一体どの辺がかわいいのか？</h2>
	<?php
	# グラフを表示させる<div>タグを適切な場所に配置します。
	echo $div1, $div2;
	?>
	<p><a href="insert.php">最初に戻る</a></p>
</div>
</body>
</html>
