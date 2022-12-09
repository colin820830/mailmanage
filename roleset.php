<?php
    require_once 'adodb.inc.php';
    require_once 'adodb-exceptions.inc.php';
    require_once 'database.php';   //資料庫class
    require_once 'config_inc.php';
    require_once 'startsession.php';
    require_once 'header.php';
    require_once 'Id_chk.php';
    require_once 'getdata.php';


    $db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
    $db->initDB(DB_UR_3, DB_PD_3);

    $where = " where m1.IS_DELETE = 'N' and m1.mailrole_id = m2.id(+) ";

    $fields = "m1.userid, m1.password, m1.update_dt, m2.role_name, m1.id";

    $result = $db->selStmt('MailUser m1, MailRole m2', $fields, $where, 'order by update_dt desc');

?>

<main>
    <div class="form-group row m-4">
        <h2>角色權限列表</h2>
        <br>

        <p>
            <a class="btn btn-lg btn-success btn-block" href="mailusercreate.php">建立新帳號</a>
        </p>

        <div class="table-responsive mb-3">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>
                            帳號
                        </th>
                        <th>
                            密碼
                        </th>
                        <th>
                            角色
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
                        if(!empty($result))
                        {
                            for($i=0; $i < count($result); $i++)
                            {
                                $userid = $result[$i][0];
                                $password = $result[$i][1];
                                $update_dt = $result[$i][2];
                                $role_name = mb_convert_encoding($result[$i][3], "UTF-8", "BIG5");

                                $id = $result[$i][4];


                                echo "<tr>";
                                echo "<td>$userid</td>";
                                echo "<td>$password</td>";
                                echo "<td>$role_name</td>";
                                echo "<td>$update_dt</td>";

                                echo '
                                <td>
                                    <a href="mailuseredit.php?id='. $id .'">修改</a>
                                </td>';
                                echo '
                                <td>
                                    <a href="mailuserdel.php?id='. $id .'" onclick="return confirm(\'確認刪除該筆資料?\')">刪除</a>
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