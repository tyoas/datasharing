<?php
// 設定ファイル等を読み込む
require_once './config.php';
require_once './functions.php';

// SESSION開始
session_start();

// DB接続
$pdo = connectDb();

// SESSION格納確認
if (isset($_SESSION['USER'])) {
	// SESSIONに値があればホーム画面に遷移する
	;

}

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初期画面表示
	;

	// トークン格納
// 	setToken();
} else {
	// フォームでサブミットされた時

	// トークンチェック
// 	checkToken();
	// 入力項目を格納
	$user_name = $_POST['user_name'];
	$user_password = $_POST['user_pass'];

	// エラー格納配列
	$err = Array();
	// エラーチェック
	if ($user_name == '') {
		$err['user_name'] = '氏名が選択されてません';
	}

	if ($user_password == '') {
		$err['user_pass'] = 'パスワードが未入力です';
	}

	// エラー確認
	if (!empty($err)) {
		;
		exit;
	}

}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有　｜　ログイン</title>
	<meta name="description" content="">
	<meta name="keyword" content="">
	<link href="./css/bootstrap.min.css" rel="stylesheet"></link>
	<link href="./css/datasharing.css" rel="stylesheet"></link>
</head>
<body>
	<div class="page-header text-center">
  <h1>データ共有システム</h1>
</div>
<div class="container">
    <div class="panel panel-info">
      <div class="panel-body panel-bg">
        <div class="row">
          <div class="col-md-12" >
          		<h1>データ共有システムとは？</h1>
          		<h3>色々な人とデータを共有するサービスです。
          		このサービスを使用することによってデータを色々なところに
          		管理することなく一元管理ができます。</h3>
          		<div id="carousel_01" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#carousel_01" data-slide-to="0" class="active"></li>
							<li data-target="#carousel_01" data-slide-to="1"></li>
							<li data-target="#carousel_01" data-slide-to="2"></li>
							<li data-target="#carousel_01" data-slide-to="3"></li>
						</ol>
					<div class="carousel-inner">
						<div class="item active"> <img src="img/data_image4.jpg" alt="" width="500px" height="700px"></div>
						<div class="item"> <img src="img/data_image1.jpg" alt="" width="500px" height="700px"></div>
						<div class="item"> <img src="img/data_image2.jpg" alt="" width="500px" height="700px"></div>
						<div class="item"> <img src="img/data_image3.jpg" alt="" width="500px" height="700px"></div>
				<a class="left carousel-control" href="#carousel_01" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a> <a class="right carousel-control" href="#carousel_01" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> </a>
				</div>
          	</div>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- /container -->
      <div class="text-center">
      	<a href="https://px.a8.net/svt/ejp?a8mat=2NT04D+38OZCI+3IDQ+60OXD" target="_blank" rel="nofollow">
<img border="0" width="468" height="60" alt="" src="https://www21.a8.net/svt/bgt?aid=160916701196&wid=001&eno=01&mid=s00000016379001011000&mc=1"></a>
<img border="0" width="1" height="1" src="https://www16.a8.net/0.gif?a8mat=2NT04D+38OZCI+3IDQ+60OXD" alt="">
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-8521988-2', 'auto');
		  ga('send', 'pageview');
		</script>
      </div>

<div class=container>
	<div class="row">
		<div class="col-md-12">
			<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
	    		ログイン
			</button>
		</div>
	</div>
</div>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">ログイン</h4>
				</div> <!-- /.modal-header -->


				<form role="form" method="post">
					<div class="modal-body">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control" id="uLogin" placeholder="Login" name="user_name">
								<label for="uLogin" class="input-group-addon glyphicon glyphicon-user"></label>
							</div>
						</div> <!-- /.form-group -->

						<div class="form-group">
							<div class="input-group">
								<input type="password" class="form-control" id="uPassword" placeholder="Password" name="user_pass">
								<label for="uPassword" class="input-group-addon glyphicon glyphicon-lock"></label>
							</div> <!-- /.input-group -->
						</div> <!-- /.form-group -->

						<div class="checkbox">
							<label>
								<input type="checkbox"> Remember me
							</label>
						</div> <!-- /.checkbox -->

					</div> <!-- /.modal-body -->

					<div class="modal-footer">
						<button class="form-control btn btn-primary">ログイン</button>

					<div class="progress">
						<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;">
							<span class="sr-only">progress</span>
						</div>
					</div>
					</div> <!-- /.modal-footer -->
				</form>

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
	<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>

</body>
</html>
