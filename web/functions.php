<?php
/*
 * その他関数
 */
 // データベースに接続
 function connectDb() {
 	$param = "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST;

 	try {
 		$pdo = new PDO($param, DB_USER, DB_PASSWORD);
 		$pdo->query('SET NAMES utf8;');
 		return $pdo;
 	} catch (PDOException $e) {
 		echo $e->getMessage();
 		exit;
 	}
 }
 // 特殊な HTML エンティティを文字に戻す
 function h($original_str) {
 	return htmlspecialchars($original_str, ENT_QUOTES, "UTF-8");
 }
// トークン発行処理
function setToken() {
	$token = sha1(uniqid(mt_rand(), true));
	$_SESSION['sstoken'] = $token;
}
// トークンをチェックする処理
function checkToken() {
	if (empty($_SESSION['sstoken']) || ($_SESSION['sstoken'] != $_POST['token'])) {
		echo '<html><head><meta charset="utf-8"></head><body>不正なアクセスです</body></html>';
		exit;
	}
}
// 配列からプルダウンメニューを作成
function arrayToSelect($inputName, $srcArray, $selectedIndex = "") {
	$temphtml = '<select class="form-control name="' . $inputName . '">' . "\n";

	foreach ($selectedIndex as $key => $val) {
		if ($selectedIndex == $key) {
			$selectedText = ' select="selected"';
		} else {
			$selectedText = '';
		}
		$temphtml .= '<option value="' . $key . '"' . $selectedText . '>' . $val . '</option>' . "\n";
	}
	$temphtml .= '</select>' . "\n";
	return $temphtml;
}
/*
 * 検索系関数
 */

/*
 * 登録系関数
 */

/*
 * 更新系関数
 */

/*
 * 削除系関数
 */
?>