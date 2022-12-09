<?php

require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';

function getMailExampleArr($MailRole_id, $MailUser_id)
{ 
    $db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
    $db->initDB(DB_UR_3, DB_PD_3);

    if($MailRole_id == 1)
    {
        $where = " where IS_DELETE = 'N' ";
    }
    else
    {
        $where = " where MailUser_id = $MailUser_id and IS_DELETE = 'N' ";
    }

    $result_MailExample = $db->selStmt('MailExample', '*', $where, 'order by Update_DT');
    
    return $result_MailExample;
}

function getMailExampleById($id)
{
    $db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
    $db->initDB(DB_UR_3, DB_PD_3);

    $where = " where id = $id ";

    $result = $db->selStmt('MailExample', '*', $where, '');

    return $result;
}

function getMailRoleArr()
{ 
    $db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
    $db->initDB(DB_UR_3, DB_PD_3);

    $where = " where IS_DELETE='N' ";
    
    $result = $db->selStmt('MailRole', '*', $where, 'order by id');
    
    return $result;
}

function getMailUserById($id)
{
    $db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
    $db->initDB(DB_UR_3, DB_PD_3);

    $where = " where id = $id ";

    $result = $db->selStmt('MailUser', '*', $where, '');

    return $result;
}


?>