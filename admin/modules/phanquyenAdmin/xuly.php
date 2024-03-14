<?php
require '../../../config/connect.php';
session_start();
if (isset($_POST['addAdmin'])) { //thêm admin

    $nameadmin = $_POST['nameadmin'];
    $pass = $_POST['pass'];
    $insert_admin = $conn->prepare("INSERT INTO `admin`(nameAdmin,passAdmin) VALUES('$nameadmin','$pass')");
    if ($insert_admin->execute()) {
        $_SESSION['status_success'] = "Thêm thành công admin mới";
        header('location: lietke_admin.php');
    }
} else if (isset($_GET['idadmin'])) { //xóa admin
    $idadmin = $_GET['idadmin'];
    $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE idAdmin = '$idadmin'");
    if ($delete_admin->execute()) {
        $_SESSION['status_success'] = "Xóa thành công admin";
        header('location: lietke_admin.php');
    }
} else if (isset($_POST['UpdateAdmin'])) {// cập nhập admin
    $idadmin = $_POST['idadmin'];
    $nameadmin = $_POST['nameadmin_up'];
    $pass = $_POST['pass_up'];
    // echo $idadmin;
    // echo $nameadmin;
    // echo $pass;
    if ($nameadmin == '' || $pass == '') {
        $_SESSION['status_warning'] = "Không được để trống";
        header('location: lietke_admin.php');
    } else {
        $check_admin = $conn->prepare("SELECT * FROM `admin` WHERE nameAdmin = '$nameadmin'");
        $check_admin->execute();
        if ($check_admin->rowCount() > 0) {
            $_SESSION['status_warning'] = "Tên này đã được sử dụng";
            header('location: lietke_admin.php');
        } else {
            $update_admin = $conn->prepare("UPDATE `admin` SET `nameAdmin` = '$nameadmin', passAdmin='$pass' WHERE idAdmin='$idadmin'");
            if ($update_admin->execute()) {
                $_SESSION['status_success'] = "Cập nhập thành công";
                header('location: lietke_admin.php');
            }
        }
    }
}
