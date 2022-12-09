<?php

require_once 'config_inc.php';
require_once 'startsession.php';
require_once 'header.php';
require_once 'Id_chk.php';


?>

<main>
    <div class="form-group row m-4">
        <h2>建立新簡訊範本</h2>
        <br>

        <form action="exampleadd.php" method="post">
            <div class="mb-1">
                <label for="Example_name">範本名稱：</label>
            </div>

            <div class="mb-3">
                <input class="form-control" id="Example_name" name="Example_name" style="max-width: 500px;" type="text" value="" required>
            </div>


            <div class="mb-1">
                <label>範本內容：</label>
            </div>
            <div class="mb-3">
                <textarea class="form-control" cols="40" id="content" name="content" rows="10" style="max-width: 800px;" required></textarea>
            </div>

            <div class="mb-5">
                <button class="btn btn-lg btn-success btn-block" style="margin: 0.5rem 0rem" name="Submit" type="Submit">確認新增</button>
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