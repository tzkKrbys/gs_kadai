<?php
session_start();
$page = $_GET['page'];
if($page == ''){
	$page = 0;
}
$page = max($page, 0);

if(isset($_POST['keyword'])){
	$keyword = '%'.$_POST['keyword'].'%';
	$_SESSION['keyword'] = $_POST['keyword'];
}elseif(isset($_SESSION['keyword']) && $_SESSION['keyword'] !== ''){
	$keyword = '%'.$_SESSION['keyword'].'%';
}

$pdo = new PDO('mysql:dbname=gs_db;host=localhost','root','hige0088');
$stmt = $pdo->query('SET NAMES utf8');

$limit = 5;
if(!$keyword){
	$stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM gs_an_table");
}else{
	$stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM gs_an_table WHERE concat_ws(char(0),indate,name,email,age,gender,naiyou) LIKE :keyword");
	$stmt->bindValue(':keyword', $keyword, PDO::PARAM_INT);
}
$flagN = $stmt->execute();
if(!$flagN){
	$view2 = "SQLエラー2";
}else{
	while($result2 = $stmt->fetch(PDO::FETCH_ASSOC)){
		$countNum .= $result2['cnt'];
	}
}
$maxPage = floor($countNum / $limit);
$page = min($page, $maxPage);
$_SESSION['page'] = $page;


$start = $page * $limit;

if($keyword){
	$stmt = $pdo->prepare('SELECT * FROM gs_an_table WHERE concat_ws(char(0),indate,name,email,age,gender,naiyou) LIKE :keyword ORDER BY id DESC LIMIT :start,:limit');//CONCAT_WS() は Concatenate With Separator ( セパレータと連結 ) を意味しており、CONCAT() の特殊な形態です。最初の引数が、残りの引数のセパレータになります。セパレータは、連結されるストリングの間に追加されます。セパレータは、あとの引数と同じく、ストリングである場合があります。セパレータが NULL の場合は、結果は NULL になります。
	
	$stmt->bindValue(':keyword', $keyword, PDO::PARAM_INT);
}else{
	$stmt = $pdo->prepare("SELECT * FROM gs_an_table ORDER BY id DESC LIMIT :start,:limit");
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
		<td>'.$result['name'].'</td>
		<td>'.$result['email'].'</td>
		<td>'.$result['age'].'</td>
		<td>'.$result['gender'].'</td>
		<td>'.$result['naiyou'].'</td>
		<tr>';
	}
}

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
			<form class="navbar-form" action="select.php" method="post">
				<div class="form-group">
					<input type="text" name="keyword" class="form-control" placeholder="キーワード" value="<?= $_SESSION['keyword'] ?>">
				</div>
				<button type="submit" class="btn btn-info">検索</button>
			</form>
			<table class="table table-striped">
				<thead>
					<tr><td>日付</td><td>名前</td><td>メールアドレス</td><td>年齢</td><td>性別</td><td>内容</td></tr>
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
			<li><a href="select.php?page=<?php print($page - 1); ?>">前のページへ</a></li>
<?php
}else{
	?>
	<li>前のページへ</li>
	<?php
}
	if($page < $maxPage){
		?>
			<li><a href="select.php?page=<?php print($page + 1); ?>">次のページへ</a></li>
			<?php
	}else{
		?>
		<li>次のページへ</li>
			<?php
	}
?>
		</ul>
		<p><a href="select.php">最初に戻る</a></p>
		<p><a href="index.php">投稿する</a></p>
		</div>
	</body>
</html>
