<?php

require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';
require_once 'header.php';
require_once 'Id_chk.php';
require_once 'getdata.php';


$MailRole_id = $_SESSION['MailRole_id'];
$MailUser_id = $_SESSION['MailUser_id'];
$UserID = $_SESSION['UserID'];

$result_MailExample = getMailExampleArr($MailRole_id, $MailUser_id);

?>

<main>
 
<div class="form-group row m-4">

<h2>簡訊發送</h2>
<br>

<form action="postmail.php" method="post" enctype="multipart/form-data">

    <div class="flexform">
        <input type="hidden" id="UserID" name="UserID" value="<?=$UserID?>">

        <div class="mb-1">
            <label for="phone_number">發送名單:</label>
        </div>

        <div class="mb-3">
            <input class="form-control" id="phone_number" name="phone_number" placeholder="多通手機以逗號分隔 ex:0975841257,0956874951" style="max-width: 500px;" type="text" value="" required>
        </div>

        <div class="mb-1">
            <label for="txtFile">上傳發送名單:</label>
        </div>

        <div class="input-group mb-3">
            <input class="form-control" id="txtFile" name="txtFile" style="max-width: 400px;" type="file" accept=".txt">
        </div>

        <div class="mb-2">
            <label class="redText">請注意上傳副檔名是否為 .txt</label>
        </div>

        <div class="mb-1">
            <label>簡訊內容</label>
        </div>

        <div class="mb-1">
            <label for="">選擇範本</label>
        </div>

        <div class="mb-1 col-md-3">
            <select class="form-select" id="ExampleSelector" name="ExampleSelector"><option value="">請選擇</option>
                <?php
                    if(!empty($result_MailExample))
                    {
                        for ($i=0; $i<count($result_MailExample); $i++) 
                        {
                            $id = $result_MailExample[$i][0];
                            $Example_name = mb_convert_encoding($result_MailExample[$i][1], "UTF-8", "BIG5");

                            echo "<option value='$id'>$Example_name</option>";
                        }
                    }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <textarea class="form-control" cols="40" data-val="true" data-val-required="content 欄位是必要項。" id="content" name="content" rows="10" style="max-width: 800px;"></textarea>
        </div>

        <div class="mb-5">
            <button class="btn btn-lg btn-success btn-block" style="margin: 0.5rem 0rem" name="Submit" id="Submit" type="Submit">確認發送</button>
        </div>
    </div>

</form>

<div>

</main>

<script type="text/javascript">

    let txtFile = document.getElementById("txtFile");

    txtFile.addEventListener("change", (e) => {
            var files = e.target.files;
            var text = $('#phone_number').val();
            if (files.length > 0) {
                var data = new FormData();
                data.append("file", files[0]);
                data.append("text", text);
                console.log(files[0]);
                console.log(data);
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "changenum.php",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    success: function (data) {
                        //alert(data);
                        document.getElementById("phone_number").value = data.num;
                    },
                    error: function () {

                    }

                });
            }
    });


    let ExampleSelector = document.getElementById("ExampleSelector");

    ExampleSelector.addEventListener("change", (e) => {

        let text = $('#ExampleSelector').val();

        var data = new FormData();
            data.append("text", text);
            console.log(data);
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'changecontent.php',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                success: function (data) {
                    document.getElementById("content").value = data.content;
                },
                error: function () {

                }

            });
    });


    $(function () {
            $("#Submit").click(function () {

                let text = $('#phone_number').val();

                if(text == "")
                {
                    return;
                }

                $.blockUI({
                    message: '<h1>簡訊寄送中...</h1>' 
                });
                //3秒後，解除BlockUI
                // setTimeout(function () {
                //     $.unblockUI(); 
                // }, 3000);

            });//end click

        });

</script>



<?php
    require_once 'footer.php';
?>