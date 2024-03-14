<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

/**
 * 
 *
 * @author CTT VNPAY
 */
require_once("./config.php");
require '../../config/connect.php';
require '../checkCart.php';
if (isset($_SESSION['customer_id']) && isset($_SESSION['dcgh']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    if ($totalPrice != 0 && $tongSL != 0) {
        $sql = $conn->prepare("INSERT INTO `orders`(idUser, idDiachiGH, tongSL, totalPrice, DVT ,method, status_order, timeOrder, timeOrderUpdate) VALUES(?, ?, '$tongSL', '$total','VNĐ' , 'VNPay', 1, NOW(), NOW() )");
        $sql->execute([$_SESSION['customer_id'], $_SESSION['dcgh']]);
        $idorder = $conn->lastInsertId();
        $_SESSION['idorder_new'] = $idorder;
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
    
}
$vnp_TxnRef = $idorder; //Mã giao dịch thanh toán tham chiếu của merchant
$sotien = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT); // Số tiền thanh toán
$vnp_Amount = $sotien;
$vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
$vnp_BankCode = $_POST['bankCode']; //Mã phương thức thanh toán
$vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount * 100,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
    "vnp_OrderType" => "other",
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
    "vnp_ExpireDate" => $expire
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}
header('Location: ' . $vnp_Url);
die();
