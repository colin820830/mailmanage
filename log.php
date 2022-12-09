<?

require_once 'adodb.inc.php';
require_once 'adodb-exceptions.inc.php';
require_once 'database.php';   //資料庫class
require_once 'config_inc.php';
require_once 'startsession.php';


class Log
{
    private $path = '/logs/'; //資料夾路徑
          
    public function write($message, $fileSalt)
    {
        $date = new DateTime(); //現在時間
        $log  = $this->path . $date->format('Y-m-d') . "-" . hash('sha512',$date->format('Y-m-d') . $fileSalt) . ".txt"; //檔案位置，使用日期與識別碼做SHA512當做檔名
        if (is_dir($this->path)) { //判斷檔案資料夾是否存在
            if (!file_exists($log)) { //判斷檔案是否存在
                $fh = fopen($log, 'a+') or die("Fatal Error !"); //建立文件
                $logcontent = "Time : " . $date->format('H:i:s') . "\r\n" . $message . "\r\n"; //要存的文字
                fwrite($fh, $logcontent); //寫入
                fclose($fh); //關閉
            } else { //如果存再，就用覆寫的方式edit()
                $this->edit($log, $date, $message);
            }
        } else { //資料夾不存在，所以建立資料夾後，再次呼叫write()
            if (mkdir($this->path, 0777) === true) {
                $this->write($message, $fileSalt);
            }
        }
    }
    private function edit($log, $date, $message)
    {
        $logcontent = "Time : " . $date->format('H:i:s') . "\r\n" . $message . "\r\n\r\n"; //要記錄得文字
        $logcontent = $logcontent . file_get_contents($log);//添加在最前面
        file_put_contents($log, $logcontent); //上傳
    }

    
}

?>