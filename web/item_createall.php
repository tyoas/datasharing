<?php
// 共通ファイルの読み込み
require_once './config.php';
require_once './functions.php';

ini_set("display_errors", 1);
error_reporting(E_ALL);

//一括登録時の時間制限延長設定
set_time_limit(10000);

// セッション開始
session_start();

// ユーザーセッションの確認
if (!isset($_SESSION['USER'])) {
	header('Location:'.SITE_URL.'login.php');
	exit;
}

$user = $_SESSION['USER'];

// 値を格納
$filename = '';
$asins = array();
$err = array();
$err_msg = '';

// Windows用
$file_tmp_dir = "C:\\data/uploaded/";
// freeBSD用
// $file_tmp_dir = "/home/koheiji/www/datasharing/web/tmp/";
// $file_tmp_dir = "/home/koheiji//tmp/";

// DB接続
$pdo = connectDb();

// リクエスト判定
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 初期表示画面



	// セットトークン(CSRL対策)
// 	setToken();
} else {
	// フォームからサブミットされる

	// チェックトークン(CSRL対策)
// 	checkToken();

	// チェック
	$hcheck = isset($_POST['hcheck']) ? $_POST['hcheck'] : '';

	if (is_uploaded_file($_FILES["csvfile"]["tmp_name"])) {
		$file_tmp_name = $_FILES["csvfile"]["tmp_name"];
		$detect_order = 'ASCII,JIS,UTF-8,CP51932,SJIS-win';
		setlocale(LC_ALL, 'ja_JP.UTF-8');
		/* 文字コードを変換してファイルを置換 */
		$buffer = file_get_contents($file_tmp_name);
		$file_name = $_FILES["csvfile"]["name"];

		if (!$encoding = mb_detect_encoding($buffer, $detect_order, true)) {
			// 文字コードの自動判定に失敗
			unset($buffer);
			throw new RuntimeException('Character set detection failed');
		}
		file_put_contents($file_tmp_name, mb_convert_encoding($buffer, 'UTF-8', $encoding));
		unset($buffer);

		//拡張子を判定
		if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv') {
			$err_msg = 'CSVファイルのみ対応しています。';
		} else {
			//ファイルをdataディレクトリに移動
			if (move_uploaded_file($file_tmp_name, $file_tmp_dir . $file_name)) {
				//後で削除できるように権限を644に
				chmod($file_tmp_dir . $file_name, 0644);
				$msg = $file_name . "をアップロードしました。";
				$file = $file_tmp_dir.$file_name;
				$fp   = fopen($file, "r");
				$count = 0;

				//配列に変換する
				while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
					if ($hcheck == 'on' && $count == 0) {
						$count = 1;
					} else {
						$asins[] = $data;
					}
				}
				fclose($fp);
				//ファイルの削除
				unlink($file_tmp_dir.$file_name);
			} else {
				$err_msg = "ファイルをアップロードできません。";
			}
		}
	} else {
		$err_msg = "ファイルが選択されていません。";
	}

	try {
		$comp_flag = data_addall($pdo, $asins);
	} catch (Exception $e) {
		throw $e;
	}


	if (isset($err_msg)) {

	}elseif ($comp_flag) {
		// 成功メッセージを代入
		$com_msg = 'ファイルのアップロードが完了しました！';
		//コミット
// 		$pdo->commit();
		// 操作履歴のログを保存
		sousa_ikkatu($pdo, $user['id']);
	} else {
		// エラーメッセージを代入
		$err_msg = 'ファイルのアップロードで失敗しました。<br />項目数を合わせて下さい。';
		// ロールバック
		$pdo->rollback();
	}
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | データ登録</title>
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
		<?php if (isset($com_msg)) echo "<div class='alert alert-success' role='alert'>" .$com_msg."</div>"; ?>
		<h1>データ登録</h1>
		<br><br>

		<form method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-12">
					<div class="input-group <?php if ($err_msg) echo 'has-error'; ?>">
					    <label class="input-group-btn">
					        <span class="btn btn-primary">
					            ファイル添付<input type="file" style="display:none" name="csvfile" accept="text/csv">
					        </span>
					    </label>
					    <input type="text" class="form-control" readonly="">
					</div>
					<span class="help-block"><?php echo $err_msg; ?></span>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12"><input type="checkbox" name="hcheck">一行目をヘッダ行として処理する。</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12"><input type="submit" value="実行" class="btn btn-success btn-block"></div>
			</div>
		</form>
	</div>

	<!--[if lte IE8]>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
	< ![endif]-->
	<!--[if gte IE 9]><!-->
	<script src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>
	<script type="text/javascript">
	$(document).on('change', ':file', function() {
	    var input = $(this),
	    numFiles = input.get(0).files ? input.get(0).files.length : 1,
	    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	    input.parent().parent().next(':text').val(label);
	});
	</script>
</body>
</html>
