<?php
// E_NOTICE 以外の全てのエラーを表示する
error_reporting(E_ALL & ~E_NOTICE);
// 日本語文字セットを設定
header("Content-Type: text/html; charset=UTF-8");
// タイムゾーンに日本時間を設定
date_default_timezone_set('Asiz/Tokyo');

/*
 * 共通設定情報
 */
define('SERVICE_NAME', 'データ共有システム 共有君');
define('SERVICE_SHORT_NAME', '共有君');
define('COPYRIGHT', '&copy; 2017 heigogo');
define('COOKIE_PATH', '/');
define('PAGE_COUNT', 10);

// ローカル
// define('SITE_URL', 'http://localhost/datasharing/web/');
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'datasharing');
// define('DB_USER', 'root');
// define('DB_PASSWORD', 'himitu');

// 本番
define('SITE_URL', 'http://koheiji.sakura.ne.jp/datasharing/web/');
define('DB_HOST', 'mysql476.db.sakura.ne.jp');
define('DB_NAME', 'koheiji_datasharing');
define('DB_USER', 'koheiji');
define('DB_PASSWORD', 'himitu552000');

$count_page_array = array(
		"99" => "選択して下さい",
		"3" => "3件づつ表示",
		"5" => "5件づつ表示",
		"10" => "10件づつ表示",
		"20" => "20件づつ表示",
		"30" => "30件づつ表示",
		"40" => "40件づつ表示",
		"50" => "50件づつ表示",
		"60" => "60件づつ表示",
		"70" => "70件づつ表示",
		"80" => "80件づつ表示",
		"90" => "90件づつ表示",
		"100" => "100件づつ表示"
);
?>