<?php

header("Content-Type:text/html; charset=UTF-8");
require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';

$Example_name	= isset($_REQUEST["Example_name"])? $_REQUEST["Example_name"] : "";
$content	= isset($_REQUEST["content"])? $_REQUEST["content"] : "";

$db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
$db->initDB(DB_UR_3, DB_PD_3);

$Example_name = mb_convert_encoding($Example_name, "BIG5", "UTF-8");
$content = mb_convert_encoding($content, "BIG5", "UTF-8");

$MailUser_id = $_SESSION['MailUser_id'];

$fields = "MailUser_id, Example_name, content, IS_DELETE, Update_DT";

$values = "$MailUser_id, '$Example_name', '$content', 'N', sysdate";

$db->insStmt("MailExample", $fields, $values);

$message = "成功新增資料!";

?>

<script>
		alert("<?php echo $message;?>");
		location.href = "setexample.php";
</script>