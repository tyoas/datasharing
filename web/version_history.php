<?php
// 共有ファイルの読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// 配列の準備
$history_date = array();

// セッションの確認
if (!isset($_SESSION['USER'])) {
	header('Location:'.SITE_URL.'login.php');
	exit;
}

$user = $_SESSION['USER'];

// DB接続
$pdo = connectDb();

if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

// リクエストの確認
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初期画面表示

	// バージョン履歴取得
	$history_date = version_history($pdo, $page, $user['count_page']);

	// 件数をカウントする
	$total_page = history_count($pdo);
	// ページ数のカウント
	$total_page = ceil($total_page / $user['count_page']);

	setToken();

} else {
	checkToken();

}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | データリスト</title>
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
	            <li><a href="./log.php">操作ログ</a></li>
<?php endif; ?>
				<li><a href="./setting.php">設定</a></li>
				<li class="active"><a href="./version_history.php">バージョン管理</a></li>
	            <li><a href="logout.php">ログアウト</a></li>
	        </ul>
	    </div>
	</nav>
	<div class="container">
		<h1>バージョン履歴</h1>
<?php if ($user['user_auth'] == 0): ?>
		<a href="./history_create.php" class="btn btn-primary btn-block">新規登録</a>
<?php endif; ?>
		<br /><br />

		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr><th>バージョン番号</th><th>変更履歴</th><th></th></tr>
<?php foreach ($history_date as $value): ?>
					<tr>
						<td><?php echo $value['version_no']; ?></td>
						<td><?php echo $value['change_history']; ?></td>
						<td>
							<?php if ($user['user_auth'] == 0): ?>
								<a class="btn btn-success" href="history_edit.php?id=<?php echo h($value['id']); ?>&version_no=<?php echo h($value['version_no']);?>&change_history=<?php echo h($value['change_history']);?>">編集</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="history_delete.php?id=<?php echo $value['id']; ?>">削除</a>
							<?php endif; ?>
						</td>
					</tr>
<?php endforeach; ?>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<nav>
					<?= sortPages($user['count_page'], $total_page) ?>
				</nav>
			</div>
		</div>

	</div>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<!--[if lte IE8]>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
	< ![endif]-->
	<!--[if gte IE 9]><!-->
	<script src="js/jquery-3.1.1.min.js"></script>
	<!--[endif]-->
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>
</body>
</html>
