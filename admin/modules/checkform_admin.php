<?php
require '../../config/connect.php';
if (isset($_POST['nameTheLoai'])) {
    
    $nameTL = $_POST['nameTheLoai'];
    $check_theloai = $conn->prepare("SELECT * FROM `theloaisach` WHERE tenTheLoai= '$nameTL' ");
    $check_theloai->execute();
    if ($check_theloai->rowCount() > 0) {
        echo 'false';
    } else {
        echo 'true';
    }
} elseif (isset($_POST['nameadmin'])) {
    $nameadmin = $_POST['nameadmin'];
    $nameadmin = trim($nameadmin);
    $checkNameAdmin = $conn->prepare("SELECT * FROM `admin` WHERE nameAdmin = '$nameadmin' ");
    $checkNameAdmin->execute();
    if ($checkNameAdmin->rowCount() > 0) {
        echo "false";
    } else {
        echo "true";
    }
}
?>
