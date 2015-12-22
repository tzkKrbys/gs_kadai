<?php
	session_start();
$id = $_GET['page'];
/*if(!isset($_SESSION['page']) || is_null($_SESSION['page'])){
	$page = 0;
}else{
	$page = $_SESSION['page'];
}*/


$pdo = new PDO('mysql:dbname=demo_cms;host=localhost','root','');
$stmt = $pdo->query('SET NAMES utf8');
$stmt = $pdo->prepare("SELECT * FROM cms_table WHERE id = :id");
$stmt->bindValue(':id', $id);
$flag = $stmt->execute();

$view = "";

if($flag = FALSE){
	$view = "SQLエラー";
}else{
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$news_title = $result['news_title'];
	$news_detail = $result['news_detail'];
	$view_flg = $result['view_flg'];
	$indate = $result['indate'];
}

/*var_dump($view);
var_dump($news_title);*/
?>







<!DOCTYPE html>
<html>
<head>
    <title>チーズアカデミーTOKYO</title>
    <meta charset="UTF-8">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-2.1.0.min.js"></script>
    <script>
    $(function(){
        $(window).on("ready resize",function(){
        $(".slides").css({"width":1440,
                         "position":"relative",
                          left:-(1440-$(window).width())/2
                         });
        });
    });
    </script>
</head>
<body>
    <div class="wrapper">
        <!-- header  -->
        <header id="header">
           <div class="inner clearfix">
            <h1 class="logo"><img src="image/logo-top.png" alt="Cheese Academy Tokyo" /></h1>
            <ul class="note_wrap">
                <li>CHEESE DEVELOPMENT</li>
                <li>GROWTH CHEESE</li>
                <li>CHEESE PERSPECTIVE</li>
                <li>CHEESE GENERATOR</li>
            </ul>
            </div>
        </header>

        <!--　nav_lower   -->
        <section class="nav_lower">
            <div class="inner">
               <?php
include("nav.html");
?>
                <!--<nav class="global_Nav">
                    <ul class="nav_wrap clearfix">
                        <li class="nav_item"><a href="#">HOME<br />-ホーム-</a></li>
                        <li class="nav_item"><a href="#">NEWS<br />-お知らせ・更新情報-</a></li>
                        <li class="nav_item"><a href="#">FEATURE<br />-特徴-</a></li>
                        <li class="nav_item"><a href="#">COURCE<br />-コース紹介-</a></li>
                        <li class="nav_item none"><a href="#">GALLERY<br />-ギャラリー-</a></li>
                        <li class="nav_item last"><a href="#">ENTRY<br />-説明会に申し込む-</a></li>
                    </ul>
                </nav>-->
            </div>
        </section>
    
        <!--news_lower    -->
        <section id="news_lower">
            <div class="news_lower_heading">
            <div class="inner clearfix">
                <div class="section-heading-wrap">
                    <h2 class="section-title white">NEWS</h2>
                    <p class="section-note"><?= $indate ?></p>
                </div>
            </div>
            </div>

            <div class="inner">
                <ul class="news_list clearfix">
                    <li>
                    <dl>
						<dt class="news-date clearfix"><span class="news_tags"><?= $news_title ?></span></dt>
						<dd class="news-title"><?= $news_detail ?></dd>
	                    </dl>
                    </li>
                </ul>
            </div>
        </section>
   
        <!--#entry    -->
        <section id="entry" class="contents-box">
            <div class="contents-heading bg-yellow">
                <h2 class="section-title">ENTRY</h2>
                <p class="section-note white">説明会に申し込む</p>
            </div>
            <p class="entry-summary">入学をご希望の方に向けて、学校説明会を実施しております。<br />
    フォームからお申し込みください。（無料・完全予約制）</p>
            <a class="entry-btn">
                <p class="entry-btn-title">ENTRY</p>
                <p class="entry-btn-note">説明会に申し込む</p>
            </a>
        </section>
        <!--end #entry-->
    
        <?php
	include("information.html");
	?>
    </div>
<script>
$(".news_list_modifer").css("display","none");
$(".btn-reading").on("click",function(){
    $(".news_list_modifer").fadeIn(400);
});
</script>
</body>
</html>