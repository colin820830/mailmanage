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

//$upfile = iconv("UTF-8", "big5", $upfile );

$upfile = mb_convert_encoding($upfile, "BIG5", "UTF-8");

//$upfile = mb_convert_encoding($upfile, "UTF-8", "BIG5");

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

            // $file = fopen($upfile , "r") or die("檔案無法開啟");
            // while ($data = fgetcsv($file)) { //每次讀取CSV裡面的一行內容
            // //print_r($data); //此為一個數組，要獲得每一個數據，訪問陣列下標即可
            // $goods_list[] = $data;
            // }

            $upfile = mb_convert_encoding($upfile, "UTF-8", "BIG5");
            // $text.= $goods_list[2][0]."  ";
            // $text.= $goods_list[1][1]."  ";
            // $text.= $goods_list[2][2]."  ";

            $file = fopen($upfile,'r'); 
            // while ($data = fgetcsv($file)) 
            // { 
            //     //每次讀取CSV裡面的一行內容
            //     //print_r($data); //此為一個數組，要獲得每一個數據，訪問陣列下標即可
            //     $goods_list[] = $data;
            // }
            // //$text.= $goods_list[3][0]."  ";

            // foreach ($goods_list as $arr){

            //     $text.= $arr[0]."  ";
                
            // } 

            // fclose($file);

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($data);
                // echo "<p> $num fields in line $row: <br /></p>\n";
                // $row++;
                for ($c=0; $c < $num; $c++) {
                    $text.= $data[$c] . ",";
                }
            }

            //$text.= $upfile;
        }
} 


echo json_encode(array('text' => $text));
exit;

?>