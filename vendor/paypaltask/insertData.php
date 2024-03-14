<?php
session_start();

// Include database connection file 
include_once '../../config/connect.php';
include_once '../checkCart.php';

if (isset($_SESSION['customer_id']) && isset($_SESSION['dcgh']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $amount = $_POST['amount'];
    if ($totalPrice != 0 && $tongSL != 0) {
        $insert = $conn->prepare("INSERT INTO `orders`(idUser, idDiachiGH, tongSL, totalPrice, DVT , method, status_order, timeOrder, timeOrderUpdate) 
                                                VALUES('$_SESSION[customer_id]','$_SESSION[dcgh]', '$tongSL', '$amount','$' , 'Paypal', 1, NOW(), NOW())");
        $insert->execute();
        $idorder = $conn->lastInsertId();
        $_SESSION['idOrder'] = $idorder;        
        foreach ($cart as $key => $value) {
            $soluong = $value['slmua'];
            $sql_sach = $conn->prepare(" SELECT * FROM `sach` WHERE idSach='$key'");
            $sql_sach->execute();
            $row_sach = $sql_sach->fetch(PDO::FETCH_ASSOC);
            $idsach = $row_sach['idSach'];
            //tổng giá mỗi sách với số lượng
            $dongia = $row_sach['price'];
            $totalPrice = $dongia * $soluong;
            //tổng giá tất cả sách
            $total += $totalPrice;

            $sql = $conn->prepare("INSERT INTO `chitietorder`(idOrder, idSach, dongia, dvt_chitiet, slmua) VALUES('$idorder', '$idsach', '$dongia', 'VNĐ' ,'$soluong')");
            $sql->execute();
        }
    }
    exit();
    
}
