<?php
session_start();
require '../../config/connect.php';
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $total = 0;
    $tongSL = 0;
    $totalPrice = 0;
    foreach ($cart as $key => $value) {
        $soluong = $value['slmua'];
        $tongSL += $soluong;

        $sql_sach = $conn->prepare(" SELECT * FROM `sach` WHERE idSach='$key'");
        $sql_sach->execute();
        $row_sach = $sql_sach->fetch(PDO::FETCH_ASSOC);
        //tổng giá mỗi sách với số lượng
        $dongia = $row_sach['price'];
        $totalPrice = $dongia * $soluong;
        //tổng giá tất cả sách
        $total += $totalPrice;
    }
}
