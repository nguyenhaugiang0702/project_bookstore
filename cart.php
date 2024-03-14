<?php
$page = 'Giỏ hàng';
include "./component_u/header_user.php";
include "./component_u/nav_user.php";
if (isset($_SESSION['status_success'])) {
    echo '<script>alert("' . $_SESSION['status_success'] . '")</script>';
    unset($_SESSION['status_success']);
}else if(isset($_SESSION['status_warning'])){
    echo '<script>alert("' . $_SESSION['status_warning'] . '")</script>';
    unset($_SESSION['status_warning']);
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="d-flex mx-auto border border-dark ">
            <div class="mx-2">
                <a href="trangchu.php">
                    <i style="color:black" class="fa-solid fa-house fs-4 my-2"></i>
                </a>

            </div>
            <p class="my-2 fw-bold"> / GIỎ HÀNG </p>
        </div>
    </div>

    <div class="my-3">
        <h3 class="mx-auto my-4">Giỏ hàng của tôi</h3>
        <table class="table">
            <thead class="table-primary border border-dark">
                <tr>
                    <th>Hình</th>
                    <th>Tên Sách</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Tổng Giá</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['cart'])) {
                    require "./config/connect.php";
                    $total = 0;
                    $cart = $_SESSION['cart'];
                    foreach ($cart as $key => $value) {
                        $sql_cart = $conn->prepare("SELECT * FROM `sach` WHERE idSach = '$key'");
                        $sql_cart->execute();
                        $row_cart = $sql_cart->fetch(PDO::FETCH_ASSOC);
                ?>
                        <tr>
                            <td style="width:180px"><img class="img-fluid" src="../project/admin/modules/quanlySach/upload/<?php echo $row_cart['imgSach'] ?>" alt=""></td>
                            <td><a class="text-decoration-none" href="./single.php?idsanpham=<?php echo $row_cart['idSach'] ?>"><?php echo $row_cart['tenSach'] ?></a> </td>
                            <td>
                                <form method="post" action="xuly.php">
                                    <input class="col-4 btn btn-outline-primary" type="number" name="slmua_cart<?= $row_cart['idSach'] ?>" value="<?= $value['slmua'] ?>" min=1>
                            </td>
                            <td>
                                <span class="price text-danger fw-bold"><?php echo $row_cart['price'] ?></span>
                                <span class="text-danger fw-bold">VNĐ</span>
                            </td>
                            <td>
                                <span class="price text-danger fw-bold"><?php echo $row_cart['price'] * $value['slmua'] ?></span>
                                <span class="text-danger fw-bold">VNĐ</span>
                            </td>
                            <td><a href="xuly.php?del_id=<?php echo $key ?>"> <button class="btn btn-danger" type="button">Xóa</button> </a></td>
                        </tr>
                <?php
                        $total = $total + $row_cart['price'] * $value['slmua'];
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end">
        <div class="mb-3 me-3 float-start">
            <button class="btn btn-info" type="submit" name="update_sl_cart">Cập nhập số lượng</button>
        </div>
        </form>
        <div class="mb-3">
            <a href="xuly.php?action=xoahet" onclick="return confirm('Bạn có chắc chắn muốn xóa hết tất cả ?')">
                <button class="btn btn-danger">Xóa tất cả</button>
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header fw-bold">Tổng Tiền Phải Thanh Toán:</div>
        <div class="card-body fw-bold">
            <span>Tổng tiền :</span>
            <span class="price text-danger"><?php if (isset($_SESSION['cart'])) {
                                                echo $total;
                                            } else {
                                                echo 0;
                                            }  ?></span>
            <span class="text-danger">VNĐ</span>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <div class="my-3">
            <a href="/../project/checkout.php" class="btn btn-success">Thanh Toán</a>
        </div>
    </div>


</div>
<?php include "./component_u/footer_user.php"; ?>