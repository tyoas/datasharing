<?php
// 共通ファイル読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// ユーザセッション判断
if (!isset($_SESSION['USER'])) {
	// 強制的に画面遷移
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// ユーザーセッションの格納
$user = $_SESSION['USER'];

// DB接続
$pdo = connectDb();

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初期画面表示

	// トークンのチェック(CSRF対策)
// 	checkToken();

	// 値の取得
	$query = $_GET['q'];

	// データ取得
	$item = getItemDownload($pdo, $query);

// 	$flag = downLoadCsv($item);
	// データダウンロード
	downLoadCsv2($item);

	// 操作履歴登録
	sousa_download($pdo, $user['id']);

	exit;

} else {
	// フォームからサブミットされた時
}
?>