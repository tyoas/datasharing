<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | データリスト</title>
	<meta name="description" content="">
	<meta name="keyword" content="">
	<link href="./css/bootstrap.min.css" rel="stylesheet"></link>
	<link href="./css/datasharing.css" rel="stylesheet"></link>
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
	            <li><a href="./user_list.php">ユーザー管理</a></li>
	            <li><a href="./log.php">操作ログ</a></li>
	            <li><a href="logout.php">ログアウト</a></li>
	        </ul>
	        <!-- 4.ボタン -->
	        <button type="button" class="btn btn-default navbar-btn">
	            <span class="glyphicon glyphicon-envelope"></span>
	        </button>
	    </div>
	</nav>

	<div class="container">
		<h1>データリスト</h1>
		<form action="#">
			<div class="form-group">
				<input type="text" name="calam1" placeholder="カラム1を入力して下さい" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="calam2" placeholder="カラム2を入力して下さい" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="calam3" placeholder="カラム3を入力して下さい" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="calam4" placeholder="カラム4を入力して下さい" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="calam5" placeholder="カラム5を入力して下さい" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="calam6" placeholder="カラム6を入力して下さい" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="calam7" placeholder="カラム7を入力して下さい" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="calam8" placeholder="カラム8を入力して下さい" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="calam9" placeholder="カラム9を入力して下さい" class="form-control">
			</div>
			<div class="form-group">
				<input type="text" name="calam10" placeholder="カラム10を入力して下さい" class="form-control">
			</div>
			<input type="submit" value="登録" class="btn btn-primary btn-block">
		</form>

	</div>

	<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>
</body>
</html>