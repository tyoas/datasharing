<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有 | データ登録</title>
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
		<h1>データ登録</h1>
		<br><br>
		<div class="row">

			<div class="col-md-12">
				<div class="input-group">
				    <label class="input-group-btn">
				        <span class="btn btn-primary">
				            ファイル添付<input type="file" style="display:none">
				        </span>
				    </label>
				    <input type="text" class="form-control" readonly="">
				</div>
			</div>


		</div>
		<br>
		<div class="row">
			<div class="col-md-12"><input type="checkbox">一行目をヘッダ行として処理する。</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12"><input type="submit" value="実行" class="btn btn-success btn-block"></div>
		</div>
	</div>

	<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
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