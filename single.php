<?php
$page = 'Thông tin chi tiết';
include "./component_u/header_user.php";

include "./component_u/nav_user.php";
?>

<?php
if (isset($_GET['idsanpham'])) {
    require "config/connect.php";
    $_SESSION['idSach_single'] = $_GET['idsanpham'];
    if (isset($_SESSION['idSach_single']) && !empty($_SESSION['idSach_single'])) {
        unset($_SESSION['idSach_single']);
        $_SESSION['idSach_single'] = $_GET['idsanpham'];
    }
    $id_sanpham = $_GET['idsanpham'];
    $sql = $conn->prepare("SELECT * FROM `sach` WHERE idSach='$id_sanpham'");
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="main-product">
    <div class="container">
        <div class="row mx-auto mt-4">
            <div class="d-flex border border-dark ">
                <div class="mx-2">
                    <a href="home.php">
                        <i style="color:black" class="fa-solid fa-house fs-4 my-2"></i>
                    </a>
                </div>
                <?php
                ?>
                <p class="my-2 fs-5 fw-bold">/ <?= $row['tenSach'] ?>/ Thông tin chi tiết</p>
                <?php
                ?>
            </div>
        </div>
        <!-- Thông tin chi tiết -->
        <div class="border border-dark px-5 my-4 pt-3" aria-label="breadcrumb">
            <div class="row my-3">
                <div class="col-md-3 col-12">
                    <img class="img-fluid border border-dark rounded" src="../project/admin/modules/quanlySach/upload/<?php echo $row['imgSach'] ?>" alt="">
                </div>
                <div class="col-md-7 col-12">
                    <div class="row">
                        <h2><?php echo $row['tenSach'] ?></h2>
                    </div>
                    <div class="row">
                        <div class="text-danger">
                            <span class="card-text price fw-bold fs-3 "><?php echo $row['price'] ?></span>
                            <span class=" fw-bold fs-3">VNĐ</span>
                        </div>
                    </div>

                    <form action="./xuly.php?action=single&" method="get">
                        <div class="row mt-3">
                            <label class="text-uppercase col-md-2" for="soluong">Số lượng:</label>
                            <input type="hidden" name="id" value="<?= $id_sanpham ?>">
                            <input class="col-md-1 border border-dark border-3 rounded-3" value="1" min="1" name="slmua" type="number" id="soluong">
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-5">
                                <?php
                                $sql1 =  $conn->prepare("SELECT * FROM `theloaisach` WHERE idTheLoai = ?");
                                $sql1->execute([$row['idTheLoai']]);
                                $row1 = $sql1->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <label class="text-uppercase">Thể loại:</label>
                                <a class="text-decoration-none fs-5" href="xuly.php?idtl=<?php echo $row1['idTheLoai'];
                                                                                                $idtl = $row1['idTheLoai']; ?>"><?php echo $row1['tenTheLoai'] ?>
                                </a>
                                <?php
                                ?>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <button type="submit" name="muangay" class="btn btn-lg btn-danger text-white ms-3 col-md-4 ">Mua ngay</button>
                            <button type="submit" name="themvaogio" class="btn btn-lg btn-primary text-white ms-3 col-md-4 ">Thêm vào giỏ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Thông tin chi tiết -->

        <!-- comment -->
        <nav>
            <div class="nav nav-tabs bg-info-subtle" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Mô tả</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    Đánh giá(
                    <?php
                    $sql_count = $conn->prepare("SELECT * FROM `comment` WHERE idSach='$id_sanpham'");
                    $sql_count->execute();
                    if ($sql_count->rowCount() > 0) {
                        echo $sql_count->rowCount();
                    } else {
                        echo 0;
                    }
                    ?>
                    )
                </button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">TAGS</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active border border-light-subtle p-3 mb-4" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <?php
                echo $row['motaSach']
                ?>
            </div>
            <div class="tab-pane fade border border-light-subtle mb-4" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <?php
                $sql_select_cmt = $conn->prepare("SELECT * FROM `comment` INNER JOIN `users` INNER JOIN `avatar` ON comment.idUser=users.idUser AND avatar.idUser=users.idUser WHERE comment.idSach='$id_sanpham'");
                $sql_select_cmt->execute();
                if ($sql_select_cmt->rowCount() > 0) {
                    while ($row_cmt = $sql_select_cmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <?php $idcmt = $row_cmt['idCmt'] ?>
                        <div class="row my-3 mx-3">
                            <div class="col-1 text-end">
                                <img style="width: 50px;" src="/../project/uploads/<?= $row_cmt['tenHinh'] ?>" alt="">
                            </div>
                            <div class="col-11">
                                <div class="fw-bold row ">
                                    <div class="col"><?= $row_cmt['nameUser'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 text-start text-break">
                                        <?php
                                        echo $row_cmt['content'];
                                        ?>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <?php
                                        $now_time = strtotime(date('Y-m-d H:i:s'));
                                        $diff_timestamp = $now_time - strtotime($row_cmt['timeCreateCmt']);
                                        if ($diff_timestamp < 60) {
                                            echo 'Một vài giây trước';
                                        } else if ($diff_timestamp > 60  && $diff_timestamp < 3600) {
                                            echo round($diff_timestamp / 60) . ' phút trước';
                                        } else if ($diff_timestamp >= 3600 && $diff_timestamp < 86400) {
                                            echo round($diff_timestamp / 3600) . ' giờ trước';
                                        } else if ($diff_timestamp >= 86400 && $diff_timestamp < 86400 * 30) {
                                            echo round($diff_timestamp / 86400) . ' ngày trước';
                                        } else if ($diff_timestamp >= 86400 * 30 && $diff_timestamp < 86400 * 365) {
                                            echo round($diff_timestamp / 86400 * 30) . ' tháng trước';
                                        } else {
                                            echo round($diff_timestamp / 86400 * 365) . ' năm trước';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                $sql_stars = $conn->prepare("SELECT * FROM `comment` WHERE idSach='$id_sanpham' AND idCmt='$idcmt'");
                                $sql_stars->execute();
                                if ($sql_stars->rowCount() > 0) {
                                    while ($row_stars = $sql_stars->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <div class="row pe-4">
                                            <div class="rateyo z-0" id="rateyo" data-rateyo-read-only="true" data-rateyo-rating="<?= $row_stars['rate'] ?>">
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>

                            </div>
                            <hr>
                        </div>
                <?php
                    }
                }

                ?>
                <form action="xuly.php" method="post" class="rounded p-3">
                    <h2 class="mt-2 ms-2 row">Đánh Giá</h2>
                    <p class="mt-2 ms-2 row">Hãy đưa ra nhận xét của bạn:</p>
                    <div class="form-group ms-2 mb-2">
                        <label class="fw-bold">Nhận xét của bạn (<strong class="text-danger">*</strong>)</label>
                        <div class="my-2">
                            <textarea class="form-control" name="cmt" id="comment" rows="7"></textarea>
                        </div>
                    </div>

                    <div class="rateyo z-0" id="rating" data-rateyo-rating="5" data-rateyo-num-stars="5" data-rateyo-score="3" data-rateyo-full-star="true">
                    </div>
                    <input type="hidden" name="rating" class="rating">
                    <input type="hidden" name="idsp" value="<?= $id_sanpham ?>">

                    <div class="form-group">
                        <div class="ms-2 mt-2">
                            <button type="submit" name="gui_danhgia" class="btn btn-primary">Gửi đi</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- comment -->
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
        </div>

        <!-- các sách gợi ý -->
        <div class="card mb-4 border-dark">
            <div class="card-header fw-bold">
                CÁC SÁCH BẠN CÓ THỂ THÍCH
            </div>
            <div class="card-body mt-4">
                <div class="row owl-carousel owl-theme z-0">
                    <?php
                    $sql_goiy = $conn->prepare("SELECT * FROM `sach` WHERE idSach != '$id_sanpham' ORDER BY rand()");
                    $sql_goiy->execute();
                    if ($sql_goiy->rowCount() > 0) {
                        while ($row_goiy = $sql_goiy->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <div class="mx-1 h-100">
                                <div class="card w-100 h-100">
                                    <div class="card-body d-flex flex-column">
                                        <img class="img-fluid rounded-top-1" src="/../project/admin/modules/quanlySach/upload/<?php echo $row_goiy['imgSach'] ?>" alt="">
                                        <a href="single.php?idsanpham=<?php echo $row_goiy['idSach'] ?>" class="text-dark text-center h5 text-decoration-none my-3">
                                            <?php echo $row_goiy['tenSach'] ?>
                                        </a>
                                        <div class="text-center my-auto fw-bold">
                                            <span class="card-text text-danger price"><?php echo $row_goiy['price'] ?></span>
                                            <span class="text-danger">VNĐ</span>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($_SESSION['customer_id']) && isset($row_goiy['idSach'])) {
                                        $check_status_yt = $conn->prepare("SELECT y.idSach FROM yeuthich y, sach s WHERE y.idSach=s.idSach AND y.idSach=? AND y.idUser=?");
                                        $check_status_yt->execute([$row_goiy['idSach'], $_SESSION['customer_id']]);
                                        if ($check_status_yt->rowCount() > 0) {
                                            $row_checkYT = $check_status_yt->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                            <a href="./xuly.php?idsach=<?php echo $row_goiy['idSach'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=unlove_single" class="text-center ms-2 mb-2">
                                                <i class="fa-solid fa-heart fs-3 text-danger"></i> </a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="./xuly.php?idsach=<?php echo $row_goiy['idSach'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=yeuthich_single" class="text-center ms-2 mb-2">
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
                                        <a href="./xuly.php?id=<?php echo $row_goiy['idSach'] ?>" class="text-center ms-2">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-solid fa-cart-plus"></i>
                                                Thêm vào giỏ
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '1';
                    }
                    ?>
                </div>

            </div>
        </div>
        <!-- các sách gợi ý -->

        <!-- Các sách cùng loại -->
        <div class="card mb-4 border-dark">
            <div class="card-header fw-bold">
                CÁC SÁCH CÙNG LOẠI
            </div>
            <div class="card-body mt-4">
                <div class="owl-carousel owl-theme owl-height z-0">
                    <?php

                    $sql_cungloai = $conn->prepare("SELECT * FROM `sach`, `theloaisach` WHERE sach.idTheLoai=theloaisach.idTheLoai 
                        AND idSach != '$id_sanpham' AND theloaisach.idTheLoai='$idtl' ORDER BY rand()");
                    $sql_cungloai->execute();
                    while ($row_cungloai = $sql_cungloai->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <div class="mx-1 h-100">
                            <div class="card w-100 h-100">
                                <div class="card-body d-flex flex-column">
                                    <img class="img-fluid rounded-top-1" src="../project/admin/modules/quanlySach/upload/<?php echo $row_cungloai['imgSach'] ?>" alt="">
                                    <a href="single.php?idsanpham=<?php echo $row_cungloai['idSach'] ?>" class="text-dark text-center h5 text-decoration-none my-3">
                                        <?php echo $row_cungloai['tenSach'] ?>
                                    </a>
                                    <div class="text-center my-auto fw-bold">
                                        <span class="card-text text-danger price"><?php echo $row_cungloai['price'] ?></span>
                                        <span class="text-danger">VNĐ</span>
                                    </div>
                                </div>
                                <?php
                                if (isset($_SESSION['customer_id']) && isset($row_cungloai['idSach'])) {
                                    $check_status_yt = $conn->prepare("SELECT y.idSach FROM yeuthich y, sach s WHERE y.idSach=s.idSach AND y.idSach=? AND y.idUser=?");
                                    $check_status_yt->execute([$row_cungloai['idSach'], $_SESSION['customer_id']]);
                                    if ($check_status_yt->rowCount() > 0) {
                                        $row_checkYT = $check_status_yt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                        <a href="./xuly.php?idsach=<?php echo $row_cungloai['idSach'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=unlove_single" class="text-center ms-2 mb-2">
                                            <i class="fa-solid fa-heart fs-3 text-danger"></i> </a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="./xuly.php?idsach=<?php echo $row_cungloai['idSach'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=yeuthich_single" class="text-center ms-2 mb-2">
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
                                    <a href="./xuly.php?id=<?php echo $row_cungloai['idSach'] ?>" class="text-center ms-2">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-solid fa-cart-plus"></i>
                                            Thêm vào giỏ
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Các sách cùng loại -->

    </div>
</div>

<?php include "./component_u/footer_user.php"; ?>