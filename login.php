<?php
	require_once('startsession.php');
	
?>

<style type="text/css">
	
	.mg-10{
		margin: 10px;
	}

</style>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>簡訊平台系統登入</title>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="login.php">簡訊平台系統登入</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

  </div>
</nav>


<div class="container mg-10">
  <form class="form-horizontal" role="form" name="login_form" id="login_form" method="post" action="login_chk.php" >
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">帳 號</label>
    <div class="col-sm-10">
      <input class="form-control" name="e_usr" id="e_usr" placeholder="請輸入帳號" required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">密 碼</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="e_pwd" id="e_pwd" placeholder="請輸入密碼" required>
    </div>
  </div>
  <div class="form-group mg-10">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="Submit"  class="btn btn-primary">登 入</button>
	  <button type="reset" name="clear" class="btn btn-primary">取 消</button>
    </div>
  </div>
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
  <p class="form-control-static text-danger">
  ( 本站建議使用瀏覽器為Google Chrome, Firefox )
	</p>
	</div>
	</div>
</form>	

</body>


<?php
	require_once('footer.php');
?>