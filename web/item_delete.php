<?php
// 共通ファイルの読み込み
require_once './config.php';
require_once './functions.php';

// セッションの開始
session_start();

// ユーザーセッション情報格納判定
if (!isset($_SESSION['USER'])) {
	// ユーザーがセットさえていない
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// ユーザー情報取得
$user = $_SESSION['USER'];

// 値を受取
$id = $_GET['id'];

// DB接続
$pdo = connectDb();

// 削除処理
deleteItem($pdo, $id);

// 操作履歴ログ登録
sousa_datadelete($pdo,$user['id']);

// 画面遷移
header('Location:'.SITE_URL.'index.php');
exit;

?>