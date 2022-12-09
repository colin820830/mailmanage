<?php

header("Content-Type:text/html; charset=UTF-8");
require_once 'config_inc.php';
require_once 'startsession.php';
require_once 'function.php';

$phone_number	= isset($_REQUEST["phone_number"])? $_REQUEST["phone_number"] : "";
$content	= isset($_REQUEST["content"])? $_REQUEST["content"] : "";

$UserID	= isset($_REQUEST["UserID"])? $_REQUEST["UserID"] : "";

$phone_number_arr = explode(",", $phone_number);

// $UserID = $_SESSION['UserID'];

$i = 0;
while($i<count($phone_number_arr)){

	$sendNum = substr($phone_number_arr[$i],1);

	curl_mail($sendNum, $content, $UserID);

    $i++;
}

	// header("Content-Type:text/html; charset=big5");
	// $ch = curl_init();
	// curl_setopt($ch, CURLOPT_URL, "http://172.24.1.229:8080/TMMMSapi/WebApi/Send/Get?DestAddress=886972196434&SmsBody=測試輸入一段文字&Dept=FW0000&User=YF120787900");
	// curl_setopt($ch, CURLOPT_HEADER, false);
	// //curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// $re = curl_exec($ch);
	// curl_close($ch);
	// echo "[start]";
	// echo $re;
	// echo "[end]";

    $message = "寄送簡訊成功!";
?>


<script>
alert("<?php echo $message;?>");
location.href = "sendmaillogbyacc.php";

</script>