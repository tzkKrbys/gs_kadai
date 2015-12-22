<?php
session_start();
if(!isset($_SESSION["name"]) || is_null($_SESSION["name"])){
	$name = "";
}else{
	$name = $_SESSION["name"];
}
if(!isset($_SESSION["email"]) || is_null($_SESSION["email"])){
	$email = "";
}else{
	$email = $_SESSION["email"];
}
if(!isset($_SESSION["age"]) || is_null($_SESSION["age"])){
	$age = "";
}else{
	$age = $_SESSION["age"];
}
if(!isset($_SESSION["gender"]) || is_null($_SESSION["gender"])){
	$gender = "";
}else{
	$gender = $_SESSION["gender"];
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
		<script src="js/jquery-2.1.3.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<h2>新規投稿画面</h2>
			<form method="post" action="index_confirm.php" enctype="multipart/form-data" id="send_file" class="form-horizontal">
				<div class="form-group">
					<label for="name" class="col-sm-3 control-label">name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="name" id="name" placeholder="name">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">email</label>
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
print('<option value="'.$i.'"');
	if($i === (int)$age){print('selected');}
	print('>'.$i.'</option>');
}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="gender" class="col-sm-3 control-label">gender</label>
					<div class="col-sm-9">
					<?php
$gens = array('男性','女性','その他');
foreach($gens as $gen){
	print('<label>');
	print('<input type="radio" name="gender" value="'.$gen.'"');
	if($gen === $gender){ print('checked'); }
	print('>');
	print( $gen.'　</label>');
	
}
?>
						<!--<input type="radio" name="gender" value="man">男性　
						<input type="radio" name="gender" value="woman">女性-->
					</div>
				</div>


				<div class="form-group">
					<label for="naiyou" class="col-sm-3 control-label">naiyou</label>
					<div class="col-sm-9">
						<textarea name="naiyou" cols="50" rows="5"></textarea>
					</div>
				</div>



				<button type="submit" class="btn btn-primary btn-block">Submit</button>
				<input type="hidden" name="post_flg" value="1"><!--postして表示されたのか、ただ表示されたのかを見極めている-->
			</form>
			<p><a href="select.php">一覧を見る</a></p>
		</div>


		<!-- Javascript -->
		<script>
		</script>
	</body>
</html>
