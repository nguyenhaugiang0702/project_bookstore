<?php
require '../../config/connect.php';
session_start();
if (isset($_SESSION['idorder_new']) && isset($_SESSION['customer_id'])) {
    $delete_chitietorder = $conn->prepare("DELETE c FROM chitietorder c, orders o WHERE o.idOrder=c.idOrder AND c.idOrder='$_SESSION[idorder_new]' AND o.idUser='$_SESSION[customer_id]'");
    $delete_chitietorder->execute();
    $delete_orders = $conn->prepare("DELETE FROM orders WHERE idOrder='$_SESSION[idorder_new]' AND idUser='$_SESSION[customer_id]'");
    $delete_orders->execute();
    unset($_SESSION['idorder_new']);
    header('location: /../project/cart.php');
}
