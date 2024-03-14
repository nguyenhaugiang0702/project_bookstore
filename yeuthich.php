<?php
$page = 'Yêu Thích';
include "./component_u/header_user.php";
include "./component_u/nav_user.php";

?>

<div class="container-fluid px-5 py-4">
    <div class="row my-4">
        <div class="col-4 border">
            <?php include './component_u/sidebar_user.php'; ?>
        </div>
        <div class="col-8 border">
            <div class="row fw-bold fs-4 mx-auto">Danh sách yêu thích</div>
            <div class="row mx-auto mb-3">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
            <div class="row mx-auto ">
                <hr>
            </div>
            <?php
            $select_yeuthich = $conn->prepare("SELECT * FROM yeuthich y, sach s WHERE y.idSach=s.idSach AND y.idUser=?");
            $select_yeuthich->execute([$_SESSION['customer_id']]);
            if ($select_yeuthich->rowCount() > 0) {
                while ($row_yeuthich = $select_yeuthich->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="row my-4">
                        <div class="col-2">
                            <a href="single.php?idsanpham=<?= $row_yeuthich['idSach'] ?>">
                                <img class="img-fluid" src="/../project/admin/modules/quanlySach/upload/<?= $row_yeuthich['imgSach'] ?>" alt="">
                            </a>
                        </div>
                        <div class="col-10">
                            <a href="single.php?idsanpham=<?= $row_yeuthich['idSach'] ?>" class="text-decoration-none">
                                <div class="fs-4 fw-bold"><?= $row_yeuthich['tenSach'] ?></div>
                            </a>
                            <div class="fs-5 text-muted">
                                Còn <?= $row_yeuthich['soLuong'] ?> quyển
                            </div>
                            <div class="fs-5 text-danger fw-bold">
                                <span class="price"><?= $row_yeuthich['price'] ?></span>
                                <span>VNĐ</span>
                            </div>
                            <div class="my-3">
                                <a href="./xuly.php?id=<?= $row_yeuthich['idSach'] ?>&action=muangay" class="col-4 btn btn-primary"><i class="fa-solid fa-cart-plus"></i> Mua Ngay</a>
                                <a href="./xuly.php?idsach=<?= $row_yeuthich['idSach'] ?>&iduser=<?= $_SESSION['customer_id'] ?>&action=unlove_account" class="col-4 ms-2 btn btn-danger">Xóa</a>
                            </div>
                        </div>
                    </div>
                    <hr>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include "./component_u/footer_user.php"; ?>