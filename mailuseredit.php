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

$result_MailRole = getMailRoleArr();

$result = getMailUserById($id);

$password = $result[0][3];

$MailRole_id = $result[0][1];

?>

<main>
    <div class="form-group row m-4">
        <h2>修改密碼及權限</h2>
        <br>

        <form action="mailuseradd.php" method="post">
            <!-- <div class="mb-1">
                <label for="UserID">帳號</label>
            </div>

            <div class="mb-3">
                <input class="form-control" id="UserID" name="UserID" style="max-width: 500px;" type="text" value="" required>
            </div> -->

            <div class="mb-1">
                <label for="password">密碼</label>
            </div>
            <div class="mb-3">
                <input class="form-control" id="password" name="password" style="max-width: 500px;" type="text" value="<?=$password?>" required>
            </div>

            <div class="mb-1">
                <label for="password">角色</label>
            </div>

            <div class="mb-3 col-md-3">
                <select class="form-select" id="MailRole_id" name="MailRole_id">
                    <?php
                        if(!empty($result_MailRole))
                        {
                            for ($i=0; $i<count($result_MailRole); $i++) 
                            {
                                $id = $result_MailRole[$i][0];
                                $Role_name = mb_convert_encoding($result_MailRole[$i][1], "UTF-8", "BIG5");

                                $selected = "";

                                if($id == $MailRole_id )
                                {
                                    $selected = " selected='selected' ";
                                }

                                echo "<option value='$id' $selected>$Role_name</option>";
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="mb-5">
                <button class="btn btn-lg btn-success btn-block" style="margin: 0.5rem 0rem" name="Submit" type="Submit">確認修改</button>
            </div>
        </form>

        <div>
            <a href="roleset.php">回到角色權限列表</a>
        </div>
    </div>
</main>


<?php
    require_once 'footer.php';
?>