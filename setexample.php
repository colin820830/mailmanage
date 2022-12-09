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

    $result_MailExample = getMailExampleArr($MailRole_id, $MailUser_id);
?>

<main>
    <div class="form-group row m-4">
        <h2>設定簡訊範本</h2>
        <br>

        <p>
            <a class="btn btn-lg btn-success btn-block" href="examplecreate.php">建立新範本</a>
        </p>

        <div class="table-responsive mb-3">

            <table class="table table-hover">
                <tbody>
                    <tr>

                        <th>
                            範本名稱
                        </th>
                        <th>
                            內容
                        </th>

                        <th>
                            更新時間
                        </th>
                        <th>
                        </th>
                        <th>
                        </th>
                    </tr>

                    <?php
                        if(!empty($result_MailExample))
                        {
                            for($i=0; $i < count($result_MailExample); $i++)
                            {
                                $id = $result_MailExample[$i][0];
                                $Example_name = mb_convert_encoding($result_MailExample[$i][1], "UTF-8", "BIG5");
                                $content = mb_convert_encoding($result_MailExample[$i][2], "UTF-8", "BIG5");

                                $Update_DT = $result_MailExample[$i][4];

                                echo "<tr>";
                                echo "<td>$Example_name</td>";
                                echo "<td>$content</td>";
                                echo "<td>$Update_DT</td>";

                                echo '
                                <td>
                                    <a href="exampleedit.php?id='. $id .'">修改</a>
                                </td>';
                                echo '
                                <td>
                                    <a href="exampledel.php?id='. $id .'" onclick="return confirm(\'確認刪除該筆資料?\')">刪除</a>
                                </td>';

                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php
    require_once 'footer.php';
?>