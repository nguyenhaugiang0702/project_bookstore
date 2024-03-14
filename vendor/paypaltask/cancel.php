<?php
session_start();
include_once '../../config/connect.php';

if (isset($_SESSION['idOrder']) && isset($_SESSION['customer_id'])) {
    $idorder = $_SESSION['idOrder'];
    $iduser = $_SESSION['customer_id'];
    $delete_chitietorder = $conn->prepare("DELETE c FROM chitietorder c, orders o WHERE c.idOrder=o.idOrder AND c.idOrder='$idorder' AND o.idUser='$iduser'");
    $delete_chitietorder->execute();
    $delete = $conn->prepare("DELETE FROM orders WHERE idOrder='$idorder' AND idUser='$iduser'");
    $delete->execute();
    unset($_SESSION['idOrder']);
    unset($_SESSION['dcgh']);
}
?>
<h1 class="error">Your PayPal Transaction has been Canceled</h1>
<a href="/../project/cart.php" class="btn-link">Back</a>