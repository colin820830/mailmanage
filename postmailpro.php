<?php


header("Content-Type:text/html; charset=UTF-8");
require_once 'config_inc.php';
require_once 'startsession.php';
require_once 'function.php';


$content = isset($_REQUEST["content"])? $_REQUEST["content"] : "";
$UserID	= isset($_REQUEST["UserID"])? $_REQUEST["UserID"] : "";


$path = "upLoadFile/";
define("FILE_SRC", $path . $_FILES["file"]["name"]);

if (!file_exists($path))
{
    mkdir($path);	//建立資料夾
}


$upfile = $path . $_FILES["file"]["name"];

//$ori_upfile = $upfile;

$upfile = mb_convert_encoding($upfile, "BIG5", "UTF-8");


if (is_uploaded_file($_FILES["file"]["tmp_name"]))
{
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $upfile))
        {
            echo "<script>alert('上傳檔案失敗！請檢查！');";
        }
        else
        {

            $file = fopen($upfile,'r'); 


            //取第一列 中文標頭
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $first[] = $data;

                break;
            }


            $content_replace = $content;

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($data);

                $content = $content_replace;

                for ($c=0; $c < $num; $c++) {
                    $replace = mb_convert_encoding($first[0][$c], "UTF-8", "BIG5");

                    $replace = "%".$replace."%";

                    $rd = mb_convert_encoding($data[$c], "UTF-8", "BIG5");
                    //echo $rd . "<br />\n";

                    $content = str_replace($replace,$rd,$content);
                }

                $num = $data[0];
                //電話數字處理
                $num = str_replace('-','',$data[0]);

                $sendNum = substr($num,1);

                //echo $num. "<br />\n";

                //echo $content;

                curl_mail($sendNum, $content, $UserID);
            }

            $message = "寄送簡訊成功!";
        }
} 


?>

<script>
alert("<?php echo $message;?>");
location.href = "sendmaillogbyacc.php";

</script>