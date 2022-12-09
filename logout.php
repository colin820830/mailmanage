<?php
require_once 'header.php';
require_once 'startsession.php';

$old_user= (!isset($_SESSION['userid'])?'':$_SESSION['userid']);

unset($_SESSION['userid']);
unset($_SESSION['oname']);
unset($_SESSION['level']);

session_unset();
//session_destroy();

if (empty($old_user)) echo "你沒有登入,所以不需登出";
	
?>

<script>
	document.location = "login.php";
</script>