<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ Admin</title>
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/m6lvsjao8ve1aqa2vydo7qp6mq07skyhz6zugf3nu5ssnk6n/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Css -->
    <link rel="stylesheet" href="./css/admin_style.css?<?= time() ?>">

</head>

<body>
    <!-- TiniMCE -->
    <script>
        tinymce.init({
            selector: '.mytextarea'
        });
    </script>
    <!-- TiniMCE -->

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php include '../admin/modules/component_ad/sidebar.php' ?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="bg-primary">
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left  text-white fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0 text-white">Trang chủ</h2>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon "></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white fw-bold" role="button" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-bell"></i>
                                    <span class="position-absolute top-20 start-70 translate-middle badge rounded-pill bg-danger">
                                        <?php
                                        require '../config/connect.php';
                                        $flag = 0;
                                        $select_donhang = $conn->prepare("SELECT * FROM `orders` WHERE status_order=5 OR status_order=1");
                                        $select_donhang->execute();
                                        $select_slSach = $conn->prepare("SELECT idSach,soLuong FROM `sach`");
                                        $select_slSach->execute();
                                        if ($select_donhang->rowCount() > 0) {
                                            $flag = 1;
                                            if ($select_slSach->rowCount() > 0) {
                                                while ($row_slSach = $select_slSach->fetch(PDO::FETCH_ASSOC)) {
                                                    if ($row_slSach['soLuong'] == 0) {
                                                        $flag = 2;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        echo $flag;
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    if ($select_donhang->rowCount() == 0) {
                                        echo ' <li>
                        <a class="dropdown-item text-decoration-none"> Chưa có thông báo mới </a>
                    </li>';
                                    } else {
                                        echo '<li>
                            <a class="dropdown-item text-decoration-none" href="/../project/admin/modules/quanlyOrder/lietke_donhang.php"> Thông báo về đơn hàng </a>
                        </li>';
                                        if ($flag == 2) {
                                            echo '<li>
                            <a class="dropdown-item text-decoration-none" href="/../project/admin/modules/quanlySach/lietke.php"> Số lượng sách hết </a>
                        </li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fw-bold text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i><?php if (isset($_SESSION['admin_name'])) echo $_SESSION['admin_name']; ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/../project/admin/modules/component_ad/logout_admin.php">Đăng xuất</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>

            <div class="container-fluid px-4">
                <div class="row g-3 my-2">
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                    <?php
                                    $soluong_sach = $conn->prepare("SELECT * FROM sach");
                                    $soluong_sach->execute();
                                    if ($soluong_sach->rowCount() > 0) {
                                        echo $soluong_sach->rowCount();
                                    } else {
                                        echo 0;
                                    }
                                    ?>
                                </h3>
                                <p class="fs-5">Sách</p>
                            </div>
                            <i class="fa-solid fa-book fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                    <?php
                                    $soluong_order = $conn->prepare("SELECT * FROM orders");
                                    $soluong_order->execute();
                                    if ($soluong_order->rowCount() > 0) {
                                        echo $soluong_order->rowCount();
                                    } else {
                                        echo 0;
                                    }
                                    ?>
                                </h3>
                                <p class="fs-5">Mua hàng</p>
                            </div>
                            <i class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                    <?php
                                    $soluong_user = $conn->prepare("SELECT * FROM users");
                                    $soluong_user->execute();
                                    if ($soluong_user->rowCount() > 0) {
                                        echo $soluong_user->rowCount();
                                    } else {
                                        echo 0;
                                    }
                                    ?>
                                </h3>
                                <p class="fs-5">Người dùng</p>
                            </div>
                            <i class="fa-solid fa-user fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">%25</h3>
                                <p class="fs-5">Increase</p>
                            </div>
                            <i class="fas fa-chart-line fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>

                <div class="row my-5">
                    <canvas class="bg-white" id="myChart"></canvas>
                </div>

            </div>
        </div>
    </div>
    <?php
    $_SESSION['year'] = date('Y');
    if (isset($_SESSION['year'])) {
        unset($_SESSION['year']);
        $_SESSION['year'] = date('Y');
        $tong_donhang = array();
        for ($i = 1; $i <= 12; $i++) {
            $donhang = $conn->prepare("SELECT * FROM orders WHERE month(timeOrder)='$i' AND year(timeOrder)='$_SESSION[year]' AND status_order = 4");
            $donhang->execute();
            if ($donhang->rowCount() > 0) {
                $num = $donhang->rowCount();
                array_push($tong_donhang, $num);
            } else {
                array_push($tong_donhang, 0);
            }
        }
        $tong_donhang = json_encode($tong_donhang);
    }
    ?>
    <!-- /#page-content-wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                ],
                datasets: [{
                    label: 'Số lượng lượt mua sách',

                    data: <?= $tong_donhang ?>,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },

        });
    </script>
    <!-- Chart.js -->

    <?php include "../admin/modules/component_ad/footer_admin.php"; ?>