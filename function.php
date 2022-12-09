<?php

require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';

function curl_mail($sendNum, $content, $UserID)
{ 
    $searchString = " ";
    $replaceString = "";

    $content = str_replace($searchString, $replaceString, $content); 
    
    $sendUrl = feturl . "?DestAddress=886$sendNum&SmsBody=$content&Dept=FW0000&User=$UserID";

    //echo $sendUrl. "<br />\n";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $sendUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $re = curl_exec($ch);
    curl_close($ch);

}


?>