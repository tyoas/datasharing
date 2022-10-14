<?php
// 共通ファイル読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// ユーザーセッション情報格納確認
if (!isset($_SESSION['USER'])) {
	// 強制画面遷移
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// DB接続
$pdo = connectDb();

// ユーザー情報取得
$user = $_SESSION['USER'];

// 変数の準備
$err = array();
$comlete_msg = '';
$items = array();
$add_data = array();

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 編集画面初期

	// 値の取得
	$id = $_GET['id'];


	// 編集するアイテム情報の取得
	$items = getItem($pdo, $id);

	// 取得したユーザーをセッションに保持
	$_SESSION['SELECT_USER'] = $items;

	// CSRF対策(トークンのセット)
	setToken();
} else {
	// 編集画面でサブミットされる

	// CSRF対策(トークンのチェック)
	checkToken();

	// 入力項目の取得
	$add_data['column1'] = $_POST['column1'];
	$add_data['column2'] = $_POST['column2'];
	$add_data['column3'] = $_POST['column3'];
	$add_data['column4'] = $_POST['column4'];
	$add_data['column5'] = $_POST['column5'];
	$add_data['column6'] = $_POST['column6'];
	$add_data['column7'] = $_POST['column7'];
	$add_data['column8'] = $_POST['column8'];
	$add_data['column9'] = $_POST['column9'];
	$add_data['column10'] = $_POST['column10'];

	// 選択したユーザーIDを取得
	$select_user = $_SESSION['SELECT_USER'];

	// [カラム１]文字数チェック
	if (mb_strlen($add_data['column1'], 'UTF-8') > 30) {
		$err['column1'] = 'カラム１の文字数は３０バイト以内でお願いします。';
	}
	// [カラム２]文字数チェック
	if (mb_strlen($add_data['column2'], 'UTF-8') > 30) {
		$err['column2'] = 'カラム２の文字数は３０バイト以内でお願いします。';
	}
	// [カラム３]文字数チェック
	if (mb_strlen($add_data['column3'], 'UTF-8') > 30) {
		$err['column3'] = 'カラム３の文字数は３０バイト以内でお願いします。';
	}
	// [カラム４]文字数チェック
	if (mb_strlen($add_data['column4'], 'UTF-8') > 30) {
		$err['column4'] = 'カラム４の文字数は３０バイト以内でお願いします。';
	}
	// [カラム５]文字数チェック
	if (mb_strlen($add_data['column5'], 'UTF-8') > 30) {
		$err['column5'] = 'カラム５の文字数は３０バイト以内でお願いします。';
	}
	// [カラム６]文字数チェック
	if (mb_strlen($add_data['column6'], 'UTF-8') > 30) {
		$err['column6'] = 'カラム６の文字数は３０バイト以内でお願いします。';
	}
	// [カラム７]文字数チェック
	if (mb_strlen($add_data['column7'], 'UTF-8') > 30) {
		$err['column7'] = 'カラム７の文字数は３０バイト以内でお願いします。';
	}
	// [カラム８]文字数チェック
	if (mb_strlen($add_data['column8'], 'UTF-8') > 30) {
		$err['column8'] = 'カラム８の文字数は３０バイト以内でお願いします。';
	}
	// [カラム９]文字数チェック
	if (mb_strlen($add_data['column9'], 'UTF-8') > 30) {
		$err['column9'] = 'カラム９の文字数は３０バイト以内でお願いします。';
	}
	// [カラム１０]文字数チェック
	if (mb_strlen($add_data['column10'], 'UTF-8') > 30) {
		$err['column10'] = 'カラム１０の文字数は３０バイト以内でお願いします。';
	}

	// エラー格納判定
	if (empty($err)) {
		// アイテム情報更新
		updateItem($pdo, $add_data, $select_user['id']);

		// 操作ログ登録
		sousa_dataedit($pdo, $user['id']);

		$comlete_msg = '更新が完了しました！';

		// ユーザー情報格納（選択ユーザー）
		$items = getItem($pdo, $select_user['id']);
		// 選択したユーザーのセッション情報を初期化
		$_SESSION['SELECT_USER'] = array();
	}
}
// DB切断
unset($pdo);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | データリスト</title>
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
	            <li class="active"><a href="./index.php">データリスト</a></li>
<?php if ($user['user_auth'] == 0): ?>
	            <li><a href="./user_list.php">ユーザー管理</a></li>
	            <li><a href="./log.php">操作ログ</a></li>
<?php endif; ?>
				<li><a href="./setting.php">設定</a></li>
				<li><a href="./version_history.php">バージョン管理</a></li>
	            <li><a href="logout.php">ログアウト</a></li>
	        </ul>
	    </div>
	</nav>

	<div class="container">
		<?php if ($comlete_msg != ''):?>
			<div class="alert alert-success" role="alert"><?php echo $comlete_msg;?></div>
		<?php endif; ?>
		<h1>ユーザー情報編集</h1>
		<form method="post">
			<div class="form-group <?php if ($err['column1'] != '') echo 'has-error'; ?>">
				<input type="text" name="column1" placeholder="カラム１を入力して下さい。" class="form-control" value="<?php echo h($items['column1']); ?>">
				<span class="help-block"><?php echo h($err['column1']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column2'] != '') echo 'has-error'; ?>">
				<input type="text" name="column2" placeholder="カラム２を入力して下さい。" class="form-control" value="<?php echo h($items['column2']); ?>">
				<span class="help-block"><?php echo h($err['column2']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column3'] != '') echo 'has-error'; ?>">
				<input type="text" name="column3" placeholder="カラム３を入力して下さい。" class="form-control" value="<?php echo h($items['column3']); ?>">
				<span class="help-block"><?php echo h($err['column3']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column4'] != '') echo 'has-error'; ?>">
				<input type="text" name="column4" placeholder="カラム４を入力して下さい。" class="form-control" value="<?php echo h($items['column4']); ?>">
				<span class="help-block"><?php echo h($err['column4']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column5'] != '') echo 'has-error'; ?>">
				<input type="text" name="column5" placeholder="カラム５を入力して下さい。" class="form-control" value="<?php echo h($items['column5']); ?>">
				<span class="help-block"><?php echo h($err['column5']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column6'] != '') echo 'has-error'; ?>">
				<input type="text" name="column6" placeholder="カラム６を入力して下さい。" class="form-control" value="<?php echo h($items['column6']); ?>">
				<span class="help-block"><?php echo h($err['column6']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column7'] != '') echo 'has-error'; ?>">
				<input type="text" name="column7" placeholder="カラム７を入力して下さい。" class="form-control" value="<?php echo h($items['column7']); ?>">
				<span class="help-block"><?php echo h($err['column7']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column8'] != '') echo 'has-error'; ?>">
				<input type="text" name="column8" placeholder="カラム８を入力して下さい。" class="form-control" value="<?php echo h($items['column8']); ?>">
				<span class='help-block'><?php echo h($err['column8']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column9'] != '') echo 'has-error'; ?>">
				<input type="text" name="column9" placeholder="カラム９を入力して下さい。" class="form-control" value="<?php echo h($items['column9']); ?>">
				<span class="help-block"><?php echo h($err['column9']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column10'] != '') echo 'has-error'; ?>">
				<input type="text" name="column10" placeholder="カラム１０を入力して下さい。" class="form-control" value="<?php echo h($items['column10']);?>">
				<span class="help-block"><?php echo h($err['column10']); ?></span>
			</div>
			<input type="submit" value="登録" class="btn btn-primary btn-block">

			<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
		</form>

	</div>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<!--[if lte IE8]>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
	< ![endif]-->
	<!--[if gte IE 9]>
	<script src="js/jquery-3.1.1.min.js"></script>
	< ![endif]-->
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>
</body>
</html>