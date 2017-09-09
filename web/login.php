<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>データ共有　｜　ログイン</title>
	<meta name="description" content="">
	<meta name="keyword" content="">
	<link href="./css/bootstrap.min.css" rel="stylesheet"></link>
	<link href="./css/datasharing.css" rel="stylesheet"></link>
</head>
<body>
	<div class="page-header text-center">
  <h1>データ共有システム</h1>
</div>
<div class="container">
    <div class="panel panel-info">
      <div class="panel-body panel-bg">
        <div class="row">
          <div class="col-md-7" >
          	<div class="contaner">
          		<h1>データ共有システムとは？</h1>
          		<h3>色々な人とデータを共有するサービスです。
          		このサービスを使用することによってデータを色々なところに
          		管理することなく一元管理ができます。</h3>
          	</div>
          </div>
          <div class="col-md-5">
           <div class="panel panel-default">
			  <div class="panel-heading">
			    ログイン
			  </div>
			  <div class="panel-body">
				<form class="form-horizontal">
				  <fieldset>
					<div class="mb10"><input id="textinput" name="textinput" type="text" placeholder="Enter User Name" class="form-control input-md"></div>
					<div class="mb10"><input id="textinput2" name="textinput2" type="text" placeholder="Enter Password" class="form-control input-md"></div>
					<div class="form-check">
						<label class="form-check-label">
						  <input type="checkbox" class="form-check-input">
						  Check me out
						</label>
					</div>
					<a href="#"><small> Forgot Password?</small></a><br/>
					<button id="singlebutton" name="singlebutton" class="btn btn-info btn-sm pull-right">Sign In</button>
				  </fieldset>
				</form>
			  </div>
			</div>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- /container -->
      <div class="text-center">
      	<a href="https://px.a8.net/svt/ejp?a8mat=2NT04D+38OZCI+3IDQ+60OXD" target="_blank" rel="nofollow">
<img border="0" width="468" height="60" alt="" src="https://www21.a8.net/svt/bgt?aid=160916701196&wid=001&eno=01&mid=s00000016379001011000&mc=1"></a>
<img border="0" width="1" height="1" src="https://www16.a8.net/0.gif?a8mat=2NT04D+38OZCI+3IDQ+60OXD" alt="">
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-8521988-2', 'auto');
		  ga('send', 'pageview');
		</script>
      </div>

		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
	    	Log in
		</button>

	</div>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Log in</h4>
				</div> <!-- /.modal-header -->

				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control" id="uLogin" placeholder="Login">
								<label for="uLogin" class="input-group-addon glyphicon glyphicon-user"></label>
							</div>
						</div> <!-- /.form-group -->

						<div class="form-group">
							<div class="input-group">
								<input type="password" class="form-control" id="uPassword" placeholder="Password">
								<label for="uPassword" class="input-group-addon glyphicon glyphicon-lock"></label>
							</div> <!-- /.input-group -->
						</div> <!-- /.form-group -->

						<div class="checkbox">
							<label>
								<input type="checkbox"> Remember me
							</label>
						</div> <!-- /.checkbox -->
					</form>

				</div> <!-- /.modal-body -->

				<div class="modal-footer">
					<button class="form-control btn btn-primary">Ok</button>

					<div class="progress">
						<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;">
							<span class="sr-only">progress</span>
						</div>
					</div>
				</div> <!-- /.modal-footer -->

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/datasharing.js"></script>

</body>
</html>
