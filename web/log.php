<?php
// 共有ファイルの読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// セッション確認
if (!isset($_SESSION['USER'])) {
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// ユーザーセッション取得
$user = $_SESSION['USER'];

// DB接続
$pdo = connectDb();

// 配列初期化
$sousa_logs = array();

$page = $_GET['page'] ? $_GET['page'] : 1;

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初期画面表示

	// 正規表現でパラメーターが数値かどうかのチェックを行う
	if (preg_match('/^[1-9][0-9]*$/', $_GET['page'])) {
		// 正規表現にマッチしたらパラメーターをそのまま受け取る
		$page = $_GET['page'];
	} else {
		// 数値以外のパラメーターが渡されたら強制的に1にする
		$page = 1;
	}

	// ログ取得
	$sousa_logs = sousa_rireki($pdo, $page, $user['count_page']);

	// 履歴総数をカウントする
	$total_page = sousa_count($pdo);
	$total_page = ceil($total_page / $user['count_page']);

	// クロスサイトスクリプティング対策
	setToken();

} else {
	// フォームからサブミットされた時

	// クロスサイトスクリプティング対策
	checkToken();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | 操作ログ</title>
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
	            <li><a href="./index.php">データリスト</a></li>
<?php if ($user['user_auth'] == 0): ?>
	            <li><a href="./user_list.php">ユーザー管理</a></li>
	            <li class="active"><a href="./log.php">操作ログ</a></li>
<?php endif; ?>
				<li><a href="./setting.php">設定</a></li>
				<li><a href="./version_history.php">バージョン管理</a></li>
	            <li><a href="logout.php">ログアウト</a></li>
	        </ul>
	    </div>
	</nav>

	<div class="container">

		<div class="row">
			<div class="col-md-6">
				<h1>操作ログ一覧</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr><th>操作内容</th><th>操作者</th><th>操作日時日時</th></tr>
<?php foreach ($sousa_logs as $log): ?>
	<?php $sousa_user = sousa_user($pdo, $log['user_id']); ?>
					<tr>
						<td><?php echo h($log['transaction_type']);?></td>
						<td><?php echo h($sousa_user['user_name']); ?></td>
						<td><?php echo h(date('Y/m/d H:i:s', strtotime($log['created_at'])));?></td>
					</tr>
<?php endforeach; ?>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<nav>
					<?= sortPages2($user['count_page'], $total_page) ?>
				</nav>
			</div>
		</div>
	</div>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<!--[if lte IE8]><!-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
	<!--<![endif]-->
	<!--[if gte IE 9]><!-->
	<script src="js/jquery-3.1.1.min.js"></script>
	<!--<![endif]-->
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>

</body>
