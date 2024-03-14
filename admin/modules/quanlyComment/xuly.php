<?php
require '../../../config/connect.php';
session_start();
// update comment
if (isset($_POST['update_cmt'])) {
    $idcmt = $_POST['id'];
    $noidung = $_POST['contentCmt'];
    $sql = $conn->prepare("UPDATE comment SET content='$noidung' , timeUpdateCmt = current_timestamp WHERE idCmt='$idcmt'");
    if ($sql->execute()) {
        $_SESSION['status_success'] = "Cập nhập comment thành công";
        header('location: lietke_cmt.php');
    }
}
// update comment

// xóa comment 
if (isset($_GET['idcmt'])) {
    $idcmt = $_GET['idcmt'];
    $sql = $conn->prepare("DELETE FROM `comment` WHERE idCmt='$idcmt'");
    $sql->execute();
    if ($sql->execute()) {
        $_SESSION['status_success'] = "Xóa comment thành công";
        header('location: lietke_cmt.php');
    }
}
    // xóa comment 
