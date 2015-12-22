<?php $defs=array( 'name'=>'栗林緒','mail' => 'sample@sample.sample','age'=>'37','sex'=>'男性','career'=>'1','language'=>'javascript','language2'=>'ruby','serverSideLang'=>'node.js' ); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<title>プログラミング言語アンケート</title>
</head>

<body>
	<div class="container">
	<section>
		<h1>アンケート</h1>
		
		<form method="post" action="output_data.php" class="form-inline">
			<div class="form-group">
			<div class="container">
				<p>
					<label for="name">お名前：</label>
					<input type="text" class="form-control form-inline" name="name" size="20" value="<?php print($defs['name']); ?>">

				</p>
				<p>
					<label>メール：</label>
					<input type="email" class="form-control form-inline" name="email" size="30" maxlength="40" value="<?php print($defs['mail']); ?>">
				</p>
				
				<p>
				<div class="form-group">
					<label for="age">年齢：</label>
					<select id="age" class="form-control form-inline" name="age">
						<?php
for($i=18; $i < 60; $i++){
	print('<option value="'.$i.'"');
	if($i === (int)$defs['age']){
		print(' selected');
	}
	print('>'.$i.'歳</option>');
}
?>
					</select>
				</div>
				</p>
				
				<div class="form-group" class="radio-inline">
				<p class="control-label">性別：</p>
				<?php
$sexes = array('男性','女性');
foreach($sexes as $sex){
	print('<label>');
	print('<input type="radio" name="sex" value="'. $sex . '"');
	if($sex === $defs['sex']){
		print(' checked');
	}
	print('>');
	print($sex.'　</label>');
}
				?>
				</div>
				
				<p>
					<label for="language">好きな言語：</label>
					<select id="language" class="form-control" name="language">
						<?php
$languages=array( 'javascript', 'php', 'ruby', 'pearl', 'python', 'java', 'c#', 'go', 'swift' );
foreach($languages as $language){
	print('<option value="'.$language.'"');
	if($language === $defs['language']){
		print(' selected');
	}
	print('>'.$language.'</option>');
}
						?>
					</select>
				</p>

				
				<p>
					<label for="language">かっこいいと思う言語：</label>
					<select id="language2" class="form-control" name="language2">
						<?php
$languages2=array( 'javascript', 'php', 'ruby', 'pearl', 'python', 'java', 'c#', 'go', 'swift' );
foreach($languages2 as $language2){
	print('<option value="'.$language2.'"');
	if($language2 === $defs['language2']){
		print(' selected');
	}
	print('>'.$language2.'</option>');
}
						?>
					</select>
				</p>
				<p>
					<label for="serverSideLang">気になるサーバーサイド言語：</label>
					<select id="serverSideLang" class="form-control" name="serverSideLang">
						<?php
$serverSideLangs=array( 'Node.js', 'php', 'ruby', 'pearl', 'python', 'java' );
foreach($serverSideLangs as $serverSideLang){
	print('<option value="'.$serverSideLang.'"');
	if($serverSideLang === $defs['serverSideLang']){
		print(' selected');
	}
	print('>'.$serverSideLang.'</option>');
}
						?>
					</select>
				</p>
				
				<p>
					<label for="career">プログラミング経験：</label>
					<select id="career" class="form-control" name="career">
						<?php
$careers = array('半年未満','1年未満','3年未満','5年未満','10年未満','10年以上');
foreach($careers as $career){
	print('<option value="'.$career.'"');
	if($career === $defs['career']){
		print(' selected');
	}
	print('>'.$career.'</option>');
}
?>
					</select>
				</p>
					<p>
						<input type="submit" class="btn btn-primary" value="送信">
					</p>
		</form>
			</div>
	</section>
		</div>
	
</body>

</html>