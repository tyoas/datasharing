<?php
// 共有ファイルの読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// err配列の準備
$err = array();
$com_msg = array();

// ユーザーセッション確認
if (!isset($_SESSION['USER'])) {
	header('Location:'.SITE_URL.'login.php');
	exit;
}

$user = $_SESSION['USER'];
// DB接続
$pdo = connectDb();

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初回表示

	// CSRF対策
// 	setToken();
} else {
	// フォームからサブミットされた時

	// CSRF対策
// 	checkToken();

	// 入力項目の代入
	$version_history = $_POST['version_history'];
	$change_history = $_POST['change_history'];

	// エラー格納
	if ($version_history == '') {
		$err['version_history'] = 'バージョン番号が未入力です。';
	} else {

	}

	if ($change_history == '') {
		$err['change_history'] = '変更履歴が未入力です。';
	} else {

	}

	// エラーチェック
	if (empty($err)) {
		$com_msg = '登録が完了しました。';
		create_history($pdo, $version_history, $change_history);
	}
	// DBの切断
	unset($pdo);
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
<?php if ($user['user_auth'] == 0): ?>
	            <li><a href="./user_list.php">ユーザー管理</a></li>
	            <li><a href="./log.php">操作ログ</a></li>
	            <li class="active"><a href="./version_history.php">バージョン管理</a></li>
<?php endif; ?>
				<li><a href="./setting.php">設定</a></li>
	            <li><a href="logout.php">ログアウト</a></li>
	        </ul>
	    </div>
	</nav>

	<div class="container">

		<h1>開発バージョン履歴登録</h1>
<?php if ($com_msg): ?>
<?php echo "<div class='alert alert-success' role='alert'>".$com_msg."</div>"; ?>
<?php endif; ?>
		<form method="post">
			<div class="form-group <?php if ($err['version_history'] != '') echo 'has-error'; ?>">
				<input type="text" name="version_history" placeholder="バージョン改版番号を入力して下さい" class="form-control" value="">
				<span class="help-block"><?php echo $err['version_history']; ?></span>
			</div>
			<div class="form-group <?php if ($err['change_history'] != '') echo 'has-error'; ?>">
				<input type="text" name="change_history" placeholder="変更内容を入力して下さい" class="form-control" value="">
				<span class="help-block"><?php echo $err['change_history']; ?></span>
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