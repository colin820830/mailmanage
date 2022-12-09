<?php

require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';
require_once 'header.php';
require_once 'Id_chk.php';
require_once 'getdata.php';

$id	= isset($_REQUEST["id"])? $_REQUEST["id"] : "";

$MailExample_arr = getMailExampleById($id);

$Example_name = mb_convert_encoding($MailExample_arr[0][1], "UTF-8", "BIG5");
$content = mb_convert_encoding($MailExample_arr[0][2], "UTF-8", "BIG5");

?>

<main>
    <div class="form-group row m-4">
        <h2>修改簡訊範本</h2>
        <br>

        <form action="exampleupdate.php" method="post">
            <input type="hidden" id="MailExampleId" name="MailExampleId" value="<?=$id?>" >

            <div class="mb-1">
                <label for="Example_name">範本名稱：</label>
            </div>

            <div class="mb-3">
                <input class="form-control" id="Example_name" name="Example_name" style="max-width: 500px;" type="text" value="<?=$Example_name?>" required>
            </div>


            <div class="mb-1">
                <label>範本內容：</label>
            </div>
            <div class="mb-3">
                <textarea class="form-control" cols="40" id="content" name="content" rows="10" style="max-width: 800px;" required><?=$content?></textarea>
            </div>

            <div class="mb-5">
                <button class="btn btn-lg btn-success btn-block" style="margin: 0.5rem 0rem" name="Submit" type="Submit">確認修改</button>
            </div>
        </form>

        <div>
            <a href="setexample.php">回到設定簡訊範本</a>
        </div>
    </div>
</main>

<?php
    require_once 'footer.php';
?>