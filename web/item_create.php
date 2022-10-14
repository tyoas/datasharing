<?php
// 共通ファイルの読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// ユーザーセッション情報確認
if (!isset($_SESSION['USER'])) {
	// login画面に強制画面遷移
	header('Location:'.SITE_URL.'login.php');
	exit;
}
// 配列の準備
$err = array();
$add_data = array();
$com_msg = '';

// ユーザーセッション取得
$user = $_SESSION['USER'];

// httpリクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初期画面表示

	// トークンセット
	setToken();
} else {
	// フォームがサブミットされた時

	// セットトークン
	checkToken();

	// DB接続
	$pdo = connectDb();

	// 入力項目の受取
	$add_data['column1'] = $_POST['calam1'];
	$add_data['column2'] = $_POST['calam2'];
	$add_data['column3'] = $_POST['calam3'];
	$add_data['column4'] = $_POST['calam4'];
	$add_data['column5'] = $_POST['calam5'];
	$add_data['column6'] = $_POST['calam6'];
	$add_data['column7'] = $_POST['calam7'];
	$add_data['column8'] = $_POST['calam8'];
	$add_data['column9'] = $_POST['calam9'];
	$add_data['column10'] = $_POST['calam10'];

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

	// エラー情報格納判定
	if (empty($err)) {
		// 情報を登録する
		data_add($pdo, $add_data);
		// 操作履歴の保存
		sousa_touroku($pdo, $user['id']);
		// DB切断
		unset($pdo);
		// コンプリートメッセージ
		$com_msg = '商品登録が完了しました！';
	}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | データ登録</title>
	<meta name="description" content="">
	<meta name="keyword" content="">
	<link href="css/bootstrap.css" rel="stylesheet"></link>
	<link href="css/datasharing.css" rel="stylesheet"></link>
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
		<?php if ($com_msg): ?>
			<div class="alert alert-success" role="alert"><?php echo $com_msg; ?></div>
		<?php endif; ?>
		<h1>データ登録</h1>
		<form method="post">
			<div class="form-group <?php if ($err['column1'] != '') echo 'has-error'; ?>">
				<input type="text" name="calam1" placeholder="カラム1を入力して下さい" class="form-control" value="<?php echo h($calam1); ?>">
				<span class="help-block"><?php echo h($err['column1']);?></span>
			</div>
			<div class="form-group <?php if ($err['column2'] != '') echo 'has-error'; ?>">
				<input type="text" name="calam2" placeholder="カラム2を入力して下さい" class="form-control" value="<?php echo h($calam2); ?>">
				<span class="help-block"><?php echo h($err['column2']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column3'] != '') echo 'has-error'; ?>">
				<input type="text" name="calam3" placeholder="カラム3を入力して下さい" class="form-control" value="<?php echo h($calam3); ?>">
				<span class="help-block"><?php echo h($err['column3']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column4'] != '') echo 'has-error'; ?>">
				<input type="text" name="calam4" placeholder="カラム4を入力して下さい" class="form-control" value="<?php echo h($calam4); ?>">
				<span class="help-block"><?php echo h($err['column4']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column5'] != '') echo 'has-error'; ?>">
				<input type="text" name="calam5" placeholder="カラム5を入力して下さい" class="form-control" value="<?php echo h($calam5); ?>">
				<span class="help-block"><?php echo h($err['column5']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column6'] != '') echo 'has-error'; ?>">
				<input type="text" name="calam6" placeholder="カラム6を入力して下さい" class="form-control" value="<?php echo h($calam6); ?>">
				<span class="help-block"><?php echo h($err['column6']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column7'] != '') echo 'has-error'; ?>">
				<input type="text" name="calam7" placeholder="カラム7を入力して下さい" class="form-control" value="<?php echo h($calam7); ?>">
				<span class="help-block"><?php echo h($err['column7']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column8'] != '') echo  'has-error'; ?>">
				<input type="text" name="calam8" placeholder="カラム8を入力して下さい" class="form-control" value="<?php echo h($calam8); ?>">
				<span class="help-block"><?php echo h($err['column8']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column9'] != '') echo 'has-error'; ?>">
				<input type="text" name="calam9" placeholder="カラム9を入力して下さい" class="form-control" value="<?php echo h($calam9); ?>">
				<span class="help-block"><?php echo h($err['column9']); ?></span>
			</div>
			<div class="form-group <?php if ($err['column10'] != '') echo 'has-error'; ?>">
				<input type="text" name="calam10" placeholder="カラム10を入力して下さい" class="form-control" value="<?php echo h($calam10); ?>">
				<span class="help-block"><?php echo h($err['column10']); ?></span>
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
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>
</body>
</html>