<?php
$page = 'Trang chủ';
include "./component_u/header_user.php";
include './component_u/nav_user.php';
$price = $conn->prepare("SELECT MAX(price),MIN(price) FROM `sach`");
$price->execute();
$row_price = $price->fetch(PDO::FETCH_ASSOC);
$_SESSION['max']  = $row_price['MAX(price)'] + 100000;
$_SESSION['min']  = $row_price['MIN(price)'];
?>

<div id="main">
    <div class="container">
        <div class="row py-3 ">
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner ">
                    <div class="carousel-item active">
                        <img src="./images/images-1.jpg" class="d-block w-100 img-fluid" alt="slider1">
                    </div>
                    <div class="carousel-item">
                        <img src="./images/img-2.jpg" class="d-block w-100 img-fluid" alt="slider2">
                    </div>
                    <div class="carousel-item">
                        <img src="./images/img-3.png" class="d-block w-100 img-fluid" alt="slider3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>


    <div class="container my-2">
        <div class="row border border-dark mx-auto p-2">
            <div class="col-sm-3 col-md-3">
                <div class="row align-items-center my-2">
                    <div class="col-2"><i class="fa-solid fa-truck-moving fs-4 text-primary"></i></div>
                    <div class="col-9">
                        <h4>Free Shipping</h4>
                        <small>Mua với giá chỉ từ 40,000 VNĐ</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="row align-items-center my-2">
                    <div class="col-2"><i class="fa-solid fa-lock fs-4 text-primary"></i></i></div>
                    <div class="col-9">
                        <h4>Thanh toán an toàn</h4>
                        <small>100% thanh toán an toàn</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="row align-items-center my-2">
                    <div class="col-2"><i class="fa-solid fa-rotate-left fs-4 text-primary"></i></i></div>
                    <div class="col-9">
                        <h4>Dễ dàng đổi trả</h4>
                        <small>7 ngày trở lại</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="row align-items-center my-2">
                    <div class="col-2"><i class="fa-solid fa-headset fs-4 text-primary"></i></div>
                    <div class="col-9">
                        <h4>Hỗ trợ 24/7</h4>
                        <small>Gọi cho chúng tôi bất cứ lúc nào</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container p-4">
        <div id="sanpham" class="row border border-dark mt-3 ">
            <h2 class="text-center my-3">
                <i class="fa-solid fa-fire text-danger"></i>
                TOP SÁCH BÁN CHẠY
                <i class="fa-solid fa-fire text-danger"></i>
            </h2>
            <hr>
            <?php
            $select_sach = $conn->prepare("SELECT * FROM sach ORDER BY RAND() LIMIT 4");
            $select_sach->execute();
            if ($select_sach->rowCount() > 0) {
                while ($row_sp = $select_sach->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="col-sm-3 ">
                        <div class="h-100">
                            <div class="card h-100">
                                <div class="card-body ">
                                    <img class="card-img-top rounded-top-1" src="../project/admin/modules/quanlySach/upload/<?php echo $row_sp['imgSach'] ?>" alt="">
                                    <a href="single.php?idsanpham=<?php echo $row_sp['idSach'] ?>&action=chitiet" class="text-decoration-none h5">
                                        <div class="cart-title h5 my-3 text-center"><?php echo $row_sp['tenSach'] ?></div>
                                    </a>

                                    <div class="text-center card-text my-auto fw-bold">
                                        <span class="text-danger price"><?php echo $row_sp['price'] ?></span>
                                        <span class="text-danger">VNĐ</span>
                                        <div class="text-muted small">
                                            <?php
                                            if ($row_sp['soLuong'] == 0) {
                                                echo 'Hết Sách';
                                            } else {
                                                echo 'Còn (' . $row_sp['soLuong'] . ') quyển';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (isset($_SESSION['customer_id'])) {
                                    $check_status_yt = $conn->prepare("SELECT y.idSach FROM yeuthich y, sach s WHERE y.idSach=s.idSach AND y.idSach=? AND y.idUser=?");
                                    $check_status_yt->execute([$row_sp['idSach'], $_SESSION['customer_id']]);
                                    if ($check_status_yt->rowCount() > 0) {
                                        $row_checkYT = $check_status_yt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                        <a href="./xuly.php?idsach=<?php echo $row_sp['idSach'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=unlove" class="text-center ms-2 mb-2">
                                            <i class="fa-solid fa-heart fs-3 text-danger"></i> </a>
                                    <?php

                                    } else {
                                    ?>
                                        <a href="./xuly.php?idsach=<?php echo $row_sp['idSach'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=yeuthich" class="text-center ms-2 mb-2">
                                            <i class="fa-regular fa-heart fs-3 text-dark"></i> </a>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <a href="./xuly.php?action=yeuthich" class="text-center ms-2 mb-2">
                                        <i class="fa-regular fa-heart fs-3 text-dark"></i>
                                    </a>
                                <?php
                                }
                                ?>
                                <div class="card-footer mx-auto bg-white">
                                    <a href="xuly.php?id=<?php echo $row_sp['idSach'] ?>" class="text-center ms-2">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-solid fa-cart-plus"></i>
                                            Thêm vào giỏ
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            <div class="d-flex justify-content-center my-3">
                <a href="xuly.php?action=allsp">
                    <button type="button" class="btn btn-outline-primary">Xem thêm</button>
                </a>
            </div>
        </div>
    </div>
</div>
<?php include "./component_u/footer_user.php"; ?>