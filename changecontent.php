<?php
    require_once 'adodb.inc.php';
    require_once 'adodb-exceptions.inc.php';
    require_once 'database.php';   //資料庫class
    require_once 'config_inc.php';
    require_once 'startsession.php';

    header('Content-Type: application/json');

    $text	= isset($_REQUEST["text"])? $_REQUEST["text"] : "";

    $db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
	$db->initDB(DB_UR_3, DB_PD_3);

	$result = $db->selStmt('MailExample', '*', "where id = $text and IS_DELETE = 'N'", '');

    $content = mb_convert_encoding($result[0][2], "UTF-8", "BIG5");

    echo json_encode(array('content' => $content));
    exit;
?>