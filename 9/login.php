<?php
# h()関数を読み込み
require_once './h.php';
# password_verify()関数（パスワードをハッシュ化）を読み込み
require_once './password.php';

# クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

# セッションを開始
session_start();

# ユーザー名とパスワードを設定します。複数名分の設定ができます。
$userid[]   = 'admin';   // ユーザーID
$username[] = '管理者';  // お名前
// パスワード「pass1」をpassword_hash()関数でハッシュ化した文字列
$hash[] = '$2y$10$7llM8TDTW3cxrMPzwd1ydOky3FP7yYOzn/d4bEWWbeFDiQ.tTbM3O';

$userid[]   = 'test';
$username[] = 'テスト';
// パスワード「pass2」をpassword_hash()関数でハッシュ化した文字列
$hash[] = '$2y$10$qNxqM4UP79klxfqV9cIwcO6LBJI44Z34k76m9w9teN.PLpfTe8lxG';

# エラーメッセージの変数を初期化
$error = '';



# 認証済みかどうかのセッション変数を初期化します。
if (! isset($_SESSION['auth'])) {//isset — 変数がセットされていること、そして NULL でないことを検査する
	$_SESSION['auth'] = false;
}

if (isset($_POST['userid']) && isset($_POST['password'])) {
	foreach ($userid as $key => $value) {
		if ($_POST['userid'] === $userid[$key] && //受け取った$_POST['userid']と$userid内のどれか筆が一致すれば
			# 入力されたパスワード文字列とハッシュ化済みパスワードを照合します。
			password_verify($_POST['password'], $hash[$key])) { //password_verify — パスワードがハッシュにマッチするかどうかを調べる
			# セッション固定化攻撃☆レシピ301☆（セッション固定化攻撃を防ぎたい）を防ぐため、セッションIDを変更します。
			session_regenerate_id(true);//session_regenerate_id — 現在のセッションIDを新しく生成したものと置き換える
			$_SESSION['auth'] = true;
			$_SESSION['username'] = $username[$key];
			break;
		}
	}
	if ($_SESSION['auth'] === false) {
		$error = 'ユーザーIDかパスワードに誤りがあります。';
	}
}

if ($_SESSION['auth'] !== true) {
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>認証フォーム</title>
		<link rel="stylesheet" href="css/range.css">
		<link href="css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
	<div class="container">
		<div id="login">
			<h1>管理者ページ認証フォーム</h1>
			<?php
	if ($error) {  // エラー文がセットされていれば赤色で表示
		echo '<p style="color:red;">' . h($error) . '</p>';
	}
			?>
			<form action="select.php" method="post" class="form-horizontal"><!--$_SERVER['SCRIPT_NAME']現在のスクリプトのパス。 スクリプト自身のページを指定するのに有用です。-->

					<div class="form-group">
						<label for="userid" class="col-sm-2 control-label">userid</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="userid" id="userid" placeholder="userid">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">password</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" id="password" placeholder="password">
						</div>
					</div>
				<button type="submit" name="submit" class="btn btn-primary">ログイン</button>
			</form>
		</div>
		</div>
	</body>
</html>
<?php
	# スクリプトを終了し、認証が必要なページが表示されないようにします。
	exit();
}
/* ?>終了タグ省略 ☆レシピ001☆（サーバーのPHP情報を知りたい） */

