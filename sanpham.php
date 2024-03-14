<?php
$page = 'Tất cả sách';
include "./component_u/header_user.php";
include "./component_u/nav_user.php";
?>
<div id="main">
    <div class="container pt-4">
        <?php
        require "./config/connect.php";
        // tất cả sách
        if (isset($_SESSION['allsp'])) {
        ?>
            <div class="row">
                <div class="d-flex mx-3 border border-dark ">
                    <div class="mx-2">
                        <a href="home.php">
                            <i style="color:black" class="fa-solid fa-house fs-4 my-2"></i>
                        </a>
                    </div>
                    <?php
                    if (isset($_SESSION['locgia']) && isset($_SESSION['minprice']) && isset($_SESSION['maxprice'])) {
                    ?>
                        <p class="my-2 fs-5 fw-bold">/ Tất cả các sách/ giá từ <span class="price"><?= $_SESSION['minprice'] ?></span><span> VNĐ</span> - <span class="price"><?= $_SESSION['maxprice'] ?></span><span> VNĐ</span> </p>
                    <?php
                    } else {
                    ?>
                        <p class="my-2 fs-5 fw-bold">/ Tất cả các sách</p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        // thể loại
        if (isset($_SESSION['tl_id'])) {
            $id = $_SESSION['tl_id'];
            $sql = $conn->prepare("SELECT * FROM `theloaisach` WHERE idTheLoai='$id'");
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);
        ?>
            <div class="row">
                <div class="d-flex mx-3 border border-dark ">
                    <div class="mx-2">
                        <a href="home.php">
                            <i style="color:black" class="fa-solid fa-house fs-4 my-2"></i>
                        </a>
                    </div>
                    <?php
                    if (isset($_SESSION['locgia']) && isset($_SESSION['minprice']) && isset($_SESSION['maxprice'])) {
                    ?>
                        <p class="my-2 fs-5 fw-bold">/ Thể Loại / <?= $row['tenTheLoai'] ?>/ giá từ <span class="price"><?= $_SESSION['minprice'] ?></span><span> VNĐ</span> - <span class="price"><?= $_SESSION['maxprice'] ?></span><span> VNĐ</span> </p>
                    <?php
                    } else {
                    ?>
                        <p class="my-2 fs-5 fw-bold">/ Thể Loại / <?= $row['tenTheLoai'] ?></p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        // search
        if (isset($_SESSION['search_key'])) {
        ?>
            <div class="row">
                <div class="d-flex mx-3 border border-dark ">
                    <div class="mx-2">
                        <a href="./index.php?action=trangchu">
                            <i style="color:black" class="fa-solid fa-house fs-4 my-2"></i>
                        </a>
                    </div>
                    <?php
                    if (isset($_SESSION['locgia']) && isset($_SESSION['minprice']) && isset($_SESSION['maxprice'])) {
                    ?>
                        <p class="my-2 fs-5 fw-bold">/ Sách được tìm với từ khóa '<?= $_SESSION['search_key'] ?>'/ giá từ <span class="price"><?= $_SESSION['minprice'] ?></span><span> VNĐ</span> - <span class="price"><?= $_SESSION['maxprice'] ?></span><span> VNĐ</span> </p>
                    <?php
                    } else {
                    ?>
                        <p class="my-2 fs-5 fw-bold">/ Sách được tìm với từ khóa '<?= $_SESSION['search_key'] ?>'</p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }

        ?>


        <div class="row mb-3">
            <h2 class="mx-3 mt-3 col-3">Tất cả các sách</h2>
            <div class="col-6">
                <div class="row">
                    <div class="col mt-3">
                        <label class="row" for="">Lọc Theo:</label>
                        <form action="xuly.php" method="post">
                            <div class="z-1" id="slider-range" style="height: 15px;"></div>
                            <div class="row mx-auto">
                                <input class="col-6 bg-transparent" type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                <input class="col-6 bg-transparent" type="text" id="amount_end" readonly style="border:0; color:#f6931f; font-weight:bold;">
                            </div>
                            <span class="col-2 bg-transparent fw-bold text-center z-1" style="position: relative;color:#f6931f;top: -25px;left: 75px;z-index: 99;">VNĐ</span>
                            <span class="col-2 bg-transparent fw-bold text-center z-1" style="position: relative;color:#f6931f;top: -25px;left: 95px;z-index: 99;">-</span>
                            <span class="col-2 bg-transparent fw-bold text-center z-1" style="position: relative;color:#f6931f;top: -25px;left: 190px;z-index: 99;">VNĐ</span>
                            <input type="hidden" name="startprice" id="start_price">
                            <input type="hidden" name="endprice" id="end_price">
                            <input type="hidden" name="loc" value="loc">
                    </div>

                    <div class="col my-auto"><button type="submit" name="locgia" class="btn btn-primary">Lọc</button></div>
                    </form>
                </div>
            </div>
            <div class="col-2 my-auto ">
                <div class="row mx-auto">
                    <li class="nav-item dropdown" style="list-style: none;">
                        <a class="nav-link dropdown-toggle border border-dark text-decoration-none text-dark fw-bold" role="button" data-bs-toggle="dropdown">___LỌC THEO___</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="xuly.php?action=asc">Giá tăng dần</a>
                                <a class="dropdown-item" href="xuly.php?action=desc">Giá giảm dần</a>
                            </li>
                        </ul>
                    </li>
                </div>


            </div>
        </div>



        <div class="product-list row pb-4 mx-auto">

            <?php
            require "config/connect.php";
            if (isset($_SESSION['status_warning'])) {
                echo '<script>alert("' . $_SESSION['status_warning'] . '");</script>';
                unset($_SESSION['status_warning']);
            } else if (isset($_SESSION['status_success'])) {
                echo '<script>alert("' . $_SESSION['status_success'] . '");</script>';
                unset($_SESSION['status_success']);
            }

            if (isset($_SESSION['tl_id'])) {
                $id = $_SESSION['tl_id'];
                $sldislay = !empty($_GET['slsach_on_page']) ? $_GET['slsach_on_page'] : 4;
                $page_now = !empty($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page_now - 1) * $sldislay;
                $tongSP = $conn->prepare("SELECT * FROM `sach`, `theloaisach` WHERE sach.idTheLoai=theloaisach.idTheLoai AND sach.idTheLoai='$id'");
                $tongSP->execute();
                $tongSP = $tongSP->rowCount();
                $tongPage = ceil($tongSP / $sldislay);

                $sql_sp = $conn->prepare("SELECT * FROM `sach` WHERE idTheLoai='$id' ORDER BY `idSach` ASC LIMIT $sldislay OFFSET $offset");
                $sql_sp->execute();

                if (isset($_SESSION['asc'])) {
                    $sql_sp = $conn->prepare("SELECT * FROM `sach` WHERE idTheLoai='$id' ORDER BY `price` ASC LIMIT $sldislay OFFSET $offset");
                    $sql_sp->execute();
                } else if (isset($_SESSION['desc'])) {
                    $sql_sp = $conn->prepare("SELECT * FROM `sach` WHERE idTheLoai='$id' ORDER BY `price` DESC LIMIT $sldislay OFFSET $offset");
                    $sql_sp->execute();
                } else if (isset($_SESSION['locgia']) && isset($_SESSION['minprice']) && isset($_SESSION['maxprice'])) {
                    $sldislay = !empty($_GET['slsach_on_page']) ? $_GET['slsach_on_page'] : 4;
                    $page_now = !empty($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($page_now - 1) * $sldislay;
                    $tongSP = $conn->prepare("SELECT * FROM `sach` WHERE idTheLoai='$id' AND  (price BETWEEN ? AND ?)");
                    $tongSP->execute([$_SESSION['minprice'], $_SESSION['maxprice']]);
                    $tongSP = $tongSP->rowCount();
                    $tongPage = ceil($tongSP / $sldislay);

                    $sql_sp = $conn->prepare("SELECT * FROM `sach` WHERE idTheLoai='$id' AND (price BETWEEN ? AND ?) ORDER BY `price` ASC LIMIT $sldislay OFFSET $offset");
                    $sql_sp->execute([$_SESSION['minprice'], $_SESSION['maxprice']]);
                }
            }
            if (isset($_SESSION['allsp'])) {
                $sldislay = !empty($_GET['slsach_on_page']) ? $_GET['slsach_on_page'] : 4;
                $page_now = !empty($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page_now - 1) * $sldislay;
                $tongSP = $conn->prepare("SELECT * FROM `sach`");
                $tongSP->execute();
                $tongSP = $tongSP->rowCount();
                $tongPage = ceil($tongSP / $sldislay);


                $sql_sp = $conn->prepare("SELECT * FROM `sach` ORDER BY RAND() LIMIT $sldislay OFFSET $offset");
                $sql_sp->execute();
                if (isset($_SESSION['asc'])) {
                    $sql_sp = $conn->prepare("SELECT * FROM `sach` ORDER BY `price` ASC LIMIT $sldislay OFFSET $offset");
                    $sql_sp->execute();
                } else if (isset($_SESSION['desc'])) {
                    $sql_sp = $conn->prepare("SELECT * FROM `sach` ORDER BY `price` DESC LIMIT $sldislay OFFSET $offset");
                    $sql_sp->execute();
                } else if (isset($_SESSION['locgia']) && isset($_SESSION['minprice']) && isset($_SESSION['maxprice'])) {
                    $sldislay = !empty($_GET['slsach_on_page']) ? $_GET['slsach_on_page'] : 4;
                    $page_now = !empty($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($page_now - 1) * $sldislay;
                    $tongSP = $conn->prepare("SELECT * FROM `sach` WHERE price BETWEEN ? AND ?");
                    $tongSP->execute([$_SESSION['minprice'], $_SESSION['maxprice']]);
                    $tongSP = $tongSP->rowCount();
                    $tongPage = ceil($tongSP / $sldislay);

                    $sql_sp = $conn->prepare("SELECT * FROM `sach` WHERE price BETWEEN ? AND ? ORDER BY `price` ASC LIMIT $sldislay OFFSET $offset");
                    $sql_sp->execute([$_SESSION['minprice'], $_SESSION['maxprice']]);
                }
            }

            if (isset($_SESSION['search_key'])) {
                $search_key = $_SESSION['search_key'];
                $sldislay = !empty($_GET['slsach_on_page']) ? $_GET['slsach_on_page'] : 4;
                $page_now = !empty($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page_now - 1) * $sldislay;
                $tongSP = $conn->prepare("SELECT * FROM `sach` INNER JOIN `theloaisach` ON sach.idTheLoai=theloaisach.idTheLoai WHERE tenSach LIKE '%$search_key%' 
                OR tenTheLoai LIKE '%$search_key%'");
                $tongSP->execute();
                $tongSP = $tongSP->rowCount();
                $tongPage = ceil($tongSP / $sldislay);

                $sql_sp = $conn->prepare("SELECT * FROM `sach` INNER JOIN `theloaisach` ON sach.idTheLoai=theloaisach.idTheLoai WHERE tenSach LIKE '%$search_key%' 
                    OR tenTheLoai LIKE '%$search_key%' ORDER BY `idSach` ASC LIMIT $sldislay OFFSET $offset");
                $sql_sp->execute();
                if (isset($_SESSION['asc'])) {
                    $sql_sp = $conn->prepare("SELECT * FROM `sach` INNER JOIN `theloaisach` ON sach.idTheLoai=theloaisach.idTheLoai WHERE tenSach LIKE '%$search_key%' 
                    OR tenTheLoai LIKE '%$search_key%' ORDER BY `price` ASC LIMIT $sldislay OFFSET $offset");
                    $sql_sp->execute();
                } else if (isset($_SESSION['desc'])) {
                    $sql_sp = $conn->prepare("SELECT * FROM `sach` INNER JOIN `theloaisach` ON sach.idTheLoai=theloaisach.idTheLoai WHERE tenSach LIKE '%$search_key%' 
                    OR tenTheLoai LIKE '%$search_key%' ORDER BY `price` DESC LIMIT $sldislay OFFSET $offset");
                    $sql_sp->execute();
                } else if (isset($_SESSION['locgia']) && isset($_SESSION['minprice']) && isset($_SESSION['maxprice'])) {
                    $sql_sp = $conn->prepare("SELECT * FROM `sach` INNER JOIN `theloaisach` ON sach.idTheLoai=theloaisach.idTheLoai WHERE tenSach LIKE '%$search_key%' 
                    OR tenTheLoai LIKE '%$search_key%' BETWEEN ? AND ? ORDER BY `price` ASC LIMIT $sldislay OFFSET $offset");
                    $sql_sp->execute([$_SESSION['minprice'], $_SESSION['maxprice']]);
                }
            }

            if (isset($sql_sp)) {
                if ($sql_sp->rowCount() > 0) {
                    while ($row_sp = $sql_sp->fetch(PDO::FETCH_ASSOC)) {
            ?>
                        <div class="col-sm-3 ">
                            <div class="h-100">
                                <div class="card h-100">
                                    <div class="card-body ">
                                        <img class="card-img-top rounded-top-1" src="../project/admin/modules/quanlySach/upload/<?php echo $row_sp['imgSach'] ?>" alt="">
                                        <a href="single.php?idsanpham=<?php echo $row_sp['idSach'] ?>" class="text-decoration-none h5">
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
                                        <a href="./xuly.php?id=<?php echo $row_sp['idSach'] ?>" class="text-center ms-2">
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
                } else {
                    echo '<div class="text-center alert alert-warning my-4 mx-3 fw-bold">Không tìm thấy</div>';
                }
            } else {
                header('location: home.php');
            }

            ?>
        </div>
        <div class="d-flex justify-content-center py-2">
            <?php include "./phantrang.php"; ?>
        </div>
        <div class="row">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border-bottom: 2px solid blue;">
                    <button class="nav-link active fw-bold" id="nav-home-tab" disabled data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Các sách khác</button>
                </div>
            </nav>
            <div class="tab-content border-light-subtle" id="nav-tabContent">
                <div class="tab-pane fade show active border border-light-subtle p-3 mb-4" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row owl-carousel owl-theme z-0">
                        <?php
                        $sql_goiy = $conn->prepare("SELECT * FROM `sach` ORDER BY rand()");
                        $sql_goiy->execute();
                        if ($sql_goiy->rowCount() > 0) {
                            while ($row_goiy = $sql_goiy->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <div class="mx-1 h-100">
                                    <div class="card w-100 h-100">
                                        <div class="card-body d-flex flex-column">
                                            <img class="img-fluid rounded-top-1" src="../project/admin/modules/quanlySach/upload/<?php echo $row_goiy['imgSach'] ?>" alt="">
                                            <a href="single.php?idsanpham=<?php echo $row_goiy['idSach'] ?>" class="cart-title text-dark text-center h5 text-decoration-none my-3">
                                                <?php echo $row_goiy['tenSach'] ?>
                                            </a>
                                            <div class="text-center my-auto fw-bold">
                                                <span class="card-text text-danger price"><?php echo $row_goiy['price'] ?></span>
                                                <span class="text-danger">VNĐ</span>
                                                <div class="text-muted small">Còn (<?= $row_goiy['soLuong'] ?> quyển)</div>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['customer_id']) && isset($row_goiy['idSach'])) {
                                            $check_status_yt = $conn->prepare("SELECT y.idSach FROM yeuthich y, sach s WHERE y.idSach=s.idSach AND y.idSach=? AND y.idUser=?");
                                            $check_status_yt->execute([$row_goiy['idSach'], $_SESSION['customer_id']]);
                                            if ($check_status_yt->rowCount() > 0) {
                                                $row_checkYT = $check_status_yt->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                                <a href="./xuly.php?idsach=<?php echo $row_goiy['idSach'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=unlove" class="text-center ms-2 mb-2">
                                                    <i class="fa-solid fa-heart fs-3 text-danger"></i> </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a href="./xuly.php?idsach=<?php echo $row_goiy['idSach'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=yeuthich" class="text-center ms-2 mb-2">
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
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "component_u/footer_user.php"; ?>