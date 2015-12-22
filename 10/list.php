<?php
session_start();
if(!isset($_POST['page'])){
	$page = 0;
}
if(isset($_GET['page'])){
	$page = $_GET['page'];
}
if($page == ''){
	$page = 0;
}
$page = max($page, 0);//$_GETで受け取ったページ数が0より大きい場合に$pageにページ数を格納

if(isset($_POST['keyword'])){
	$keyword = '%'.$_POST['keyword'].'%';
	$_SESSION['keyword'] = $_POST['keyword'];
}elseif(isset($_SESSION['keyword']) && $_SESSION['keyword'] !== ''){
	$keyword = '%'.$_SESSION['keyword'].'%';
}else{
	$keyword = "";
}
$pdo = new PDO('mysql:dbname=demo_cms;host=localhost','root','');
$stmt = $pdo->query('SET NAMES utf8');

$countNum = "";

$limit = 5;

if(!$keyword){
	$stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM cms_table");
}else{
	$stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM cms_table WHERE concat_ws(char(0),indate,news_title,news_detail) LIKE :keyword");
	$stmt->bindValue(':keyword', $keyword, PDO::PARAM_INT);
}
$flagN = $stmt->execute();
if(!$flagN){
	$view2 = "SQLエラー2";
}else{
	$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
	$countNum .= $result2['cnt'];
}
$maxPage = floor($countNum / $limit);//データ件数を１ページ表示件数で割って最大ページ数を算出
$page = min($page, $maxPage);//min — 最小値を返す
$_SESSION['page'] = $page;//ページ数をセッションに格納


$start = $page * $limit;//ページ数＊１ページ表示件数

if($keyword){
	$stmt = $pdo->prepare('SELECT * FROM cms_table WHERE concat_ws(char(0),indate,news_title,news_detail,view_flg) LIKE :keyword ORDER BY id DESC LIMIT :start,:limit');//CONCAT_WS() は Concatenate With Separator ( セパレータと連結 ) を意味しており、CONCAT() の特殊な形態です。最初の引数が、残りの引数のセパレータになります。セパレータは、連結されるストリングの間に追加されます。セパレータは、あとの引数と同じく、ストリングである場合があります。セパレータが NULL の場合は、結果は NULL になります。
	$stmt->bindValue(':keyword', $keyword, PDO::PARAM_INT);
}else{
	$stmt = $pdo->prepare("SELECT * FROM cms_table ORDER BY id DESC LIMIT :start,:limit");
}
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

$flag = $stmt->execute();

$view = "";
if($flag =  false){
	$view = "SQLエラー";
}else{
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$view .= '
		<tr data-href="update.php?page='.$result['id'].'">
		<td>'.$result['indate'].'</td>
		<td>'.$result['news_title'].'</td>
		<td>'.$result['news_detail'].'</td>
		<td>'.$result['image_file'].'</td>
		<td>'.$result['view_flg'].'</td>
		<tr>';
	}
}

var_dump($page);
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>POSTデータ登録</title>
		<!-- Bootstrap -->
		<link href="./css/bootstrap.min.css" rel="stylesheet">
		<style>
			tbody tr {
				cursor:pointer;
			}

			tbody tr:hover {
				color:#dd0000;
				background:#ccc
			}
		</style>
		<script src="./js/jquery-2.1.3.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
		<script src="./jquery.min.js"></script>
		<script>
jQuery( function($) {
	$('tbody tr[data-href]').addClass('clickable').click( function() {
		console.log($(this).attr('data-href'));
		window.location = $(this).attr('data-href');
	}).find('a').hover( function() {
		$(this).parents('tr').unbind('click');
	}, function() {
		$(this).parents('tr').click( function() {
			window.location = $(this).attr('data-href');
		});
	});
});
		</script>
	</head>
	<body>
		<div class="container">
			<h2>投稿一覧画面</h2>
			<form class="navbar-form" action="list.php" method="post">
				<div class="form-group">
					<input type="text" name="keyword" class="form-control" placeholder="キーワード" value="<?= $keyword ?>">
				</div>
				<button type="submit" class="btn btn-info">検索</button>
			</form>
			<table class="table table-striped">
				<thead>
					<tr><td>日時</td><td>news_title</td><td>news_detail</td><td>image_file</td><td>view_flg</td></tr>
				</thead>
				<tbody>
					<?php
	print($view);
					?>
				</tbody>
			</table>
			<ul　class="paging">
				<?php
if($page > 0){
				?>
				<li><a href="list.php?page=<?php print($page - 1); ?>">前のページへ</a></li>
				<?php
}else{
				?>
				<li>前のページへ</li>
				<?php
}
if($page < $maxPage){
				?>
				<li><a href="list.php?page=<?php print($page + 1); ?>">次のページへ</a></li>
				<?php
}else{
				?>
				<li>次のページへ</li>
				<?php
}
				?>
			</ul>
			<form NAME="form" method="post" action="list.php">
				<a href="javascript:document.form.submit()">最初に戻る</a><!--リンクタグでpostを渡す方法-->
				<input type="hidden" name="keyword" value="">
			</form>
			<!--<p><a href="list.php?keyword=NULL">最初に戻る</a></p>-->
			<p><a href="insert.php">投稿する</a></p>
		</div>
	</body>
</html>
