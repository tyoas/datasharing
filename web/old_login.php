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
// 	header('location:'.SITE_URL.'index.php');
// 	exit;
}


// 値取得
$login_user = user_select_all($pdo);
$all_user = array();

foreach ($login_user as $val) {
	$all_user[] = array('id' => $val['id'], 'user_name' => $val['user_name']);
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

	echo 'user_name'.$user_name;
	echo 'user_pass'.$user_password;

// 	echo 'ユーザー名：' . $user_name;
// 	exit;

	// エラー格納配列
	$err = Array();

	// エラーチェック
	if ($user_password == '') {
		$err['user_pass'] = 'パスワードが未入力です';
	} else {
		if (strlen($user_password) >= 30) {
			$err['user_pass'] = 'パスワードは30バイト以内でお願いします';
		}
	}

	// ユーザー確認
// 	if () {
// 		;
// 	}


	// エラー確認
	if (!empty($err)) {
		//

		// セッション情報格納
		$user = $_SESSION['USER'];

		header('Location:'.SITE.'index.php');
		exit;
	}

}

unset($pdo);

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
	<link href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet"> <!-- 3 KB -->
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
				<div class="fotorama" data-width="499" data-height="350" data-stopAutoplayOnAction="false">
  					<img src="http://s.fotorama.io/1.jpg">
  					<img src="http://s.fotorama.io/2.jpg">
  					<img src="img/data_image1.jpg">
  					<img src="img/data_image2.jpg">
  					<img src="img/data_image3.jpg">
  					<img src="img/data_image4.jpg">
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
								<?php echo arrayToSelectLogin("user_name", $all_user); ?>
								<label for="user_name" class="input-group-addon glyphicon glyphicon-user"></label>
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
	<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script> <!-- 16 KB -->
	<script type="text/javascript">
	fotoramaDefaults = {
		autoplay:3000, // ミリ秒
	}
	</script>
</body>
</html>
