<?php

header("Content-Type:text/html; charset=UTF-8");
require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';

$id	= isset($_REQUEST["id"])? $_REQUEST["id"] : "";

$db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
$db->initDB(DB_UR_3, DB_PD_3);


$where =' where IS_DELETE = \'N\' and id = \''. $id .'\'';	

$fields = " IS_DELETE = 'Y', Update_DT = sysdate";

$db->updStmt("MailExample", $fields, $where);

$message = "成功刪除資料!";

?>

<script>
		alert("<?php echo $message;?>");
		location.href = "setexample.php";
</script>