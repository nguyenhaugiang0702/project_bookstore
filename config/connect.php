<?php
$servername = "localhost";
$dbuser = "root";
$dbname="db_sach";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbuser, $password);
    //echo "Connected successfully";
} catch(PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
}



?>

<?php

//time ago single.php:-comment
// class getdatetimediff{
//     public static function getdatetimediff($date){
//         $now_time = strtotime(date('Y-m-d H:i:s'));
//         $diff_timestamp = $now_time - strtotime($date);
//         if($diff_timestamp < 60){
//             echo 'Một vài giây trước';
//         }else if($diff_timestamp > 60  && $diff_timestamp < 3600){
//             echo round($diff_timestamp/60).' phút trước';
//         }else if($diff_timestamp >= 3600 && $diff_timestamp < 86400){
//             echo round($diff_timestamp/3600).' giờ trước';
//         }else if($diff_timestamp >= 86400 && $diff_timestamp < 86400*30){
//             echo round($diff_timestamp/86400).' ngày trước';
//         }else if($diff_timestamp >= 86400*30 && $diff_timestamp < 86400*365){
//             echo round($diff_timestamp/86400*30).' tháng trước';
//         }else{
//             echo round($diff_timestamp/86400*365).' năm trước';
//         }
//     }
// }
// ?>