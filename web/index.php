<?php
// 共通ファイル読み込み
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

// DB接続
$pdo = connectDb();

// 配列の準備
$item_list = array();
$search_query = '';
// $page = 1;
$err = array();
$sort = '';

// $order = '';
$order = isset($_GET['o']) ? $_GET['o'] : '';
// sortkey
$sortflag = isset($_GET['s']) ? $_GET['s'] : '';
// ユーザーセッション格納
$user = $_SESSION['USER'];

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// getリクエスト発生時

	// 正規表現でパラメーターが数値かどうかのチェックを行う
	if (preg_match('/^[1-9][0-9]*$/', $_GET['page'])) {
		// 正規表現にマッチしたらパラメーターをそのまま受け取る
		$page = $_GET['page'];
	} else {
		// 数値以外のパラメーターが渡されたら強制的に1にする
		$page = 1;
	}

	$search_query = isset($_GET['q']) ? $_GET['q'] : '';

	// ソートリンク押下
	if (isset($_GET['o']) || isset($_GET['s'])) {

		// ソートフラグ取得
		$sortflag = ascdesc_flag($sortflag);

		$item_list = getSortItemList($pdo, $page, $user['count_page'], $order, $sortflag, $search_query);
		// var_dump($item_list);
		/* array_multisortを使用した連想配列のソート
		foreach ($item_list as $key => $value) {
			$sort2[$key] = $value['id'];
		}
		array_multisort($sort2, SORT_DESC, $item_list);
		*/
		// if ($order == 'asc' || $order == '') {

		// 	// 昇順ソート時実行
		// 	$order = 'desc';
		// 	// echo 'asc⇛'.$order;
		// } elseif ($order == 'desc') {
		// 	// 降順ソート時実行
		// 	$order = 'asc';
		// 	// echo 'desc⇛'.$order;
		// }
	} else {
		// 検索ボタン押下判定
		if (isset($_GET['q'])) {
			// 検索項目の代入
			// $search_query = $_GET['q'];

			// DBから検索条件にものを検索する
			$item_list = getSelectItemList($pdo, $search_query, $page, $user['count_page']);

			// 操作履歴登録
			sousa_kensaku($pdo, $user['id']);
		} else {
			// アイテムリスト取得
			$item_list = getItemList($pdo, $page, $user['count_page']);
		}

	}
	// DBから検索条件にものを検索する
// 	$item_list = getSelectItemList($pdo, $search_query, $page);

	// 件数取得
	$total_page = page_count($pdo, $search_query);
	// 全ページ数取得
// 	$total_page = ceil($total_page / PAGE_COUNT);
	$total_page = ceil($total_page / $user['count_page']);
	// crrentページを取得
// 	$current=filter_input(INPUT_GET,"page",FILTER_VALIDATE_INT,["options"=>["default"=>1,"min_range"=>1,"max_range"=>$total_page]]);
	/*$viewが偶数のときは左寄り*/
// 	$offset_left = (int)(($user['count_page']-1)/2);
// 	$offset_right = $user['count_page'] - $offset_left -1;

// 	$pos_start = $current - $offset_left;
// 	$post_end = $current + $offset_right;

// 	echo 'start:' . $pos_start;
// 	echo 'end:' . $post_end;

	// CSRF対策(トークンセット)
	setToken();
} else {
	// フォームからサブミットされた時

	// CSRF対策(トークンチェック)
	checkToken();

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
		<h1>データリスト</h1>

				<form method="get">
					<div class="input-group">
						<input type="text" name="q" placeholder="検索する値を入力して下さい" class="form-control">
						<span class="input-group-btn">
							<input type="submit" class="btn btn-primary" value="検索">
						<!--
						&nbsp;&nbsp;
						<a href="./item_create.php" class="btn btn-primary">新規登録</a>
						&nbsp;&nbsp;
						<a href="./item_createall.php" class="btn btn-danger">データ一括登録</a>
						-->
						</span>
					</div>
					<br />
					<a href="./item_create.php" class="btn btn-primary btn-block">新規登録</a>
					<br />
					<a href="./item_createall.php" class="btn btn-danger btn-block">データ一括登録</a>
					<br />
				</form>

		<br /><br />

		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr>
						<th><a href="?o=1&s=<?php if ($order=='1'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム1<span class="glyphicon <?php ?>"></span></a></th>
						<th><a href="?o=2&s=<?php if ($order=='2'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム2<span class="glyphicon <?php ?>"></span></a></th>
						<th><a href="?o=3&s=<?php if ($order=='3'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム3<span class="glyphicon <?php ?>"></span></a></th>
						<th><a href="?o=4&s=<?php if ($order=='4'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム4<span class="glyphicon <?php ?>"></span></a></th>
						<th><a href="?o=5&s=<?php if ($order=='5'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム5<span class="glyphicon <?php ?>"></span></a></th>
						<th><a href="?o=6&s=<?php if ($order=='6'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム6<span class="glyphicon <?php ?>"></span></a></th>
						<th><a href="?o=7&s=<?php if ($order=='7'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム7<span class="glyphicon <?php ?>"></span></a></th>
						<th><a href="?o=8&s=<?php if ($order=='8'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム8<span class="glyphicon <?php ?>"></span></a></th>
						<th><a href="?o=9&s=<?php if ($order=='9'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム9<span class="glyphicon <?php ?>"></span></a></th>
						<th><a href="?o=10&s=<?php if ($order=='10'): echo $sortflag; else: echo 'asc'; endif; ?>&q=<?php echo h($search_query); ?>">カラム10<span class="glyphicon <?php ?>"></span></a></th>
						<th></th>
					</tr>
<?php foreach ($item_list as $item ): ?>
<tr>
	<td class="<? $item['id']; ?>"><?php echo h($item['column1']);?></td>
	<td><?php echo h($item['column2']);?></td>
	<td><?php echo h($item['column3']);?></td>
	<td><?php echo h($item['column4']);?></td>
	<td><?php echo h($item['column5']);?></td>
	<td><?php echo h($item['column6']);?></td>
	<td><?php echo h($item['column7']);?></td>
	<td><?php echo h($item['column8']);?></td>
	<td><?php echo h($item['column9']);?></td>
	<td><?php echo h($item['column10']);?></td>
	<td>
		<a class="btn btn-success" href="./item_edit.php?id=<?php echo h($item['id']); ?>">変更</a> <a class="btn btn-danger" href="javascript:void(0);" onclick="var ok=confirm('削除しても宜しいですか？'); if (ok) location.href='item_delete.php?id=<?php echo h($item['id']);?>' ; return false;">削除</a>
	</td>
</tr>
<?php endforeach; ?>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<nav>
					<?= sortPages2($user['count_page'], $total_page, $search_query) ?>
				</nav>
			</div>
			<div class="col-md-6">
				<a href="item_download.php?q=<?php echo h($search_query); ?>" class="btn btn-warning btn-block">データダウンロード</a>
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
</html>
