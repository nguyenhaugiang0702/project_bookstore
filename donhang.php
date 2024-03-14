<?php 
$page = 'Đơn Hàng';
include "./component_u/header_user.php";
include "./component_u/nav_user.php";
?>

<div class="container-fluid px-5 py-4">
    <div class="row my-4">
        <div class="col-4 border">
            <?php include './component_u/sidebar_user.php'; ?>
        </div>
        <div class="col-8 border">
            <div class="row fw-bold fs-4 mx-auto">Đơn hàng của tôi</div>
            <div class="row mx-auto mb-3">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
            <div class="row mx-auto ">
                <hr>
            </div>
            <div class="row my-3">
                <?php
                if (isset($_SESSION['status_success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
                    unset($_SESSION['status_success']);
                } else if (isset($_SESSION['status_warning'])) {
                    echo '<div class="alert alert-warning">' . $_SESSION['status_warning'] . '</div>';
                    unset($_SESSION['status_warning']);
                }
                ?>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <?php
                        $sql_checkStatus1 = $conn->prepare("SELECT * FROM orders WHERE status_order=1 AND idUser='$_SESSION[customer_id]'");
                        $sql_checkStatus1->execute();
                        $sql_checkStatus2 = $conn->prepare("SELECT * FROM orders WHERE status_order=2 AND idUser='$_SESSION[customer_id]'");
                        $sql_checkStatus2->execute();
                        $sql_checkStatus3 = $conn->prepare("SELECT * FROM orders WHERE status_order=3 AND idUser='$_SESSION[customer_id]'");
                        $sql_checkStatus3->execute();
                        $sql_checkStatus4 = $conn->prepare("SELECT * FROM orders WHERE status_order=4 AND idUser='$_SESSION[customer_id]'");
                        $sql_checkStatus4->execute();
                        $sql_checkStatus5 = $conn->prepare("SELECT * FROM orders WHERE status_order=5 AND idUser='$_SESSION[customer_id]'");
                        $sql_checkStatus5->execute();
                        $sql_checkStatus6 = $conn->prepare("SELECT * FROM orders WHERE status_order=6 AND idUser='$_SESSION[customer_id]'");
                        $sql_checkStatus6->execute();
                        ?>
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-cxn" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Chờ xác nhận (<strong><?= $sql_checkStatus1->rowCount() ?></strong>)</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-dxn" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Đã xác nhận (<strong><?= $sql_checkStatus2->rowCount() ?></strong>)</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-dvc" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Đang vận chuyển (<strong><?= $sql_checkStatus3->rowCount() ?></strong>)</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-dgh" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Đã giao hàng (<strong><?= $sql_checkStatus4->rowCount() ?></strong>)</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-ych" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Yêu cầu hủy (<strong><?= $sql_checkStatus5->rowCount() ?></strong>)</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-dh" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Đã hủy (<strong><?= $sql_checkStatus6->rowCount() ?></strong>)</button>
                    </div>
                </nav>
                <!-- Chờ xác nhận đơn hàng -->
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active border" id="nav-cxn" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?php
                        $select_orders = $select_donhang = $conn->prepare("SELECT idOrder FROM orders o, users u
                                                        WHERE o.idUser=u.idUser AND o.idUser='$_SESSION[customer_id]' AND o.status_order=1");
                        $select_orders->execute();
                        if ($select_orders->rowCount() > 0) {
                            while ($row_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                $idorder = $row_orders['idOrder'];
                                $select_addRess = $conn->prepare("SELECT * FROM orders o, diachigh d, tinh t, quan_huyen q, xa x
                                WHERE d.idDiachiGH=o.idDiachiGH AND t.idTinh=d.idTinh AND q.idQH=d.idQH AND x.idXa=d.idXa AND o.idOrder = '$idorder'");
                                $select_addRess->execute();
                                $row_addRess = $select_addRess->fetch(PDO::FETCH_ASSOC);
                        ?>
                                <div class="row mx-2 my-2">
                                    <div class="card">
                                        <div class="row card-header">
                                            <div>
                                                <a class="btn btn-danger float-end" href="./xuly.php?idorder=<?= $row_orders['idOrder'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=huydon">HỦY</a>
                                            </div>
                                        </div>
                                        <?php
                                        $select_donhang = $conn->prepare("SELECT * FROM orders o, chitietorder c, sach s WHERE o.idOrder=c.idOrder AND s.idSach=c.idSach
                                                                                    AND o.idUser='$_SESSION[customer_id]' AND o.idOrder=? AND o.status_order=1");
                                        $select_donhang->execute([$row_orders['idOrder']]);
                                        if ($select_donhang->rowCount() > 0) {
                                            while ($row_donhang = $select_donhang->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <a href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                <img class="img-fluid" src="/../project/admin/modules/quanlySach/upload/<?= $row_donhang['imgSach'] ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row fs-4 fw-bold mb-2">
                                                                <div class="col-12">
                                                                    <a class="text-decoration-none" href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                        <?= $row_donhang['tenSach'] ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">
                                                                    SỐ LƯỢNG: <?= $row_donhang['slmua'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">ĐƠN GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12"> TỔNG GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] * $row_donhang['slmua'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <div class="row card-footer">
                                            <div class="row mt-2">
                                                <span class="fw-bold col-3">Địa chỉ giao hàng:</span>
                                                <span class="col">
                                                    <?php
                                                    echo $row_addRess['diachi'] . ', ';
                                                    echo $row_addRess['tenXa'] . ', ';
                                                    echo $row_addRess['tenQH'] . ', ';
                                                    echo $row_addRess['tenTinh'] . ', ';
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="row mt-2">
                                                <span class="col-3 fw-bold">Phương thức thanh toán:</span>
                                                <span class="col">
                                                    <?php
                                                    if ($row_addRess['method'] == 'Ship COD') {
                                                        echo 'Thanh toán khi nhận hàng';
                                                    } else if ($row_addRess['method'] == 'Paypal') {
                                                        echo 'Thanh toán bằng Paypal';
                                                    } else if ($row_addRess['method'] == 'VNPay') {
                                                        echo 'Thanh toán bằng VNPay';
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- Chờ xác nhận đơn hàng -->

                    <!-- Đã xác nhận đơn hàng -->
                    <div class="tab-pane fade show border" id="nav-dxn" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?php
                        $select_orders = $select_donhang = $conn->prepare("SELECT idOrder FROM orders o, users u
                                                        WHERE o.idUser=u.idUser AND o.idUser='$_SESSION[customer_id]' AND o.status_order=2");
                        $select_orders->execute();
                        if ($select_orders->rowCount() > 0) {
                            while ($row_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                $idorder = $row_orders['idOrder'];
                                $select_addRess = $conn->prepare("SELECT * FROM orders o, diachigh d, tinh t, quan_huyen q, xa x
                                WHERE d.idDiachiGH=o.idDiachiGH AND t.idTinh=d.idTinh AND q.idQH=d.idQH AND x.idXa=d.idXa AND o.idOrder = '$idorder'");
                                $select_addRess->execute();
                                $row_addRess = $select_addRess->fetch(PDO::FETCH_ASSOC);
                        ?>
                                <div class="row mx-2 my-2">
                                    <div class="card">

                                        <?php
                                        $select_donhang = $conn->prepare("SELECT * FROM orders o, chitietorder c, sach s WHERE o.idOrder=c.idOrder AND s.idSach=c.idSach
                                                                                    AND o.idUser='$_SESSION[customer_id]' AND o.idOrder=? AND o.status_order=2");
                                        $select_donhang->execute([$row_orders['idOrder']]);
                                        if ($select_donhang->rowCount() > 0) {
                                            while ($row_donhang = $select_donhang->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <a href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                <img class="img-fluid" src="/../project/admin/modules/quanlySach/upload/<?= $row_donhang['imgSach'] ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row fs-4 fw-bold mb-2">
                                                                <div class="col-12">
                                                                    <a class="text-decoration-none" href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                        <?= $row_donhang['tenSach'] ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">
                                                                    SỐ LƯỢNG: <?= $row_donhang['slmua'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">ĐƠN GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12"> TỔNG GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] * $row_donhang['slmua'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <div class="row card-footer">
                                            <div class="row mt-2">
                                                <span class="fw-bold col-3">Địa chỉ giao hàng:</span>
                                                <span class="col">
                                                    <?php
                                                    echo $row_addRess['diachi'] . ', ';
                                                    echo $row_addRess['tenXa'] . ', ';
                                                    echo $row_addRess['tenQH'] . ', ';
                                                    echo $row_addRess['tenTinh'] . ', ';
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="row mt-2">
                                                <span class="col-3 fw-bold">Phương thức thanh toán:</span>
                                                <span class="col">
                                                    <?php
                                                    if ($row_addRess['method'] == 'Ship COD') {
                                                        echo 'Thanh toán khi nhận hàng';
                                                    } else if ($row_addRess['method'] == 'Paypal') {
                                                        echo 'Thanh toán bằng Paypal';
                                                    } else if ($row_addRess['method'] == 'VNPay') {
                                                        echo 'Thanh toán bằng VNPay';
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- Đã xác nhận đơn hàng -->

                    <!-- Đang vận chuyển đơn hàng -->
                    <div class="tab-pane fade show border" id="nav-dvc" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?php
                        $select_orders = $select_donhang = $conn->prepare("SELECT idOrder FROM orders o, users u
                                                        WHERE o.idUser=u.idUser AND o.idUser='$_SESSION[customer_id]' AND o.status_order=3");
                        $select_orders->execute();
                        if ($select_orders->rowCount() > 0) {
                            while ($row_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                $idorder = $row_orders['idOrder'];
                                $select_addRess = $conn->prepare("SELECT * FROM orders o, diachigh d, tinh t, quan_huyen q, xa x
                                WHERE d.idDiachiGH=o.idDiachiGH AND t.idTinh=d.idTinh AND q.idQH=d.idQH AND x.idXa=d.idXa AND o.idOrder = '$idorder'");
                                $select_addRess->execute();
                                $row_addRess = $select_addRess->fetch(PDO::FETCH_ASSOC);
                        ?>
                                <div class="row mx-2 my-2">
                                    <div class="card">

                                        <?php
                                        $select_donhang = $conn->prepare("SELECT * FROM orders o, chitietorder c, sach s WHERE o.idOrder=c.idOrder AND s.idSach=c.idSach
                                                                                    AND o.idUser='$_SESSION[customer_id]' AND o.idOrder=? AND o.status_order=3");
                                        $select_donhang->execute([$row_orders['idOrder']]);
                                        if ($select_donhang->rowCount() > 0) {
                                            while ($row_donhang = $select_donhang->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <a href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                <img class="img-fluid" src="/../project/admin/modules/quanlySach/upload/<?= $row_donhang['imgSach'] ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row fs-4 fw-bold mb-2">
                                                                <div class="col-12">
                                                                    <a class="text-decoration-none" href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                        <?= $row_donhang['tenSach'] ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">
                                                                    SỐ LƯỢNG: <?= $row_donhang['slmua'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">ĐƠN GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12"> TỔNG GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] * $row_donhang['slmua'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <div class="row card-footer">
                                            <div class="row mt-2">
                                                <span class="fw-bold col-3">Địa chỉ giao hàng:</span>
                                                <span class="col">
                                                    <?php
                                                    echo $row_addRess['diachi'] . ', ';
                                                    echo $row_addRess['tenXa'] . ', ';
                                                    echo $row_addRess['tenQH'] . ', ';
                                                    echo $row_addRess['tenTinh'] . ', ';
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="row mt-2">
                                                <span class="col-3 fw-bold">Phương thức thanh toán:</span>
                                                <span class="col">
                                                    <?php
                                                    if ($row_addRess['method'] == 'Ship COD') {
                                                        echo 'Thanh toán khi nhận hàng';
                                                    } else if ($row_addRess['method'] == 'Paypal') {
                                                        echo 'Thanh toán bằng Paypal';
                                                    } else if ($row_addRess['method'] == 'VNPay') {
                                                        echo 'Thanh toán bằng VNPay';
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- Đang vận chuyển đơn hàng -->

                    <!-- Đã giao hàng -->
                    <div class="tab-pane fade border" id="nav-dgh" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <?php
                        $select_orders = $select_donhang = $conn->prepare("SELECT idOrder FROM orders o, users u
                                                        WHERE o.idUser=u.idUser AND o.idUser='$_SESSION[customer_id]' AND o.status_order=4");
                        $select_orders->execute();
                        if ($select_orders->rowCount() > 0) {
                            while ($row_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                $idorder = $row_orders['idOrder'];
                                $select_addRess = $conn->prepare("SELECT * FROM orders o, diachigh d, tinh t, quan_huyen q, xa x
                                WHERE d.idDiachiGH=o.idDiachiGH AND t.idTinh=d.idTinh AND q.idQH=d.idQH AND x.idXa=d.idXa AND o.idOrder = '$idorder'");
                                $select_addRess->execute();
                                $row_addRess = $select_addRess->fetch(PDO::FETCH_ASSOC);
                        ?>
                                <div class="row mx-2 my-2">
                                    <div class="card">

                                        <?php
                                        $select_donhang = $conn->prepare("SELECT * FROM orders o, chitietorder c, sach s WHERE o.idOrder=c.idOrder AND s.idSach=c.idSach
                                                                                    AND o.idUser='$_SESSION[customer_id]' AND o.idOrder=? AND o.status_order=4");
                                        $select_donhang->execute([$row_orders['idOrder']]);
                                        if ($select_donhang->rowCount() > 0) {
                                            while ($row_donhang = $select_donhang->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <a href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                <img class="img-fluid" src="/../project/admin/modules/quanlySach/upload/<?= $row_donhang['imgSach'] ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row fs-4 fw-bold mb-2">
                                                                <div class="col-12">
                                                                    <a class="text-decoration-none" href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                        <?= $row_donhang['tenSach'] ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">
                                                                    SỐ LƯỢNG: <?= $row_donhang['slmua'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">ĐƠN GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12"> TỔNG GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] * $row_donhang['slmua'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <div class="row card-footer">
                                            <div class="row mt-2">
                                                <span class="fw-bold col-3">Địa chỉ giao hàng:</span>
                                                <span class="col">
                                                    <?php
                                                    echo $row_addRess['diachi'] . ', ';
                                                    echo $row_addRess['tenXa'] . ', ';
                                                    echo $row_addRess['tenQH'] . ', ';
                                                    echo $row_addRess['tenTinh'] . ', ';
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="row mt-2">
                                                <span class="col-3 fw-bold">Phương thức thanh toán:</span>
                                                <span class="col">
                                                    <?php
                                                    if ($row_addRess['method'] == 'Ship COD') {
                                                        echo 'Thanh toán khi nhận hàng';
                                                    } else if ($row_addRess['method'] == 'Paypal') {
                                                        echo 'Thanh toán bằng Paypal';
                                                    } else if ($row_addRess['method'] == 'VNPay') {
                                                        echo 'Thanh toán bằng VNPay';
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- Đã giao hàng -->

                    <!-- yêu cầu hủy đơn hàng của người dùng -->
                    <div class="tab-pane fade border" id="nav-ych" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <?php
                        $select_orders = $select_donhang = $conn->prepare("SELECT idOrder FROM orders o, users u
                                                        WHERE o.idUser=u.idUser AND o.idUser='$_SESSION[customer_id]' AND o.status_order=5");
                        $select_orders->execute();
                        if ($select_orders->rowCount() > 0) {
                            while ($row_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                $idorder = $row_orders['idOrder'];
                                $select_addRess = $conn->prepare("SELECT * FROM orders o, diachigh d, tinh t, quan_huyen q, xa x
                                WHERE d.idDiachiGH=o.idDiachiGH AND t.idTinh=d.idTinh AND q.idQH=d.idQH AND x.idXa=d.idXa AND o.idOrder = '$idorder'");
                                $select_addRess->execute();
                                $row_addRess = $select_addRess->fetch(PDO::FETCH_ASSOC);
                        ?>
                                <div class="row mx-2 my-2">
                                    <div class="card">

                                        <?php
                                        $select_donhang = $conn->prepare("SELECT * FROM orders o, chitietorder c, sach s WHERE o.idOrder=c.idOrder AND s.idSach=c.idSach
                                                                                    AND o.idUser='$_SESSION[customer_id]' AND o.idOrder=? AND o.status_order=5");
                                        $select_donhang->execute([$row_orders['idOrder']]);
                                        if ($select_donhang->rowCount() > 0) {
                                            while ($row_donhang = $select_donhang->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <a href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                <img class="img-fluid" src="/../project/admin/modules/quanlySach/upload/<?= $row_donhang['imgSach'] ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row fs-4 fw-bold mb-2">
                                                                <div class="col-12">
                                                                    <a class="text-decoration-none" href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                        <?= $row_donhang['tenSach'] ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">
                                                                    SỐ LƯỢNG: <?= $row_donhang['slmua'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">ĐƠN GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12"> TỔNG GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] * $row_donhang['slmua'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <div class="row card-footer">
                                            <div class="row mt-2">
                                                <span class="fw-bold col-3">Địa chỉ giao hàng:</span>
                                                <span class="col">
                                                    <?php
                                                    echo $row_addRess['diachi'] . ', ';
                                                    echo $row_addRess['tenXa'] . ', ';
                                                    echo $row_addRess['tenQH'] . ', ';
                                                    echo $row_addRess['tenTinh']
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="row mt-2">
                                                <span class="col-3 fw-bold">Phương thức thanh toán:</span>
                                                <span class="col">
                                                    <?php
                                                    if ($row_addRess['method'] == 'Ship COD') {
                                                        echo 'Thanh toán khi nhận hàng';
                                                    } else if ($row_addRess['method'] == 'Paypal') {
                                                        echo 'Thanh toán bằng Paypal';
                                                    } else if ($row_addRess['method'] == 'VNPay') {
                                                        echo 'Thanh toán bằng VNPay';
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- yêu cầu hủy đơn hàng của người dùng -->

                    <!-- Đã hủy đơn hàng -->
                    <div class="tab-pane fade border" id="nav-dh" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <?php
                        $select_orders = $select_donhang = $conn->prepare("SELECT idOrder FROM orders o, users u
                                                        WHERE o.idUser=u.idUser AND o.idUser='$_SESSION[customer_id]' AND o.status_order=6");
                        $select_orders->execute();
                        if ($select_orders->rowCount() > 0) {
                            while ($row_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                $idorder = $row_orders['idOrder'];
                                $select_addRess = $conn->prepare("SELECT * FROM orders o, diachigh d, tinh t, quan_huyen q, xa x
                                WHERE d.idDiachiGH=o.idDiachiGH AND t.idTinh=d.idTinh AND q.idQH=d.idQH AND x.idXa=d.idXa AND o.idOrder = '$idorder'");
                                $select_addRess->execute();
                                $row_addRess = $select_addRess->fetch(PDO::FETCH_ASSOC);
                        ?>
                                <div class="row mx-2 my-2">
                                    <div class="card">

                                        <?php
                                        $select_donhang = $conn->prepare("SELECT * FROM orders o, chitietorder c, sach s WHERE o.idOrder=c.idOrder AND s.idSach=c.idSach
                                                                                    AND o.idUser='$_SESSION[customer_id]' AND o.idOrder=? AND o.status_order=6");
                                        $select_donhang->execute([$row_orders['idOrder']]);
                                        if ($select_donhang->rowCount() > 0) {
                                            while ($row_donhang = $select_donhang->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <a href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                <img class="img-fluid" src="/../project/admin/modules/quanlySach/upload/<?= $row_donhang['imgSach'] ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="row fs-4 fw-bold mb-2">
                                                                <div class="col-12">
                                                                    <a class="text-decoration-none" href="./single.php?idsanpham=<?= $row_donhang['idSach'] ?>">
                                                                        <?= $row_donhang['tenSach'] ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">
                                                                    SỐ LƯỢNG: <?= $row_donhang['slmua'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12">ĐƠN GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                            <div class="row fw-bold mb-2">
                                                                <div class="col-12"> TỔNG GIÁ:
                                                                    <span class="price text-danger"><?= $row_donhang['dongia'] * $row_donhang['slmua'] ?></span>
                                                                    <span class="text-danger">VNĐ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- Đã hủy đơn hàng -->

                </div>
            </div>
        </div>
    </div>
</div>

<?php include "./component_u/footer_user.php"; ?>