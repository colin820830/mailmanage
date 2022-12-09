<?php

    $today = date('Y-m-d-H-i-s');
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=SendMailLog" . $today .".xls");

    require_once 'adodb.inc.php';
    require_once 'adodb-exceptions.inc.php';
    require_once 'database.php';   //資料庫class
    require_once 'config_inc.php';
    require_once 'startsession.php';

    error_reporting(E_ALL);
    ini_set('display_errors', false);
    ini_set('html_errors', false);	


    $startDate = isset($_REQUEST["startDate"])? $_REQUEST["startDate"] : "";
    $endDate = isset($_REQUEST["endDate"])? $_REQUEST["endDate"] : "";


    $db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
    $db->initDB(DB_UR_3, DB_PD_3);

    $where = " where to_char(Create_DT,'YYYYMMDD') >= '$startDate'  and to_char(Create_DT,'YYYYMMDD') <= '$endDate' ";

    $field = "DESTADDRESS, SMSBODY, EmployeeId, to_char(Create_DT,'yyyy/mm/dd hh24:mi:ss')Create_DT";

    $result = $db->selStmt('TMMMSLog', $field, $where, 'order by id');
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Colin" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="index, follow" />
        <meta name="rating" content="General" />

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>
        <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
        <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>


        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />

    </head>

    <body>

    <table border="1">
                <tbody>
                    <tr>
                        <th>
                            帳號
                        </th>
                        <th>
                            寄送號碼
                        </th>
                        <th>
                            內容
                        </th>
                        <th>
                            寄出時間
                        </th>
                    </tr>

                    <?php
                        if(!empty($result))
                        {
                            for($i=0; $i < count($result); $i++)
                            {
                                //$DESTADDRESS = $result[$i][0];
                                $DESTADDRESS = substr($result[$i][0],3);
                                $SMSBODY = mb_convert_encoding($result[$i][1], "UTF-8", "BIG5");
                                $EmployeeId = $result[$i][2];

                                $Create_DT = $result[$i][3];

                                echo "<tr>";
                                echo "<td>$EmployeeId</td>";
                                echo "<td>$DESTADDRESS</td>";
                                echo "<td>$SMSBODY</td>";
                                echo "<td>$Create_DT</td>";
                                echo "</tr>";
                            }
                        }
                    ?>

                </tbody>
            </table>
    </body>
</html>