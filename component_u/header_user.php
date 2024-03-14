<?php session_start();
ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (isset($page)) echo $page; ?>
    </title>
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- rateyo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <!-- owl-carousel -->
    <link rel="stylesheet" href="./css/owl.carousel.min.css">
    <link rel="stylesheet" href="./css/owl.theme.default.min.css">
    <!-- Jquey UI css -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- css -->
    <link rel="stylesheet" href="./css/style.css?<?= time() ?>">
</head>

<body>
    <div id="header">
        <div class="container-fluid mt-2">
            <div class="row mb-2">
                <div class="offset-0 col-sm-2 mt-2">
                    <img style="width: 180px;height: 80px;" id="logo" src="/../project/images/logo.jpg" alt="">
                </div>
                <!-- search.php -->
                <div class="col-sm-5">
                    <form action="xuly.php" method="get" class="d-md-flex">
                        <div id="header-searchbox" class="input-group my-4 w-100 border border-dark rounded-3">
                            <input name="search_key" type="text" class="form-control border-0" placeholder="Nhập để tìm kiếm">
                            <button type="livesearch" class="rounded-end border px-3">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- search.php -->
                <div class="col-sm-5 my-auto">
                    <div class="row ">
                        <div class="col-4 text-end">
                            <div class="dropdown z-3">
                                <button class="btn btn-white dropdown-toggle position-relative border-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-shopping-cart fs-3"></i> <span class="fs-5">Giỏ Hàng</span>
                                    <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2">
                                        <span class="visually-hidden">unread messages</span>
                                        <?php
                                        if (isset($_SESSION['cart'])) {
                                            $cart = $_SESSION['cart'];
                                            $count = count($cart);
                                            echo $count;
                                        } else {
                                            echo 0;
                                        }
                                        ?>
                                    </span>
                                </button>
                                <ul class="dropdown-menu border-dark" style="width: 500px;">
                                    <?php
                                    include './config/connect.php';
                                    $total = 0;
                                    if (isset($_SESSION['cart'])) {
                                        $cart = $_SESSION['cart'];
                                        foreach ($cart as $key => $value) {
                                            $sql_cart = $conn->prepare("SELECT * FROM `sach` WHERE idSach = '$key'");
                                            $sql_cart->execute();
                                            $row_cart = $sql_cart->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                            <div class="mb-2 d-flex">
                                                <div class="ms-2 ">
                                                    <img style="width:180px" src="/../project/admin/modules/quanlySach/upload/<?php echo $row_cart['imgSach'] ?>" alt="">
                                                </div>
                                                <div class="ms-4" style="width: 500px;">
                                                    <a class=" text-decoration-none fs-5" href="./single.php?idsanpham=<?php echo $row_cart['idSach'] ?>"><?php echo $row_cart['tenSach'] ?></a>
                                                    <div class=" soluong fw-bold mt-2">SỐ LƯỢNG:
                                                        <input style="width: 40px;" class="ms-2 fw-bold text-center" type="text" disabled value="<?php echo $value['slmua'] ?>">
                                                    </div>
                                                    <div class="mt-1">
                                                        <span class="fw-bold">GIÁ: </span>
                                                        <span class="card-text text-danger price gia fw-bold"><?php echo $row_cart['price'] ?></span>
                                                        <span class="text-danger fw-bold">VNĐ</span>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                            $total = $total + $row_cart['price'] * $value['slmua'];
                                        }
                                    }
                                    ?>
                                    <hr class="mx-2">
                                    <div class="d-flex ms-2 justify-content-around">
                                        <div>
                                            <i class="fas fa-shopping-cart fs-3"></i>
                                            <span class="badge rounded-pill bg-danger">
                                                <?php
                                                if (isset($_SESSION['cart'])) {
                                                    echo $count;
                                                } else {
                                                    echo 0;
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <div>
                                            <Span>Tổng tiền:</Span>
                                            <span class="price text-danger fw-bold"><?= $total ?></span>
                                            <span class="text-danger fw-bold">VNĐ</span>
                                        </div>
                                    </div>
                                    <hr class="mx-2">
                                    <div class="d-flex mx-2 justify-content-around mb-2">
                                        <a href="../project/cart.php">
                                            <button class="btn btn-warning">Giỏ Hàng</button>
                                        </a>
                                        <a href="/../project/checkout.php">
                                            <button class="btn btn-success">Thanh Toán</button>
                                        </a>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <?php
                            if (!isset($_SESSION['customer_id']) && empty($_SESSION['customer_id'])) {
                            ?>
                                <div class="mt-2 fs-5">
                                    <i class="fas fa-regular fa-user fs-3"></i>
                                    <a class="text-decoration-none " href="/../project/login_users.php"> <span class="hover_dk_dn">Đăng nhập</span> </a> |
                                    <a class="text-decoration-none " href="/../project/register_user.php"> <span class="hover_dk_dn">Đăng ký</span> </a>
                                </div>
                            <?php
                            } else {
                            ?>
                                <li class="dropdown mt-2" style="list-style: none;">
                                    <i class="fas fa-regular fa-user fs-3 col-1"></i>
                                    <?php
                                    if (isset($_SESSION['customer_id'])) {
                                        $slect_user = $conn->prepare("SELECT nameUser FROM users WHERE idUser = '$_SESSION[customer_id]'");
                                        $slect_user->execute();
                                        $row = $slect_user->fetch(PDO::FETCH_ASSOC);
                                        if ($slect_user->rowCount() > 0) {
                                    ?>
                                            <a class="dropdown-toggle text-dark fw-bold col" role="button" data-bs-toggle="dropdown"><span class="hover_nav fs-5"><?= $row['nameUser'] ?></span> </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item text-decoration-none" href="/../project/my_account.php"> Tài Khoản của tôi</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-decoration-none" href="/../project/component_u/header_user_logout.php"> Đăng xuất</a>
                                                </li>
                                            </ul>
                                    <?php
                                        }
                                    }
                                    ?>
                                </li>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>