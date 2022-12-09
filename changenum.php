<?php

header('Content-Type: application/json');

$file	= isset($_REQUEST["file"])? $_REQUEST["file"] : "";
$text	= isset($_REQUEST["text"])? $_REQUEST["text"] : "";

$path = "upLoadFile/";
define("FILE_SRC", $path . $_FILES["file"]["name"]);

if (!file_exists($path))
{
    mkdir($path);	//建立資料夾
}

// $obj = dir($path);	// 建立物件
// $obj->rewind();		// 重設handle	
$upfile = $path . $_FILES["file"]["name"];

$upfile = iconv("UTF-8", "big5", $upfile );

//echo $_FILES["file"]["tmp_name"];

if (is_uploaded_file($_FILES["file"]["tmp_name"]))
{
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $upfile))
        {
            echo "<script>alert('上傳檔案失敗！請檢查！');";
            // echo "history.back()</script>";
        }
        else
        {
            $fp = fopen($upfile , "r") or die("檔案無法開啟");

            $num = $text;

            if($num != "")
            {
                $num =  $num.",";
            }

            while (($data = fgets($fp)))	//逐行讀取
            {
                $num.=$data.",";
            }

            $num = substr($num,0,-1);
        }
} 


echo json_encode(array('num' => $num));
exit;

?>