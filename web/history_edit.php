<?php
// 共有ファイルの読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// ユーザーのセッション確認
if (!isset($_SESSION['USER'])) {
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// DB接続
$pdo = connectDb();

// セッション格納
$user = $_SESSION['USER'];

// 変数の準備
$version_no = '';
$change_history = '';
$com_msg = '';
$err = array();

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初期画面表示

	// 前画面からのデータ受取
	$history_id = $_GET['id'];

	// 入力項目受取
	$version_no = $_GET['version_no'];
	$change_history = $_GET['change_history'];

	// CSRS対策
	setToken();
} else {
	// フォームからサブミットされた時の処理

	// CSRS対策
	checkToken();

	// 入力値を受け取る
	$version_no = $_POST['version_no'];
	$change_history = $_POST['change_history'];
	$history_id = $_POST['history_id'];

	if ($version_no == '') {
		$err['version_no'] = 'バージョン番号を入力して下さい。';
	} else {

	}

	if ($change_history == '') {
		$err['change_history'] = '対応内容を入力してください。';
	} else {

	}

	// エラー判定
	if (empty($err)) {
		history_update($pdo, $history_id, $version_no, $change_history);
		$com_msg = '編集が完了しました！';
	}

	// エラー格納判定


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
			<div class="form-group <?php if ($err['version_no'] != '') echo 'has-error'; ?>">
				<input type="text" name="version_no" placeholder="バージョン改版番号を入力して下さい" class="form-control" value="<?php echo h($version_no); ?>">
				<span class="help-block"><?php echo $err['version_no']; ?></span>
			</div>
			<div class="form-group <?php if ($err['change_history'] != '') echo 'has-error'; ?>">
				<input type="text" name="change_history" placeholder="変更内容を入力して下さい" class="form-control" value="<?php echo h($change_history); ?>">
				<span class="help-block"><?php echo $err['change_history']; ?></span>
			</div>
			<input type="submit" value="登録" class="btn btn-primary btn-block">
			<input type="hidden" name="history_id" value="<?php echo h($history_id); ?>" />
			<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
		</form>
	</div>

	<!--[if lte IE8]>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
	< ![endif]-->
	<!--[if gte IE 9]><!-->
	<script src="js/jquery-3.1.1.min.js"></script>
	<!--<![endif]-->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>
</body>
</html>