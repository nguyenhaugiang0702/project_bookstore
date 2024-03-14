<?php
require '../../../config/connect.php';
session_start();

//xác nhận đơn hàng
if (isset($_GET['idxn'])) {
    $id = $_GET['idxn'];
    $sql_accepted = $conn->prepare("UPDATE `orders` SET status_order = 2, timeOrderUpdate=current_timestamp WHERE idOrder = '$id'");
    if ($sql_accepted->execute()) {
        $sql_chitietorder = $conn->prepare("SELECT * FROM `chitietorder` WHERE idOrder = '$id' ");
        $sql_chitietorder->execute();
        while ($row_chitietorder = $sql_chitietorder->fetch(PDO::FETCH_ASSOC)) {
            $slmua = $row_chitietorder['slmua'];
            $idsach = $row_chitietorder['idSach'];
            $sql_update_sl = $conn->prepare("UPDATE `sach` SET soLuong=soLuong-$slmua WHERE idSach='$idsach'");
            if ($sql_update_sl->execute()) {
                $_SESSION['status_success'] = "cập nhập số lượng thành công";
            }
        }
        header('location: lietke_donhang.php');
    }
}

//vận chuyển đơn hàng
if (isset($_GET['idvc'])) {
    $id = $_GET['idvc'];
    $sql_vanchuyen = $conn->prepare("UPDATE `orders` SET status_order = 3, timeOrderUpdate=current_timestamp WHERE idOrder = '$id'");
    $sql_vanchuyen->execute();
            header('location: lietke_donhang.php');

}

//Đã giao hàng
if (isset($_GET['iddgh'])) {
    $id = $_GET['iddgh'];
    $sql_dagiaohang = $conn->prepare("UPDATE `orders` SET status_order = 4, timeOrderUpdate=current_timestamp WHERE idOrder = '$id'");
    $sql_dagiaohang->execute();
            header('location: lietke_donhang.php');

}

// đã hủy đơn
if (isset($_GET['idhuydon'])) {
    $idhuy = $_GET['idhuydon'];
    $sql_huydon = $conn->prepare("UPDATE `orders` SET status_order = 6, timeOrderUpdate=current_timestamp WHERE idOrder = '$idhuy'");
    if ($sql_huydon->execute()) {
                header('location: lietke_donhang.php');

    }
}

// hủy yêu cầu hủy đơn của khách
if (isset($_GET['idhuyyeucau'])) {
    $idhuyyeucau = $_GET['idhuyyeucau'];
    $sql_huyyeucau = $conn->prepare("UPDATE `orders` SET status_order = 1, timeOrderUpdate=current_timestamp WHERE idOrder = '$idhuyyeucau'");
    if ($sql_huyyeucau->execute()) {
                header('location: lietke_donhang.php');

    }
}

//xoa order
if (isset($_POST['xoaOrder'])) {
    $idorder = $_POST['idorder'];
    $check_status_order = $conn->prepare("SELECT * FROM orders o, chitietorder c WHERE o.idOrder=c.idOrder AND c.idOrder='$idorder'");
    $check_status_order->execute();
    if ($check_status_order->rowCount() > 0) {
        while ($row = $check_status_order->fetch(PDO::FETCH_ASSOC)) {
            if ($row['status_order'] == 2 || $row['status_order'] == 3) {
                $update_slmua = $conn->prepare("UPDATE sach SET soLuong=soLuong+? WHERE idSach=?");
                $update_slmua->execute([$row['slmua'], $row['idSach']]);
            }
        }
    }
    $delete_chitietorder = $conn->prepare("DELETE c FROM orders o, chitietorder c WHERE o.idOrder=c.idOrder AND c.idOrder='$idorder'");
    $delete_chitietorder->execute();
    $delete_order = $conn->prepare("DELETE FROM orders WHERE idOrder='$idorder'");
    $delete_order->execute();
    $_SESSION['status_success'] = "Xóa thành công";
            header('location: lietke_donhang.php');

}
