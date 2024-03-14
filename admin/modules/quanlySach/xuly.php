<?php
require '../../../config/connect.php';
session_start();
if (isset($_POST['themsach']) && isset($_FILES['imgBook'])) { // thêm sách
    $namebook = $_POST['nameBook'];
    $motabook = $_POST['motaBook'];
    $typebook = $_POST['theloai'];
    $numbook = $_POST['numBook'];
    $pricebook = $_POST['priceBook'];
    $pricebook = filter_var($pricebook, FILTER_SANITIZE_NUMBER_INT);
    $img_name = $_FILES['imgBook']['name'];
    $tmp_name = $_FILES['imgBook']['tmp_name'];
    $newfilename = uniqid() . '-' . $img_name;
    $sql_insert = $conn->prepare("INSERT INTO `sach`(tenSach,motaSach,imgSach,idTheLoai,soLuong,price) VALUES('$namebook','$motabook','$newfilename','$typebook','$numbook','$pricebook')");
    if ($sql_insert->execute()) {
        move_uploaded_file($tmp_name, 'upload/' . $newfilename);
        $_SESSION['status_success'] = "Thêm sách thành công";
        header('location: lietke.php');
    }
} else if (isset($_POST['update'])) { // cập nhập sách
    $namebook = $_POST['nameBook'];
    $motabook = $_POST['motabook'];
    $typebook = $_POST['theloai'];
    $numbook = $_POST['numBook'];
    $pricebook = $_POST['priceBook'];
    $pricebook = filter_var($pricebook, FILTER_SANITIZE_NUMBER_INT);
    $id = $_POST['idb'];

    $new_img = $_FILES['imgBook_update']['name'];
    $old_img = $_POST['img_book_old'];

    if ($_FILES['imgBook_update']['name'] != '') {
        $newfilename = uniqid() . '-' . $new_img;
        $sql_update_1 = $conn->prepare("UPDATE `sach` SET tenSach='$namebook', motaSach='$motabook', imgSach='$newfilename', idTheLoai='$typebook', 
                    soLuong='$numbook', price='$pricebook' WHERE idSach='$id'");
        if ($sql_update_1->execute()) {
            move_uploaded_file($_FILES['imgBook_update']['tmp_name'], "upload/" . $newfilename);
            unlink("upload/" . $old_img);
            $_SESSION['status_success'] = "Cập nhập thành công";
            header('location: /../project/admin/modules/quanlySach/lietke.php');
        }
    } else {
        $sql_update = $conn->prepare("UPDATE `sach` SET tenSach='$namebook', motaSach='$motabook', imgSach='$old_img', idTheLoai='$typebook', 
            soLuong='$numbook', price='$pricebook' WHERE idSach='$id'");
        if ($sql_update->execute()) {
            $_SESSION['status_success'] = "Cập nhập thành công";
            header('location: /../project/admin/modules/quanlySach/lietke.php');
        }
    }
} else if (isset($_POST['delete_book'])) { // xóa sách
    $idbook = $_POST['idsach'];
    $img_book = $_POST['delete_img'];

    $check_idSach_chitietorder = $conn->prepare("SELECT * FROM chitietorder WHERE idSach='$idbook'");
    $check_idSach_chitietorder->execute();

    if ($check_idSach_chitietorder->rowCount() > 0) {
        while ($row = $check_idSach_chitietorder->fetch(PDO::FETCH_ASSOC)) {
            //Cập nhập giá đơn hàng khi xóa 1 sách
            $update_price_orders = $conn->prepare("UPDATE orders SET totalPrice=totalPrice-?, tongSL=tongSL-? WHERE idOrder=?");
            $update_price_orders->execute([$row['dongia'] * $row['slmua'], $row['slmua'], $row['idOrder']]);
            //Kiểm tra giá đơn hàng
            $check_price_orders = $conn->prepare("SELECT totalPrice FROM orders WHERE idOrder=?");
            $check_price_orders->execute([$row['idOrder']]);
            $row_totalPrice = $check_price_orders->fetch(PDO::FETCH_ASSOC);
            if ($row_totalPrice['totalPrice'] == 0) { // == 0 : xóa bên chitietorder và bên orders
                $sql_delete = $conn->prepare("DELETE c FROM sach s, chitietorder c WHERE s.idSach=c.idSach AND c.idSach='$idbook' AND c.idOrder=?");
                $sql_delete->execute([$row['idOrder']]);
                $_SESSION['status_success'] = "Xóa sách thành công";
                $delete_orders = $conn->prepare("DELETE FROM orders WHERE idOrder=?");
                $delete_orders->execute([$row['idOrder']]);
            } else { // xóa bên chititorder
                $sql_delete = $conn->prepare("DELETE c FROM sach s, chitietorder c WHERE s.idSach=c.idSach AND c.idSach='$idbook'");
                $sql_delete->execute();
                $_SESSION['status_success'] = "Xóa sách thành công";
            }
        }
    }

    // Kiểm tra sách xóa có trong comment và xóa ? 
    $check_idSach_comment = $conn->prepare("SELECT * FROM sach s, comment c WHERE s.idSach=c.idSach AND c.idSach='$idbook'");
    $check_idSach_comment->execute();
    if ($check_idSach_comment->rowCount() > 0) {
        $sql_delete = $conn->prepare("DELETE c FROM sach s, comment c WHERE s.idSach=c.idSach AND c.idSach='$idbook'");
        $sql_delete->execute();
        $_SESSION['status_success'] = "Xóa sách thành công";
    }

    // Kiểm tra sách xóa có trong yeuthich và xóa ? 
    $check_idSach_yeuthich = $conn->prepare("SELECT * FROM sach s, yeuthich y WHERE s.idSach=y.idSach AND y.idSach='$idbook'");
    $check_idSach_yeuthich->execute();
    if ($check_idSach_yeuthich->rowCount() > 0) {
        $sql_delete = $conn->prepare("DELETE y FROM sach s, yeuthich y WHERE s.idSach=y.idSach AND y.idSach='$idbook'");
        $sql_delete->execute();
        $_SESSION['status_success'] = "Xóa sách thành công";
    }

    // Xóa sách khỏi bảng sách
    $sql_delete = $conn->prepare("DELETE FROM sach WHERE idSach='$idbook'");
    if ($sql_delete->execute()) {
        unlink("upload/" . $img_book);
        $_SESSION['status_success'] = "Xóa thành công";
    }
    header('location: lietke.php');
}
