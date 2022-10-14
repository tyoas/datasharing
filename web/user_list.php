<?php
// 共通ファイル読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// userセッション取得確認
if (!isset($_SESSION['USER'])) {
	// セッションが格納されていない場合
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// 配列の用意
$user_list = array();

// DB接続
$pdo = connectDb();

// ページ数初期化
$page = $_GET['page'] ? $_GET['page'] : 1;

$user = $_SESSION['USER'];

// リクエスト確認
if ($_SERVER['REQUEST_METHOD'] != 'POST'){
	// 初期画面表示

	// 正規表現でパラメーターが数値かどうかのチェックを行う
	if (preg_match('/^[1-9][0-9]*$/', $_GET['page'])) {
		// 正規表現にマッチしたらパラメーターをそのまま受け取る
		$page = $_GET['page'];
	} else {
		// 数値以外のパラメーターが渡されたら強制的に1にする
		$page = 1;
	}
	// ユーザー一覧情報取得
// 	$users = user_select_all($pdo, $page);
// 	$users = users_page($pdo, $page);
	$users = users_page($pdo, $page, $user['count_page']);

	// 総ユーザ数をカウントする
	$total_pages = users_count($pdo);
	// 全ページ数の取得
	$total_pages = ceil($total_pages / $user['count_page']);

	// トークンの取得
	setToken();
} else {
	// フォームでサブミットされて時

	// トークンのチェック
	checkToken();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | ユーザー一覧</title>
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

		<h1>ユーザー一覧</h1>
		<a href="./user_create.php" class="btn btn-primary btn-block">新規登録</a>
		<br /><br />

		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr><th>ユーザー名</th><th>権限</th><th>登録日時</th><th></th></tr>
<?php foreach ($users as $user ): ?>
						<tr><td><?php echo $user['user_name'];?></td><td><?php echo $user['user_auth'] == 0 ? '管理' : '一般'; ?></td><td><?php echo $user['created_at'];?></td><td><a  class="btn btn-success" href="user_edit.php?id=<?php echo $user['id'];?>">変更</a>&nbsp;<a class="btn btn-danger" href="javascript:void(0);" onclick="var ok=confirm('削除しても宜しいですか？'); if (ok) location.href='user_delete.php?id=<?php echo $user['id'];?>' ; return false;">削除</a></td></tr>
<?php endforeach; ?>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<nav>
					<?= sortPages($user['count_page'], $total_pages) ?>
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
	<!--<![endif]-->
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>

</body>
