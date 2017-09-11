<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | ユーザー一覧</title>
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
	            <li><a href="./index.php">データリスト</a></li>
	            <li class="active"><a href="./user_list.php">ユーザー管理</a></li>
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

		<div class="row">
			<div class="col-md-6">
				<h1>ユーザー一覧</h1>
			</div>
			<div class="col-md-6">
				<a href="./user_create.php" class="btn btn-primary">新規登録</a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr><th>ユーザー名</th><th>権限</th><th>登録日時</th><th></th></tr>
					<tr>
						<td>XXX</td><td>一般</td><td>YYYY/MM/DD H:M:S</td><td><a href="./user_edit.php">[変更] </a><a href="#">[削除]</a></td>
					</tr>
					<tr>
						<td>XXX</td><td>管理</td><td>YYYY/MM/DD H:M:S</td><td><a href="./user_edit.php">[変更] </a><a href="#">[削除]</a></td>
					</tr>
					<tr>
						<td>XXX</td><td>一般</td><td>YYYY/MM/DD H:M:S</td><td><a href="./user_edit.php">[変更] </a><a href="#">[削除]</a></td>
					</tr>
					<tr>
						<td>XXX</td><td>一般</td><td>YYYY/MM/DD H:M:S</td><td><a href="./user_edit.php">[変更] </a><a href="#">[削除]</a></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<nav>
					<ul class="pagination pagination-lg">
						<li>
							<a href="#" aria-label="前のページへ">
								<span aria-hidden="true">«</span>
							</a>
						</li>
						<li><a href="#">1</a></li>
						<li class="active"><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
							<a href="#" aria-label="次のページへ">
								<span aria-hidden="true">»</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>

	</div>

	<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>

</body>