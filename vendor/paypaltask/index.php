<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    // Include configuration file 
    include_once 'config.php';
    include '../checkCart.php';
    // Include database connection file 
    include_once '../../config/connect.php';
    ?>

    <div class="container" class="px-5">
        <div class="fw-bold fs-4 pt-5">Tạo hóa đơn mới</div>
        <form action="<?php echo PAYPAL_URL; ?>" method="post" id="paypal_form" onSubmit="return submitData();">
            <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">

            <!-- Important For PayPal Checkout -->
            <div class="form-group">
                <label>Số tiền</label>
                <input type="text" class="form-control mb-1" value="<?= $total ?>" readonly>
                <input type="hidden" value="<?= round($total / 23000) ?>" name="amount" id="amount">
                <input type="text" class="form-control mb-1" value="<?= '$' . round($total / 23000) ?>" readonly>
                <input type="text" class="form-control" value="Thanh Toan Sach" name="item_name" id="item_name">
            </div>

            <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">

            <!-- Specify a Buy Now button. -->
            <input type="hidden" name="cmd" value="_xclick">
            <!-- Specify URLs -->
            <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
            <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
            <br>
            <!-- Display the payment button. -->
            <input type="submit" name="submit" class="btn btn-success" value="Tiếp tục">
        </form>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        function submitData() {
            var formData = $('#paypal_form').serialize();
            $.ajax({
                url: "insertData.php",
                type: "POST",
                data: formData
            });
        }
    </script>
</body>

</html>