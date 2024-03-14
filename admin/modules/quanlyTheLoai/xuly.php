<?php
require '../../../config/connect.php';
session_start();
ob_start();
if (isset($_POST['addtheloai'])) { //thêm thể loại
    $namebook = $_POST['nameTheLoai'];
    $sql_insert = $conn->prepare("INSERT INTO `theloaisach`(tenTheLoai) VALUES('$namebook')");
    if ($sql_insert->execute()) {
        $_SESSION['status_success'] = "Thêm thể loại thành công";
        header('location: lietke_theloai.php');
    }
} elseif (isset($_POST['xoaTL'])) { //xóa thể loại
    $id_tl = $_POST['id_tl'];
    $select_img = $conn->prepare("SELECT  DISTINCT s.idTheLoai, s.imgSach, s.idSach FROM sach s, theloaisach t WHERE s.idTheLoai=t.idTheLoai AND s.idTheLoai='$id_tl'");
    $select_img->execute();
    if ($select_img->rowCount() > 0) {
        while ($row = $select_img->fetch(PDO::FETCH_ASSOC)) {
            unlink('../../modules/quanlySach/upload/' . $row['imgSach']);
        }
        $sql_delete = $conn->prepare("DELETE t,s FROM theloaisach t, sach s WHERE s.idTheLoai=t.idTheLoai AND s.idTheLoai='$id_tl'");
        if ($sql_delete->execute()) {
            $_SESSION['status_success'] = "Xóa thể loại thành công";
        }
    }

    $check_idSach_Chitietorder = $conn->prepare("SELECT * FROM sach s, theloaisach t, chitietorder c WHERE s.idSach=c.idSach AND s.idTheLoai=t.idTheLoai ANd t.idTheLoai='$id_tl'");
    $check_idSach_Chitietorder->execute();

    $check_idSach_cmt = $conn->prepare("SELECT * FROM sach s, theloaisach t, comment c WHERE s.idSach=c.idSach AND s.idTheLoai=t.idTheLoai ANd t.idTheLoai='$id_tl'");
    $check_idSach_cmt->execute();

    $check_idSach_yeuthich = $conn->prepare("SELECT * FROM sach s, theloaisach t, yeuthich y WHERE s.idSach=y.idSach AND s.idTheLoai=t.idTheLoai ANd t.idTheLoai='$id_tl'");
    $check_idSach_yeuthich->execute();

    if ($check_idSach_Chitietorder->rowCount() > 0) {
        while ($row_check_idSach_Chitietorder = $check_idSach_Chitietorder->fetch(PDO::FETCH_ASSOC)) {
            $idorder = $row_check_idSach_Chitietorder['idOrder'];
            $delete_idsach = $conn->prepare("DELETE c FROM chitietorder c, orders o WHERE o.idOrder=c.idOrder AND c.idChitietOrder=?");
            $delete_idsach->execute([$row_check_idSach_Chitietorder['idChitietOrder']]);
            $delete_idsach_orders = $conn->prepare("DELETE FROM orders WHERE idOrder=?");
            $delete_idsach_orders->execute([$idorder]);
        }
        $_SESSION['status_success'] = "Xóa thể loại thành công";
    }
    if ($check_idSach_cmt->rowCount() > 0) {
        while ($row_check_idSach_cmt = $check_idSach_cmt->fetch(PDO::FETCH_ASSOC)) {
            $delete_idsach = $conn->prepare("DELETE FROM comment WHERE idCmt=?");
            $delete_idsach->execute([$row_check_idSach_cmt['idCmt']]);
        }
        $_SESSION['status_success'] = "Xóa thể loại thành công";
    }
    if ($check_idSach_yeuthich->rowCount() > 0) {
        while ($row_check_idSach_yeuthich = $check_idSach_yeuthich->fetch(PDO::FETCH_ASSOC)) {
            $delete_idsach = $conn->prepare("DELETE FROM yeuthich WHERE idYeuThich=?");
            $delete_idsach->execute([$row_check_idSach_yeuthich['idYeuThich']]);
        }
        $_SESSION['status_success'] = "Xóa thể loại thành công";
    }
    $sql_delete = $conn->prepare("DELETE FROM theloaisach WHERE idTheLoai='$id_tl'");
    if ($sql_delete->execute()) {
        $_SESSION['status_success'] = "Xóa thể loại thành công";
    }
    header('location: lietke_theloai.php');
} elseif (isset($_POST['updatetheloai'])) { //update thể loại
    $name_tl = $_POST['nametl'];
    $id = $_POST['idtype'];

    $check_theloai = $conn->prepare("SELECT * FROM `theloaisach` WHERE tenTheLoai= '$name_tl' ");
    $check_theloai->execute();
    if ($name_tl == '') {
        $_SESSION['status_warning'] = "Không được để trống";
        header('location: lietke_theloai.php');
    } elseif ($check_theloai->rowCount() > 0) {
        $_SESSION['status_warning'] = "Thể loại này đã tồn tại";
        header('location: lietke_theloai.php');
    } else {
        $sql_update = $conn->prepare("UPDATE `theloaisach` SET tenTheLoai='$name_tl' WHERE idTheLoai='$id'");
        if ($sql_update->execute()) {
            $_SESSION['status_success'] = "Cập nhập thể loại thành công";
            header('location: lietke_theloai.php');
        }
    }
}
