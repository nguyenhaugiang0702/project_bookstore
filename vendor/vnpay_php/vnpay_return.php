<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VNPAY RESPONSE</title>
    <!-- Bootstrap core CSS -->
    <link href="../vnpay_php/assets/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="../vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">
    <script src="../vnpay_php/assets/jquery-1.11.3.min.js"></script>
</head>

<body>
    <?php
    require_once("./config.php");
    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    $inputData = array();
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }

    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    ?>

    <?php
    if ($secureHash != $vnp_SecureHash) {
        echo '<script>alert("Lỗi")</script>';
    }
    ?>
    <!--Begin display -->
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY RESPONSE</h3>
        </div>
        <?php
        session_start();
        if (isset($_SESSION['idorder_new'])) {
            require '../../config/connect.php';
            $select_order = $conn->prepare("SELECT * FROM orders WHERE idOrder='$_SESSION[idorder_new]' AND idUser='$_SESSION[customer_id]'");
            $select_order->execute();
            $row_order = $select_order->fetch(PDO::FETCH_ASSOC);
            if ($select_order->rowCount() > 0) {
        ?>
                <div class="table-responsive">
                    <div class="form-group">
                        <label>Mã đơn hàng:</label>
                        <label><?= $row_order['idOrder'] ?></label>
                    </div>
                    <div class="form-group">
                        <label>Số tiền:</label>
                        <label class="price"><?= $row_order['totalPrice'] ?></label>
                        <label>VNĐ</label>
                    </div>
                    <div class="form-group">
                        <label>Nội dung thanh toán:</label>
                        <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
                    </div>
                    <div class="form-group">
                        <label>Mã phản hồi (vnp_ResponseCode):</label>
                        <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
                    </div>
                    <div class="form-group">
                        <label>Mã GD Tại VNPAY:</label>
                        <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
                    </div>
                    <div class="form-group">
                        <label>Mã Ngân hàng:</label>
                        <label><?php echo $_GET['vnp_BankCode'] ?></label>
                    </div>
                    <div class="form-group">
                        <label>Thời gian thanh toán:</label>
                        <label><?= $row_order['timeOrder'] ?></label>
                    </div>
                    <div class="form-group">
                        <label>Kết quả:</label>
                        <label>
                            <?php
                            if ($secureHash == $vnp_SecureHash) {
                                if ($_GET['vnp_ResponseCode'] == '00') {
                                    echo "<span style='color:blue'>GD Thanh cong</span>";
                                    unset($_SESSION['cart']);
                                } else {
                                    echo "<span style='color:red'>GD Khong thanh cong</span>";
                                    header('location: huydon.php');
                                }
                            } else {
                                echo "<span style='color:red'>Chu ky khong hop le</span>";
                                header('location: huydon.php');
                            }
                            
                            ?>
                        </label>
                        <br>
                        <a href="/../project/cart.php" class="btn btn-info">Quay về</a>
                    </div>
                </div>
            <?php
            }
        } 
        // else {
        //     header('location: huydon.php');
        // }
        // unset($_SESSION['idorder_new']);
        ?>
        
        <p>
            &nbsp;
        </p>
        <footer class="footer">
            <p>&copy; VNPAY <?php echo date('Y') ?></p>
        </footer>
    </div>
    <script src="/../project/js/simple.money.format.js"></script>
    <script>
        $('.price').simpleMoneyFormat();
    </script>
</body>

</html>