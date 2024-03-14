<?php session_start();
ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/m6lvsjao8ve1aqa2vydo7qp6mq07skyhz6zugf3nu5ssnk6n/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Css -->
    <link rel="stylesheet" href="../../css/admin_style.css?<?= time() ?>">

</head>

<body>

    <script>
        tinymce.init({
            selector: '.mytextarea'
        });
    </script>