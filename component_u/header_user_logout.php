<?php
    session_start();
    unset($_SESSION['customer_sdt']);
    unset($_SESSION['customer_name']);
    unset($_SESSION['customer_id']);
    unset($_SESSION['customer_email']);
    session_destroy();
    ob_start();
    header('location: /../project/home.php')
?>