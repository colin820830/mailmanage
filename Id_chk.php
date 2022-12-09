<?

	if(empty($_SESSION['UserID']))
	{
		print('<script type="text/javascript">alert("請先登入 !");</script>');				
		print('<script type="text/javascript">location.href = "login.php";</script>');
	}

?>