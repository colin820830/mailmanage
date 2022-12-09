<?php

$file = fopen('1110919.csv','r'); 
// while ($data = fgetcsv($file)) { //每次讀取CSV裡面的一行內容
// //print_r($data); //此為一個數組，要獲得每一個數據，訪問陣列下標即可
// $goods_list[] = $data;
//  }

//print_r($goods_list);
// foreach ($goods_list as $arr){
//     if ($arr[0]!=""){
//         echo $arr[0]."<br>";
//         echo $arr[1]."<br>";
//     }
// } 


while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    $num = count($data);
    echo "<p> $num fields in line $row: <br /></p>\n";
    $row++;
    for ($c=0; $c < $num; $c++) {
        echo $data[$c] . "<br />\n";
    }
}


// foreach ($goods_list as $arr){

//     echo $arr[3]."<br>";
//     //echo max(array_map('count', $goods_list));
// } 

// for($i=0; $i< count($goods_list); $i++)
// {
//     echo $goods_list[2][$i]."<br>";
// }


 //echo $goods_list[2][0];
 fclose($file);



//  function get_file_line( $file_name, $line ){
//     $n = 0;
//     $handle = fopen($file_name,'r');
//     if ($handle) {
//       while (!feof($handle)) {
//           ++$n;
//           $out = fgets($handle, 4096);
//           if($line==$n) break;
//       }
//       fclose($handle);
//     }
//     if( $line==$n) return $out;
//     return false;
//   }

//   echo get_file_line("1110919.csv", 1);
?>