<?php
# 認証を要求したいページの先頭に以下を記述します。
require_once './login.php';
?>


<?php
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
$tableView="";
if($flag==false){
  $view = "SQLエラー";
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
	  //PDOStatement::fetch — 結果セットから次の行を取得する
	  //PDOStatementオブジェクトに関連付けられた結果セットから1行取得します。 fetch_style パラメータは、PDO がその行をどの様に返すかを決定します。
	  //PDO::FETCH_ASSOC: は、結果セットに 返された際のカラム名で添字を付けた配列を返します。
    /*$view .= '<div> ' . $result['id'] . "," .$result['name'] . ',' . $result['email'] . ',' . $result['age'] . ',' . $result['naiyou'] . ',' . $result['indate'] . '</div>';*/
	  $tableView .= '<tr><td>'.$result['id'].'</td><td>'.$result['name'].'</td><td>'.$result['email'].'</td><td>'.$result['age'].'</td><td>'.$result['naiyou'].'</td><td>'.$result['indate'].'</td></tr>';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
	div {
		padding: 10px;font-size:16px;
	}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid container">
    	<div class="navbar-header"><a class="navbar-brand" href="#">データ登録</a>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<!--<div>
    <div class="container jumbotron"><?= $view ?></div>
  </div>-->
</div>
<div class="container">
	<p>ようこそ<?= $_SESSION['username'] ?>さん。</p>
	<table class="table table-striped">
	<thead><tr><th>id</th><th>name</th><th>email</th><th>age</th><th>naiyou</th><th>indate</th></tr></thead>
	<?= $tableView ?>
</table>
	<p><a href="logout.php">ログアウトする</a></p>
	</div>
<!-- Main[End] -->

<!-- Javascript -->
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
