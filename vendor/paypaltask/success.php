<?php
session_start();
include_once 'config.php';
include_once '../../config/connect.php';

if (isset($_SESSION['idOrder'])) {
    $idorder = $_SESSION['idOrder'];
    if (isset($_GET['PayerID'])) {
        echo "<h1>Your Payment has been successfull</h1>";
        unset($_SESSION['cart']);
        unset($_SESSION['dcgh']);
    } else {
        echo "<h1>Your Payment has been failed</h1>";
    }
}
?>
<a href="../../cart.php">Back</a>