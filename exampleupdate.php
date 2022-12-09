<?php

header("Content-Type:text/html; charset=UTF-8");
require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';

$MailExampleId	= isset($_REQUEST["MailExampleId"])? $_REQUEST["MailExampleId"] : "";
$Example_name	= isset($_REQUEST["Example_name"])? $_REQUEST["Example_name"] : "";
$content	= isset($_REQUEST["content"])? $_REQUEST["content"] : "";

$db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
$db->initDB(DB_UR_3, DB_PD_3);

$Example_name = mb_convert_encoding($Example_name, "BIG5", "UTF-8");
$content = mb_convert_encoding($content, "BIG5", "UTF-8");


$where =' where IS_DELETE = \'N\' and id = \''. $MailExampleId .'\'';	

$fields = " Example_name = '$Example_name', content = '$content', Update_DT = sysdate";

$db->updStmt("MailExample", $fields, $where);

$message = "成功修改資料!";

?>

<script>
		alert("<?php echo $message;?>");
		location.href = "setexample.php";
</script>