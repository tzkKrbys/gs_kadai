


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>POSTデータ登録</title>

		<!-- Bootstrap -->
		<link href="./css/bootstrap.min.css" rel="stylesheet">
		<script src="js/jquery-2.1.3.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
		<style>
			div {
				padding: 10px;font-size:16px;
			}
			img {
				width: 100%;
			}
		</style>
	</head>
	<body>

		<!-- Head[Start] -->
<!--		<header>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header"><a class="navbar-brand" href="#">画像一覧</a>
					</div>
				</div>
			</nav>
		</header>-->
		<!-- Head[End] -->
		<!-- Main[Start] -->
<!--		<div class="jumbotron">
			<p id="status">・・・受信中・・・</p>
			<form method="post" action="insert.php" enctype="multipart/form-data" id="send_file">
				<input type="text" name="name" id="name">
				<input type="email" name="email" id="email">
				<input type="text" name="age" id="age">
				<textarea rows="7" cols="50"></textarea>
				<input type="text" name="age" id="age">
				<input type="file" accept="image/*" capture="camera" name="upfile">
				<input type="text" name="lat" id="lat">
				<input type="text" name="lon" id="lon">
				<input type="hidden" name="post_flg" value="1">
				<input type="submit" value="送信">
			</form>
		</div>-->
		<!-- Main[End] -->
		
	<div class="container">
		<div class="col-sm-4">
			<img src="./images/photo3.jpg" alt="#">
		</div>
		<div class="col-sm-8">
			<h2>左の写真のどこがかわいいですか？</h2>
			<form method="post" action="result.php" enctype="multipart/form-data" id="send_file" class="form-horizontal "><!--自分自身にデータを送信している-->
				<div class="form-group">
					<label for="reason" class="col-sm-3 control-label">どこがかわいい？</label>
					<div class="col-sm-9">
						<select class="form-control input-lg" name="reason">
							<option value="背景がかわいい">背景がかわいい</option>
							<option value="おにぎりがかわいい">おにぎりがかわいい</option>
							<option value="サランラップがかわいい">サランラップがかわいい</option>
							<option value="持ち方がかわいい">持ち方がかわいい</option>
							<option value="存在自体がかわいい">存在自体がかわいい</option>
							<option value="全然かわいくない">全然かわいくない</option>
						</select>
						<!--
<input type="password" class="form-control" name="password" id="password" placeholder="Password">
-->
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-3 control-label">name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="name" id="name" placeholder="name">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Email address</label>
					<div class="col-sm-9">
						<input type="email" class="form-control" name="email" id="email" placeholder="email">
					</div>
				</div>
				
				<div class="form-group">
					<label for="age" class="col-sm-3 control-label">age</label>
					<div class="col-sm-9">
						<select name="age" class="form-control">
							<?php
for($i = 18; $i <= 60; $i++){
print('<option value="'.$i.'">'.$i.'</option>');
}
							?>
						</select>
					</div>
				</div>
				<!--<div class="form-group">
					<label for="naiyou" class="col-sm-2 control-label">naiyou</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="4" name="naiyou" id="naiyou" class="naiyou" placeholder="naiyou"></textarea>
					</div>
				</div>-->
				<!--				<div class="form-group">
<label for="exampleInputFile">File input</label>
<input type="file" id="exampleInputFile">
<p class="help-block">Example block-level help text here.</p>
</div>-->
				<!--<div class="checkbox">
<label>
<input type="checkbox"> Check me out
</label>
</div>-->
				<button type="submit" class="btn btn-primary btn-block">Submit</button>
				<input type="hidden" name="post_flg" value="1"><!--postして表示されたのか、ただ表示されたのかを見極めている-->
			</form>
		</div><!-- end.col-sm-8 -->
	</div>


		<!-- Javascript -->
		
		<script>
			/**
* Geolocation（緯度・経度）
*/
			navigator.geolocation.getCurrentPosition( //getCurrentPosition :or: watchPosition
				// 位置情報の取得に成功した時の処理
				function (position) {
					try {
						var lat = position.coords.latitude;  //緯度
						var lon = position.coords.longitude; //経度
						$("#lat").val(lat);
						$("#lon").val(lon);
						$("#status").html("受信完了！");
					} catch (error) {
						console.log("getGeolocation: " + error);
					}
				},
				// 位置情報の取得に失敗した場合の処理
				function (error) {
					var e = "";
					if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
						e = "位置情報が許可されてません";
					}
					if (error.code == 2) { //2＝現在地を特定できない
						e = "現在位置を特定できません";
					}
					if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
						e = "位置情報を取得する前にタイムアウトになりました";
					}
					$("#status").html("エラー：" + e);

				}, {
					// 位置情報取得オプション
					enableHighAccuracy: true, //より高精度な位置を求める
					maximumAge: 20000,        //最後の現在地情報取得が20秒以内であればその情報を再利用する設定、0はキャッシュなし
					timeout: 10000            //10秒以内に現在地情報を取得できなければ、処理を終了
				}
			);
		</script>
	</body>
</html>
