<?php
session_start();
$page = $_SESSION['page'];

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
<script src="./js/jquery-2.1.3.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
<h2>削除完了確認画面</h2>
<p>書き込みを削除しました。</p>
<p><a href="list.php?page=<?php print($page) ?>">一覧に戻る</a>
</p>
</div>
</body>

</html>