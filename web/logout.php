<?php
// 共通ファイルの読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

// DB接続
$pdo = connectDb();

if (isset($_COOKIE['DATASHARING'])) {
	// 自動ログインキーの取得
	$auto_login_key = $_COOKIE['DATASHARING'];

	// Cookie情報クリア
	setcookie('DATAShARING', '', time()-86400, COOKIE_PATH);

	// DB情報クリア
	delete_AutoLoginkey($pdo, $auto_login_key);
}

// ログアウト処理
$_SESSION = '';

if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-86400, COOKIE_PATH);
}

// セッション情報の破棄
session_destroy();

// DB切断
unset($pdo);

// ページ遷移
header('location:'.SITE_URL.'login.php');
?>