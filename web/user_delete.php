<?php
// 共通ファイルの読み込み
require_once './config.php';
require_once './functions.php';

// セッション開始
session_start();

if (!isset($_SESSION['USER'])) {
	header('Location:'.SITE_URL.'login.php');
	exit;
}

// ユーザ情報取得
$user = $_SESSION['USER'];
// DB接続
$pdo = connectDb();

// ユーザー情報取得
$user_id = $_GET['id'];

// ユーザー削除
delete_user($pdo, $user_id);

// ログ履歴登録
sousa_userdelete($pdo, $user['id']);
// DB切断
unset($pdo);

// 画面遷移
header('Location:'.SITE_URL.'user_list.php');
?>