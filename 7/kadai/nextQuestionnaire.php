<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>次のアンケート</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script>
		$(function(){
			$('.kouho').on('click',function(){
				$('.kouho').removeClass('selected');
				$(this).addClass('selected');
				$('#answer').val($(this).data('id'));
			})
			$('#submit').on('click',function(){
				$('#answer').val();
			});
		});
	</script>
	<style>
		/** {
			box-sizing: border-box;
		}*/
	.selected {
		/*border: 4px solid #f00;*/
		box-shadow: 0 0 20px 10px rgb(0, 83, 61);
		opacity: 0.6;
	}
		img {
			margin-left: 20px;
		}
	</style>
</head>
<body>
	<div  class="container">
		<form method="post" action="nextQuestionnaire.php">
			<h2>一番可愛いのはどれ？</h2>
			<p>
			<img src="images/photo1.jpg" class="kouho" data-id="0" width="260">
			<img src="images/photo2.jpg" class="kouho" data-id="1" width="260">
			<img src="images/photo3.jpg" class="kouho" data-id="2" width="260">
			<img src="images/photo4.jpg" class="kouho" data-id="3" width="260">
			</p>
			<p><input type="submit" class="btn btn-primary" id="submit" name="submit" value="投票する"></p>
	<input type="hidden" id="answer" name="answer" value="">

<?php
$cawaii = array('ガッキー', 'ハリネズミ', 'おれ', 'パグゾウ');//配列を作成
?>
</form>
<!--<table border='1'>-->
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th><i class="glyphicon glyphicon-sort-by-attributes"></i></th>
				<th><i class="glyphicon glyphicon-heart-empty"></i>名前</th>
				<th><i class="glyphicon glyphicon-object-align-left"></i>得票数</th>
			</tr>
		</thead>
<?php
$ed = file('nextQuestionnaire.txt');
for ($i = 0; $i < count($cawaii); $i++){
	$ed[$i] = rtrim($ed[$i]);
}
if ($_POST['submit']) {//もし、送信ボタンが押されたら・・・」という意味
	$ed[$_POST['answer']]++;
	$fp = fopen('nextQuestionnaire.txt', 'w');
	for ($i = 0; $i < count($cawaii); $i++) {
fwrite($fp, $ed[$i] . "\n");
}
fclose($fp);
}
for ($i = 0; $i < count($cawaii); $i++) {
print "<tr>";
	print "<td>" . ($i + 1) . "</td>";
	print "<td>{$cawaii[$i]}</td>";
print "<td><table><tr>";
$w = $ed[$i] * 10;
print "<td width='$w' bgcolor='#00ffa7'> </td>";
print "<td>{$ed[$i]} 票</td>";
print "</tr></table></td>";
print "</tr>\n";
}
?>
</table>
	</div>
</body>
</html>