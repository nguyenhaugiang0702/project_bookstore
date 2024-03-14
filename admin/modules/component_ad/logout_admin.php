<?php
    session_start();
    unset($_SESSION['admin_id']);
    session_destroy();
    ob_start();
    header('location: /../project/admin/index.php')
?>
