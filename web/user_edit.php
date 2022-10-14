<?php
// 共通ファイル読み込み
require_once './config.php';
require_once './functions.php';
require_once './lib/password.php';

// セッション開始
session_start();

// セッションユーザー情報確認
if (!isset($_SESSION['USER'])) {
	// 強制画面遷移
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// DB接続
$pdo = connectDb();

// ユーザ情報取得
$this_user = $_SESSION['USER'];

// 配列の準備
$err = array();
$user = array();
$comlete_msg = '';

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初期画面表示

	// 入力項目の受取
	$user_id = $_GET['id'];


	// ユーザー情報の取得
	$user = getUser($pdo, $user_id);

	// 指定ユーザーをセッションに格納
	$_SESSION['EDIT_USER'] = $user;

	// セットトークン
	setToken();

} else {
	// フォームからポストされた時の表示

	// 入力項目の受け渡し
	$user_name = $_POST['user_name'];
	$user_pass = $_POST['user_pass'];
	$user_auth = $_POST['user_auth'];

	$edit_user = $_SESSION['EDIT_USER'];

	// 「ユーザーネームが未入力
	if ($user_name == '') {
		$err['user_name'] = 'ユーザーネームが未入力です';
	} else {
		// [ユーザーネーム]
		if (mb_strlen($user_name) > 30) {
			$err['user_name'] = 'ユーザーネームは３０バイト以内でお願いします';
		}
	}

	// [ユーザーパスワード]の文字数チェック
	if (mb_strlen($user_pass) > 30) {
		$err['user_password'] = 'パスワードは３０バイト以内でお願いします';
	} else {

	}

	// エラー判定
	if (empty($err)) {
		// ユーザー情報更新
		edit_user($pdo, $edit_user['id'], $user_name, $user_pass, $user_auth);

		// 操作ログの登録
		sousa_useredit($pdo, $this_user['id']);
		$_SESSION['EDIT_USER'] = array();
		// ユーザー情報の取得
		$user = getUser($pdo, $edit_user['id']);
		$comlete_msg = '変更が完了しました！';
	}

	// チェックトークン
	checkToken();
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | ユーザー情報編集</title>
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
<?php if ($this_user['user_auth'] == 0): ?>
	            <li class="active"><a href="./user_list.php">ユーザー管理</a></li>
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
			<div class="form-group <?php if ($err['user_name'] != '') echo 'has-error'; ?>">
				<input type="text" name="user_name" placeholder="氏名を入力して下さい" class="form-control" value="<?php echo $user['user_name'];?>">
				<span class="help-block"><?php echo $err['user_name']; ?></span>
			</div>
			<div class="form-group <?php if ($err['user_password'] != '') echo 'has-error'; ?>">
				<input type="password" name="user_pass" placeholder="パスワードを入力して下さい" class="form-control" value="">
				<span class="help-block"><?php echo $err['user_password']; ?></span>
			</div>
			<div class="form-group">
				<select name="user_auth" class="form-control">
					<option value="0" <?php if ($user['user_auth'] == 0) echo 'selected'; ?>>管理者</option>
					<option value="1" <?php if ($user['user_auth'] == 1) echo 'selected'; ?>>一般</option>
				</select>
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