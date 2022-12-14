<?php
// 共有ファイルの読み込み
require_once './config.php';
require_once './functions.php';
require_once './lib/password.php';

// セッションの開始
session_start();

// セッションの格納判定
if (!isset($_SESSION['USER'])) {
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// ユーザー情報取得
$user = $_SESSION['USER'];

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初期表示

	// CSRF対策
	setToken();

} else {
	// サブミットされたときの処理

	// CSRF対策
	checkToken();

	// DB接続
	$pdo = connectDb();

	// 入力項目代入
	$err = Array();
	$comp_msg;
	$user_name = $_POST['user_name'];
	$user_pass = $_POST['user_pass'];
	$user_kengen = $_POST['user_kengen'];

	// 入力チェック
	if ($user_name == '') {
		$err['user_name'] = '氏名が未入力です';
	} else {

	}
	if ($user_pass == '') {
		$err['user_pass'] = 'パスワードが未入力です。';
	}

	if ($user_kengen == 99) {
		$err['user_kengen'] == '権限が未設定です。';
	}
	// エラー格納チェック
	if (empty($err)) {
		// ユーザー登録
		user_add($pdo, $user_name, $user_pass, $user_kengen);
		// 操作履歴保存
		sousa_useradd($pdo, $user['id']);
		// PDO接続切断
		unset($pdo);
		// メッセージ取得
		$comp_msg = '登録が完了しました！';
		// 画面遷移
// 		header('Location:'.SITE_URL.'user_create.php');
// 		exit;
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
<?php if ($user['user_auth'] == 0): ?>
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

		<?php if ($comp_msg != ''): ?>
			<div class="alert alert-success" role="alert"><?php echo $comp_msg; ?></div>
		<?php endif; ?>
		<h1>ユーザー情報登録</h1>
		<form method="post">
			<div class="form-group <?php if ($err['user_name'] != '') echo 'has-error'; ?>">
				<input type="text" name="user_name" placeholder="氏名を入力して下さい" class="form-control" value="">
				<span class="help-block"><?php echo $err['user_name']; ?></span>
			</div>
			<div class="form-group <?php if ($err['user_pass'] != '') echo 'has-error'; ?>">
				<input type="password" name="user_pass" placeholder="パスワードを入力して下さい" class="form-control" value="">
				<span class="help-block"><?php echo $err['user_pass']; ?></span>
			</div>
			<div class="form-group">
				<select name="user_kengen" class="form-control">
					<option value="0">管理者</option>
					<option value="1">一般</option>
				</select>
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