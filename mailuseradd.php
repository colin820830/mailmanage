<?php

header("Content-Type:text/html; charset=UTF-8");
require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';

$UserID	= isset($_REQUEST["UserID"])? $_REQUEST["UserID"] : "";
$password	= isset($_REQUEST["password"])? $_REQUEST["password"] : "";
$MailRole_id	= isset($_REQUEST["MailRole_id"])? $_REQUEST["MailRole_id"] : "";

$have_UserID = false;

$db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
$db->initDB(DB_UR_3, DB_PD_3);

$where = " where userid='$UserID' and IS_DELETE='N' ";

$result = $db->selStmt('MailUser', '*', $where, '');

if(count($result) > 0)
{
    $message = "此帳號已存在 請更換帳號";
    $have_UserID = true;
}


if($have_UserID)
{

}
else
{
    $fields = "MailRole_id, UserID, password, IS_DELETE, Update_DT";

    $values = "$MailRole_id, '$UserID', '$password', 'N', sysdate";

    $db->insStmt("MailUser", $fields, $values);

    $message = "成功新增資料!";
}

?>

<script>
		alert("<?php echo $message;?>");
		location.href = "roleset.php";
</script>