<?php 
$page = 'Thông Tin Của Tôi';
include "./component_u/header_user.php";
include './component_u/nav_user.php';

?>

<div class="container-fluid px-5 py-4">
    <div class="row my-4">
        <div class="col-4 border">
            <?php include './component_u/sidebar_user.php'; ?>
        </div>
        <div class="col-8 border">
            <div class="row fw-bold fs-4 mx-auto">Hồ sơ của tôi</div>
            <div class="row mx-auto mb-3">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
            <div class="row mx-auto ">
                <hr>
            </div>
            <div class="row">
                <form action="xuly.php" method="post" id="changeInforForm">
                    <div class="col-6 ms-4">
                        <?php
                        if (isset($_SESSION['status_success'])) {
                            echo '<div class="alert alert-success">' . $_SESSION['status_success'] . '</div>';
                            unset($_SESSION['status_success']);
                        }else if (isset($_SESSION['status_warning'])) {
                            echo '<div class="alert alert-warning">' . $_SESSION['status_warning'] . '</div>';
                            unset($_SESSION['status_warning']);
                        }
                        ?>
                        <div class="my-4 form-group">
                            <label for="fullname" class="fw-bold">Tên đầy đủ:</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" value="<?= $row['nameUser'] ?>">
                        </div>
                        <div class="my-4 form-group">
                            <label for="email" class="fw-bold">Email:</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $row['emailUser'] ?>">
                        </div>
                        <div class="my-4 form-group">
                            <label for="sdt" class="fw-bold">Số điện thoại:</label>
                            <input type="text" class="form-control" id="sdt" name="sdt" value="<?= $row['sdtUser'] ?>">
                        </div>
                        <div class="my-4 form-group">
                            <button type="submit" class="btn btn-success" name="updateUser">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "./component_u/footer_user.php"; ?>