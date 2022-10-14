<?php
require_once('config.php');
require_once('functions.php');
require_once('lib/password.php');

session_start();

// データベースに接続する（PDOを使う）
$pdo = connectDb();

// 値取得
$login_user = user_select_all($pdo);
$all_user = array();

foreach ($login_user as $val) {
	$all_user[] = array('id' => $val['id'], 'user_name' => $val['user_name']);
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 初めて画面にアクセスした時の処理

    if (isset($_COOKIE['DATASHARING'])) {
        // 自動ログイン情報があればキーを取得
        $auto_login_key = $_COOKIE['DATASHARING'];

        // 自動ログインキーをDBに照合
        $row = getAutoLoginkey($pdo, $auto_login_key);

        if ($row) {
            // 照合成功、自動ログイン
            $user = getUserbyUserId($row['user_id'], $pdo);

            if ($user) {
                // セッションハイジャック対策
                session_regenerate_id(true);
                $_SESSION['USER'] = $user;

                // HOME画面に遷移する。
                unset($pdo);
                header('Location:'.SITE_URL.'index.php');
                exit;
            }
        }
    }

    // CSRF対策(トークンのセット)
    setToken();

} else {
    // フォームからサブミットされた時の処理

    // CSRF対策(トークンのチェック)
    checkToken();

    // メールアドレス、パスワードを受け取り、変数に入れる。
    $user_password = $_POST['user_password'];
    $user_name = $_POST['user_name'];
    $auto_login = $_POST['auto_login'];

    // 入力チェックを行う。
    $err = array();

    // [パスワード]未入力チェック
    if ($user_password == '') {
        $err['user_password'] = 'パスワードを入力して下さい。';
    } else {
    	$user_token = getUser($pdo, $user_name);
    	if (!password_verify($user_password, $user_token['user_password'])) {
    		$err['user_password'] = 'パスワードが正しくありません。';
    	}
    }

    // もし$err配列に何もエラーメッセージが保存されていなかったら
    if (empty($err)) {
		// セッションハイジャック対策
        session_regenerate_id(true);

        // ユーザー情報取得
//         $user = select_User($pdo, $user_name, $user_password, $user_token['password']);
		$user = select_User($pdo, $user_name);

        // ログインに成功したのでセッションにユーザデータを保存する。
        $_SESSION['USER'] = $user;

        // 自動ログイン情報を一度クリアする。
        if (isset($_COOKIE['DATASHARING'])) {
            $auto_login_key = $_COOKIE['DATASHARING'];

            // Cookie情報をクリア
            setcookie('DATASHARING', '', time()-86400, COOKIE_PATH);

            // DB情報をクリア
            delete_AutoLoginkey($pdo, $auto_login_key);
        }


        // チェックボックスにチェックが入っていた場合
        if ($auto_login) {

            // 自動ログインキーを生成
            $auto_login_key = sha1(uniqid(mt_rand(), true));

            // Cookie登録処理
            setcookie('DATASHARING', $auto_login_key, time()+3600*24*365, COOKIE_PATH);
            // DB登録処理
            set_AutoLoginkey($pdo, $id, $auto_login_key);
        }

        // HOME画面に遷移する。
        unset($pdo);
        header('Location:'.SITE_URL.'index.php');
        exit;
    }

    unset($pdo);
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
	<title>データ共有 | データリスト</title>
	<meta name="description" content="">
	<meta name="keyword" content="">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/datasharing.css" rel="stylesheet">
</head>

<body id="main">

    <div class="navbar navbar-default">
        <div class="navbar-inner">
            <div class="container">
                <a class="navbar-brand" href="<?php echo SITE_URL; ?>"><?php echo SERVICE_SHORT_NAME; ?></a>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="row">

            <div class="col-md-9">
                <div class="jumbotron">
                    <h1>データ共有システム</h1>
                    <p>社員同士でデータを共有できるシステム</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="sidebar-nav panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">ログイン</h2>
                    </div>
                    <div class="panel-body">
                        <form method="POST" >
                        	<div class="form-group <?php if ($err['user_name'] != '') echo 'has-error'; ?>">
                                <label>ユーザ名</label>
                                <?php echo arrayToSelectLogin("user_name", $all_user); ?>
                                <span class="help-block"><?php echo h($err['user_name']); ?></span>
                            </div>
                            <div class="form-group <?php if ($err['user_password'] != '') echo 'has-error'; ?>">
                                <label>パスワード</label>
                                <input type="password" class="form-control" name="user_password" value="" placeholder="パスワード" />
                                <span class="help-block"><?php echo h($err['user_password']); ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="ログイン" class="btn btn-primary btn-block">
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="auto_login" value="1"> 次回から自動でログイン</label>
                            </div>
                            <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']); ?>" />
                        </form>
                    </div>
                </div>
            </div><!--/col-md-3-->

        </div><!--/row-->

        <hr>
        <footer class="footer">
            <p><?php echo COPYRIGHT; ?></p>
        </footer>
    </div><!--/.container-->

<!--     <script src="http://code.jquery.com/jquery.js"></script> -->
	<!--[if lte IE8]>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
	< ![endif]-->
	<!--[if gte IE 9]>
	<script src="js/jquery-3.1.1.min.js"></script>
	< ![endif]-->
    <script src="js/bootstrap.js"></script>
	<script src="js/datasharing.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</body>
</html>