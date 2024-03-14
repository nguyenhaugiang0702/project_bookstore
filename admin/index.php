<?php session_start();
ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css">
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/m6lvsjao8ve1aqa2vydo7qp6mq07skyhz6zugf3nu5ssnk6n/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Css -->
    <link rel="stylesheet" href="./css/admin_style.css">

</head>

<body>

    <script>
        tinymce.init({
            selector: '.mytextarea'
        });
    </script>

    <header class="container-fluid py-4 bg-primary">
        <h1 class="text-center text-white">Welcome to adminator control panel</h1>

        <?php
        if (isset($_SESSION['admin_id'])) {
        ?>
            <li class="dropdown" style="list-style: none;">
                <a class="dropdown-toggle text-dark fw-bold" role="button" data-bs-toggle="dropdown">
                    <span class="me-3 text-white fs-3">
                        ADMINSTRATOR
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item text-decoration-none" href="/../project/admin/modules/component_ad/logout_admin.php"> Đăng xuất</a>
                    </li>
                </ul>
            </li>

        <?php
        }
        ?>
    </header>

    </div>
    <div class="form-container">
        <!-- <?php
                if (isset($_SESSION['status_warning'])) {
                    echo '<script>alert("' . $_SESSION['status_warning'] . '")</script>';
                    unset($_SESSION['status_warning']);
                }
                ?> -->

        <div class="title">
            Đăng Nhập Admin
        </div>
        <?php

        if (isset($_POST['login_admin'])) {
            require "../config/connect.php";
            $nameadmin = $_POST['nameadmin'];
            $passadmin = $_POST['passadmin'];
            $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE nameAdmin=?");
            $select_admin->execute([$nameadmin]);
            $row = $select_admin->fetch(PDO::FETCH_ASSOC);

            if ($select_admin->rowCount() > 0) {
                if ($passadmin == $row['passAdmin']) {
                    $_SESSION['admin_id'] = $row['idAdmin'];
                    $_SESSION['admin_name'] = $row['nameAdmin'];
                    header('location: /../project/admin/admin.php');
                } else {
                    echo "<div class='alert alert-danger'>Sai mật khẩu </div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Sai tên đăng nhập</div>";
            }
        }

        ?>

        <form id="Login_admin" method="post">
            <div class="form-group">
                <label for="nameadmin" class="fw-bold">Tên đăng nhập:</label>
                <input type="text" class="form-control" id="nameadmin" name="nameadmin" placeholder="Admin Name:">
            </div>
            <div class="form-group">
                <label for="passadmin" class="fw-bold">Mật khẩu:</label>
                <input type="password" class="form-control" id="passadmin" name="passadmin" placeholder="Password Admin:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Đăng nhập" name="login_admin">
            </div>
        </form>
    </div>
    <?php include "../admin/modules/component_ad/footer_admin.php"; ?>