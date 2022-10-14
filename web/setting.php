<?php
// 共有ファイルの読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// ユーザーセッション情報保持確認
if (!isset($_SESSION['USER'])) {
	// 強制的にlogin.phpへ
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// エラー配列
$err_msg = array();
$com_msg = '';

// セッション代入
$user = $_SESSION['USER'];

// DB接続
$pdo = connectDb();

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初回表示
	// CSRF対策
	setToken();
} else {
	// フォームからサブミットされた時

	// CSRF対策
	checkToken();

	$count_page = $_POST['count_page'];

	// 入力確認
	if ($count_page == '99') {
		$err_msg['count_page'] = '個別設定を選択して下さい';
	}

	// エラー確認
	if (empty($err_msg)) {
		// 設定を登録する
		insert_setting($pdo, $user['id'], $count_page);
		// セッション情報更新
		$user['count_page'] = $count_page;
		$_SESSION['USER'] = $user;
		// 完了メッセージ
		$com_msg = '更新が完了しました！';
		// DB切断
		unset($pdo);
	}
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | ユーザー情報登録</title>
	<meta name="description" content="">
	<meta name="keyword" content="">
	<link href="./css/bootstrap.css" rel="stylesheet"></link>
	<link href="./css/datasharing.css" rel="stylesheet"></link>
</head>
<body>
	<nav class="navbar navbar-default">
	    <div class="container">
	        <!-- 2.ヘッダ情報 -->
	        <div class="navbar-header">
	            <a class="navbar-brand">データ共有システム</a>
	        </div>
	        <!-- 3.リストの配置 -->
	        <ul class="nav navbar-nav">
	            <li><a href="./index.php">データリスト</a></li>
	            <li><a href="./user_list.php">ユーザー管理</a></li>
	            <li><a href="./log.php">操作ログ</a></li>
	            <li class="active"><a href="./setting.php">設定</a></li>
				<li><a href="./version_history.php">バージョン管理</a></li>
	            <li><a href="./logout.php">ログアウト</a></li>
	        </ul>
	    </div>
	</nav>

	<div class="container">


		<h1>個別設定画面</h1>

		<?php if (!empty($com_msg)):?>
			<div class="alert alert-success" role="alert"><?php echo h($com_msg); ?></div>
		<?php endif; ?>
		<form method="post">
			<div class="form-group">
<!-- 				<input type="text" name="user_name" placeholder="1ページの表示件数を入力して下さい" class="form-control" value=""> -->
				<?php echo arrayToSelect("count_page", $count_page_array, $user['count_page']); ?>
				<span class="help-block"><?php echo h($err_msg['count_page']); ?></span>
			</div>
			<input type="submit" value="登録" class="btn btn-primary btn-block">
			<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
		</form>
	</div>

	<!--[if lte IE8]>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
	< ![endif]-->
	<!--[if gte IE 9]>
	<script src="js/jquery-3.1.1.min.js"></script>
	< ![endif]-->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>
</body>
</html>
