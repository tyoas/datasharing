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

		<div class="row">
			<div class="col-md-8">
				<form>
					<div class="input-group">
						<input type="text" name="serche" placeholder="検索する値を入力して下さい" class="form-control">
						<span class="input-group-btn">
							<input type="submit" value="検索" class="btn btn-primary">
						</span>
					</div>
				</form>
			</div>
			<div class="col-md-2">
				<a href="./item_create.php" class="btn btn-success">新規登録</a>
			</div>
			<div class="col-md-2">
				<form>
					<a href="./item_createall.php" class="btn btn-danger">データ一括登録</a>
				</form>
			</div>
		</div>

		<br /><br />

		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr>
						<th>カラム1</th>
						<th>カラム2</th>
						<th>カラム3</th>
						<th>カラム4</th>
						<th>カラム5</th>
						<th>カラム6</th>
						<th>カラム7</th>
						<th>カラム8</th>
						<th>カラム9</th>
						<th>カラム10</th>
						<th></th>
					</tr>
					<tr>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td><a href="#">[変更]</a> <a href="#">[削除]</a></td>
					</tr>
					<tr>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td><a href="#">[変更]</a> <a href="#">[削除]</a></td>
					</tr>
					<tr>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td>XXXXXX</td>
						<td><a href="#">[変更]</a> <a href="#">[削除]</a></td>
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
			<div class="col-md-6">
				<form>
					<input type="submit" value="データダウンロード" class="btn btn-warning btn-block">
				</form>
			</div>
		</div>

	</div>

	<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/datasharing.js"></script>
</body>
</html>