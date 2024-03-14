<?php include "./component_u/header_user.php";
include "./component_u/nav_user.php";

?>

<div class="main bg-light">
    <div class="container">
        <div class="col-12 ms-4 my-4">
            <div class="d-flex mx-3 border border-dark ">
                <div class="mx-2">
                    <a href="home.php">
                        <i style="color:black" class="fa-solid fa-house fs-4 my-2"></i>
                    </a>
                </div>
                <p class="my-2 fs-5 fw-bold">/ <a class="text-decoration-none text-dark" href="cart.php">Giỏ Hàng</a> /<a class="text-decoration-none text-dark" href="cart.php"> Thanh Toán</a></p>
            </div>
        </div>
        <?php
        if (!isset($_SESSION['customer_id'])) {
            $_SESSION['status_warning'] = "Vui lòng đăng nhập để thanh toán";
            header('location: ../project/login_users.php');
        } else {
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                $_SESSION['status_warning'] = "Giỏ hàng trống, vui lòng thêm sản phẩm để thanh toán";
                header('location: cart.php');
            } else {
                $cart = $_SESSION['cart'];
                if (isset($_POST['checkout'])) {
                    $dcgh = $_POST['dcgh'];
                    $dcgh = htmlspecialchars($dcgh);
                    $_SESSION['dcgh'] = $dcgh;
                    if (isset($_SESSION['dcgh'])) {
                        unset($_SESSION['dcgh']);
                        $_SESSION['dcgh'] = $dcgh;
                    }
                    require "./config/connect.php";
                    $total = 0;
                    $tongSL = 0;
                    $cart = $_SESSION['cart'];
                    foreach ($cart as $key => $value) {
                        $soluong = $value['slmua'];
                        $tongSL += $soluong;

                        $sql_sach = $conn->prepare(" SELECT * FROM `sach` WHERE idSach='$key'");
                        $sql_sach->execute();
                        $row_sach = $sql_sach->fetch(PDO::FETCH_ASSOC);
                        //tổng giá mỗi sách với số lượng
                        $dongia = $row_sach['price'];
                        $totalPrice = $dongia * $soluong;
                        //tổng giá tất cả sách
                        $total += $totalPrice;
                    }
                    if (isset($_POST['payment']) && !empty($_POST['payment'])) {
                        if ($_POST['payment'] == 'VNPay') {
                            header('location: /../project/vendor/vnpay_php/vnpay_pay.php');
                        } else if ($_POST['payment'] == 'Paypal') {
                            header('location: /../project/vendor/paypaltask/index.php');
                        } else {
                            $payment = $_POST['payment'];
                            $sql = $conn->prepare("INSERT INTO `orders`(idUser, idDiachiGH, tongSL, totalPrice, DVT ,method, status_order, timeOrder, timeOrderUpdate) VALUES('$_SESSION[customer_id]','$dcgh', '$tongSL', '$total','VNĐ' , '$payment', 1, NOW(), NOW())");
                            $sql->execute();
                            $idorder = $conn->lastInsertId();
                            foreach ($cart as $key => $value) {

                                $soluong = $value['slmua'];

                                $sql_sach = $conn->prepare(" SELECT * FROM `sach` WHERE idSach='$key'");
                                $sql_sach->execute();
                                $row_sach = $sql_sach->fetch(PDO::FETCH_ASSOC);
                                $idsach = $row_sach['idSach'];
                                //tổng giá mỗi sách với số lượng
                                $dongia = $row_sach['price'];
                                $totalPrice = $dongia * $soluong;
                                //tổng giá tất cả sách
                                $total += $totalPrice;

                                $sql = $conn->prepare("INSERT INTO `chitietorder`(idOrder, idSach, dongia, dvt_chitiet, slmua) VALUES('$idorder', '$idsach', '$dongia', 'VNĐ' ,'$soluong')");
                                $sql->execute();
                            }
                            unset($_SESSION['cart']);
                            $_SESSION['status_success'] = 'Bạn đã đặt hàng thành công';
                            header('location: cart.php');
                        }
                    }
                }
            }
        }
        ?>
        <div class="row bg-light">
            <div class="col-8 my-4">
                <form id="checkoutForm" method="post">
                    <div class="mx-5 form-group">
                        <label for="name" class="fw-bold form-label">Tên đầy đủ:</label>
                        <input type="text" class="form-control" disabled id="name" value="<?= $_SESSION['customer_name'] ?>">
                    </div>
                    <div class="mx-5 form-group">
                        <label for="sdt" class="fw-bold form-label">Số điện thoại:</label>
                        <input type="text" class="form-control" id="sdt" disabled value="<?= $_SESSION['customer_sdt'] ?>">
                    </div>
                    <div class="mx-5 form-group">
                        <label for="email" class="fw-bold form-label">Email:</label>
                        <input type="text" class="form-control" id="email" disabled value="<?= $_SESSION['customer_email'] ?>">
                    </div>

                    <div class="mx-5 form-group">
                        <label for="dcgh" class="fw-bold form-label">Địa chỉ giao hàng:</label>
                        <select name="dcgh" id="dcgh" class="form-control">
                            <?php
                            $select_diachigh = $conn->prepare("SELECT * FROM diachigh d, tinh t, quan_huyen q, xa x WHERE d.idTinh=t.idTinh 
                            AND d.idQH=q.idQH AND d.idXa=x.idXa AND idUser='$_SESSION[customer_id]'");
                            $select_diachigh->execute();
                            if ($select_diachigh->rowCount() > 0) {
                                $select_diachigh_macdinh = $conn->prepare("SELECT * FROM diachigh d, tinh t, quan_huyen q, xa x WHERE d.idTinh=t.idTinh 
                                AND d.idQH=q.idQH AND d.idXa=x.idXa AND idUser='$_SESSION[customer_id]' AND status=1");
                                $select_diachigh_macdinh->execute();
                                $row_dcgh_md = $select_diachigh_macdinh->fetch(PDO::FETCH_ASSOC);
                                if ($select_diachigh_macdinh->rowCount() > 0) {
                            ?>
                                    <option value="<?= $row_dcgh_md['idDiachiGH'] ?>">
                                        <?php
                                        echo $row_dcgh_md['diachi'] . ', ';
                                        echo $row_dcgh_md['tenXa'] . ', ';
                                        echo $row_dcgh_md['tenQH'] . ', ';
                                        echo $row_dcgh_md['tenTinh'] . ', ';
                                        ?>
                                    </option>
                                    <?php
                                }

                                $select_diachigh_not_macdinh = $conn->prepare("SELECT * FROM diachigh d, tinh t, quan_huyen q, xa x WHERE d.idTinh=t.idTinh 
                                AND d.idQH=q.idQH AND d.idXa=x.idXa AND idUser='$_SESSION[customer_id]' AND status=0");
                                $select_diachigh_not_macdinh->execute();
                                if ($select_diachigh_not_macdinh->rowCount() > 0) {
                                    while ($row_dcgh_not_md = $select_diachigh_not_macdinh->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <option value="<?= $row_dcgh_not_md['idDiachiGH'] ?>">
                                            <?php
                                            echo $row_dcgh_not_md['diachi'] . ', ';
                                            echo $row_dcgh_not_md['tenXa'] . ', ';
                                            echo $row_dcgh_not_md['tenQH'] . ', ';
                                            echo $row_dcgh_not_md['tenTinh'] . ', ';
                                            ?>
                                        </option>
                                <?php
                                    }
                                }
                            } else {
                                ?>
                                <option value="">Chọn địa chỉ giao hàng</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row mx-5">
                        <button class=" my-3 btn btn-success col-2" id="btnCheckOut" name="checkout" type="submit">Đặt hàng</button>
                    </div>
            </div>

            <div class="col-4 my-4 ">
                <div class="bg-white py-4 px-4 checkout_shadow">
                    <div class="row mx-auto ">
                        <div class="col-7 fw-bold fs-4">Đơn của bạn</div>
                        <div class="col-5 fs-4 text-end">
                            <a href="../project/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                        </div>
                    </div>
                    <hr>
                    <div class="row mx-auto fw-bold">
                        <div class="col-7">Tổng giá giỏ hàng:</div>
                        <div class="col-5 ">
                            <span class="price text-danger fw-bold"><?= $total ?></span>
                            <span class="text-danger fw-bold">VNĐ</span>
                        </div>
                    </div>
                    <div class="row mx-auto mt-2">
                        <div class="col-7 fw-bold">Vận chuyển và xử lý:</div>
                        <div class="col-5 fst-italic">Miễn phí</div>
                    </div>
                    <hr>
                    <div class="row mx-auto fw-bold mt-2">
                        <div class="col-7">Tổng cộng:</div>
                        <div class="col-5">
                            <span class="price text-danger fw-bold"><?= $total ?></span>
                            <span class="text-danger fw-bold">VNĐ</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white my-4 py-4 px-4 checkout_shadow">
                    <div class="row mx-auto">
                        <div class="col-12 text-start fw-bold fs-4 mb-4">Phương thức thanh toán</div>
                        <hr>
                    </div>
                    <div class="row mx-auto my-3 form-group">
                        <input class="form-check-input border border-dark col-1 ms-3" type="radio" checked name="payment" id="payment1" value="Ship COD">
                        <label class="fw-bold col" id="payment1">Thanh toán khi nhận hàng</label>
                    </div>
                    <div class="row mx-auto my-3 form-group">
                        <input class="form-check-input border border-dark col-1 ms-3" type="radio" name="payment" id="payment3" value="Paypal">
                        <label class="fw-bold col" id="payment3">Thanh toán qua Paypal</label>
                    </div>
                    <div class="row mx-auto my-3 form-group">
                        <input class="form-check-input border border-dark col-1 ms-3" type="radio" name="payment" id="payment4" value="VNPay">
                        <label class="fw-bold col" id="payment3">Thanh toán qua VNPay</label>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<?php include "./component_u/footer_user.php"; ?>