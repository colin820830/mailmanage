<?php
    require_once 'startsession.php';
    require_once 'header.php';
    require_once 'Id_chk.php';


    $startDate = isset($_REQUEST["startDate"])? $_REQUEST["startDate"] : "";
    $endDate = isset($_REQUEST["endDate"])? $_REQUEST["endDate"] : "";

    $UserID = $_SESSION['UserID'];

    if(empty($startDate))
    {
        $startDate=date('Ym01', strtotime(date("Y-m-d")));
    }

    if(empty($endDate))
    {
        $endDate =  date('Ymd', strtotime("$startDate +1 month -1 day"));
    }

    $db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
    $db->initDB(DB_UR_3, DB_PD_3);

    $where = " where to_char(Create_DT,'YYYYMMDD') >= '$startDate'  and to_char(Create_DT,'YYYYMMDD') <= '$endDate'  and employeeid = '$UserID'";

    $field = "DESTADDRESS, SMSBODY, EmployeeId, to_char(Create_DT,'yyyy/mm/dd hh24:mi:ss')Create_DT";

    $result = $db->selStmt('TMMMSLog', $field, $where, 'order by id');

?>



<main>
    <div class="form-group row m-4">
        <h2>個人簡訊寄送紀錄</h2>

        <form action="sendmaillogbyacc.php" method="post">
            <div class="mb-1">
                <label for="startDate">統計區間：</label>
            </div>

            <div class="mb-6 row">
                
                <div class="col-md-3">
                    <input class="form-control datepicker" id="startDate" name="startDate" style="max-width: 300px; " type="text" value="<?=$startDate?>">
                </div>

                <div class="col-md-auto">
                    <label for="endDate" style="font-size:25px">~</label>
                </div>

                <div class="col-md-3">
                    <input class="form-control datepicker" id="endDate" name="endDate" style="max-width: 300px;" type="text" value="<?=$endDate?>">
                </div>
            </div>

            <div class="form-group row m-2">

                <div class="col-md-auto">
                    <button class="btn btn btn-success" style="font-size:1.25rem" name="Submit" type="Submit">查詢</button>
                </div>

                <!-- <div class="col-md-auto">
                    <button type="button" class="btn btn-success" style="font-size:1.25rem" onclick= "download_excel()" >下載 excel</button>
                </div> -->
            </div>
        </form>

        <div class="form-group row m-2">
            <h4>總筆數:<?=count($result)?></h4>
        </div>

        <div class="table-responsive mb-3">
            <table class="table table-hover table-bordered" id="MyTable">
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
                                $DESTADDRESS = $result[$i][0];
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
        </div>
    </div>
</main>

<script>

    $( function() {
    $( ".datepicker" ).datepicker({
                dateFormat: "yymmdd",
                // lang: 'ch',
            });
    } );


    function download_excel()
    {
        let startDate = document.getElementById('startDate').value;

        let endDate = document.getElementById('endDate').value;

        
        window.location = "sendmaillog_excel.php?startDate=" + startDate + "&endDate=" + endDate; //原視窗開啟

    }  


</script>

<?php
    require_once 'footer.php';
?>