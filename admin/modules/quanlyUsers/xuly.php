<?php
require '../../../config/connect.php';
session_start();
//inactive
if (isset($_GET['id_inac'])) {
    $id = $_GET['id_inac'];
    $sql_inactive = $conn->prepare("UPDATE `account` SET status_account = 0 WHERE idAccount = '$id'");
    if ($sql_inactive->execute()) {
        header('location: lietke_user.php');
    }
}

//active
if (isset($_GET['id_ac'])) {
    $id = $_GET['id_ac'];
    $sql_active = $conn->prepare("UPDATE `account` SET status_account = 1 WHERE idAccount = '$id'");
    if ($sql_active->execute()) {
        header('location: lietke_user.php');
    }
}

//xoa user
if (isset($_POST['XoaUser'])) {
    $idaccount = $_POST['idaccount'];
    $iduser = $_POST['iduser'];

    // Kiểm tra user có trong bảng account và xóa 
    $check_account = $conn->prepare("SELECT * FROM account WHERE idAccount='$idaccount'");
    $check_account->execute();
    if ($check_account->rowCount() > 0) {
        $sql_deleteUser = $conn->prepare("DELETE FROM account WHERE idAccount='$idaccount'");
        $sql_deleteUser->execute();
        $_SESSION['status_success'] = "Xóa người dùng thành công";
    }

    // Kiểm tra user có trong bảng comment và xóa 
    $check_comment = $conn->prepare("SELECT * FROM comment WHERE idUser='$iduser'");
    $check_comment->execute();
    if ($check_comment->rowCount() > 0) {
        $sql_deleteUser = $conn->prepare("DELETE c FROM comment c,users u WHERE u.iduser=c.idUser AND c.idUser='$iduser'");
        $sql_deleteUser->execute();
        $_SESSION['status_success'] = "Xóa người dùng thành công";
    }

    // Kiểm tra user có trong bảng yeuthich và xóa 
    $check_yeuthich = $conn->prepare("SELECT * FROM yeuthich WHERE idUser='$iduser'");
    $check_yeuthich->execute();
    if ($check_yeuthich->rowCount() > 0) {
        $sql_deleteUser = $conn->prepare("DELETE y FROM yeuthich y,users u WHERE u.iduser=y.idUser AND y.idUser='$iduser'");
        $sql_deleteUser->execute();
        $_SESSION['status_success'] = "Xóa người dùng thành công";
    }

    // Kiểm tra user có trong bảng avatar và xóa 
    $check_avatar = $conn->prepare("SELECT * FROM avatar WHERE idUser='$iduser'");
    $check_avatar->execute();
    $row_avatar = $check_avatar->fetch(PDO::FETCH_ASSOC);
    echo $row_avatar['tenHinh'];
    if ($check_avatar->rowCount() > 0) {
        $sql_deleteUser = $conn->prepare("DELETE a FROM avatar a,users u WHERE u.iduser=a.idUser AND a.idUser='$iduser'");
        $sql_deleteUser->execute();
        unlink('../../../uploads/' . $row_avatar['tenHinh']);
        $_SESSION['status_success'] = "Xóa người dùng thành công";
    }

    // Kiểm tra user có trong bảng chitietorder và xóa 
    $check_chitietorder = $conn->prepare("SELECT * FROM chitietorder c, orders o WHERE o.idOrder=c.idOrder AND o.idUser='$iduser'");
    $check_chitietorder->execute();
    if ($check_chitietorder->rowCount() > 0) {
        while ($row = $check_chitietorder->fetch(PDO::FETCH_ASSOC)) {
            if ($row['status_order'] == 2 && $row['status_order'] == 3) {
                $update_sl = $conn->prepare("UPDATE sach SET soLuong=soLuong+? WHERE idSach=?");
                $update_sl->execute([$row['slmua'], $row['idSach']]);
            }
        }
        $sql_deleteUser = $conn->prepare("DELETE c FROM chitietorder c, users u, orders o WHERE o.idUser=u.idUser AND o.idOrder=c.idOrder AND o.idUser='$iduser'");
        $sql_deleteUser->execute();
        $_SESSION['status_success'] = "Xóa người dùng thành công";
    }

    // Kiểm tra user có trong bảng orders và xóa 
    $check_orders = $conn->prepare("SELECT * FROM orders WHERE idUser='$iduser'");
    $check_orders->execute();
    if ($check_orders->rowCount() > 0) {
        $sql_deleteUser = $conn->prepare("DELETE o FROM users u, orders o WHERE o.idUser=u.idUser AND o.idUser='$iduser'");
        $sql_deleteUser->execute();
        $_SESSION['status_success'] = "Xóa người dùng thành công";
    }

    // Kiểm tra user có trong bảng dcgh và xóa 
    $check_diachigh = $conn->prepare("SELECT * FROM diachigh WHERE idUser='$iduser'");
    $check_diachigh->execute();
    if ($check_diachigh->rowCount() > 0) {
        $sql_deleteUser = $conn->prepare("DELETE d FROM users u, diachigh d WHERE u.idUser=d.idUser AND d.idUser='$iduser'");
        $sql_deleteUser->execute();
        $_SESSION['status_success'] = "Xóa người dùng thành công";
    }

    // Kiểm tra user có trong bảng users và xóa 
    $check_users = $conn->prepare("SELECT * FROM users WHERE idUser='$iduser'");
    $check_users->execute();
    if ($check_users->rowCount() > 0) {
        $sql_deleteUser = $conn->prepare("DELETE FROM users WHERE idUser='$iduser'");
        $sql_deleteUser->execute();
        $_SESSION['status_success'] = "Xóa người dùng thành công";
    }
    header('location: lietke_user.php');
}
