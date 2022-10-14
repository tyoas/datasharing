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

 		// 静的プレースホルダを指定(カラム名をDBの名前をプレースホルダーとして利用しない)
//  		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 		// エラー発生時に例外を投げる
 		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 		//トランザクション分離レベル設定
 		$pdo->exec("SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED;");

 		return $pdo;
 	} catch (PDOException $e) {
 		echo $e->getMessage();
 		exit;
 	}
 }
 // XSS(クロスサイト・スクリプティング)対策(入力されたスクリプトを無効にする)
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
	$temphtml = '<select class="form-control" name="' . $inputName . '">' . "\n";

	foreach ($srcArray as $key => $val) {
		if ($selectedIndex == $key) {
			$selectedText = ' selected="selected"';
		} else {
			$selectedText = '';
		}
		$temphtml .= '<option value="' . $key . '"' . $selectedText . '>' . $val . '</option>' . "\n";
	}
	$temphtml .= '</select>' . "\n";
	return $temphtml;
}
// ログインメニュ要プルダウン
function arrayToSelectLogin($inputName, $srcArray) {
	$temphtml = '<select class="form-control" name="' . $inputName . '">' . "\n";

	foreach ($srcArray as $value) {
		$temphtml .= '<option value="' . $value['id'] . '"' . '>' . $value['user_name'] . '</option>' . "\n";
	}
	$temphtml .= '</select>' . "\n";
	return $temphtml;
}
// CSV形式でファイルを保存
function downLoadCsv($array_data) {
	$flag = false;
// 	$file = "c:\\tmp\\test.csv";
	$folder = "c:\\tmp";
	if (mkdir($folder, 0777)){
		echo '作成できました。';
	} else {
		echo "作成に失敗しました";
	}
	// ファイルを書き込み用に開ける
	$f = fopen("c:\\tmp\\test.csv", "w");
	// 正常にファイルを開くことができていれば、書き込みます。
	if ($f) {
		$flag = true;
		// $ary から順番に配列を呼び出して書き込みます。
		foreach ($array_data as $key => $value) {
			// fputcsv関数でファイルに書き込みます。
			foreach ($value as $line) {
				var_dump($line);
				exit;
				fputcsv($f, $value);
			}
		}
	}
	fclose($f);
	return $f;
}
// CSV形式でファイルを保存
function downLoadCsv2($array_data) {
	// 出力情報の設定
// 	header("Content-Type: application/octet-stream");
// 	header("Content-Disposition: attachment; filename=sample.csv");
// 	header("Content-Transfer-Encoding: binary");
	$filename = 'sample.csv';
// 	1行目のラベルを作成
	$csv = '"ID","カラム１","カラム２","カラム３","カラム４","カラム５","カラム６","カラム７","カラム８","カラム９","カラム１０","作成日","作成日２","更新日","更新日２"' . "\n";

	foreach ($array_data as $data) {
// 		$csv .= '"' . $data['id'] . '","' . $data['column1'] . '","' . $data['column2'] . '","' . $data['column3'] . '","' . $data['column4'] . '","' . $data['column5'] . '","' . $data['column6'] . '","' . $data['column7'] . '","' . $data['column8'] . '","' . $data['column9'] . '","' . $data['column10'] . '","' . $data['created_at'] . '","' . $data['created_by'] . '","' . $data['updated_at'] . '","' . $data['updated_by'] . '","' . "\n";
		$csv .= str_replace(',', '","',$data['id']) . ',';
		$csv .= str_replace(',', '","',$data['column1']) .',';
		$csv .= str_replace(',', '","',$data['column2']) .',';
		$csv .= str_replace(',', '","',$data['column3']) .',';
		$csv .= str_replace(',', '","',$data['column4']) .',';
		$csv .= str_replace(',', '","',$data['column5']) .',';
		$csv .= str_replace(',', '","',$data['column6']) .',';
		$csv .= str_replace(',', '","',$data['column7']) .',';
		$csv .= str_replace(',', '","',$data['column8']) .',';
		$csv .= str_replace(',', '","',$data['column9']) .',';
		$csv .= str_replace(',', '","',$data['column10']) .',';
		$csv .= $data['created_at'] .',';
		$csv .= $data['created_by'] .',';
		$csv .= $data['updated_at'] .',';
		$csv .= $data['updated_by'];
		$csv .= "\n";
	}
	$csv = trim($csv);

	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$filename");
	header("Content-Transfer-Encoding: binary");
	echo mb_convert_encoding($csv,"SJIS", "UTF-8");
}
// 操作履歴のデータ検索のログを保存する
function sousa_kensaku($pdo, $user_id) {
	$transaction_type = 'データ検索';
	$sql = "insert into transaction (user_id, transaction_type, created_at) values(:user_id, :transaction_type, now())";
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$smtp->bindValue(':transaction_type', $transaction_type, PDO::PARAM_STR);
	$smtp->execute();
}
// 操作履歴の新規データ登録のログを保存する
function sousa_touroku($pdo, $user_id) {
	$transaction_type = 'データ新規登録';
	$sql = "insert into transaction (user_id, transaction_type, created_at) values(:user_id, :transaction_type, now())";
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$smtp->bindValue(':transaction_type', $transaction_type, PDO::PARAM_STR);
	$smtp->execute();
}
// 操作履歴の一括データ登録のログを保存する
function sousa_ikkatu($pdo, $user_id) {
	$transaction_type = '一括登録';
	$sql = "insert into transaction (user_id, transaction_type, created_at) values (:user_id, :transaction_type, now())";
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$smtp->bindValue(':transaction_type', $transaction_type, PDO::PARAM_STR);
	$smtp->execute();
}
// 操作履歴のデータダウンロードを保存する
function sousa_download($pdo, $user_id) {
	$transaction_type = 'データダウンロード';
	$sql = "insert into transaction (user_id, transaction_type, created_at) values (:user_id, :transaction_type, now())";
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$smtp->bindValue(':transaction_type', $transaction_type, PDO::PARAM_STR);
	$smtp->execute();
}
// 操作履歴のデータ編集を保存する
function sousa_dataedit($pdo, $user_id) {
	$transaction_type = 'データ編集';
	$sql = "insert into transaction (user_id, transaction_type, created_at) values (:user_id, :transaction_type, now())";
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$smtp->bindValue(':transaction_type', $transaction_type, PDO::PARAM_STR);
	$smtp->execute();
}
// 操作履歴のデータ削除を保存する
function sousa_datadelete($pdo, $user_id) {
	$transaction_type = 'データ削除';
	$sql = "insert into transaction (user_id, transaction_type, created_at) values (:user_id, :transaction_type, now())";
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$smtp->bindValue(':transaction_type', $transaction_type, PDO::PARAM_STR);
	$smtp->execute();
}
// 操作履歴のユーザ登録を保存する
function sousa_useradd($pdo, $user_id) {
	$transaction_type = 'ユーザ登録';
	$sql = 'insert into transaction (user_id, transaction_type, created_at) values (:user_id, :transaction_type, now())';
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$smtp->bindValue(':transaction_type', $transaction_type, PDO::PARAM_STR);
	$smtp->execute();
}
// 操作履歴のユーザ編集を保存する
function sousa_useredit($pdo, $user_id) {
	$transaction_type = 'ユーザ編集';
	$sql = 'insert into transaction (user_id, transaction_type, created_at) values (:user_id, :transaction_type, now())';
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$smtp->bindValue(':transaction_type', $transaction_type, PDO::PARAM_STR);
	$smtp->execute();
}
// 操作履歴のユーザ削除を保存する
function sousa_userdelete($pdo, $user_id) {
	$transaction_type = 'ユーザ削除';
	$sql = 'insert into transaction (user_id, transaction_type, created_at) values (:user_id, :transaction_type, now())';
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$smtp->bindValue(':transaction_type', $transaction_type, PDO::PARAM_STR);
	$smtp->execute();
}
// ソートカラム判定フラグ
function ascdesc_flag($order) {
	if ($order == 'asc') {
		return 'desc';
	} elseif ($order == 'desc') {
		return 'asc';
	}
}
/*
 * 検索系関数
 */
// ログインでのユーザー取得
function user_select_all($pdo) {
	$sql = 'select * from user';
	$smtp = $pdo->prepare($sql);
	$smtp->execute();
	$result = $smtp->fetchAll();
	return $result;
}
// ユーザー確認
// function select_User($pdo, $id, $user_pass) {
// 	$sql = 'select * from user where id = :id and  user_password = :user_pass limit 1';
// 	$smtp = $pdo->prepare($sql);
// 	$smtp->bindValue(':id', $id, PDO::PARAM_INT);
// 	$smtp->bindValue(':user_pass', password_hash($user_pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
// 	$smtp->execute();
// 	$result = $smtp->fetch();
// 	return $result;
// }
function select_User($pdo, $id) {
	$sql = 'select * from user where id = :id limit 1';
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':id', $id, PDO::PARAM_INT);
	$smtp->execute();
	$result = $smtp->fetch();
	return $result;
}
// 自動ログインキーをDBに照合
function getAutoLoginkey($pdo, $c_key) {
	// 自動ログインキーをDBに照合
	$sql = "SELECT * FROM auto_login WHERE c_key = :c_key AND expire >= :expire LIMIT 1";
	$stmt = $pdo->prepare($sql);
// 	$stmt->execute(array(":c_key" => $c_key, ":expire" => date('Y:m:d H:i:s')));
	$stmt->bindValue(':c_key', $c_key, PDO::PARAM_STR);
	$stmt->bindValue(':expire', date('Y:m:d H:i:s'), PDO::PARAM_STR);
	$row = $stmt->fetch();
	return $row;
}
// 自動ログインの照合確認
function getUserbyUserId($pdo, $id) {
	// 自動照合データがあるか参照
	$sql = "select * from auto_login where id = :id limit 1";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':id', $id, PDO::PARAM_STR);
	return $stmt->fetch();
}
// 編集画面のユーザー情報取得
function getUser($pdo, $id) {
	$sql = 'select * from user where id = :id limit 1';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	$val = $stmt->fetch();
	return $val;
}
// 全件アイテム取得
function getItemList($pdo, $page, $count_page) {
	$offset = $count_page * ($page -1);
	$count_page = intval($count_page);
	$sql = 'select * from item limit :offset, :count';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->bindValue(':count', $count_page, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchall();
}
// ソート時アイテム取得
function getSortItemList($pdo, $page, $count_page, $o, $s, $q) {
	$offset = $count_page * ($page -1);
	$count_page = intval($count_page);
	// ホワイトリストの準備（カラム）
	$sort_whitelist = array('column1' => 'column1',
							'column2' => 'column2',
							'column3' => 'column3',
							'column4' => 'column4',
							'column5' => 'column5',
							'column6' => 'column6',
							'column7' => 'column7',
							'column8' => 'column8',
							'column9' => 'column9',
							'column10' => 'column10'
						);
	// ホワイトリスト準備（オーダー）
	$order_whitelist = array('asc' => 'asc', 'desc' => 'desc');

	// パラメーターをホワイトリストと照合
	$sort_safe = isset($sort_whitelist[$s]) ? $sort_whitelist[$s] : $sort_whitelist['column1'];
	$order_safe = isset($order_whitelist[$o]) ? $order_whitelist[$o] : $order_whitelist['asc'];

	$sql = "select * from item where
			column1 like :q or
			column2 like :q or
			column3 like :q or
			column4 like :q or
			column5 like :q or
			column6 like :q or
			column7 like :q or
			column8 like :q or
			column9 like :q or
			column10 like :q
			order by column$o $s limit :offset, :count";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->bindValue(':count', $count_page, PDO::PARAM_INT);
	$stmt->bindValue(':q', '%'.$q.'%', PDO::PARAM_STR);
	// $stmt->debugDumpParams();
	$stmt->execute();

	return $stmt->fetchAll();
}
// 編集アイテム情報を取得
function getItem($pdo, $id) {
	$sql = 'select * from item where id = :id limit 1';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetch();
}
// index.phpの検索情報取得
function getSelectItemList($pdo, $search_query, $page, $count_page) {
// 	$offset = PAGE_COUNT * ($page -1);
	$count_page = intval($count_page);
	$offset = $count_page * ($page -1);
	$sql = "select * from item where
			column1 like :q or
			column2 like :q or
			column3 like :q or
			column4 like :q or
			column5 like :q or
			column6 like :q or
			column7 like :q or
			column8 like :q or
			column9 like :q or
			column10 like :q
			limit :offset, :count";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':q', '%' . $search_query . '%', PDO::PARAM_STR);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->bindValue(':count', $count_page, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchall();
}
// 総ページ数取得
function page_count($pdo, $serch_query) {
	$sql = "select count(*) from item where
			column1 like :q or
			column2 like :q or
			column3 like :q or
			column4 like :q or
			column5 like :q or
			column6 like :q or
			column7 like :q or
			column8 like :q or
			column9 like :q or
			column10 like :q";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':q', '%'.$serch_query.'%', PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetchColumn();
}
// ダウンロード用アイテム取得
function getItemDownload($pdo, $q) {
	$sql = 'select * from item where
			column1 like :q or
			column2 like :q or
			column3 like :q or
			column4 like :q or
			column5 like :q or
			column6 like :q or
			column7 like :q or
			column8 like :q or
			column9 like :q or
			column10 like :q';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':q', '%'.$q.'%', PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetchAll();
}
// 操作ログの履歴取得
function sousa_rireki($pdo, $page, $count_page) {
	$offset = $count_page * ($page - 1);
	$count_page = intval($count_page);
	$sql = 'select * from transaction order by created_at desc limit :offset, :count';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->bindValue(':count', $count_page, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchAll();
}
// 操作履歴をカウントする
function sousa_count($pdo) {
	$sql = 'select count(*) from transaction';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}
// 操作ログの履歴に関するユーザー取得
function sousa_user($pdo, $log_user){
	$sql = 'select * from user where id = :user_id limit 1';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':user_id', $log_user, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch();
}
// ユーザー数をカウントする
function users_count($pdo) {
	$sql = 'select count(*) from user';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}
// ページ情報取得
function users_page($pdo, $page, $count_page) {
// 	$offset = PAGE_COUNT * ($page -1);
	$offset = $count_page * ($page -1);
	$count_page = intval($count_page);
	$sql = 'select * from user limit :offset, :count';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
// 	$stmt->bindValue(':count', PAGE_COUNT, PDO::PARAM_INT);
	$stmt->bindValue(':count', $count_page, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchall();
}
// 開発履歴情報取得
function version_history($pdo, $page, $count_page) {
	$offset = $count_page * ($page -1);
	$count_page = intVal($count_page);
	$sql = 'select * from version_history order by version_no ASC limit ?, ?';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $offset, PDO::PARAM_INT);
	$stmt->bindValue(2, $count_page, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchall();
}
// 開発履歴更新
function history_update($pdo, $id, $no, $historhy) {
	$sql = 'update version_history set version_no = ?, change_history = ?, created_at = now(), updated_at = now() where id = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $no, PDO::PARAM_INT);
	$stmt->bindValue(2, $historhy, PDO::PARAM_STR);
	$stmt->bindValue(3, $id, PDO::PARAM_INT);
	$stmt->execute();
}
// 開発履歴変更情報取得
function history_edit($pdo, $id) {
	$sql = 'select * from version_history where id = ? limit 1';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $id, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetch();
}
function history_count($pdo) {
	$sql = 'select count(*) from version_history';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}
/*
 * 登録系関数
 */
// 新規ユーザー登録
function user_add($pdo, $user_name, $user_pass, $user_kengen) {
	$sql = 'insert into user (user_name, user_password, user_auth, created_at) values (:user_name, :user_pass, :user_kengen, now())';
	$smtp = $pdo->prepare($sql);
	$smtp->bindValue(':user_name', $user_name, PDO::PARAM_STR);
	$smtp->bindValue(':user_pass', password_hash($user_pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
	$smtp->bindValue(':user_kengen', $user_kengen, PDO::PARAM_INT);
	$smtp->execute();
}
// 自動ログインキー登録
function set_AutoLoginkey($pdo, $id, $auto_login_key) {
	// DB登録処理
	$sql = "INSERT INTO auto_login (user_id, c_key, expire, created_at, updated_at)
            VALUES (:user_id, :c_key, :expire, now(), now())";
	$stmt = $pdo->prepare($sql);
// 	$params = array(":user_id" => $user['id'], ":c_key" => $auto_login_key, ":expire" => date('Y-m-d H:i:s', time()+3600*24*365));
	$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
	$stmt->bindValue(':c_key', $auto_login_key, PDO::PARAM_STR);
	$stmt->bindValue(':expire', date('Y-m-d H:i:s', time()+3600*24*365), PDO::PARAM_STR);
	$stmt->execute();
}
// データ登録
function data_add($pdo,$add_data) {
	$sql = 'insert into item (column1, column2, column3, column4, column5,
			column6, column7, column8, column9, column10, created_at)
			values (:column1, :column2, :column3, :column4, :column5,
			:column6, :column7, :column8, :column9, :column10, now())';
	$stmt = $pdo->prepare($sql);
	foreach ($add_data as $key => $value) {
		switch ($key) {
			case 'column1':
				$stmt->bindValue(':column1', $value, PDO::PARAM_STR);
			case 'column2':
				$stmt->bindValue(':column2', $value, PDO::PARAM_STR);
			case 'column3':
				$stmt->bindValue(':column3', $value, PDO::PARAM_STR);
			case 'column4':
				$stmt->bindValue(':column4', $value, PDO::PARAM_STR);
			case 'column5':
				$stmt->bindValue(':column5', $value, PDO::PARAM_STR);
			case 'column6':
				$stmt->bindValue(':column6', $value, PDO::PARAM_STR);
			case 'column7':
				$stmt->bindValue(':column7', $value, PDO::PARAM_STR);
			case 'column8':
				$stmt->bindValue(':column8', $value, PDO::PARAM_STR);
			case 'column9':
				$stmt->bindValue(':column9', $value, PDO::PARAM_STR);
			case 'column10':
				$stmt->bindValue(':column10', $value, PDO::PARAM_STR);
		}
	}
	$stmt->execute();
}
// 一括登録
function data_addall($pdo, $asins) {
	$flag = true;
	$sql = 'insert into item (column1, column2, column3, column4, column5,
								column6, column7, column8, column9, column10)
						values (:column1, :column2, :column3, :column4, :column5,
								:column6, :column7, :column8, :column9, :column10)';
	$stmt = $pdo->prepare($sql);
	//トランザクション処理を開始
// 	$pdo->beginTransaction();
	foreach ($asins as $key1 => $value1) {
// 		echo "--".$key1. "--<br />\n";
		foreach ($value1 as $key2 => $value2) {
// 			echo $key2. "：" .$value2."<br />\n";
			switch ($key2) {
				case 0:
					$stmt->bindValue('column1', $value2, PDO::PARAM_STR);
					break;
				case 1:
					$stmt->bindValue('column2', $value2, PDO::PARAM_STR);
					break;
				case 2:
					$stmt->bindValue('column3', $value2, PDO::PARAM_STR);
					break;
				case 3:
					$stmt->bindValue('column4', $value2, PDO::PARAM_STR);
					break;
				case 4:
					$stmt->bindValue('column5', $value2, PDO::PARAM_STR);
					break;
				case 5:
					$stmt->bindValue('column6', $value2, PDO::PARAM_STR);
					break;
				case 6:
					$stmt->bindValue('column7', $value2, PDO::PARAM_STR);
					break;
				case 7:
					$stmt->bindValue('column8', $value2, PDO::PARAM_STR);
					break;
				case 8:
					$stmt->bindValue('column9', $value2, PDO::PARAM_STR);
					break;
				case 9:
					$stmt->bindValue('column10', $value2, PDO::PARAM_STR);
					break;
				default:
					$flag = false;
			}
		}
		$stmt->execute();
	}
	return $flag;
}
// バージョンアップ履歴の登録
function create_history($pdo, $version_history, $change_history) {
	$sql = 'insert into version_history (version_no, change_history, created_at)
			values (?,?,now())';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $version_history, PDO::PARAM_STR);
	$stmt->bindValue(2, $change_history, PDO::PARAM_STR);
	$stmt->execute();
}
/*
 * 更新系関数
 */
// 編集画面ユーザー情報更新
function edit_user($pdo, $id, $user_name, $user_pass = '', $user_auth) {
	$sql = 'update user set user_name = :user_name, user_auth = :user_auth,';
	if ($user_pass != '') {
		$sql .= ' user_password = :user_password, ';
	}
	$sql .= ' updated_at = now() where id = :id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
	$stmt->bindValue(':user_auth', $user_auth, PDO::PARAM_INT);
	if ($user_pass != '') {
		$stmt->bindValue(':user_password', password_hash($user_pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
	}
	$stmt->execute();
}
// アイテム情報の更新
function updateItem($pdo,$item_data, $id) {
	$sql = 'update item set
			column1 = :column1,
			column2 = :column2,
			column3 = :column3,
			column4 = :column4,
			column5 = :column5,
			column6 = :column6,
			column7 = :column7,
			column8 = :column8,
			column9 = :column9,
			column10 = :column10
			where id = :id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':column1', $item_data['column1'], PDO::PARAM_STR);
	$stmt->bindValue(':column2', $item_data['column2'], PDO::PARAM_STR);
	$stmt->bindValue(':column3', $item_data['column3'], PDO::PARAM_STR);
	$stmt->bindValue(':column4', $item_data['column4'], PDO::PARAM_STR);
	$stmt->bindValue(':column5', $item_data['column5'], PDO::PARAM_STR);
	$stmt->bindValue(':column6', $item_data['column6'], PDO::PARAM_STR);
	$stmt->bindValue(':column7', $item_data['column7'], PDO::PARAM_STR);
	$stmt->bindValue(':column8', $item_data['column8'], PDO::PARAM_STR);
	$stmt->bindValue(':column9', $item_data['column9'], PDO::PARAM_STR);
	$stmt->bindValue(':column10', $item_data['column10'], PDO::PARAM_STR);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
}
// バージョン履歴更新
function update_history($pdo, $version_history, $change_history) {
	$sql = 'update version_history set version_no = ?, change_history = ?, updated_at = now() where id = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $version_history, PDO::PARAM_STR);

}
// 設定情報登録
function insert_setting($pdo, $user_id, $count_page) {
	$sql = 'update user set count_page = ? where id = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $count_page, PDO::PARAM_INT);
	$stmt->bindValue(2, $user_id, PDO::PARAM_INT);
	$stmt->execute();
}
/*
 * 削除系関数
 */
 // クッキー情報削除
 function delete_AutoLoginkey($pdo, $auto_login_key) {
 	$sql = "DELETE FROM auto_login WHERE c_key = :c_key";
 	$stmt = $pdo->prepare($sql);
//  	$stmt->execute(array(":c_key" => $auto_login_key));
 	$stmt->bindValue(':c_key' , $auto_login_key, PDO::PARAM_STR);
 	$stmt->execute();
 }
 // ユーザー削除
 function delete_user($pdo, $id) {
 	$sql = 'delete from user where id = :id';
 	$stmt = $pdo->prepare($sql);
 	$stmt->bindValue(':id', $id, PDO::PARAM_STR);
 	$stmt->execute();
 }
// アイテム削除
function deleteItem($pdo, $id) {
	$sql = 'delete from item where id = :id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
}
// ソート機能
function sortItem($sort, $order, $arrayItem) {
	if ($order == 'asc') {
		// code...

	} elseif ($order == 'desc') {
		// code...
	}
}
//  ソート機能
function sortItemSample($pdo, $page, $count_page) {
	$offset = $count_page * ($page -1);
	$count_page = intval($count_page);
	$sql = 'select * from item limit :offset, :count';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->bindValue(':count', $count_page, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchall();
}

// ソート機能のページ表示数
function sortPages($view, $pages){
	$view = 5;
	$current=filter_input(INPUT_GET,"page",FILTER_VALIDATE_INT,
["options"=>["default"=>1,"min_range"=>1,"max_range"=>$pages]
]);

	/*$viewが偶数のときは左寄り*/
	$offset_left=(int) (($view-1)/2);
	$offset_right=$view - $offset_left -1;

	$pos_start=$current - $offset_left;
	$pos_end=$current + $offset_right;

	if($current-$offset_left<1){
	  $pos_start=1;
	  $pos_end=$pos_start+($view<$pages?$view:$pages)-1;
	}elseif($current+$offset_right>$pages){
	  $pos_end=$pages;
	  $pos_start=$pages-($view<$pages?$view:$pages)+1;
	}
	print "<ul class='pagination pagination-lg'>";
	if($current>1){print "<li><a href='?page=".($current-1)."&q="."'><span aria-hidden='true'>&lt;&lt;</span></a></li>";}
	for($i=$pos_start;$i<=$pos_end;$i++){
	  if($i==$current){
		print "<li class='active'><a href=#>" . $i ."</a></li>";
	  }else{
	    // print "<a href=\"?p=$i\">$i</a> ";
		print "<li><a href=?page=".$i.">".$i."</a></li>";
	  }
	}
	// if($current<$pages){print "<a href=\"?page=".($current+1)."\">next</a> ";}
	if($current<$pages){print "<li><a href='?page=".($current+1)."' aria-label='次のページへ'><span aria-hidden='true'>&gt;&gt;</span></a></li>";}
}

// ソート機能のページ表示数
function sortPages2($view, $pages, $q = ''){
	$view = 5;
	$current=filter_input(INPUT_GET,"page",FILTER_VALIDATE_INT,
["options"=>["default"=>1,"min_range"=>1,"max_range"=>$pages]
]);

	/*$viewが偶数のときは左寄り*/
	$offset_left=(int) (($view-1)/2);
	$offset_right=$view - $offset_left -1;

	$pos_start=$current - $offset_left;
	$pos_end=$current + $offset_right;

	if($current-$offset_left<1){
	  $pos_start=1;
	  $pos_end=$pos_start+($view<$pages?$view:$pages)-1;
	}elseif($current+$offset_right>$pages){
	  $pos_end=$pages;
	  $pos_start=$pages-($view<$pages?$view:$pages)+1;
	}
	print "<ul class='pagination pagination-lg'>";
	if($current>1){
		if($q == ''){
			print "<li><a href='?page=".($current-1) . "'><span aria-hidden='true'>&lt;&lt;</span></a></li>";
		} else {
			print "<li><a href='?page=".($current-1) . "&q=" .$q. "'><span aria-hidden='true'>&lt;&lt;</span></a></li>";
		}
	}
	for($i=$pos_start;$i<=$pos_end;$i++){
	  if($i==$current){
		print "<li class='active'><a href=#>" . $i ."</a></li>";
	  }else{
		if ($q == '') {
		  	print "<li><a href=?page=".$i.">".$i."</a></li>";
		} else {
			print "<li><a href=?page=".$i."&q=".$q.">".$i."</a></li>";
		}
	  }
	}
	// if($current<$pages){print "<a href=\"?page=".($current+1)."\">next</a> ";}
	if($current<$pages){
		if ($q == '') {
			print "<li><a href='?page=".($current+1)."' aria-label='次のページへ'><span aria-hidden='true'>&gt;&gt;</span></a></li>";
		} else {
			print "<li><a href='?page=".($current+1)."&q=".$q."' aria-label='次のページへ'><span aria-hidden='true'>&gt;&gt;</span></a></li>";
		}
	}
}
?>
