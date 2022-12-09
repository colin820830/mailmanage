<?php

require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';

if(isset($_SESSION['MailRole_id']))
{
    $MailRole_id = $_SESSION['MailRole_id'];

    $db = new Database('oracle', DB_HT_3, '1521',DB_SD_3);
	$db->initDB(DB_UR_3, DB_PD_3);

	$result_MailRole = $db->selStmt('MailRole', '*', "where id = '$MailRole_id' and IS_DELETE = 'N'", '');

    if (!empty($result_MailRole))
    {
        $permission = $result_MailRole[0][2];

        if($permission == "all")
        {
            $where = "where is_delete = 'N'";
        }
        else
        {
            $where = "where id in($permission) and is_delete = 'N'";
        }

        $result_MailOptions = $db->selStmt('MailOptions', '*', $where, 'order by Controller_name,ordernum');

    }
}

?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Colin" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow" />
    <meta name="rating" content="General" />
    <link rel="icon" type="image/png" href="images/icon.png" />

    <base target="_self" />
    <title>簡訊平台系統</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <!--引用jQuery BlockUI-->
    <script type="text/javascript" src="http://malsup.github.io/jquery.blockUI.js"></script>
    <script src="js/datepicker-zh-TW.js"></script>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
</head>
<body>
    

<header>
    <div class="mobile-nav-row">

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">簡訊平台系統</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    <!-- <li class="nav-item">
                    <a class="nav-link active" href="index.php">首頁
                        <span class="visually-hidden">(current)</span>
                    </a>
                    </li> -->


                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">範例</a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="changecard.php">替換圖片</a>
                        <a class="dropdown-item" href="manageUser.php">權限設定</a>
                        </div>
                    </li> -->

                    <?php
                        $s_menu = "";

                        if(!empty($result_MailOptions))
                        {
                            for ($i=0; $i<count($result_MailOptions); $i++) 
                            {
                                $id = $result_MailOptions[$i][0];
                                $main_option = mb_convert_encoding($result_MailOptions[$i][1], "UTF-8", "BIG5");
                                $option_name = mb_convert_encoding($result_MailOptions[$i][2], "UTF-8", "BIG5");
                                $action_name = $result_MailOptions[$i][6];

                                if($s_menu != $main_option)
                                {
                                    ?>
                                     <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?=$main_option?></a>
                                        <div class="dropdown-menu">
                                    <?php
                                }

                                ?>

                                <a class="dropdown-item" href="<?=$action_name?>.php"><?=$option_name?></a>

                                <?php

                                $s_menu = $main_option;

                                if($s_menu != $main_option)
                                {
                                    echo "</div>";
                                    echo "</li>";
                                }
                            }
                        }

                    ?>



                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">登出</a>
                    </li>

                </ul>

            </div>
        </div>
        </nav>
        
    </div>
</header>